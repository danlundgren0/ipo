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

    public function searchReports(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $searchCriterias) {
    	
    	//$toDate = \DateTime::createFromFormat('Y-m-d', $demand->getToDate());
    	//$where = 'WHERE ';
    	$reportArr = array();
    	$and='';
    	if($searchCriterias->getCity()!=-1) {
    		$where .= " reports.estate IN (SELECT estate.uid FROM tx_dliponlyestate_domain_model_estate estate WHERE estate.city = '".$searchCriterias->getCity()."')";
    		$and = ' AND ';
    	}
    	if($searchCriterias->getNoteType()!=0) {    		
    		$where .= $and." reports.notes IN (SELECT note.state FROM tx_dliponlyestate_domain_model_note note WHERE note.state = '".$searchCriterias->getNoteType()."')";
    		$and = ' AND ';
    	}
    	if($searchCriterias->getFromDate()!='') {
    		$fromDate = \DateTime::createFromFormat('Y-m-d', $searchCriterias->getFromDate());
    		$where .= $and." date>='".$searchCriterias->getFromDate()."'";
    		$and = ' AND ';
    	}
    	if($searchCriterias->getToDate()!='') {
    		$fromDate = \DateTime::createFromFormat('Y-m-d', $searchCriterias->getToDate());
    		$where .= $and." date<='".$searchCriterias->getToDate()."'";
    		$and = ' AND ';
    	}
    	if($searchCriterias->getEstate()!=-1) {
    		$where .= $and." estate=".$searchCriterias->getEstate()->getUid();
    		$and = ' AND ';
    	}
    	if($searchCriterias->getNodeType()!=-1) {    		
    		$where .= $and." node_type=".$searchCriterias->getNodeType();
    		$and = ' AND ';
    	}


    	$searchRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
    		'reports.*', 
    		'tx_dliponlyestate_domain_model_report reports', 
    		$where 
    	);
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($searchRes)) {
        	$reportArr[] = $row;
        }
/*\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
 array(
  'class' => __CLASS__,
  'function' => __FUNCTION__,
  'searchCriterias' => $searchCriterias,
  'debug_lastBuiltQuery' => $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery,
  'reportArr' => $reportArr,
 )
);*/
    }


	public function findEstates(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand) {
	    $query = $this->createQuery();
	    $constraints = array();
	    if ($demand->getEstate() != 0) {
	        $constraints[] = $query->matching($query->equals('estate', $demand->getEstate()));
	    }
	    else {
	        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
	        $estateRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\EstateRepository');
	        $estates = $estateRepository->findAll();
	    	$constraints[] = $estateRepository->findAll();
	    }
		
\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
 array(
  'class' => __CLASS__,
  'function' => __FUNCTION__,
  'query' => $query,
  'estates' => $estates,
  'getEstate' => $demand->getEstate(),
  'execute' => $query->execute(),
 )
);
		$query->matching($query->logicalAnd($constraints));
	    return $query->execute();
	}
	public function findBySearchWord(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand) {
	    $query = $this->createQuery();
	    $constraints = array();
		if (is_string($demand->getFreeSearch()) && strlen($demand->getFreeSearch()) > 0) {
			if (count($demand->getNotes()) > 0) {
			    foreach ($demand->getNotes() as $note) {
			    	$constraints[] = $query->like($note->getComment(), '%' . $demand->getFreeSearch . '%');
			        //$constraints[] = $query->contains('type', $type);
			    }
			}	    
	    }
\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
 array(
  'class' => __CLASS__,
  'function' => __FUNCTION__,
  'execute' => $query->execute(),
  'demand->getFreeSearch' => $demand->getFreeSearch(),
 )
);
		//$query->matching($query->logicalAnd($constraints));
	    return $query->execute();
	}



	public function findDemanded(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand) {
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
			        //$constraints[] = $query->contains('type', $type);
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
\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
 array(
  'class' => __CLASS__,
  'function' => __FUNCTION__,
  'query execute' => $query->execute(),
  //'fromDate format' => $fromDate->format('Y-m-d'),
  //'toDate format' => $toDate->format('Y-m-d'),
  'Searchstring' => $demand->getFreeSearch(),
  'query' => $query,
  'getNotes' => $demand->getNotes(),
  'constraints' => $constraints,
 )
);	
	    return $query->execute();
	}

//	public function searchReports(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand) {
		/** @var \TYPO3\CMS\Core\Database\Connection $conn */
//		$conn = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_dliponlyestate_domain_model_report');
		
		/** @var QueryBuilder $queryBuilder */
		//$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dliponlyestate_domain_model_report');

//		$statement = $queryBuilder
//		   ->select('*')
//		   ->from('tx_dliponlyestate_domain_model_report')
//		   ->where(
//		      $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($demand->getEstate()->getUid()))
//		   )
//		   ->execute();
//		while ($row = $statement->fetch()) {

//		}
//	}

}