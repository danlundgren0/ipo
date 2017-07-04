<?php
namespace DanLundgren\DlQrcodesgenerator\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Dan Lundgren <danlundgren0@gmail.com>, Dan Lundgren
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
 * QRcodesGeneratorController
 */
class QRcodesGeneratorController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $parentPid = $GLOBALS['TSFE']->id;
        $tmpUrl = '';
        foreach($GLOBALS['TSFE']->rootLine as $rootKey => $rootLine) {
        	if($rootLine['tx_realurl_pathsegment']!='') {        		
        		$tmpUrl = ($tmpUrl=='') ? $rootLine['tx_realurl_pathsegment'] : $rootLine['tx_realurl_pathsegment'].'/'.$tmpUrl;
        	}
        }
        $qrUrl .= $this->request->getBaseUri().''.$tmpUrl;
        $homepage = file_get_contents('https://chart.googleapis.com/chart?cht=qr&chs=500&chl=$qrUrl');
        print('<iframe width="500" height="500" src="https://chart.googleapis.com/chart?cht=qr&chs=500&chl=$qrUrl"></iframe>');
        print('<img src="'.$homepage.'" />');
        

\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
 array(
  'class' => __CLASS__,
  'function' => __FUNCTION__,
  'qrUrl' => $qrUrl,
  'getBaseUri' => $this->request->getBaseUri(),
  'TSFE' => $GLOBALS['TSFE'],
  'parentPid' => $parentPid,
 )
);
    }

}