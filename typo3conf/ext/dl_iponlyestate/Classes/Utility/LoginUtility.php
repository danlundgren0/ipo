<?php
namespace DanLundgren\DlIponlyestate\Utility;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Dan Lundgren <danlundgren0@gmail.com>, Dan Lundgren
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * LogintUtility
 */
class LogintUtility {
    public function isLoggedIn() {
		/*
    	if($_COOKIE["user"] && (isset($_POST) && isset($_POST['logintype']) && $_POST['logintype'] == 'login')) {
    		$loginStatus = $this->loginUser($_COOKIE["user"]);
    	}
    	*/
    	if($_COOKIE["user"] && isset($_POST['logintype']) && $_POST['logintype'] == 'logout') {
		    $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		    $loginCookie = $objectManager->get('DanLundgren\DlIponlyestate\Hooks\SetLoginCookie');
    		$loginCookie->delLoginCookie();
    	}    	
    	elseif($_COOKIE["user"] && (!isset($GLOBALS['TSFE']->fe_user->user))) {
    		$loginStatus = $this->loginUser($_COOKIE["user"]);
			header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
			//exit;
    	}
    }

	public function loginUser($username, $password='')
	{
	    $loginData = array(
	        'uname' => $username,
	        'uident_text' => $password,
	        'status' => 'login'
	    );

	    $GLOBALS['TSFE']->fe_user->checkPid = 0;
	    $info = $GLOBALS['TSFE']->fe_user->getAuthInfoArray();
	    $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
	    $userAuth = $objectManager->get('TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication');
	    $user = $userAuth->fetchUserRecord($info['db_user'], $loginData['uname']);

	    if ($user) {
	        $userAuth->checkPid = false;	        
	        $saltedPasswordService = $objectManager->get('TYPO3\CMS\Saltedpasswords\SaltedPasswordService');
	        $isValidLoginData = $saltedPasswordService->authUser($user);

	        if (!$isValidLoginData) {
	            return false;
	        } else {
	            $GLOBALS['TSFE']->fe_user->forceSetCookie = TRUE;
	            $GLOBALS['TSFE']->fe_user->dontSetCookie = false;
	            $GLOBALS['TSFE']->fe_user->start();
	            $GLOBALS['TSFE']->fe_user->createUserSession($user);
	            $GLOBALS['TSFE']->fe_user->setAndSaveSessionData('dummy', TRUE);
	            $GLOBALS['TSFE']->fe_user->loginUser = 1;
	            return true;
	        }
	    } else {
	        return false;
	    }
	}

}