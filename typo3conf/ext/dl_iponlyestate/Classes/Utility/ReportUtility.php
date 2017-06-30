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

    public static function getAllReportsWithRemarks($clickedReport=NULL, $estate=NULL, $reports=NULL) {    
        $reportsArr = array();
        if(!$clickedReport || !$estate) return $reportsArr;
        $reportsArr['estateName'] = $estate->getName();
        $reportsArr['estateUid'] = $estate->getUid();
        $reportsArr['pageLink'] = $estate->getPageLink();
        $reportsArr['nodeTypeName'] = $estate->getNodeTypeName();
        $reportsArr['respTechnicianName'] = $estate->getRespTechnicianName();
        //TODO: Move all report method to foreach loop
        $reportsArr['reportUid'] = $clickedReport->getUid();
        $reportsArr['reportName'] = $clickedReport->getName();        
        $reportsArr['dateVersion'] = $clickedReport->getDate()->format('Y-m-d').' Nr '.$clickedReport->getVersion();
        $reportsArr['reportVersion'] = $clickedReport->getVersion();
        $reportsArr['reportDate'] = $clickedReport->getDate()->format('Y-m-d');        
        $reportsArr['execTechnicianName'] = $clickedReport->getExecTechnicianName();
        $reportsArr['noOfCriticalRemarks'] = $clickedReport->getNoOfCriticalRemarks();
        $reportsArr['getNoOfOk'] = $clickedReport->getNoOfOk();
        $reportsArr['noOfRemarks'] = $clickedReport->getNoOfRemarks();
        $reportsArr['noOfNotes'] = $clickedReport->getNoOfNotes();
        $reportsArr['noOfPurchases'] = $clickedReport->getNoOfPurchases();
        $reportsArr['noOfReportedMeasurements'] = $clickedReport->getNoOfReportedMeasurements();
        $reportsArr['noOfQuestionsLeft'] = 0;
        $reportsArr['allCheckedAndOk'] = FALSE;	
        $noOfPostedMeasure = 0;
        $noOfOngoingNotes = 0;
        $noOfPostedNotes = 0;
        $noOfOngoingNotes = 0;
        $noOfQuestionsReported = 0;
        $noOfQuestionsLeft = 0;
        $noOfTotalNotesAndMeas = 0;
        foreach($estate->getControlPoints() as $cp) {
            $levelOneIdentifier = 'estate';
            $levelTwoIdentifier = 'report';
            $cpIdentifier = 'cp_'.$cp->getUid();
            foreach($cp->getQuestions() as $q) {
            	$noOfTotalNotesAndMeas +=1;
                $questIdentifier = 'quest_'.$q->getUid();
                $qIsReported = false;
                foreach($reports as $report) {
                	if($clickedReport->getDate()->format('Y-m-d')>=$report->getDate()->format('Y-m-d')) {
	                    foreach($report->getNotes() as $note) {
	                        $noteIdentifier = 'note_'.$note->getUid();
	                        if($note->getQuestion()->getUid() == $q->getUid()) {
	                            $qIsReported = true;
	                            $noOfQuestionsReported += 1;
	                            if($note->getIsComplete()) {
	                                $noOfPostedNotes+=1;
	                            }
	                            else {
	                                $noOfOngoingNotes+=1;
	                            }
	                            $reportsArr['noOfQuestionsReported'] = $noOfQuestionsReported;
	                            $reportsArr['noOfOngoingNotes'] = $noOfOngoingNotes;
	                            $reportsArr['noOfPostedNotes'] = $noOfPostedNotes;
	                            $reportsArr['controlPoints'][$cpIdentifier]['cpName'] = $note->getControlPoint()->getHeader();
	                            $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['type'] = 'note';
	                            $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['questionName'] = $note->getQuestion()->getHeader();
                                $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['noteUid'] = $note->getUid();
	                            $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['noteIsComplete'] = $note->getIsComplete();
	                            $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['comment'] = $note->getComment();
	                            $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['remarkType'] = $note->getRemarkType();
	                            $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['status'] = 'checked-'.$note->getRemarkType();
                                $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['date'] = $note->getDate()->format('Y-m-d');
                                $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['exeTech'] = $note->getExecutiveTechnician();
	                            //$reportsArr[$cpIdentifier]['image'] = $note->getImages();
	                            if($note->getImages() && $note->getImages()->getUid()>0) {
	                                $fileRefUidRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid_local', 'sys_file_reference', 'uid='.$note->getImages()->getUid());
	                                while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($fileRefUidRes)) {
	                                    $uidLocal = $row['uid_local'];
	                                    break;
	                                }
	                                $sysFileRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'sys_file', 'uid='.$uidLocal);
	                                while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($sysFileRes)) {
	                                    $sysFile = $row;
	                                    break;
	                                }
	                                if($sysFile && count($sysFile)>0) {
	                                    $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['image'] = '/fileadmin/'.$sysFile['identifier'];
	                                }
	                            }
	                            //break;    
	                        }
	                    }
	                    if(!$qIsReported) {
	                        foreach($report->getReportedMeasurement() as $meas) {
	                            if($meas->getQuestion()->getUid() == $q->getUid()) {
	                                $noteIdentifier = 'meas_'.$meas->getUid();
	                                $noOfQuestionsReported += 1;
	                                $noOfPostedMeasure += 1;
	                                $qIsReported = true;
	                                $reportsArr['noOfPostedMeasure'] = $noOfPostedMeasure;
	                                $reportsArr['noOfQuestionsReported'] = $noOfQuestionsReported;
	                                $reportsArr['nodeTypeName'] = $report->getNodeTypeName();
	                                $reportsArr['dateVersion'] = $report->getDate()->format('Y-m-d').' Nr '.$report->getVersion();
	                                $reportsArr['respTechnicianName'] = $report->getRespTechnicianName();
	                                $reportsArr['execTechnicianName'] = $report->getExecTechnicianName();
	                                $reportsArr['controlPoints'][$cpIdentifier]['cpName'] = $meas->getControlPoint()->getHeader();
	    							$reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['type'] = 'measure';
	                                $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['questionName'] = $meas->getQuestion()->getHeader();
	                                $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['measName'] = $meas->getName();
	                                $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['unit'] = $meas->getUnit();
	                                $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['value'] = $meas->getValue();
	                                $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['status'] = 'measure-checked';
	                                break;
	                            }
	                        }
	                    }
	                    if(!$qIsReported) {
	                        $noOfQuestionsLeft += 1;
	                        $reportsArr['noOfQuestionsLeft'] = $noOfQuestionsLeft;
	                        $reportsArr['controlPoints'][$cpIdentifier]['cpName'] = $cp->getHeader();
	                        $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['questionName'] = $q->getHeader();
	                        $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['status'] = 'not-checked';
	                        $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['message'] = 'Ej kontrollerad';
	                    }
                	}
                }
            }
        }
        $reportsArr['noOfTotalNotesAndMeas']=$noOfTotalNotesAndMeas;
        $reportsArr['allCheckedAndOk'] = FALSE;
        $reportsArr['partlyCheckedAndOk'] = FALSE;
        $reportsArr['newOrNotCheckedAtAll'] = FALSE;
        if((int)$reportsArr['getNoOfOk']+(int)$reportsArr['noOfReportedMeasurements']==(int)$reportsArr['noOfTotalNotesAndMeas']) {
        	$reportsArr['allCheckedAndOk'] = TRUE;	
        }
        if(
        	((int)$reportsArr['getNoOfOk']+(int)$reportsArr['noOfReportedMeasurements']>0) &&
        	((int)$reportsArr['getNoOfOk']+(int)$reportsArr['noOfReportedMeasurements']<(int)$reportsArr['noOfTotalNotesAndMeas'])) {
        	$reportsArr['partlyCheckedAndOk'] = TRUE;	
        }
        if((int)$reportsArr['getNoOfOk']+(int)$reportsArr['noOfReportedMeasurements']==0) {
        	$reportsArr['newOrNotCheckedAtAll'] = TRUE;	
        }
        return $reportsArr;
    }
    public static function getCompleteReport($clickedReport=NULL, $estate=NULL, $reports=NULL) {    
        $reportsArr = array();
        if(!$clickedReport || !$estate) return $reportsArr;
        $reportsArr['estateName'] = $estate->getName();
        $reportsArr['estateUid'] = $estate->getUid();
        $reportsArr['pageLink'] = $estate->getPageLink();
        $reportsArr['nodeTypeName'] = $estate->getNodeTypeName();
        $reportsArr['respTechnicianName'] = $estate->getRespTechnicianName();
        //TODO: Move all report method to foreach loop
        $reportsArr['reportUid'] = $clickedReport->getUid();
        $reportsArr['reportName'] = $clickedReport->getName();        
        $reportsArr['dateVersion'] = $clickedReport->getDate()->format('Y-m-d').' Nr '.$clickedReport->getVersion();
        $reportsArr['reportVersion'] = $clickedReport->getVersion();
        $reportsArr['reportDate'] = $clickedReport->getDate()->format('Y-m-d');        
        $reportsArr['execTechnicianName'] = $clickedReport->getExecTechnicianName();
        $reportsArr['noOfCriticalRemarks'] = $clickedReport->getNoOfCriticalRemarks();
        $reportsArr['getNoOfOk'] = $clickedReport->getNoOfOk();
        $reportsArr['noOfRemarks'] = $clickedReport->getNoOfRemarks();
        $reportsArr['noOfNotes'] = $clickedReport->getNoOfNotes();
        $reportsArr['noOfPurchases'] = $clickedReport->getNoOfPurchases();
        $reportsArr['noOfReportedMeasurements'] = $clickedReport->getNoOfReportedMeasurements();
        $reportsArr['noOfQuestionsLeft'] = 0;
        $reportsArr['allCheckedAndOk'] = FALSE; 
        $noOfPostedMeasure = 0;
        $noOfOngoingNotes = 0;
        $noOfPostedNotes = 0;
        $noOfOngoingNotes = 0;
        $noOfQuestionsReported = 0;
        $noOfQuestionsLeft = 0;
        $noOfTotalNotesAndMeas = 0;
        foreach($estate->getControlPoints() as $cp) {
            $levelOneIdentifier = 'estate';
            $levelTwoIdentifier = 'report';
            $cpIdentifier = 'cp_'.$cp->getUid();
            foreach($cp->getQuestions() as $q) {
                $noOfTotalNotesAndMeas +=1;
                $questIdentifier = 'quest_'.$q->getUid();
                $qIsReported = false;
                foreach($clickedReport->getNotes() as $note) {
                    $noteIdentifier = 'note_'.$note->getUid();
                    if($note->getQuestion()->getUid() == $q->getUid()) {
                        $qIsReported = true;
                        $noOfQuestionsReported += 1;
                        if($note->getIsComplete()) {
                            $noOfPostedNotes+=1;
                        }
                        else {
                            $noOfOngoingNotes+=1;
                        }
                        $reportsArr['noOfQuestionsReported'] = $noOfQuestionsReported;
                        $reportsArr['noOfOngoingNotes'] = $noOfOngoingNotes;
                        $reportsArr['noOfPostedNotes'] = $noOfPostedNotes;
                        $reportsArr['controlPoints'][$cpIdentifier]['cpName'] = $note->getControlPoint()->getHeader();
                        $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['type'] = 'note';
                        $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['questionName'] = $note->getQuestion()->getHeader();
                        $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['noteUid'] = $note->getUid();
                        $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['noteIsComplete'] = $note->getIsComplete();
                        $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['comment'] = $note->getComment();
                        $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['remarkType'] = $note->getRemarkType();
                        $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['status'] = 'checked-'.$note->getRemarkType();                        
                        //$reportsArr[$cpIdentifier]['image'] = $note->getImages();
                        if($note->getImages() && $note->getImages()->getUid()>0) {
                            $fileRefUidRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid_local', 'sys_file_reference', 'uid='.$note->getImages()->getUid());
                            while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($fileRefUidRes)) {
                                $uidLocal = $row['uid_local'];
                                break;
                            }
                            $sysFileRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'sys_file', 'uid='.$uidLocal);
                            while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($sysFileRes)) {
                                $sysFile = $row;
                                break;
                            }
                            if($sysFile && count($sysFile)>0) {
                                $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['image'] = '/fileadmin/'.$sysFile['identifier'];
                            }
                        }
                        //break;    
                    }
                }
                if(!$qIsReported) {
                    foreach($clickedReport->getReportedMeasurement() as $meas) {
                        if($meas->getQuestion()->getUid() == $q->getUid()) {
                            $noteIdentifier = 'meas_'.$meas->getUid();
                            $noOfQuestionsReported += 1;
                            $noOfPostedMeasure += 1;
                            $qIsReported = true;
                            $reportsArr['noOfPostedMeasure'] = $noOfPostedMeasure;
                            $reportsArr['noOfQuestionsReported'] = $noOfQuestionsReported;
                            $reportsArr['nodeTypeName'] = $clickedReport->getNodeTypeName();
                            $reportsArr['dateVersion'] = $clickedReport->getDate()->format('Y-m-d').' Nr '.$clickedReport->getVersion();
                            $reportsArr['respTechnicianName'] = $clickedReport->getRespTechnicianName();
                            $reportsArr['execTechnicianName'] = $clickedReport->getExecTechnicianName();
                            $reportsArr['controlPoints'][$cpIdentifier]['cpName'] = $meas->getControlPoint()->getHeader();
                            $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['type'] = 'measure';
                            $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['questionName'] = $meas->getQuestion()->getHeader();
                            $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['measName'] = $meas->getName();
                            $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['unit'] = $meas->getUnit();
                            $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['value'] = $meas->getValue();
                            $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['notes'][$noteIdentifier]['status'] = 'measure-checked';
                            break;
                        }
                    }
                }
                if(!$qIsReported) {
                    $noOfQuestionsLeft += 1;
                    $reportsArr['noOfQuestionsLeft'] = $noOfQuestionsLeft;
                    $reportsArr['controlPoints'][$cpIdentifier]['cpName'] = $cp->getHeader();
                    $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['questionName'] = $q->getHeader();
                    $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['status'] = 'not-checked';
                    $reportsArr['controlPoints'][$cpIdentifier]['questions'][$questIdentifier]['message'] = 'Ej kontrollerad';
                }
            }
        }
        $reportsArr['noOfTotalNotesAndMeas']=$noOfTotalNotesAndMeas;
        $reportsArr['allCheckedAndOk'] = FALSE;
        $reportsArr['partlyCheckedAndOk'] = FALSE;
        $reportsArr['newOrNotCheckedAtAll'] = FALSE;
        if((int)$reportsArr['getNoOfOk']+(int)$reportsArr['noOfReportedMeasurements']==(int)$reportsArr['noOfTotalNotesAndMeas']) {
            $reportsArr['allCheckedAndOk'] = TRUE;  
        }
        if(
            ((int)$reportsArr['getNoOfOk']+(int)$reportsArr['noOfReportedMeasurements']>0) &&
            ((int)$reportsArr['getNoOfOk']+(int)$reportsArr['noOfReportedMeasurements']<(int)$reportsArr['noOfTotalNotesAndMeas'])) {
            $reportsArr['partlyCheckedAndOk'] = TRUE;   
        }
        if((int)$reportsArr['getNoOfOk']+(int)$reportsArr['noOfReportedMeasurements']==0) {
            $reportsArr['newOrNotCheckedAtAll'] = TRUE; 
        }
        return $reportsArr;
    }
    public static function adaptPostedReportsForOutput($reportsByEstates) {    
        if(count($reportsByEstates)<=0) {
            return NULL;
        }
        $reportsArr = array();        
        foreach ($reportsByEstates as $objType) {
            if($objType instanceof \DanLundgren\DlIponlyestate\Domain\Model\Estate) {
                $estate = $objType;
                $levelOneIdentifier = 'estate_'.$estate->getUid();
                $reportsArr['level1'][$levelOneIdentifier]['estateName'] = $estate->getName();
                $reportsArr['level1'][$levelOneIdentifier]['estateUid'] = $estate->getUid();
                $reportsArr['level1'][$levelOneIdentifier]['pageLink'] = $estate->getPageLink();
                $reportsArr['level1'][$levelOneIdentifier]['nodeTypeName'] = $estate->getNodeType()->getName();
                $reportsArr['level1'][$levelOneIdentifier]['respTechnicianName'] = $estate->getRespTechnicianName();
                $reportsArr['level1'][$levelOneIdentifier]['newOrNotCheckedAtAll'] = FALSE;
                $reportsArr['level1'][$levelOneIdentifier]['hasReports'] = 0;
                continue;
            }
            //$reportsArr['level1']['hasReports'] = count($reports->getreport());            
            $noOfCompletedNotes = 0;
            foreach($objType as $report) {
            	$noOfTotalNotesAndMeas = 0;
            	$isAtLeastPartlyChecked = FALSE;
            	foreach($report->getEstate()->getControlPoints() as $cp) {
            		$noOfTotalNotesAndMeas += count($cp->getQuestions());
            	}
                $levelOneIdentifier = 'estate_'.$report->getEstate()->getUid();
                $levelTwoIdentifier = 'report_'.$report->getUid();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['totalNoOfCompletedNotes'] = $report->getTotalNoOfCompletedNotes();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['totalNoOfCriticalRemarks'] = $report->getTotalNoOfCriticalRemarks();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['totalNoOfRemarks'] = $report->getTotalNoOfRemarks();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['totalNoOfPurchases'] = $report->getTotalNoOfPurchases();
                $reportsArr['level1'][$levelOneIdentifier]['estateName'] = $report->getEstate()->getName();
                $reportsArr['level1'][$levelOneIdentifier]['estateUid'] = $report->getEstate()->getUid();
                $reportsArr['level1'][$levelOneIdentifier]['pageLink'] = $report->getEstate()->getPageLink();
                $reportsArr['level1'][$levelOneIdentifier]['nodeTypeName'] = $report->getEstate()->getNodeType()->getName();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['nodeTypeName'] = $report->getEstate()->getNodeType()->getName();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['respTechnicianName'] = $report->getEstate()->getRespTechnicianName();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['execTechnicianName'] = $report->getExecTechnicianName();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['dateVersion'] = $report->getDate()->format('Y-m-d').' Nr '.$report->getVersion();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['hasNotes'] = count($report->getNotes());
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['reportUid'] = $report->getUid();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['reportName'] = $report->getName();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfCriticalRemarks'] = $report->getNoOfCriticalRemarks();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfRemarks'] = $report->getNoOfRemarks();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfCompletedNotes'] = $report->getAllCompletedNotes();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfNotes'] = $report->getNoOfNotes();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfPurchases'] = $report->getNoOfPurchases();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['newOrNotCheckedAtAll'] = FALSE;
                $reportsArr['level1'][$levelOneIdentifier]['hasReports'] = count($objType);
                if(count($report->getNotes())==0) {
                    $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['hasNotes'] = count($report->getNotes());
                }
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['getNoOfOk'] = $report->getNoOfOk();
                foreach($report->getNotes() as $note) {
                	$isAtLeastPartlyChecked = TRUE;
                    if($note->getIsComplete()) {
                        $noOfCompletedNotes+=1;
                    }					
                    $levelThreeIdentifier = 'cp_'.$note->getControlPoint()->getUid();
                    $levelFourIdentifier = 'quest_'.$note->getQuestion()->getUid();                                    
                    //$reportsArr['level1'][$levelOneIdentifier]['estateName'] = $report->getEstate()->getName();
                    //$reportsArr['level1'][$levelOneIdentifier]['estateUid'] = $report->getEstate()->getUid();
                    //$reportsArr['level1'][$levelOneIdentifier]['pageLink'] = $report->getEstate()->getPageLink();
                    //$reportsArr['level1'][$levelOneIdentifier]['nodeTypeName'] = $report->getEstate()->getNodeType()->getName();
                    //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['hasNotes'] = count($report->getNotes());
                    //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['reportUid'] = $report->getUid();
                    //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['reportName'] = $report->getName();
                    //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['nodeTypeName'] = $report->getEstate()->getNodeType()->getName();
                    //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['dateVersion'] = $report->getDate()->format('Y-m-d').' Nr '.$report->getVersion();
                    //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['respTechnicianName'] = $report->getEstate()->getRespTechnicianName();
                    //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfCriticalRemarks'] = $report->getNoOfCriticalRemarks();
                    //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfRemarks'] = $report->getNoOfRemarks();
                    //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfCompletedNotes'] = $report->getAllCompletedNotes();
                    //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['execTechnicianName'] = $report->getExecTechnicianName();
                    //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfNotes'] = $report->getNoOfNotes();
                    //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfPurchases'] = $report->getNoOfPurchases();
                    $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['cpName'] = $note->getControlPoint()->getHeader();
                    $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['questionName'] = $note->getQuestion()->getHeader();
                    $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['comment'] = $note->getComment();
                    $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['remarkType'] = $note->getRemarkType();
                    //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['image'] = $note->getImages();
                    if($note->getImages() && $note->getImages()->getUid()>0) {
                        $fileRefUidRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid_local', 'sys_file_reference', 'uid='.$note->getImages()->getUid());
                        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($fileRefUidRes)) {
                            $uidLocal = $row['uid_local'];
                            break;
                        }
                        $sysFileRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'sys_file', 'uid='.$uidLocal);
                        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($sysFileRes)) {
                            $sysFile = $row;
                            break;
                        }
                        if($sysFile && count($sysFile)>0) {
                            $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['image'] = 'fileadmin/'.$sysFile['identifier'];
                        }
                    }
                }
                $noOfMeasurements = 0;
                foreach($report->getReportedMeasurement() as $measurement) {
                	$isAtLeastPartlyChecked = TRUE;
                    $noOfMeasurements+=1;
                }
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfMeasurements'] = $noOfMeasurements;
		        $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfTotalNotesAndMeas']=$noOfTotalNotesAndMeas;
		        $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['allCheckedAndOk'] = FALSE;
		        $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['partlyCheckedAndOk'] = FALSE;
		        //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['newOrNotCheckedAtAll'] = FALSE;

		        $tmpNoOfOk = $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['getNoOfOk'];
		        if((int)$tmpNoOfOk+(int)$noOfMeasurements==(int)$noOfTotalNotesAndMeas) {
		        	$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['allCheckedAndOk'] = TRUE;	
		        }
		        else if($isAtLeastPartlyChecked) {
		        	$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['partlyCheckedAndOk'] = TRUE;	
		        }
		        else if(!$isAtLeastPartlyChecked) {
		        	$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['newOrNotCheckedAtAll'] = TRUE;	
		        }
            }
        }
