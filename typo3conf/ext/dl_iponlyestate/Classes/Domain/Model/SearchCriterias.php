<?php
namespace DanLundgren\DlIponlyestate\Domain\Model;

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
 * ControlPoint
 */
class SearchCriterias extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * noteRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\NoteRepository
     * @inject
     */
    protected $noteRepository = NULL;

    /**
     * reportRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository
     * @inject
     */
    protected $reportRepository = NULL;

    /**
     * fromDate
     *
     * @var string
     */
    protected $fromDate = null;

    /**
     * toDate
     *
     * @var string
     */
    protected $toDate = null;

    /**
     * nodeType
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\NodeType>
     */
    protected $nodeType = null;

    /**
     * estate
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Estate>
     */
    protected $estate = null;

    /**
     * city
     *
     * @var string
     */
    protected $city = '';

    /**
     * noteType
     *
     * @var int
     */
    protected $noteType = 0;

    /**
     * notes
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Note>
     */
    protected $notes = null;

    /**
     * technician
     *
     * @var int
     */
    protected $technician = 0;

    /**
     * freeSearch
     *
     * @var string
     */
    protected $freeSearch = '';    


    /**
     * area
     *
     * @var int
     */
    protected $area = 0;

    /**
     * __construct
     */
    public function __construct($fromDate='',$toDate='',$nodeType=-1,$estate=-1,$city=-1,$noteType=0,$technician=-1,$freeSearch = '',$area=-1)
    {
        //Do not remove the next line: It would break the functionality        
        $this->initStorageObjects();
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->nodeType = $nodeType;
        $this->estate = $estate;
        $this->city = $city;
        $this->noteType = $noteType;
        $this->technician = $technician;
     	$this->freeSearch = $freeSearch;
        $this->area = $area;
     	//$this->getNotes();
    }
    
    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->estate = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->nodeType = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the fromDate
     *
     * @return string $fromDate
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }
    
    /**
     * Sets the fromDate
     *
     * @param \DateTime $date
     * @return void
     */
    public function setFromDate(\DateTime $date)
    {
        $this->fromDate = $date;
    }

    /**
     * Returns the toDate
     *
     * @return string $toDate
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * Sets the toDate
     *
     * @param \DateTime $date
     * @return void
     */
    public function setToDate(\DateTime $date)
    {
        $this->toDate = $date;
    }

    /**
     * Returns the nodeType
     *
     * @return int $nodeType
     */
    public function getNodeType()
    {
        return $this->nodeType;
    }

    /**
     * Sets the nodeType
     *
     * @param int $nodeType
     * @return void
     */
    public function setNodeType($nodeType)
    {
        $this->nodeType = $nodeType;
    }

    /**
     * Returns the estate
     *
     * @return \DanLundgren\DlIponlyestate\Domain\Model\Estate $estate
     */
    public function getEstate()
    {
    	if($this->estate>0) {
	        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
	        $this->estateRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\EstateRepository');    	
	        $estate = $this->estateRepository->findByUid($this->estate);
	        return $estate;
    	}
        return $this->estate;
    }
    
    /**
     * Sets the estate
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Estate $estate
     * @return void
     */
    public function setEstate(\DanLundgren\DlIponlyestate\Domain\Model\Estate $estate=NULL)
    {
        $this->estate = $estate;
    }

    /**
     * Returns the city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns the area
     *
     * @return string $area
     */
    public function getArea()
    {
        return $this->area;
    }
    
    /**
     * Sets the area
     *
     * @param string $area
     * @return void
     */
    public function setArea($area)
    {
        $this->area = $area;
    }

    /**
     * Sets the noteType
     *
     * @param int $noteType
     * @return void
     */
    public function setNoteType($noteType)
    {
        $this->noteType = $noteType;
    }

    /**
     * Returns the noteType
     *
     * @return int noteType
     */
    public function getNoteType()
    {
        return $this->noteType;
    }
    
    /**
     * Returns the notes
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Note> notes
     */
    public function getNotes()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $this->reportRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
        if(!$this->estate || $this->estate <= 0) {
            $reports = $this->reportRepository->findAll();
        }
        else {
            $reports = $this->reportRepository->findByEstate($this->estate);    
        }
    	$noteArr = array();
    	foreach($reports as $report) {
    		foreach($report->getNotes() as $note) {
    			$noteArr[] = $note;
    		}
    	}
        return $noteArr;
    }
    
    /**
     * Returns the technician
     *
     * @return int $technician
     */
    public function getTechnician()
    {
        return $this->technician;
    }
    
    /**
     * Sets the technician
     *
     * @param int $technician
     * @return void
     */
    public function setTechnician($technician)
    {
        $this->technician = $technician;
    }

    /**
     * Returns the freeSearch
     *
     * @return string $freeSearch
     */
    public function getFreeSearch()
    {
        return $this->freeSearch;
    }
    
    /**
     * Sets the freeSearch
     *
     * @param string $freeSearch
     * @return void
     */
    public function setFreeSearch($searchWord)
    {
        $this->freeSearch = $searchWord;
    }

}