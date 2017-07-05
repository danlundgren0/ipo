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
        $parentPid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('pid');
        $pageRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'pages', 'uid=' . $parentPid); //.' AND hidden=0 AND deleted=0');
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($pageRes)) {
            $parentPage = $row;
        }
        $subPageRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('title,uid', 'pages', 'pid=' . $parentPid.' AND hidden=0 AND deleted=0');
        $subPages = array();
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($subPageRes)) {
            $subPages[] = $row;
        }
/*\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
 array(
  'class' => __CLASS__,
  'function' => __FUNCTION__,
  'parentPage' => $parentPage,
  'subPages' => $subPages,
 )
);*/
        $rootlineUtility = new \TYPO3\CMS\Core\Utility\RootlineUtility($parentPid);
        $rootlineArr = $rootlineUtility->get();
        //$parentPid = $GLOBALS['TSFE']->id;

        $tmpUrl = '';
        foreach ($rootlineArr as $rootKey => $rootLine) {
            if ($rootLine['tx_realurl_pathsegment'] != '') {
                $tmpUrl = $tmpUrl == '' ? $rootLine['tx_realurl_pathsegment'] : $rootLine['tx_realurl_pathsegment'] . '/' . $tmpUrl;
            }
        }
        $qrUrl .= $this->request->getBaseUri() . '' . $tmpUrl;
        //print '<iframe width="100" height="100" src="https://chart.googleapis.com/chart?cht=qr&chs=100&chl='.$qrUrl.'" frameBorder="0"></iframe><div>'.$parentPage['title'].'</div>';
        $qrParent = '<iframe width="100" height="100" src="https://chart.googleapis.com/chart?cht=qr&chs=100&chl='.$qrUrl.'" frameBorder="0"></iframe><div>'.$parentPage['title'].'</div>';
        $this->view->assign('qrParent',$qrParent);
        $qrSubPages = array();
        foreach($subPages as $subPage) {
            $rootlineUtility = new \TYPO3\CMS\Core\Utility\RootlineUtility($subPage['uid']);
            $rootlineArr = $rootlineUtility->get();
            $tmpUrl = '';
            foreach ($rootlineArr as $rootKey => $rootLine) {
                if ($rootLine['tx_realurl_pathsegment'] != '') {
                    $tmpUrl = $tmpUrl == '' ? $rootLine['tx_realurl_pathsegment'] : $rootLine['tx_realurl_pathsegment'] . '/' . $tmpUrl;
                }
            }
            //print('<br>');
            //print '<iframe width="100" height="100" src="https://chart.googleapis.com/chart?cht=qr&chs=100&chl='.$qrUrl.'" frameBorder="0"></iframe><div>'.$parentPage['title'].' - '.$subPage['title'].'</div>';
            $qrSubPages[] = '<iframe width="100" height="100" src="https://chart.googleapis.com/chart?cht=qr&chs=100&chl='.$qrUrl.'" frameBorder="0"></iframe><div>'.$parentPage['title'].' - '.$subPage['title'].'</div>';
        }
        $this->view->assign('qrSubPages',$qrSubPages);
    }
    
    /**
     * action link
     *
     * @return void
     */
    public function linkAction()
    {
        $this->view->assign('pid',$GLOBALS['TSFE']->id);
    }

}