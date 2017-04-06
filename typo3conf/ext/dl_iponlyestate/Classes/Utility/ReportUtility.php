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
 * General Utility
 */
class ReportUtility {

    /**
     * action getLatestOrNewReport
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Report $reports
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Report $estate
     * @return \DanLundgren\DlIponlyestate\Domain\Model\Report $reports
     */ 
    public static function getLatestOrNewReport($reportPid, $estate, $persistIt=false) {
        $reportPid = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dliponlyestate.']['persistence.']['reportPid'];
        if(!(int)$reportPid>0) {
\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
 array(
  'class' => __CLASS__,
  'function' => __FUNCTION__,
  'ERROR' => 'Report Id saknas',
 )
);
            return NULL;
        }
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        $reportPid = (int)$reportPid;
        //$allReports = $reportRepository->findByPid($reportPid);
        $allReports = $reportRepository->findAll();
        $highestVersion = -1;
        $latestReport = NULL;
        foreach($allReports as $report) {
            if($report->getEstate()==$estate) {
                if((int)$report->getVersion()>(int)$highestVersion) {
                    $highestVersion = (int)$report->getVersion();
                    if($report->getReportIsPosted() && !$report->getIsComplete()) {
                        $startDate = $report->getStartDate();
                    }
                    $latestReport = $report;                
                }
            }
        }
        $highestVersion=($highestVersion==-1)?1:$highestVersion+=1;
        if($latestReport && !$latestReport->getIsComplete() && !$latestReport->getReportIsPosted()) {
            return $latestReport;
        }
        //TODO: Check so reportPid constant is set
        $newReport = self::createNewReport($highestVersion, $estate, $reportPid, $startDate, $persistIt);
        return $newReport;
        
