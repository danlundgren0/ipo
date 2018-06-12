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
        //<script type="text/javascript" src="//www.shieldui.com/shared/components/latest/js/jquery-1.11.1.min.js"></script>        
        
        //$GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('jquery', 'var tag = document.createElement(\'script\');tag.src = \'https://www.shieldui.com/shared/components/latest/js/jquery-1.11.1.min.js\';var firstScriptTag = document.getElementsByTagName(\'script\')[0];firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);');

        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile('typo3conf/ext/dl_qrcodesgenerator/Resources/Public/Js/jquery-1.11.1.min.js');
        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile('typo3conf/ext/dl_qrcodesgenerator/Resources/Public/Js/shieldui-all.min.js');
        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile('typo3conf/ext/dl_qrcodesgenerator/Resources/Public/Js/dl_qrcodesgenerator.js');
        //$GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('YT', 'var tag = document.createElement(\'script\');tag.src = \'https://www.youtube.com/iframe_api\';var firstScriptTag = document.getElementsByTagName(\'script\')[0];firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);');
        $i=0;
        $parentPid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('pid');
        $librarytest = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('libtest');
        $pageRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'pages', 'uid=' . $parentPid); //.' AND hidden=0 AND deleted=0');
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($pageRes)) {
            $parentPage = $row;
        }
        $subPageRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('title,uid', 'pages', 'pid=' . $parentPid.' AND hidden=0 AND deleted=0 AND doktype=1');
        $subPages = array();
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($subPageRes)) {
            $subPages[] = $row;
        }
/*        
\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
 array(
  'class' => __CLASS__,
  'function' => __FUNCTION__,
  'getFullUrl' => $this->getFullUrl($parentPid),

 )
);
*/
        $rootlineUtility = new \TYPO3\CMS\Core\Utility\RootlineUtility($parentPid);
        $rootlineArr = $rootlineUtility->get();
        //$parentPid = $GLOBALS['TSFE']->id;
        $tmpUrl = '';
        foreach ($rootlineArr as $rootKey => $rootLine) {
            if ($rootLine['tx_realurl_pathsegment'] != '') {
                $tmpUrl = $tmpUrl == '' ? $rootLine['tx_realurl_pathsegment'] : $rootLine['tx_realurl_pathsegment'] . '/' . $tmpUrl;
            }
            else if($rootLine['uid']!=1) {
            	$tmpUrl = $tmpUrl == '' ? $rootLine['uid'] : $rootLine['uid'] . '/' . $tmpUrl;	
            }
        }
        $qrUrl = $this->request->getBaseUri() . '' . $tmpUrl;
        $qrPages = array();
        
        //Old google.apis - different size based´on url-length
        /*
        $qrPages[] = '<div style="transform: rotate(-90deg);width: 180px;margin-left: 40px;"><img style="overflow: hidden;" width="200" height="200" src="https://chart.googleapis.com/chart?cht=qr&chs=180x180&chl='.$qrUrl.'" frameBorder="0" /><div style="margin-top: 20px;text-align: center;font-size: 22px;font-family: Arial;font-weight: bold;white-space: nowrap;">'.$parentPage['title'].'</div>
            </div>';
        
        */
        /*
        $qrPages[] = '<div style="transform: rotate(-90deg);width: 180px;margin-left: 40px;">
            <img src="https://api.qrserver.com/v1/create-qr-code/?data='.$qrUrl.'&amp;size=180x180" alt="" title="" />
            <div style="margin-top: 20px;text-align: center;font-size: 22px;font-family: Arial;font-weight: bold;white-space: nowrap;">'.$parentPage['title'].'</div>
        </div>';
        */
        $qrPages[$i]['qrUrl'] = $qrUrl;
        $qrPages[$i]['parentPage'] = $parentPage['title'];
    
        
        /*   
        $id = 0;
        //https://davidshimjs.github.io/qrcodejs/            
        $qrPages[] = '<div id="qrcode_'.$id.'" style="transform: rotate(-90deg);width: 180px;margin-left: 40px;">
            <div style="margin-top: 20px;text-align: center;font-size: 22px;font-family: Arial;font-weight: bold;white-space: nowrap;">'.$parentPage['title'].'</div>
            </div>';
		*/
        $i+=1;
        foreach($subPages as $subPage) {
        	$id+=1;
            $rootlineUtility = new \TYPO3\CMS\Core\Utility\RootlineUtility($subPage['uid']);
            $rootlineArr = $rootlineUtility->get();
            $tmpUrl = '';
            foreach ($rootlineArr as $rootKey => $rootLine) {
                if ($rootLine['tx_realurl_pathsegment'] != '') {
                    $tmpUrl = $tmpUrl == '' ? $rootLine['tx_realurl_pathsegment'] : $rootLine['tx_realurl_pathsegment'] . '/' . $tmpUrl;
                }
            	else if($rootLine['uid']!=1) {
                	$tmpUrl = $tmpUrl == '' ? $rootLine['uid'] : $rootLine['uid'] . '/' . $tmpUrl;	
                }
            }
            $qrUrl = $this->request->getBaseUri() . '' . $tmpUrl;
            
            //Old google.apis - different size based´on url-length
            /*
            $qrPages[] = '<div style="transform: rotate(-90deg);width: 180px;margin-left: 48px;"><img style="overflow: hidden;" width="200" height="200" src="https://chart.googleapis.com/chart?cht=qr&chs=180x180&chl='.$qrUrl.'" frameBorder="0" /><div style="margin-top: 20px;text-align: center;font-size: 22px;font-family: Arial;font-weight: bold;white-space: nowrap;">'.$parentPage['title'].'</div>
                <div style="font-weight: bold;text-align: center;font-size: 13px;font-family: Arial;white-space: nowrap;">'.$subPage['title'].'</div>
                </div>';
            */

			/*            
            $qrPages[] = '<div style="transform: rotate(-90deg);width: 180px;margin-left: 48px;">
                <img src="https://api.qrserver.com/v1/create-qr-code/?data='.$qrUrl.'&amp;size=180x180" alt="" title="" />
                <div style="margin-top: 20px;text-align: center;font-size: 22px;font-family: Arial;font-weight: bold;white-space: nowrap;">'.$parentPage['title'].'</div>
                <div style="font-weight: bold;text-align: center;font-size: 13px;font-family: Arial;white-space: nowrap;">'.$subPage['title'].'</div>
            </div>';
			*/
            $qrPages[$i]['qrUrl'] = $qrUrl;
            $qrPages[$i]['parentPage'] = $parentPage['title'];
            $qrPages[$i]['subPage'] = $subPage['title'];
            $i+=1;
            /*
            //https://davidshimjs.github.io/qrcodejs/
            $qrPages[] = '<div id="qrcode_'.$id.'" style="transform: rotate(-90deg);width: 180px;margin-left: 48px;">
                <div style="margin-top: 20px;text-align: center;font-size: 22px;font-family: Arial;font-weight: bold;white-space: nowrap;">'.$parentPage['title'].'</div>
                <div style="font-weight: bold;text-align: center;font-size: 13px;font-family: Arial;white-space: nowrap;">'.$subPage['title'].'</div>
                </div>';

            */    
        }
        $this->view->assign('qrPages',$qrPages);
        $this->view->assign('librarytest',$librarytest);
        
    }

    private function getFullUrl($uid) {
        return $this->controllerContext
            ->getUriBuilder()
            ->reset()
            ->setTargetPageUid($uid)
            //->setArguments(array ARRAY_VARIABLE_OF_ADDITIONAL_ARGUMENTS)
            ->buildFrontendUri();
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