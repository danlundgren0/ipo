<?php
    namespace DanLundgren\DlIponlyestate\Hooks;
    class injectCopyAndPaste {
        protected  $rootPageIsSelected = FALSE;

        /*
        *  $status      new, updated
        *  $table       fe_users
        *  $id          new: NEW5691208b2428b763522287 updated: 4
        *  $fieldArray  feuser data
        *  $pObj        ?
         */
        public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, &$pObj) {
            if($table == 'tx_dliponlyestate_domain_model_report') {
                $GLOBALS['DanLundgren']['reportPid'] = $fieldArray['pid'];
                $GLOBALS['DanLundgren']['hasEcexuted'] = FALSE;
            }
        }
        public function processDatamap_afterAllOperations(&$pObj) {
            if($GLOBALS['DanLundgren'] && is_array($GLOBALS['DanLundgren']) && !$GLOBALS['DanLundgren']['hasEcexuted'] && isset($GLOBALS['DanLundgren']['reportPid'])) {
                $GLOBALS['TYPO3_DB']->exec_DELETEquery('tx_dliponlyestate_domain_model_note', 'pid='.intval($GLOBALS['DanLundgren']['reportPid']));
                $GLOBALS['TYPO3_DB']->exec_DELETEquery('tx_dliponlyestate_domain_model_report', 'pid='.intval($GLOBALS['DanLundgren']['reportPid']));                
                $GLOBALS['DanLundgren']['hasEcexuted'] = TRUE;
            }
            if(isset($GLOBALS['DanLundgren']['mainPid']) && (int)$GLOBALS['DanLundgren']['mainPid']>1) {
                $this->setTxRealurlPathsegment();
            } 
        }
        public function processDatamap_afterDatabaseOperations($status, $table, $rawId, $fieldArray, $pObj) {
            if($table == 'pages' && !isset($GLOBALS['DanLundgren']['mainPid'])) {
                $GLOBALS['DanLundgren']['mainPid'] = $pObj->substNEWwithIDs[$rawId];
            }
        }
        private function setTxRealurlPathsegment() {
            $pageId = (int)$GLOBALS['DanLundgren']['mainPid'];
            $mainPageRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('title', 'pages', 'uid='.$pageId);
            while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($mainPageRes)) {
                $md5 = md5($row['title'].''.$pageId);
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('pages', 'uid='.$pageId, array('tx_realurl_pathsegment' => $md5));
            }
            $subPageRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid,title', 'pages', 'pid='.$pageId);
            while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($subPageRes)) {
                $md5 = md5($row['title'].''.$row['uid']);
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('pages', 'uid='.$row['uid'], array('tx_realurl_pathsegment' => $md5));
            }
        }
    }