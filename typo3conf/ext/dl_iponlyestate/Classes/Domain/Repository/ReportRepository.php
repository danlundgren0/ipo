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
     * @param \DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $searchCriterias
     */
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
            $where .= $and . ' ((reports.responsible_technicians = fe_user.uid AND fe_user.uid = ' . $searchCriterias->getTechnician() . ') OR (reports.executive_technician = fe_user.uid AND fe_user.uid = ' . $searchCriterias->getTechnician() . '))';
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
        /*if($searchCriterias->getEstate()>0) {
            		$where .= $and." reports.estate=".$searchCriterias->getEstate()->getUid();
            		$and = ' AND ';
            	}*/
        
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
                    if($report->getEstate()) {
                        $reportsByEstate[$report->getEstate()->getUid()][] = $report;
                        foreach ($reportsByEstate as &$estateArr) {
                            usort($estateArr, array($this, 'cmpDesc'));
                        }                        
                    }
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

        /*
        if(count($reportArr)>0) {
        	$reportUids = array();
        	foreach($reportArr as $report) {
        		$reportUids[] = $report['uid'];
        	}
        	$query = $this->createQuery();
        		    $query->matching($query->in('uid', $reportUids));
        		    return $query->execute();
        }
        */
        return $reportsByEstate;
        //return $sortedAndLimitedReportsByEstate;
    }
    
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