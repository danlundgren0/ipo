<?php
namespace DanLundgren\DlIponlyestate\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
 * The repository for Reports
 */
class ReportRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );
    
    /**
     * @param $city
     * @param $technician
     * @param $nodeType
     */
    private function addInClause($city = NULL, $technician = NULL, $nodeType = NULL)
    {
        $no = 0;
        $in = ' reports.estate IN (SELECT estate.uid FROM tx_dliponlyestate_domain_model_estate estate WHERE ';
        if ($city != -1) {
            $in .= ' estate.city = \'' . $city . '\'';
            $no += 1;
        }
        if ($technician > 0) {
            $in = $no > 0 ? $in . ' AND ' : $in;
            $in .= ' estate.responsible_technician = \'' . $technician . '\'';
            $no += 1;
        }
        if ($nodeType > 0) {
            $in = $no > 0 ? $in . ' AND ' : $in;
            $in .= ' estate.node_type = \'' . $nodeType . '\'';
            $no += 1;
        }
        $in .= ')';
        if ($no == 0) {
            $in = '';
        }
        return $in;
    }
    
    /**
     * @param \DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $searchCriterias
     */
    public function searchReports(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $searchCriterias)
    {
        //$in = $this->addInClause($searchCriterias->getCity(), $searchCriterias->getTechnician(), $searchCriterias->getNodeType());
        $reportArr = array();
        $and = '';
        //$from = 'tx_dliponlyestate_domain_model_report reports';
        $from = 'tx_dliponlyestate_domain_model_report reports ';
        $additionalWhere = '';
        $additionalOrderBy = '';
        $addEstateNoReportWhereFromDate = '';
        $addEstateNoReportWhereToDate = '';
        $addEstateNoReportWhere = '';
        //if(strlen($in)>0) {
        /*
        if((int)$searchCriterias->getNodeType()>0 || (int)$searchCriterias->getTechnician() > 0 || (int)$searchCriterias->getCity() != '-1') {
            $from .= ' INNER JOIN tx_dliponlyestate_domain_model_estate estate ON estate.uid = reports.estate';
        }
        */
        
        if ((int) $searchCriterias->getNodeType() > 0) {
            //$from = ' tx_dliponlyestate_domain_model_report reports, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            //$from .= ' AND estate.node_type = '.$searchCriterias->getNodeType();
            //$and = ' AND ';
            $additionalWhere .= ' AND nodetype.uid =  ' . $searchCriterias->getNodeType();
            $addAND .= ' AND nodeType.uid =  ' . $searchCriterias->getNodeType();
        }
        if ($searchCriterias->getCity() != '-1') {
            //$from = ' tx_dliponlyestate_domain_model_report reports, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            //$from .= ' AND estate.city = \''.$searchCriterias->getCity().'\'';
            //$and = ' AND ';
            $additionalWhere .= ' AND estate.city =  "' . $searchCriterias->getCity() . '"';
            $addAND .= ' AND estate.city = "' . $searchCriterias->getCity() . '"';
        }
        if ($searchCriterias->getArea() != '-1') {
            //$from = ' tx_dliponlyestate_domain_model_report reports, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            //$from .= ' AND estate.city = \''.$searchCriterias->getCity().'\'';
            //$and = ' AND ';
            $additionalWhere .= ' AND estate.pid =  "' . $searchCriterias->getArea() . '"';
            $addAND .= ' AND estate.pid = "' . $searchCriterias->getArea() . '"';
        }
        if ((int) $searchCriterias->getTechnician() > 0) {
            //$from = ' tx_dliponlyestate_domain_model_report reports, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            //$from .= ' AND estate.responsible_technician = '.$searchCriterias->getTechnician();
            //$and = ' AND ';
            $additionalWhere .= ' AND estate.responsible_technician =  ' . $searchCriterias->getTechnician();
            $addAND .= ' AND feuser.uid = ' . $searchCriterias->getTechnician();
        }
        if ($searchCriterias->getNoteType() > 0) {
            //$where .= $and . ' note.state = ' . $searchCriterias->getNoteType() . ' AND reports.uid = note.report AND note.is_complete=0 AND note.deleted=0 AND note.hidden=0 ';
            $from .= ' LEFT JOIN tx_dliponlyestate_domain_model_note note ON note.state = ' . $searchCriterias->getNoteType() . '
             AND reports.uid = note.report AND note.is_complete=0';
            $and = ' AND ';
            switch ($searchCriterias->getNoteType()) {
                case '2':    $additionalWhere .= ' AND reports.no_of_critical_remarks > 0 ';
                    //TODO: Activate if Lina request it
                    //$additionalOrderBy .= ' reports.no_of_critical_remarks DESC, ';
                    break;
                case '3':    $additionalWhere .= ' AND reports.no_of_remarks > 0 ';
                    //TODO: Activate if Lina request it
                    //$additionalOrderBy .= ' reports.no_of_remarks DESC, ';
                    break;
                case '4':    $additionalWhere .= ' AND reports.no_of_purchases > 0 ';
                    //TODO: Activate if Lina request it
                    //$additionalOrderBy .= ' reports.no_of_purchases DESC, ';
                    break;
                default:    break;
            }
        }
        if ($searchCriterias->getFromDate() != '') {
            $additionalWhere .= ' AND reports.date>=\'' . $searchCriterias->getFromDate() . '\' ';
            //$addEstateNoReportWhereFromDate = $searchCriterias->getFromDate().' 00:00:00';
            $addEstateNoReportWhereFromDate = '\'' . $searchCriterias->getFromDate() . '\' ';
        }
        if ($searchCriterias->getToDate() != '') {
            $additionalWhere .= ' AND reports.date<=\'' . $searchCriterias->getToDate() . '\' ';
            $addEstateNoReportWhereToDate = '\'' . $searchCriterias->getToDate() . ' 23:59:59\'';
        }
        if ($searchCriterias->getFreeSearch() != '') {
            //$from .= $and . ' ((note.comment LIKE \'%' . $searchCriterias->getFreeSearch() . '%\' AND reports.uid = note.report) OR (estate.name LIKE \'%' . $searchCriterias->getFreeSearch() . '%\' AND reports.estate = estate.uid))';
            //$from = 'tx_dliponlyestate_domain_model_report reports, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            //$and = ' AND ';
            $additionalWhere .= '
				AND (
				 	(estate.name LIKE \'%' . $searchCriterias->getFreeSearch() . '%\' AND reports.estate = estate.uid)
				 	OR (feuser2.username LIKE \'%' . $searchCriterias->getFreeSearch() . '%\' AND reports.executive_technician = feuser2.uid)
				 	OR (remarks.comment LIKE \'%' . $searchCriterias->getFreeSearch() . '%\' AND reports.uid = remarks.report)
				)
            ';
        }
        if ($from == '') {
            $from = 'tx_dliponlyestate_domain_model_report reports ';
        }
        $select = ' 
            reports.*, estate.name AS estateName, estate.uid AS estateUid, estate.page_link AS pageLink, 
            nodetype.uid AS nodeTypeUid, nodetype.name AS nodeTypeName, 
            feuser.name AS respTechnicianName, feuser2.name AS execTechnicianName, 
            COUNT(CASE WHEN remarks.remark_type = 3 AND remarks.is_complete = 0 THEN remarks.remark_type END) AS noOfRemarks, 
            COUNT(CASE WHEN remarks.remark_type = 2 AND remarks.is_complete = 0 THEN remarks.remark_type END) AS noOfCriticalRemarks,  
            COUNT(CASE WHEN remarks.is_complete = 1 THEN remarks.remark_type END) AS noOfCompletedNotes, 
            COUNT(CASE WHEN remarks.remark_type = 4 AND remarks.is_complete = 0 THEN remarks.remark_type END) AS noOfPurchases, 
            COUNT(CASE WHEN remarks.remark_type = 1 THEN remarks.remark_type END) AS getNoOfOk, 
            (reports.no_of_notes+reports.reported_measurement) AS NoOfReportedNotesAndMeas, 
            (
                SELECT SUM(cp.questions)
                FROM tx_dliponlyestate_domain_model_controlpoint cp, tx_dliponlyestate_estate_controlpoint_mm estate_cp_mm
                WHERE cp.uid = estate_cp_mm.uid_foreign AND estate.uid = estate_cp_mm.uid_local
            ) AS noOfTotalNotesAndMeas 
        ';
        $from .= '  LEFT JOIN tx_dliponlyestate_domain_model_note remarks ON reports.uid = remarks.report
                    LEFT JOIN tx_dliponlyestate_domain_model_estate estate ON estate.uid = reports.estate 
                    LEFT JOIN tx_dliponlyestate_domain_model_nodetype nodetype ON nodetype.uid = estate.node_type 
                    LEFT JOIN fe_users feuser ON feuser.uid = estate.responsible_technician 
                    LEFT JOIN fe_users feuser2 ON feuser2.uid = reports.executive_technician 
                ';
        $where = ' reports.deleted=0 AND reports.hidden=0 AND estate.deleted=0 AND estate.hidden=0  ';
        $where .= $additionalWhere;
        $groupBy = 'reports.uid';
        $orderBy = $additionalOrderBy . ' respTechnicianName ASC , nodeTypeName ASC , reports.name DESC';
        $searchRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select, $from, $where, $groupBy, $orderBy);
        //print('select '.$select.' from '.$from.'where'.$where. 'group by '.$groupBy.' order by '.$orderBy);
        //echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
        if (strlen($addEstateNoReportWhereFromDate) > 0 && strlen($addEstateNoReportWhereToDate) > 0) {
            $addEstateNoReportWhere .= ' 
                AND
                (
                    tx_dliponlyestate_domain_model_report.start_date >= ' . $addEstateNoReportWhereFromDate . ' AND tx_dliponlyestate_domain_model_report.end_date <= ' . $addEstateNoReportWhereToDate . ' 
                )
            ';
        } elseif (strlen($addEstateNoReportWhereFromDate) > 0) {
            $addEstateNoReportWhere .= ' 
                AND
                (
                    tx_dliponlyestate_domain_model_report.start_date >= ' . $addEstateNoReportWhereFromDate . ' 
                )
            ';
        } elseif (strlen($addEstateNoReportWhereToDate) > 0) {
            $addEstateNoReportWhere .= ' 
                AND
                (
                    tx_dliponlyestate_domain_model_report.end_date >= ' . $addEstateNoReportWhereToDate . ' 
                )
            ';
        }
        //THIS SQL selects all estates without any report within the set daterange
        $estateUidArr = array();
        $estateUidSelect = 'estate.uid AS estate,estate.name AS estateName, nodeType.uid AS nodeTypeUid, nodeType.name AS nodeTypeName, estate.page_link AS pageLink, feuser.name AS respTechnicianName, "noReport"';
        $estateUidFrom = '
                tx_dliponlyestate_domain_model_estate AS estate 
                LEFT JOIN tx_dliponlyestate_domain_model_nodetype nodeType ON nodeType.uid = estate.node_type
                LEFT JOIN fe_users feuser ON feuser.uid = estate.responsible_technician
            ';
        $estateUidWhere = '
             NOT EXISTS 
            (
                SELECT 1 FROM tx_dliponlyestate_domain_model_report 
                WHERE estate.uid = tx_dliponlyestate_domain_model_report.estate ' . $addEstateNoReportWhere . '
            )
            AND estate.hidden = 0 AND estate.deleted = 0 
            AND feuser.username IS NOT NULL
        ' . $addAND;
        $estateUidRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery($estateUidSelect, $estateUidFrom, $estateUidWhere);        
        $debugQuery = 'SELECT ' . $estateUidSelect . ' FROM ' . $estateUidFrom . ' WHERE ' . $estateUidWhere;
        //print('<br>-------------<br>');
        $nodeTypeArr = $this->getNodeTypes();
        //print($debugQuery);
        $reportUids = array();
        $reportsByEstate = array();
        //if ($searchCriterias->getSearchAll()) {
            while ($estateUidRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($estateUidRes)) {
                //$estateUidArr[] = $estateUidRow['uid'];
                $reportsByEstate[$estateUidRow['uid']][] = $estateUidRow;

				$nodeTypeUid = $estateUidRow['nodeTypeUid'];
				$estateUid = $estateUidRow['estate'];
				if(!isset($nodeTypeArr[$nodeTypeUid]['noOfEstates'])) {
					$nodeTypeArr[$nodeTypeUid]['noOfEstates'] = 0;
				}
				if(!isset($nodeTypeArr[$nodeTypeUid]['noOfEstatesNoReport'])) {
					$nodeTypeArr[$nodeTypeUid]['noOfEstatesNoReport'] = 0;
				}
                if(!in_array($estateUid, $nodeTypeArr[$nodeTypeUid]['estateUids'])) {
                	$nodeTypeArr[$nodeTypeUid]['estateUids'][] = $estateUid;
                	$nodeTypeArr[$nodeTypeUid]['noOfEstates'] += 1;
                	$nodeTypeArr[$nodeTypeUid]['noOfEstatesNoReport'] += 1;
                }
            }
        //}
        
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($searchRes)) {
            if ((int) $row['estate'] > 0) {
                $reportsByEstate[$row['estate']][] = $row;
				$nodeTypeUid = $row['nodeTypeUid'];
				$estateUid = $row['estate'];
				if(!isset($nodeTypeArr[$nodeTypeUid]['noOfEstates'])) {
					$nodeTypeArr[$nodeTypeUid]['noOfEstates'] = 0;
				}
				if(!isset($nodeTypeArr[$nodeTypeUid]['noOfEstatesNoReport'])) {
					$nodeTypeArr[$nodeTypeUid]['noOfEstatesNoReport'] = 0;
				}
                if(!in_array($estateUid, $nodeTypeArr[$nodeTypeUid]['estateUids'])) {
                	$nodeTypeArr[$nodeTypeUid]['estateUids'][] = $estateUid;
                	$nodeTypeArr[$nodeTypeUid]['noOfEstates'] += 1;
                	$nodeTypeArr[$nodeTypeUid]['noOfEstatesWithReport'] += 1;
                }
                
                
            }
        }
        $searchedReports = $this->getSearchedReports($reportsByEstate);
        $searchedReports['statistics'] = $nodeTypeArr;
        return $searchedReports;
    }

    private function getNodeTypes() {
    	$nodeTypeArr = [];
    	$nodeTypeRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('name, uid', 'tx_dliponlyestate_domain_model_nodetype', 'deleted = 0 and hidden = 0');    	
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($nodeTypeRes)) {
            if (!array_key_exists($row['uid'], $nodeTypeArr)) {
                $nodeTypeArr[$row['uid']]['nodeTypeName'] = $row['name'];
                $nodeTypeArr[$row['uid']]['estateUids'] = [];
            	$nodeTypeArr[$row['uid']]['noOfEstates'] = 0;
            	$nodeTypeArr[$row['uid']]['noOfEstatesWithReport'] = 0;
            	$nodeTypeArr[$row['uid']]['noOfEstatesNoReport'] = 0;
            }
        }
        return $nodeTypeArr;
    }
    
    /**
     * @param $reportsByEstate
     */
    private function getSearchedReports($reportsByEstate)
    {
        $returnArr = array();
        foreach ($reportsByEstate as $estateArr) {
            $hasReports = true;
            $totalNoOfCriticalRemarks = 0;
            $totalNoOfRemarks = 0;
            $totalNoOfPurchases = 0;
            $totalNoOfCompletedNotes = 0;
            foreach ($estateArr as $reportsArr) {
                $noOfTotalNotesAndMeas = 0;
                //TODO: Kolla ifall denna behövs ReportUtility rad: 494
                /*
                foreach($report->getEstate()->getControlPoints() as $cp) {
                    $noOfTotalNotesAndMeas += count($cp->getQuestions());
                }
                */
                
                $noOfScannedNotesAndMeas = 0;
                $isAtLeastPartlyChecked = FALSE;
                $levelOneIdentifier = 'estate_' . $reportsArr['estate'];
                if ($reportsArr['noReport']) {
                    $returnArr['level1'][$levelOneIdentifier]['nodeTypeName'] = $reportsArr['nodeTypeName'];
                    $returnArr['level1'][$levelOneIdentifier]['estateName'] = $reportsArr['estateName'];
                    $returnArr['level1'][$levelOneIdentifier]['estateUid'] = $reportsArr['estateUid'];
                    $returnArr['level1'][$levelOneIdentifier]['noReport'] = $reportsArr['noReport'];
                    $returnArr['level1'][$levelOneIdentifier]['pageLink'] = $reportsArr['pageLink'];
                    $returnArr['level1'][$levelOneIdentifier]['respTechnicianName'] = $reportsArr['respTechnicianName'];
                    //$returnArr['level1'][$levelOneIdentifier]['respTechnicianName'] = 'ZZZ';
                    $hasReports = false;
                    continue;
                }
                $totalNoOfCriticalRemarks += $reportsArr['no_of_critical_remarks'];
                //->getNoOfCriticalRemarks();
                $totalNoOfRemarks += $reportsArr['no_of_remarks'];
                $totalNoOfPurchases += $reportsArr['no_of_purchases'];
                //TODO: Implement in main query
                $noteRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('notes.*', 'tx_dliponlyestate_domain_model_note notes', 'report = ' . $reportsArr['uid'] . ' and is_complete = 1 ', '', '');
                //$totalNoOfCompletedNotes += $GLOBALS['TYPO3_DB']->sql_num_rows($noteRes);
                $totalNoOfCompletedNotes = $GLOBALS['TYPO3_DB']->sql_num_rows($noteRes);
                $reportsArr['totalNoOfCompletedNotes'] = $totalNoOfCompletedNotes;
                $returnArr['level1'][$levelOneIdentifier]['estateUid'] = $reportsArr['estateUid'];
                //$estate->getUid();
                $returnArr['level1'][$levelOneIdentifier]['pageLink'] = $reportsArr['pageLink'];
                //$estate->getPageLink();
                $returnArr['level1'][$levelOneIdentifier]['nodeTypeName'] = $reportsArr['nodeTypeName'];
                //$estate->getNodeType()->getName();
                $returnArr['level1'][$levelOneIdentifier]['respTechnicianName'] = strlen($reportsArr['respTechnicianName']) > 0 ? $reportsArr['respTechnicianName'] : 'Tekniker saknas på fastigheten';
                //$estate->getRespTechnicianName();
                $returnArr['level1'][$levelOneIdentifier]['newOrNotCheckedAtAll'] = FALSE;
                $returnArr['level1'][$levelOneIdentifier]['hasReports'] = count($reportsArr);
                $levelTwoIdentifier = 'report_' . $reportsArr['uid'];

                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['hasAdminNote'] = $reportsArr['has_admin_note'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['adminNoteIsChecked'] = $reportsArr['admin_note_is_checked'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['adminNote'] = $reportsArr['admin_note'];

                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['reportUid'] = $reportsArr['uid'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['totalNoOfCompletedNotes'] = $totalNoOfCompletedNotes;
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['totalNoOfCriticalRemarks'] = $totalNoOfCriticalRemarks;
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['totalNoOfRemarks'] = $totalNoOfRemarks;
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['totalNoOfPurchases'] = $totalNoOfPurchases;
                $returnArr['level1'][$levelOneIdentifier]['estateName'] = $reportsArr['estateName'];
                $returnArr['level1'][$levelOneIdentifier]['estateUid'] = $reportsArr['estateUid'];
                $returnArr['level1'][$levelOneIdentifier]['pageLink'] = $reportsArr['pageLink'];
                $returnArr['level1'][$levelOneIdentifier]['nodeTypeName'] = $reportsArr['nodeTypeName'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['nodeTypeName'] = $reportsArr['nodeTypeName'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['respTechnicianName'] = strlen($reportsArr['respTechnicianName']) > 0 ? $reportsArr['respTechnicianName'] : 'Tekniker saknas på fastigheten';
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['execTechnicianName'] = $reportsArr['execTechnicianName'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['dateVersion'] = date('Y-m-d', strtotime($reportsArr['date'])) . ' Nr ' . $reportsArr['version'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['dateString'] = date('Y-m-d', strtotime($reportsArr['date']));
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['versionWithLabel'] = ' Nr ' . $reportsArr['version'];
                $noteRes2 = $GLOBALS['TYPO3_DB']->exec_SELECTquery('notes.*', 'tx_dliponlyestate_domain_model_note notes', 'report = ' . $reportsArr['uid'], '', '');
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['hasNotes'] = $GLOBALS['TYPO3_DB']->sql_num_rows($noteRes2);
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['reportUid'] = $reportsArr['uid'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['reportName'] = $reportsArr['name'];
                if (strlen($reportsArr['start_date']) > 0) {
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['startDate'] = date('Y-m-d H:i', strtotime($reportsArr['start_date']));
                }
                if (strlen($reportsArr['end_date']) > 0) {
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['endDate'] = date('Y-m-d H:i', strtotime($reportsArr['end_date']));
                }
                //TODO: Check Multi Joins if note remarks is wrong
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfCriticalRemarks'] = $reportsArr['noOfCriticalRemarks'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfRemarks'] = $reportsArr['noOfRemarks'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfCompletedNotes'] = $reportsArr['noOfCompletedNotes'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfNotes'] = $reportsArr['notes'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfPurchases'] = $reportsArr['noOfPurchases'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['newOrNotCheckedAtAll'] = FALSE;
                $returnArr['level1'][$levelOneIdentifier]['hasReports'] = count($estateArr);
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['hasNotes'] = $reportsArr['no_of_notes'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['getNoOfOk'] = $reportsArr['getNoOfOk'];
                /*
                //With images - comented because it only select those with images
                $noteSelect = ' note.control_point AS cpUid,
                                note.question AS quUid, note.comment AS comment,
                                note.remark_type AS remarkType,
                                image.identifier AS image, cp.NAME AS cpName,
                                qu.NAME AS questionName ';
                $noteFrom = ' tx_dliponlyestate_domain_model_note note
                            RIGHT JOIN tx_dliponlyestate_domain_model_controlpoint cp ON note.control_point = cp.uid
                            RIGHT JOIN tx_dliponlyestate_domain_model_question qu ON note.question = qu.uid
                            RIGHT JOIN sys_file_reference ref ON note.uid = ref.uid_foreign AND ref.tablenames = "tx_dliponlyestate_domain_model_note"
                            RIGHT JOIN sys_file image ON image.uid = ref.uid_local
                            ';
                */
                
                $noteSelect = ' note.control_point AS cpUid, 
                                note.question AS quUid, note.comment AS comment, 
                                note.remark_type AS remarkType, note.is_complete as isComplete, 
                                cp.NAME AS cpName, 
                                qu.NAME AS questionName ';
                $noteFrom = ' tx_dliponlyestate_domain_model_note note 
                            RIGHT JOIN tx_dliponlyestate_domain_model_controlpoint cp ON note.control_point = cp.uid
                            RIGHT JOIN tx_dliponlyestate_domain_model_question qu ON note.question = qu.uid
                            ';
                $noteWhere = ' report=' . $reportsArr['uid'];
                $debugSQL = 'SELECT ' . $noteSelect . ' FROM ' . $noteFrom . ' WHERE ' . $noteWhere;
                //print($debugSQL);
                $noteRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery($noteSelect, $noteFrom, $noteWhere, '', '');
                while ($note = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($noteRes)) {
                    $isAtLeastPartlyChecked = TRUE;
                    $noOfScannedNotesAndMeas += 1;
                    if ($note['cpUid'] === null || (int) $note['cpUid'] == 0) {
                        continue;
                    }
                    $levelThreeIdentifier = 'cp_' . $note['cpUid'];
                    if ($note['quUid'] === null || (int) $note['quUid'] == 0) {
                        continue;
                    }
                    $levelFourIdentifier = 'quest_' . $note['quUid'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['cpName'] = $note['cpName'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['questionName'] = $note['questionName'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['comment'] = $note['comment'];
                    if ($note['isComplete'] == 0) {
                        $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['remarkType'] = $note['remarkType'];
                    } else {
                        $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['remarkType'] = '88';
                    }
                    if ($note['image'] && strlen($note['image']) > 0) {
                        $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['image'] = 'fileadmin' . $note['image'];
                    }
                }
                $measureSelect = ' reported_measurement.control_point AS cpUid, 
                                    reported_measurement.question AS quUid, 
                                    reported_measurement.unit AS unit, 
                                    reported_measurement.value AS value, 
                                    reported_measurement.page_id AS page_id,
                                    cp.NAME AS cpName, 
                                    qu.NAME AS questionName 
                                ';
                $measureFrom = '    tx_dliponlyestate_domain_model_reportedmeasurement reported_measurement 
                                    RIGHT JOIN tx_dliponlyestate_domain_model_controlpoint cp ON reported_measurement.control_point = cp.uid 
                                    RIGHT JOIN tx_dliponlyestate_domain_model_question qu ON reported_measurement.question = qu.uid
                            ';
                $measureWhere = ' report=' . $reportsArr['uid'];
                $debugSQL = 'SELECT ' . $measureSelect . ' FROM ' . $measureFrom . ' WHERE ' . $measureWhere;
                $measureRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery($measureSelect, $measureFrom, $measureWhere, '', '');
                $noOfMeasurements = 0;
                while ($measurement = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($measureRes)) {
                    $isAtLeastPartlyChecked = TRUE;
                    $noOfMeasurements += 1;
                    $noOfScannedNotesAndMeas += 1;
                    if ($measurement['cpUid'] === null || (int) $measurement['cpUid'] == 0) {
                        continue;
                    }
                    $levelThreeIdentifier = 'cp_' . $measurement['cpUid'];
                    if ($measurement['quUid'] === null || (int) $measurement['quUid'] == 0) {
                        continue;
                    }
                    $levelFourIdentifier = 'quest_' . $measurement['quUid'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['cpName'] = $measurement['cpName'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['questionName'] = $measurement['questionName'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['comment'] = $measurement['value'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['remarkType'] = '99';
                }
                /*
                foreach($report->getReportedMeasurement() as $measurement) {
                    $isAtLeastPartlyChecked = TRUE;
                    $noOfMeasurements+=1;
                    $noOfScannedNotesAndMeas+=1;
                }
                */
                
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfMeasurements'] = $noOfMeasurements;
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfScannedNotesAndMeas'] = $noOfScannedNotesAndMeas;
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['NoOfReportedNotesAndMeas'] = $reportsArr['NoOfReportedNotesAndMeas'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfTotalNotesAndMeas'] = $reportsArr['noOfTotalNotesAndMeas'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['allCheckedAndOk'] = FALSE;
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['partlyCheckedAndOk'] = FALSE;
                //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['newOrNotCheckedAtAll'] = FALSE;
                if ((int) $reportsArr['NoOfReportedNotesAndMeas'] >= (int) $reportsArr['noOfTotalNotesAndMeas']) {
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['allCheckedAndOk'] = TRUE;
                } else {
                    if ((int) $reportsArr['NoOfReportedNotesAndMeas'] > 0 && (int) $reportsArr['NoOfReportedNotesAndMeas'] < (int) $reportsArr['noOfTotalNotesAndMeas']) {
                        $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['partlyCheckedAndOk'] = TRUE;
                    } else {
                        if (!$isAtLeastPartlyChecked) {
                            $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['newOrNotCheckedAtAll'] = TRUE;
                        }
                    }
                }
                $tmpNoOfOk = $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['getNoOfOk'];
            }
        }
        return $returnArr;
    }
    
    /**
     * @param \DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $searchCriterias
     */
    public function searchReports2018(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $searchCriterias)
    {
        //$in = $this->addInClause($searchCriterias->getCity(), $searchCriterias->getTechnician(), $searchCriterias->getNodeType());
        $reportArr = array();
        $and = '';
        //$from = 'tx_dliponlyestate_domain_model_report reports';
        $from = 'tx_dliponlyestate_domain_model_report reports ';
        //if(strlen($in)>0) {
        if ((int) $searchCriterias->getNodeType() > 0 || (int) $searchCriterias->getTechnician() > 0 || (int) $searchCriterias->getCity() != '-1') {
            $from .= ' INNER JOIN tx_dliponlyestate_domain_model_estate estate ON estate.uid = reports.estate';
        }
        if ((int) $searchCriterias->getNodeType() > 0) {
            //$from = ' tx_dliponlyestate_domain_model_report reports, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            $from .= ' AND estate.node_type = ' . $searchCriterias->getNodeType();
            $and = ' AND ';
        }
        if ($searchCriterias->getCity() != '-1') {
            //$from = ' tx_dliponlyestate_domain_model_report reports, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            $from .= ' AND estate.city = \'' . $searchCriterias->getCity() . '\'';
            $and = ' AND ';
        }
        if ((int) $searchCriterias->getTechnician() > 0) {
            //$from = ' tx_dliponlyestate_domain_model_report reports, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            $from .= ' AND estate.responsible_technician = ' . $searchCriterias->getTechnician();
            $and = ' AND ';
        }
        if ($searchCriterias->getNoteType() > 0) {
            //$where .= $and . ' note.state = ' . $searchCriterias->getNoteType() . ' AND reports.uid = note.report AND note.is_complete=0 AND note.deleted=0 AND note.hidden=0 ';
            $from .= ' INNER JOIN tx_dliponlyestate_domain_model_note note ON note.state = ' . $searchCriterias->getNoteType() . '
             AND reports.uid = note.report AND note.is_complete=0';
            $and = ' AND ';
        }
        if ($searchCriterias->getFromDate() != '') {
            $fromDate = \DateTime::createFromFormat('Y-m-d', $searchCriterias->getFromDate());
            $where .= $and . ' reports.date>=\'' . $searchCriterias->getFromDate() . '\'';
            //$from = 'tx_dliponlyestate_domain_model_report reports, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            $and = ' AND ';
        }
        if ($searchCriterias->getToDate() != '') {
            $fromDate = \DateTime::createFromFormat('Y-m-d', $searchCriterias->getToDate());
            $where .= $and . ' reports.date<=\'' . $searchCriterias->getToDate() . '\'';
            //$from = 'tx_dliponlyestate_domain_model_report reports, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            $and = ' AND ';
        }
        if ($searchCriterias->getFreeSearch() != '') {
            $from .= $and . ' ((note.comment LIKE \'%' . $searchCriterias->getFreeSearch() . '%\' AND reports.uid = note.report) OR (estate.name LIKE \'%' . $searchCriterias->getFreeSearch() . '%\' AND reports.estate = estate.uid))';
            //$from = 'tx_dliponlyestate_domain_model_report reports, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            $and = ' AND ';
        }
        if ($from == '') {
            $from = 'tx_dliponlyestate_domain_model_report reports ';
        }
        //$where = $in.$where;
        //$where .= $and . ' reports.deleted=0 AND reports.hidden=0 ';
        $where = ' reports.deleted=0 AND reports.hidden=0 ';
        //$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
        //$sqltimer1 = microtime(true);
        $searchRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery(' DISTINCT reports.*', $from, $where);
        //echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($searchRes)) {
            $reportArr[] = $row;
        }
        //$totalsqltimer1 = microtime(true) - $sqltimer1;
        //echo $totalsqltimer1;
        //echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
        $reportUids = array();
        $reportsByEstate = array();
        $sortedAndLimitedReportsByEstate = array();
        if (count($reportArr) > 0) {
            foreach ($reportArr as $report) {
                $reportUids[] = $report['uid'];
            }
            $query = $this->createQuery();
            $query->matching($query->in('uid', $reportUids));
            $allReports = $query->execute();
            if (count($allReports) > 0) {
                foreach ($allReports as $report) {
                    if ($report->getEstate()) {
                        $reportsByEstate[$report->getEstate()->getUid()][] = $report;
                    }
                }
                foreach ($reportsByEstate as $estateArr) {
                    $totalNoOfCriticalRemarks = 0;
                    $totalNoOfRemarks = 0;
                    $totalNoOfPurchases = 0;
                    $totalNoOfCompletedNotes = 0;
                    foreach ($estateArr as $report) {
                        $totalNoOfCriticalRemarks += $report->getNoOfCriticalRemarks();
                        $report->setTotalNoOfCriticalRemarks($totalNoOfCriticalRemarks);
                        $totalNoOfRemarks += $report->getNoOfRemarks();
                        $report->setTotalNoOfRemarks($totalNoOfRemarks);
                        $totalNoOfPurchases += $report->getNoOfPurchases();
                        $report->setTotalNoOfPurchases($totalNoOfPurchases);
                        $totalNoOfCompletedNotes += $report->getAllCompletedNotes();
                        $report->setTotalNoOfCompletedNotes($totalNoOfCompletedNotes);
                    }
                }
                foreach ($reportsByEstate as &$estateArr) {
                    usort($estateArr, array($this, 'cmpDesc'));
                }
                $c = 0;
                $maxReports = 5;
                if ($searchCriterias->getFromDate() != '' && $searchCriterias->getToDate() != '') {
                    $maxReports = 999;
                }
                foreach ($reportsByEstate as $estateArr2) {
                    $r = 0;
                    foreach ($estateArr2 as $report) {
                        if ($r >= $maxReports) {
                            break;
                        }
                        $sortedAndLimitedReportsByEstate[$c][] = $report;
                        $r += 1;
                    }
                    $c += 1;
                }
            }
        }
        return $reportsByEstate;
    }
    
    /*
    public function searchReports(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $searchCriterias)
    {
        //$toDate = \DateTime::createFromFormat('Y-m-d', $demand->getToDate());
        //$where = 'WHERE ';
        $reportArr = array();
        $and = '';
        $from = 'tx_dliponlyestate_domain_model_report reports';
        if ($searchCriterias->getCity() != -1) {
            $where .= ' reports.estate IN (SELECT estate.uid FROM tx_dliponlyestate_domain_model_estate estate WHERE estate.city = \'' . $searchCriterias->getCity() . '\')';
            $from = 'tx_dliponlyestate_domain_model_report reports, fe_users fe_user, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            $and = ' AND ';
        }
        if ($searchCriterias->getNoteType() > 0) {
            //$where .= $and." reports.notes IN (SELECT note.state FROM tx_dliponlyestate_domain_model_note note WHERE note.state = '".$searchCriterias->getNoteType()."' and reports.uid = note.report)";
            $where .= $and . ' note.state = ' . $searchCriterias->getNoteType() . ' AND reports.uid = note.report AND note.is_complete=0 AND note.deleted=0 AND note.hidden=0 ';
            $from = 'tx_dliponlyestate_domain_model_report reports, fe_users fe_user, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            //$where .= $and." note.state = ".$searchCriterias->getNoteType();
            $and = ' AND ';
        }
        if ($searchCriterias->getTechnician() > 0) {
            $where .= $and . ' (estate.responsible_technician = fe_user.uid AND fe_user.uid = ' . $searchCriterias->getTechnician() . ')';
            $from = 'tx_dliponlyestate_domain_model_report reports, fe_users fe_user, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            $and = ' AND ';
        }
        if ($searchCriterias->getFromDate() != '') {
            $fromDate = \DateTime::createFromFormat('Y-m-d', $searchCriterias->getFromDate());
            $where .= $and . ' reports.date>=\'' . $searchCriterias->getFromDate() . '\'';
            $from = 'tx_dliponlyestate_domain_model_report reports, fe_users fe_user, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            $and = ' AND ';
        }
        if ($searchCriterias->getToDate() != '') {
            $fromDate = \DateTime::createFromFormat('Y-m-d', $searchCriterias->getToDate());
            $where .= $and . ' reports.date<=\'' . $searchCriterias->getToDate() . '\'';
            $from = 'tx_dliponlyestate_domain_model_report reports, fe_users fe_user, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            $and = ' AND ';
        }
        if ($searchCriterias->getNodeType() > 0) {
            $where .= $and . ' estate.node_type=' . $searchCriterias->getNodeType();
            $from = 'tx_dliponlyestate_domain_model_report reports, fe_users fe_user, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            $and = ' AND ';
        }
        if ($searchCriterias->getFreeSearch() != '') {
            $where .= $and . ' ((note.comment LIKE \'%' . $searchCriterias->getFreeSearch() . '%\' AND reports.uid = note.report) OR (estate.name LIKE \'%' . $searchCriterias->getFreeSearch() . '%\' AND reports.estate = estate.uid))';
            $from = 'tx_dliponlyestate_domain_model_report reports, fe_users fe_user, tx_dliponlyestate_domain_model_note note, tx_dliponlyestate_domain_model_estate estate ';
            $and = ' AND ';
        }
        $where .= $and . ' reports.deleted=0 AND reports.hidden=0 ';
        $searchRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery(' DISTINCT reports.*', $from, $where);
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($searchRes)) {
            $reportArr[] = $row;
        }
        echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
        $reportUids = array();
        $reportsByEstate = array();
        $sortedAndLimitedReportsByEstate = array();
        if (count($reportArr) > 0) {
            foreach ($reportArr as $report) {
                $reportUids[] = $report['uid'];
            }
            $query = $this->createQuery();
            $query->matching($query->in('uid', $reportUids));
            $allReports = $query->execute();
            if (count($allReports) > 0) {
                foreach ($allReports as $report) {
                    if ($report->getEstate()) {
                        $reportsByEstate[$report->getEstate()->getUid()][] = $report;
                    }
                }
                foreach ($reportsByEstate as $estateArr) {
                    $totalNoOfCriticalRemarks = 0;
                    $totalNoOfRemarks = 0;
                    $totalNoOfPurchases = 0;
                    $totalNoOfCompletedNotes = 0;
                    foreach ($estateArr as $report) {
                        $totalNoOfCriticalRemarks += $report->getNoOfCriticalRemarks();
                        $report->setTotalNoOfCriticalRemarks($totalNoOfCriticalRemarks);
                        $totalNoOfRemarks += $report->getNoOfRemarks();
                        $report->setTotalNoOfRemarks($totalNoOfRemarks);
                        $totalNoOfPurchases += $report->getNoOfPurchases();
                        $report->setTotalNoOfPurchases($totalNoOfPurchases);
                        $totalNoOfCompletedNotes += $report->getAllCompletedNotes();
                        $report->setTotalNoOfCompletedNotes($totalNoOfCompletedNotes);
                    }
                }
                foreach ($reportsByEstate as &$estateArr) {
                    usort($estateArr, array($this, 'cmpDesc'));
                }
                $c = 0;
                $maxReports = 5;
                if ($searchCriterias->getFromDate() != '' && $searchCriterias->getToDate() != '') {
                    $maxReports = 999;
                }
                foreach ($reportsByEstate as $estateArr2) {
                    $r = 0;
                    foreach ($estateArr2 as $report) {
                        if ($r >= $maxReports) {
                            break;
                        }
                        $sortedAndLimitedReportsByEstate[$c][] = $report;
                        $r += 1;
                    }
                    $c += 1;
                }
            }
        }
        return $reportsByEstate;
    }
    */
    
    /**
     * @param $a
     * @param $b
     */
    public function cmpDesc($a, $b)
    {
        if ($a->getUid() == $b->getUid()) {
            //if ($a['uid'] == $b['uid']) {
            return 0;
        }
        return $a->getUid() > $b->getUid() ? -1 : 1;
    }
    
    /**
     * @param \DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand
     */
    public function findEstates(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand)
    {
        $query = $this->createQuery();
        $constraints = array();
        if ($demand->getEstate() != 0) {
            $constraints[] = $query->matching($query->equals('estate', $demand->getEstate()));
        } else {
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $estateRepository = $objectManager->get('DanLundgren\\DlIponlyestate\\Domain\\Repository\\EstateRepository');
            $estates = $estateRepository->findAll();
            $constraints[] = $estateRepository->findAll();
        }
        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }
    
    /**
     * @param \DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand
     */
    public function findBySearchWord(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand)
    {
        $query = $this->createQuery();
        $constraints = array();
        if (is_string($demand->getFreeSearch()) && strlen($demand->getFreeSearch()) > 0) {
            if (count($demand->getNotes()) > 0) {
                foreach ($demand->getNotes() as $note) {
                    $constraints[] = $query->like($note->getComment(), '%' . $demand->getFreeSearch . '%');
                }
            }
        }
        //$query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }
    
    /**
     * @param \DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand
     */
    public function findDemanded(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand)
    {
        $query = $this->createQuery();
        $constraints = array();
        if ($demand->getEstate() !== NULL) {
            $constraints[] = $query->matching($query->equals('estate', $demand->getEstate()));
        }
        /*
                                                        	    if ($demand->getCategory() !== NULL) {
                                                                $constraints[] = $query->contains('categories', $demand->getCategory());
                                                        	    }
                                                        	    if ($demand->getOrganization() !== NULL) {
                                                                $constraints[] = $query->contains('organization', $demand->getOrganization());
                                                        	    }*/
        
        if (is_string($demand->getFreeSearch()) && strlen($demand->getFreeSearch()) > 0) {
            if (count($demand->getNotes()) > 0) {
                foreach ($notes as $note) {
                    $constraints[] = $query->like($note->getComment(), '%' . $demand->getFreeSearch . '%');
                }
            }
        }
        /*    if (($demand->getFromDate() !== '') && ($demand->getToDate() !== '')) {
                                                        	    	$fromDate = \DateTime::createFromFormat('Y-m-d', $demand->getFromDate());
                                                        	    	$toDate = \DateTime::createFromFormat('Y-m-d', $demand->getToDate());
                                                        	    	$constraints[] = $query->lessThanOrEqual('date', $fromDate->format('Y-m-d'));
                                                        	    	*/
        
        /*$constraints[] = $query->logicalAnd(
                                                        	            	$query->greaterThanOrEqual('date', $fromDate->format('Y-m-d')),
          $query->lessThanOrEqual('date', $toDate->format('Y-m-d'))
                                                        	            	//$query->greaterThanOrEqual('date', $demand->getFromDate()),
          //$query->lessThanOrEqual('date', $demand->getToDate())
          );*/
        
        /*
        $constraints[] = $query->logicalAnd(
            $query->logicalOr(
                $query->equals('date.minimumValue', NULL),
                $query->greaterThanOrEqual('date.maximumValue', $demand->getFromDate())
            ),
            $query->logicalOr(
                $query->equals('date.maximumValue', NULL),
                $query->lessThanOrEqual('date.minimumValue', $demand->getToDate())
            )
        );
        */
        
        //}
        /*else if ($demand->getFromDate() !== '') {
          }
          else if ($demand->getToDate() !== '') {
          }*/
        
        /*
                                                        	    $constraints[] = $query->logicalOr(
                                                                $query->equals('dateRange.minimumValue', NULL),
                                                                $query->equals('dateRange.minimumValue', 0),
                                                                $query->greaterThan('dateRange.maximumValue', (time() - 60*60*24*7))
                                                        	    );*/
        
        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }

}