/*\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
 array(
  'class' => __CLASS__,
  'function' => __FUNCTION__,
  'reportsArr' => $reportsArr,
 )
);*/
        return $reportsArr;
    }
    public static function adaptReportsForOutput($reports) {
        if(count($reports)<=0) {
            return NULL;
        }
        $reportsArr = array();
        foreach($reports as $report) {
            $levelOneIdentifier = 'report_'.$report->getUid();
            foreach($report->getNotes() as $note) {
                $levelOneIdentifier = 'report_'.$report->getUid();
                $levelTwoIdentifier = 'cp_'.$note->getControlPoint()->getUid();
                $levelThreeIdentifier = 'quest_'.$note->getQuestion()->getUid();
                $reportsArr['level1'][$levelOneIdentifier]['reportUid'] = $report->getUid();
                $reportsArr['level1'][$levelOneIdentifier]['reportName'] = $report->getName();
                $reportsArr['level1'][$levelOneIdentifier]['estateName'] = $report->getEstate()->getName();
                $reportsArr['level1'][$levelOneIdentifier]['estateUid'] = $report->getEstate()->getUid();
                $reportsArr['level1'][$levelOneIdentifier]['pageLink'] = $report->getEstate()->getPageLink();
                $reportsArr['level1'][$levelOneIdentifier]['nodeTypeName'] = $report->getNodeTypeName();
                $reportsArr['level1'][$levelOneIdentifier]['dateVersion'] = $report->getDate()->format('Y-m-d').' Nr '.$report->getVersion();
                $reportsArr['level1'][$levelOneIdentifier]['respTechnicianName'] = $report->getRespTechnicianName();
                $reportsArr['level1'][$levelOneIdentifier]['noOfCriticalRemarks'] = $report->getNoOfCriticalRemarks();
                $reportsArr['level1'][$levelOneIdentifier]['noOfRemarks'] = $report->getNoOfRemarks();
                $reportsArr['level1'][$levelOneIdentifier]['execTechnicianName'] = $report->getExecTechnicianName();
                $reportsArr['level1'][$levelOneIdentifier]['noOfNotes'] = $report->getNoOfNotes();
                $reportsArr['level1'][$levelOneIdentifier]['noOfPurchases'] = $report->getNoOfPurchases();


                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['cpName'] = $note->getControlPoint()->getHeader();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['questionName'] = $note->getQuestion()->getHeader();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['comment'] = $note->getComment();
                $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['remarkType'] = $note->getRemarkType();
                //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['image'] = $note->getImages();
                if($note->getImages() && $note->getImages()->getUid()>0) {
                    $fileRefUidRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid_local', 'sys_file_reference', 'uid='.$note->getImages()->getUid());
                    while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($fileRefUidRes)) {
                        $uidLocal = $row['uid_local'];
                        break;
                    }
                    $sysFileRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'sys_file', 'uid='.$uidLocal);
                    while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($sysFileRes)) {
                        $sysFile = $row;
                        break;
                    }
                    if($sysFile && count($sysFile)>0) {
                        $reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['image'] = 'fileadmin/'.$sysFile['identifier'];
                    }
                }
            }
            foreach($report->getReportedMeasurement() as $measurement) {
            
            }
        }
        return $reportsArr;
    }

    /**
     * action getNextReportVersionNumber
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Report $estate
     * @return int
     */
    public static function getNextReportVersionNumber($estate) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        $allReports = $reportRepository->findAll();
        $highestVersion = -1;
        $latestReport = NULL;
        foreach($allReports as $report) {
            if($report->getEstate()==$estate) {
                if((int)$report->getVersion()>(int)$highestVersion) {
                    $highestVersion = (int)$report->getVersion();
                }
            }
        }
        $highestVersion=($highestVersion==-1)?1:$highestVersion+=1;
        return $highestVersion;
    }

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
                    //if($report->getReportIsPosted() && !$report->getIsComplete()) {
                    //    $startDate = $report->getStartDate();
                    //}
                    $latestReport = $report;                
                }
            }
        }
        $highestVersion=($highestVersion==-1)?1:$highestVersion+=1;
        if($latestReport && !$latestReport->getIsComplete() && !$latestReport->getReportIsPosted()) {
            return $latestReport;
        }
        return NULL;
        //$newReport = self::createNewReport($highestVersion, $estate, $reportPid, $startDate, true);
        //return $newReport;
    }
    //public static function createNewReport($highestVersion, $estate, $reportPid, $startDate=null, $persistIt=false) {
    public static function createNewReport($highestVersion, $estateUid, $startDate=null, $persistIt=false) {
        $reportPid = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dliponlyestate.']['persistence.']['reportPid'];
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $estateRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\EstateRepository');
        if((int)$estateUid>0) {
            $estate = $estateRepository->findByUid((int) $estateUid);    
        }        
        $persistenceManager = $objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface');
        $reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        $report = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DanLundgren\DlIponlyestate\Domain\Model\Report');
        $report->setVersion($highestVersion);
		$datetime = new \DateTime();
		$datetime->format('Y-m-d H:i:s');
		$report->setDate($datetime);
		$report->setName($estate->getName.' '. $datetime->format('Y-m-d H:i').' Nr: '.$report->getVersion());
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
    public static function getNextMeasureVersion($estate) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        $allReports = $reportRepository->findAll();
        $newVerNo = 0;
        foreach($allReports as $report) {
            if($report->getEstate()==$estate) {
                foreach($report->getReportedMeasurement() as $prevMeasurement) {
                    //if($prevMeasurement->getVersion()>$newVerNo && $prevMeasurement->getQuestion()==$questUid) {
                    if($prevMeasurement->getVersion()>$newVerNo) {
                        $newVerNo = $prevMeasurement->getVersion();
                    }
                }
            }
        }
        return $newVerNo+=1;  
    }
    public static function getNextNoteVersion($estate) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        $allReports = $reportRepository->findAll();
        $newVerNo = 0;
        foreach($allReports as $report) {
            if($report->getEstate()==$estate) {
                foreach($report->getNotes() as $prevNote) {
                    //if($prevMeasurement->getVersion()>$newVerNo && $prevMeasurement->getQuestion()==$questUid) {
                    if($prevNote->getVersion()>$newVerNo) {
                        $newVerNo = $prevNote->getVersion();
                    }
                }
            }
        }
        return $newVerNo+=1;  
    }
    public static function saveMeasurement($report, $cpUid, $questUid, $measureUid, $measureValue, $measureName, $measureUnit, $pid) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $persistenceManager = $objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface');
        $reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        $questionRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\QuestionRepository');
        $controlPointRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ControlPointRepository');
        $reportedMeasurementRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportedMeasurementRepository');

        if((int)$measureUid>0) {
            $reportedMeasurement = $reportedMeasurementRepository->findByUid((int)$measureUid);
        }
        if(!$reportedMeasurement) {
            $reportedMeasurement = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DanLundgren\DlIponlyestate\Domain\Model\ReportedMeasurement');
        }   
        //reportedMeasurement = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DanLundgren\DlIponlyestate\Domain\Model\ReportedMeasurement');
		$newVerNo = 0;
        /*
		foreach($report->getReportedMeasurement() as $prevMeasurement) {
			//if($prevMeasurement->getVersion()>$newVerNo && $prevMeasurement->getQuestion()==$questUid) {
            if($prevMeasurement->getVersion()>$newVerNo) {
				$newVerNo = $prevMeasurement->getVersion();
			}
		}
        */
		$cp = $controlPointRepository->findByUid($cpUid);
		$reportedMeasurement->setControlPoint($cp);
        //$newVerNo+=1;       
        $reportedMeasurement->setVersion(self::getNextMeasureVersion($report->getEstate()));
        /*
        if($newVerNo<0) {
            $reportedMeasurement->setVersion(1);    
        }
        else {
            $reportedMeasurement->setVersion($newVerNo);    
        }
        */
		//$note->setVersion($newVerNo+=1);
        $reportedMeasurement->setPageId($pid);
		$reportedMeasurement->setName($measureName);
		$reportedMeasurement->setUnit($measureUnit);
		$reportedMeasurement->setValue($measureValue);
        $reportedMeasurement->setExecutiveTechnician($GLOBALS['TSFE']->fe_user->user['name']);
        $datetime = new \DateTime();
		$datetime->format('Y-m-d H:i:s');
        $reportedMeasurement->setDate($datetime);
        $question = $questionRepository->findByUid($questUid);
		$reportedMeasurement->setQuestion($question);
		$reportedMeasurement->setPid($report->getPid());
        //$report->addReportedMeasurement($reportedMeasurement);
        if((int)$measureUid>0) {
            $reportedMeasurementRepository->update($reportedMeasurement);
        }
        else {
            $report->addReportedMeasurement($reportedMeasurement);
        } 
        if($report->getUid()==NULL) {
            $reportRepository->add($report);
        }
        else {
            $reportRepository->update($report);
        }
        $persistenceManager->persistAll();
        return $reportedMeasurement;
    }
    public static function saveNote($report, $cpUid, $questUid, $noteUid, $noteText, $noteState, $curVer, $pid, $isPost=0) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $persistenceManager = $objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface');
        $reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        $questionRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\QuestionRepository');
        $controlPointRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ControlPointRepository');
        $noteRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\noteRepository');
        if((int)$noteUid>0) {
            $note = $noteRepository->findByUid((int)$noteUid);
        }
        if(!$note) {
            $note = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DanLundgren\DlIponlyestate\Domain\Model\Note');
        }        
		$newVerNo = 0;
		foreach($report->getNotes() as $prevNote) {
			//if($prevNote->getVersion()>$newVerNo && $prevNote->getQuestion()==$questUid) {
            if($prevNote->getVersion()>$newVerNo) {
				$newVerNo = $prevNote->getVersion();
			}
		}
		$cp = $controlPointRepository->findByUid($cpUid);
		$note->setControlPoint($cp);
        if((int)$noteUid>0) {
            //$note->setVersion(self::getNextNoteVersion($report->getEstate()));
        }
        else {
            $note->setVersion(self::getNextNoteVersion($report->getEstate()));
        }        
        //$note->setVersion($newVerNo);
        /*
        if($newVerNo) {
            $note->setVersion(1);    
        }
        else {
            $note->setVersion($newVerNo);    
        }
        */
		//$note->setVersion($newVerNo+=1);
        if($isPost>0) {
            $note->setUploadedImage(true);
        }
        $note->setPageId($pid);
		$note->setRemarkType($noteState);
		$note->setComment($noteText);
		$note->setState($noteState);
        $note->setExecutiveTechnician($GLOBALS['TSFE']->fe_user->user['name']);
        $datetime = new \DateTime();
		$datetime->format('Y-m-d H:i:s');
        $note->setDate($datetime);
		if($note->getState()=='ok') {
			$note->setIsComplete(1);
		}
        $question = $questionRepository->findByUid($questUid);
		$note->setQuestion($question);
		$note->setPid($report->getPid());
     
        if((int)$noteUid>0) {
            $noteRepository->update($note);
        }
        else {
            $report->addNote($note);
        }
        $noOfCriticalRemarks = 0;
        $noOfRemarks = 0;
        $noOfPurchases = 0;
        $report->setNoOfNotes(count($report->getNotes()));
        foreach($report->getNotes() as $tmpNote) {
            switch($tmpNote->getRemarkType()) {
                case 2:
                    $noOfCriticalRemarks +=1;
                    break;
                case 3:
                    $noOfRemarks +=1;
                    break;
                case 4:
                    $noOfPurchases +=1;
                    break;
                default:

            }
        }
        $report->setNoOfCriticalRemarks($noOfCriticalRemarks);
        $report->setNoOfRemarks($noOfRemarks);
        $report->setNoOfPurchases($noOfPurchases); 

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
            /*
            if($report->getStartDate() == $startDate && $report->getEstate()==$estate && $report->getReportIsPosted()) {
                $postedReports[] = $report;
            }
            */
            if($report->getEstate()==$estate && $report->getReportIsPosted()) {
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