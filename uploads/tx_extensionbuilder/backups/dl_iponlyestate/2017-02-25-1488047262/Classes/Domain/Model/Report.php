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
     * version
     *
     * @var int
     */
    protected $version = 0;
    
    /**
     * date
     *
     * @var \DateTime
     */
    protected $date = null;
    
    /**
     * criticalRemarks
     *
     * @var bool
     */
    protected $criticalRemarks = false;
    
    /**
     * remarks
     *
     * @var bool
     */
    protected $remarks = false;
    
    /**
     * note
     *
     * @var bool
     */
    protected $note = false;
    
    /**
     * purchase
     *
     * @var bool
     */
    protected $purchase = false;
    
    /**
     * comment
     *
     * @var string
     */
    protected $comment = '';
    
    /**
     * question
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Question>
     * @cascade remove
     */
    protected $question = null;
    
    /**
     * responsibleTechnician
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Model\Technician
     */
    protected $responsibleTechnician = null;
    
    /**
     * technician
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Model\Technician
     */
    protected $technician = null;
    
    /**
     * dynamicColumn
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\DynamicColumn>
     * @cascade remove
     */
    protected $dynamicColumn = null;
    
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
        $this->question = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->dynamicColumn = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Adds a Question
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Question $question
     * @return void
     */
    public function addQuestion(\DanLundgren\DlIponlyestate\Domain\Model\Question $question)
    {
        $this->question->attach($question);
    }
    
    /**
     * Removes a Question
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Question $questionToRemove The Question to be removed
     * @return void
     */
    public function removeQuestion(\DanLundgren\DlIponlyestate\Domain\Model\Question $questionToRemove)
    {
        $this->question->detach($questionToRemove);
    }
    
    /**
     * Returns the question
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Question> $question
     */
    public function getQuestion()
    {
        return $this->question;
    }
    
    /**
     * Sets the question
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Question> $question
     * @return void
     */
    public function setQuestion(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $question)
    {
        $this->question = $question;
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
     * Returns the criticalRemarks
     *
     * @return bool $criticalRemarks
     */
    public function getCriticalRemarks()
    {
        return $this->criticalRemarks;
    }
    
    /**
     * Sets the criticalRemarks
     *
     * @param bool $criticalRemarks
     * @return void
     */
    public function setCriticalRemarks($criticalRemarks)
    {
        $this->criticalRemarks = $criticalRemarks;
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
     * Returns the remarks
     *
     * @return bool $remarks
     */
    public function getRemarks()
    {
        return $this->remarks;
    }
    
    /**
     * Sets the remarks
     *
     * @param bool $remarks
     * @return void
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;
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
     * Returns the note
     *
     * @return bool $note
     */
    public function getNote()
    {
        return $this->note;
    }
    
    /**
     * Sets the note
     *
     * @param bool $note
     * @return void
     */
    public function setNote($note)
    {
        $this->note = $note;
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
     * Returns the purchase
     *
     * @return bool $purchase
     */
    public function getPurchase()
    {
        return $this->purchase;
    }
    
    /**
     * Sets the purchase
     *
     * @param bool $purchase
     * @return void
     */
    public function setPurchase($purchase)
    {
        $this->purchase = $purchase;
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
     * Returns the responsibleTechnician
     *
     * @return \DanLundgren\DlIponlyestate\Domain\Model\Technician $responsibleTechnician
     */
    public function getResponsibleTechnician()
    {
        return $this->responsibleTechnician;
    }
    
    /**
     * Sets the responsibleTechnician
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Technician $responsibleTechnician
     * @return void
     */
    public function setResponsibleTechnician(\DanLundgren\DlIponlyestate\Domain\Model\Technician $responsibleTechnician)
    {
        $this->responsibleTechnician = $responsibleTechnician;
    }
    
    /**
     * Returns the technician
     *
     * @return \DanLundgren\DlIponlyestate\Domain\Model\Technician $technician
     */
    public function getTechnician()
    {
        return $this->technician;
    }
    
    /**
     * Sets the technician
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Technician $technician
     * @return void
     */
    public function setTechnician(\DanLundgren\DlIponlyestate\Domain\Model\Technician $technician)
    {
        $this->technician = $technician;
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
     * Returns the comment
     *
     * @return string $comment
     */
    public function getComment()
    {
        return $this->comment;
    }
    
    /**
     * Sets the comment
     *
     * @param string $comment
     * @return void
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

}