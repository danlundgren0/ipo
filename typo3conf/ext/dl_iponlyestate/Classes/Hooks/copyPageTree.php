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
        }
    }