        //$newReport = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DanLundgren\DlIponlyestate\Domain\Model\Report');
        //$newReport->setVersion($highestVersion);

/*        
\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
 array(
  'class' => __CLASS__,
  'function' => __FUNCTION__,
  'newReport' => $newReport,
  'allReports' => $allReports,
  'reportPid' => $reportPid,
 )
);
*/ 
        return $newReport;
    }
    public static function createNewReport($highestVersion, $estate, $reportPid, $startDate=null, $persistIt=false) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $persistenceManager = $objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface');
        $reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        $report = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DanLundgren\DlIponlyestate\Domain\Model\Report');
        $report->setVersion($highestVersion);
		$datetime = new \DateTime();
		$datetime->format('Y-m-d H:i:s');
		$report->setDate($datetime);
		$report->setName($datetime->format('Y-m-d H:i').' Nr: '.$report->getVersion());
        $report->setIsComplete(false);
        $report->setPid($reportPid);
        $report->setExecutiveTechnician($GLOBALS['TSFE']->fe_user->user['uid']);
        if($startDate) {
            $report->setStartDate($startDate);    
        }
        else {
            $report->setStartDate($datetime);
        }        
        $report->setReportIsPosted(false);
        $report->setEstate($estate);
        if($persistIt) {
            $reportRepository->add($report);
            $persistenceManager->persistAll();	
        }

        //$this->data['statusMessage'] = $this->data['statusMessage'].' Ny rapport skapad';
        return $report;
    }
    public static function updateReportWithMessages($reportUid, $message='', $purchase='') {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $persistenceManager = $objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface');
        $reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        $purchaseRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\PurchaseRepository');
        $messageRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\MessageRepository');
        $purchaseObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DanLundgren\DlIponlyestate\Domain\Model\Purchase');
        $messageObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DanLundgren\DlIponlyestate\Domain\Model\Message');
        $report = $reportRepository->findByUid($reportUid);
        if($purchase != '') {
            $purchaseObj->setPurchase($purchase);            
            $report->addPurchase($purchaseObj);
            $reportRepository->update($report);
        }
        if($message != '') {
            $messageObj->setMessage($message);
            //$messageRepository->add($messageObj
            $report->addMessage($messageObj);
            $reportRepository->update($report);
        }        
        $persistenceManager->persistAll();	
        return $report;
    }
    public static function setReportProperties($estateUid, $datetime, $reportUid, $cpUid, $nodeTypeUid, $responsibleTechnician) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        $estateRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\EstateRepository');
        $estate = $estateRepository->findByUid((int) $estateUid);
        $report = $reportRepository->findByUid((int) $reportUid);
		$report->setDate($datetime);
		$report->setName($datetime->format('Y-m-d H:i').' Nr: '.$report->getVersion());
		$report->setEstate($estate);
		$report->setControlPoint($cpUid);
		$report->setNodeType($nodeTypeUid);
		$report->setResponsibleTechnicians($responsibleTechnician);
        $report->setExecutiveTechnician($GLOBALS['TSFE']->fe_user->user['uid']);
        return $report;
    }
    public static function saveReport($reportUid) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $persistenceManager = $objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface');
        $reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        $report = $reportRepository->findByUid((int) $reportUid);
        $datetime = new \DateTime();
		$datetime->format('Y-m-d H:i:s');
        $report->setDate($datetime);
        $report->setReportIsPosted(true);
        $reportRepository->update($report);
        $persistenceManager->persistAll();
        return $report;
    }
    public static function saveNoteFixed($noteUids) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $persistenceManager = $objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface');
        $noteRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\NoteRepository');
        $notes = $noteRepository->findByUidInList($noteUids);
        foreach($notes as $note) {
            $note->setIsComplete(true);
            $noteRepository->update($note);
        }
        $persistenceManager->persistAll();
    }
    public static function saveNote($report, $cpUid, $questUid, $noteUid, $noteText, $noteState) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $persistenceManager = $objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface');
        $reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        $questionRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\QuestionRepository');
        $controlPointRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ControlPointRepository');
        $note = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DanLundgren\DlIponlyestate\Domain\Model\Note');
		$newVerNo = -2;
		foreach($report->getNotes() as $prevNote) {
			if($prevNote->getVersion()>$newVerNo && $prevNote->getQuestion()==$questUid) {
				$newVerNo = $prevNote->getVersion();
			}
		}
		$cp = $controlPointRepository->findByUid($cpUid);
		$note->setControlPoint($cp);
        $newVerNo+=1;       
        if($newVerNo<0) {
            $note->setVersion(1);    
        }
        else {
            $note->setVersion($newVerNo);    
        }
		//$note->setVersion($newVerNo+=1);
		$note->setRemarkType($noteState);
		$note->setComment($noteText);
		$note->setState($noteState);
		if($note->getState()=='ok') {
			$note->setIsComplete(1);
		}
        $question = $questionRepository->findByUid($questUid);
		$note->setQuestion($question);
		$note->setPid($report->getPid());
        $report->addNote($note);
        if($report->getUid()==NULL) {
            $reportRepository->add($report);
        }
        else {
            $reportRepository->update($report);
        }
        $persistenceManager->persistAll();
        return $note;
        /*
		if($noteUid == '-1') {
			$report->addNote($note);
			$note->setVersion(1);	
			$this->data['statusMessage'] = $this->data['statusMessage'].' Ny anmärkning skapad ';
		}
		else {
			//$report->update($note);
			$this->data['statusMessage'] = $this->data['statusMessage'].' Anmärkning sparad ';
			//$note->setVersion($newVerNo+=1);	
		}
        */
        //$reportRepository->add($report);
        //$persistenceManager->persistAll();
    }
    /**
     * action getUnPostedReports
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Report $reports
     * @return array
     */    
    public static function getUnPostedReports($reportPid, $estate, $startDate) {

    }

    /**
     * action getPostedReports
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Report $reports
     * @return array
     */    
    public static function getPostedReports($reportPid, $estate, $startDate) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        //$allReports = $reportRepository->findByPid($reportPid); 
        //$allReports = $reportRepository->findByEstate($estate);
        $allReports = $reportRepository->findAll();
        $postedReports = array();
        foreach($allReports as $report) {
            if($report->getStartDate() == $startDate && $report->getEstate()==$estate) {
                $postedReports[] = $report;
            }
        }
        return $postedReports;
    }

    /**
     * action getNextVersionNumber
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Report $reports
     * @return int
     */
    public static function getNextVersionNumber($reports) {
        $tmpVer = 0;
        if($reports) {
            foreach($reports as $report) {                
                if($report->getVersion()>$tmpVer) {
                    $tmpVer = $report->getVersion();
                }
            }
        }
        return $tmpVer += 1;
    }

    /**
     * action getReportWithNewVersion
     *
     * @return array
     */
    public static function getReportWithNewVersion($verNo) {
        //TODO generate and retun new version report
    }

    /**
     * action isAllNotesOk
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Report $report
     * @return boolean
     */
    public static function isLatestNoteOk($report, $question) {
        //TODO generate and retun new version report
        foreach($report->getNotes() as $note) {
            //Sort on version no. Get highest
            //if($note->getRemarkType)
        }
    }

}