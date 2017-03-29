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
 * Report
 */
class Report extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     * @validate NotEmpty
     */
    protected $name = '';
    
    /**
     * version
     *
     * @var int
     * @validate NotEmpty
     */
    protected $version = 0;
    
    /**
     * date
     *
     * @var \DateTime
     */
    protected $date = null;
    
    /**
     * isComplete
     *
     * @var bool
     */
    protected $isComplete = false;
    
    /**
     * estate
     *
     * @var int
     */
    protected $estate = 0;
    
    /**
     * nodeType
     *
     * @var int
     */
    protected $nodeType = 0;
    
    /**
     * controlPoint
     *
     * @var int
     */
    protected $controlPoint = 0;
    
    /**
     * executiveTechnician
     *
     * @var int
     */
    protected $executiveTechnician = 0;
    
    /**
     * responsibleTechnicians
     *
     * @var int
     */
    protected $responsibleTechnicians = 0;
    
    /**
     * noOfCriticalRemarks
     *
     * @var int
     */
    protected $noOfCriticalRemarks = 0;
    
    /**
     * noOfRemarks
     *
     * @var int
     */
    protected $noOfRemarks = 0;
    
    /**
     * noOfOldRemarks
     *
     * @var int
     */
    protected $noOfOldRemarks = 0;
    
    /**
     * noOfNotes
     *
     * @var int
     */
    protected $noOfNotes = 0;
    
    /**
     * noOfPurchases
     *
     * @var int
     */
    protected $noOfPurchases = false;
    
    /**
     * reportIsPosted
     *
     * @var bool
     */
    protected $reportIsPosted = false;
    
    /**
     * The date when the inspection started
     *
     * @var \DateTime
     */
    protected $startDate = null;
    
    /**
     * The date when the inspection ended. All remarks has state OK.
     *
     * @var \DateTime
     */
    protected $endDate = null;
    
    /**
     * dynamicColumn
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\DynamicColumn>
     * @cascade remove
     */
    protected $dynamicColumn = null;
    
    /**
     * notes
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Note>
     * @cascade remove
     */
    protected $notes = null;
    
    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
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
        $this->dynamicColumn = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->notes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Returns the version
     *
     * @return int $version
     */
    public function getVersion()
    {
        return $this->version;
    }
    
    /**
     * Sets the version
     *
     * @param int $version
     * @return void
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }
    
    /**
     * Returns the date
     *
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * Sets the date
     *
     * @param \DateTime $date
     * @return void
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
    
    /**
     * Returns the boolean state of criticalRemarks
     *
     * @return bool
     */
    public function isCriticalRemarks()
    {
        return $this->criticalRemarks;
    }
    
    /**
     * Returns the boolean state of remarks
     *
     * @return bool
     */
    public function isRemarks()
    {
        return $this->remarks;
    }
    
    /**
     * Returns the boolean state of note
     *
     * @return bool
     */
    public function isNote()
    {
        return $this->note;
    }
    
    /**
     * Returns the boolean state of purchase
     *
     * @return bool
     */
    public function isPurchase()
    {
        return $this->purchase;
    }
    
    /**
     * Adds a DynamicColumn
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\DynamicColumn $dynamicColumn
     * @return void
     */
    public function addDynamicColumn(\DanLundgren\DlIponlyestate\Domain\Model\DynamicColumn $dynamicColumn)
    {
        $this->dynamicColumn->attach($dynamicColumn);
    }
    
    /**
     * Removes a DynamicColumn
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\DynamicColumn $dynamicColumnToRemove The DynamicColumn to be removed
     * @return void
     */
    public function removeDynamicColumn(\DanLundgren\DlIponlyestate\Domain\Model\DynamicColumn $dynamicColumnToRemove)
    {
        $this->dynamicColumn->detach($dynamicColumnToRemove);
    }
    
    /**
     * Returns the dynamicColumn
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\DynamicColumn> $dynamicColumn
     */
    public function getDynamicColumn()
    {
        return $this->dynamicColumn;
    }
    
    /**
     * Sets the dynamicColumn
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\DynamicColumn> $dynamicColumn
     * @return void
     */
    public function setDynamicColumn(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $dynamicColumn)
    {
        $this->dynamicColumn = $dynamicColumn;
    }
    
    /**
     * Adds a Comment
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Note $note
     * @return void
     */
    public function addNote(\DanLundgren\DlIponlyestate\Domain\Model\Note $note)
    {
        $this->notes->attach($note);
    }
    
    /**
     * Removes a Comment
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Note $noteToRemove The Note to be removed
     * @return void
     */
    public function removeNote(\DanLundgren\DlIponlyestate\Domain\Model\Note $noteToRemove)
    {
        $this->notes->detach($noteToRemove);
    }
    
    /**
     * Returns the notes
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Note> notes
     */
    public function getNotes()
    {
        return $this->notes;
    }
    
    /**
     * Sets the notes
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Note> $notes
     * @return void
     */
    public function setNotes(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $notes)
    {
        $this->notes = $notes;
    }
    
    /**
     * Returns the isComplete
     *
     * @return bool $isComplete
     */
    public function getIsComplete()
    {
        return $this->isComplete;
    }
    
    /**
     * Sets the isComplete
     *
     * @param bool $isComplete
     * @return void
     */
    public function setIsComplete($isComplete)
    {
        $this->isComplete = $isComplete;
    }
    
    /**
     * Returns the boolean state of isComplete
     *
     * @return bool
     */
    public function isIsComplete()
    {
        return $this->isComplete;
    }
    
    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Returns the estate
     *
     * @return int $estate
     */
    public function getEstate()
    {
        return $this->estate;
    }
    
    /**
     * Sets the estate
     *
     * @param int $estate
     * @return void
     */
    public function setEstate($estate)
    {
        $this->estate = $estate;
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
     * Returns the controlPoint
     *
     * @return int $controlPoint
     */
    public function getControlPoint()
    {
        return $this->controlPoint;
    }
    
    /**
     * Sets the controlPoint
     *
     * @param string $controlPoint
     * @return void
     */
    public function setControlPoint($controlPoint)
    {
        $this->controlPoint = $controlPoint;
    }
    
    /**
     * Returns the responsibleTechnicians
     *
     * @return int $responsibleTechnicians
     */
    public function getResponsibleTechnicians()
    {
        return $this->responsibleTechnicians;
    }
    
    /**
     * Sets the responsibleTechnicians
     *
     * @param int $responsibleTechnicians
     * @return void
     */
    public function setResponsibleTechnicians($responsibleTechnicians)
    {
        $this->responsibleTechnicians = $responsibleTechnicians;
    }
    
    /**
     * Returns the noOfCriticalRemarks
     *
     * @return int $noOfCriticalRemarks
     */
    public function getNoOfCriticalRemarks()
    {
        return $this->noOfCriticalRemarks;
    }
    
    /**
     * Sets the noOfCriticalRemarks
     *
     * @param int $noOfCriticalRemarks
     * @return void
     */
    public function setNoOfCriticalRemarks($noOfCriticalRemarks)
    {
        $this->noOfCriticalRemarks = $noOfCriticalRemarks;
    }
    
    /**
     * Returns the noOfRemarks
     *
     * @return int $noOfRemarks
     */
    public function getNoOfRemarks()
    {
        return $this->noOfRemarks;
    }
    
    /**
     * Sets the noOfRemarks
     *
     * @param int $noOfRemarks
     * @return void
     */
    public function setNoOfRemarks($noOfRemarks)
    {
        $this->noOfRemarks = $noOfRemarks;
    }
    
    /**
     * Returns the noOfOldRemarks
     *
     * @return int $noOfOldRemarks
     */
    public function getNoOfOldRemarks()
    {
        return $this->noOfOldRemarks;
    }
    
    /**
     * Sets the noOfOldRemarks
     *
     * @param int $noOfOldRemarks
     * @return void
     */
    public function setNoOfOldRemarks($noOfOldRemarks)
    {
        $this->noOfOldRemarks = $noOfOldRemarks;
    }
    
    /**
     * Returns the noOfNotes
     *
     * @return int $noOfNotes
     */
    public function getNoOfNotes()
    {
        return $this->noOfNotes;
    }
    
    /**
     * Sets the noOfNotes
     *
     * @param int $noOfNotes
     * @return void
     */
    public function setNoOfNotes($noOfNotes)
    {
        $this->noOfNotes = $noOfNotes;
    }
    
    /**
     * Returns the boolean state of purchaseNeeded
     *
     * @return bool
     */
    public function isPurchaseNeeded()
    {
        return $this->purchaseNeeded;
    }
    
    /**
     * Returns the noOfPurchases
     *
     * @return int noOfPurchases
     */
    public function getNoOfPurchases()
    {
        return $this->noOfPurchases;
    }
    
    /**
     * Sets the noOfPurchases
     *
     * @param bool $noOfPurchases
     * @return void
     */
    public function setNoOfPurchases($noOfPurchases)
    {
        $this->noOfPurchases = $noOfPurchases;
    }
    
    /**
     * Returns the reportIsPosted
     *
     * @return bool $reportIsPosted
     */
    public function getReportIsPosted()
    {
        return $this->reportIsPosted;
    }
    
    /**
     * Sets the reportIsPosted
     *
     * @param bool $reportIsPosted
     * @return void
     */
    public function setReportIsPosted($reportIsPosted)
    {
        $this->reportIsPosted = $reportIsPosted;
    }
    
    /**
     * Returns the boolean state of reportIsPosted
     *
     * @return bool
     */
    public function isReportIsPosted()
    {
        return $this->reportIsPosted;
    }
    
    /**
     * Returns the executiveTechnician
     *
     * @return int $executiveTechnician
     */
    public function getExecutiveTechnician()
    {
        return $this->executiveTechnician;
    }
    
    /**
     * Sets the executiveTechnician
     *
     * @param int $executiveTechnician
     * @return void
     */
    public function setExecutiveTechnician($executiveTechnician)
    {
        $this->executiveTechnician = $executiveTechnician;
    }
    
    /**
     * Returns the startDate
     *
     * @return \DateTime $startDate
     */
    public function getStartDate()
    {
        return $this->startDate;
    }
    
    /**
     * Sets the startDate
     *
     * @param \DateTime $startDate
     * @return void
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;
    }
    
    /**
     * Returns the endDate
     *
     * @return \DateTime $endDate
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    
    /**
     * Sets the endDate
     *
     * @param \DateTime $endDate
     * @return void
     */
    public function setEndDate(\DateTime $endDate)
    {
        $this->endDate = $endDate;
    }

}