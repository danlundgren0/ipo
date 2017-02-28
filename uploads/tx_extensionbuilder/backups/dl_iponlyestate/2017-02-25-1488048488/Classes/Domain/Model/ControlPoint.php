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
class ControlPoint extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';
    
    /**
     * One control point may hold * Reports. A Report should only belong to 1 Control
     * point.
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<>
     * @cascade remove
     */
    protected $report = null;
    
    /**
     * nodeType
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Model\NodeType
     */
    protected $nodeType = null;
    
    /**
     * Control Pints and Questions have many-to-many relation.
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Question>
     */
    protected $questions = null;
    
    /**
     * The responsible thechnician that are allowed to perform checks
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Model\Technician
     */
    protected $alllowedResponsibleTechnicians = null;
    
    /**
     * The thechnicians that are allowed to perform checks
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Technician>
     */
    protected $allowedTechnicians = null;
    
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
        $this->report = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->questions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->allowedTechnicians = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Returns the nodeType
     *
     * @return \DanLundgren\DlIponlyestate\Domain\Model\NodeType $nodeType
     */
    public function getNodeType()
    {
        return $this->nodeType;
    }
    
    /**
     * Sets the nodeType
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\NodeType $nodeType
     * @return void
     */
    public function setNodeType(\DanLundgren\DlIponlyestate\Domain\Model\NodeType $nodeType)
    {
        $this->nodeType = $nodeType;
    }
    
    /**
     * Adds a Question
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Question $question
     * @return void
     */
    public function addQuestion(\DanLundgren\DlIponlyestate\Domain\Model\Question $question)
    {
        $this->questions->attach($question);
    }
    
    /**
     * Removes a Question
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Question $questionToRemove The Question to be removed
     * @return void
     */
    public function removeQuestion(\DanLundgren\DlIponlyestate\Domain\Model\Question $questionToRemove)
    {
        $this->questions->detach($questionToRemove);
    }
    
    /**
     * Returns the questions
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Question> $questions
     */
    public function getQuestions()
    {
        return $this->questions;
    }
    
    /**
     * Sets the questions
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Question> $questions
     * @return void
     */
    public function setQuestions(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $questions)
    {
        $this->questions = $questions;
    }
    
    /**
     * Adds a Report
     *
     * @param  $report
     * @return void
     */
    public function addReport($report)
    {
        $this->report->attach($report);
    }
    
    /**
     * Removes a Report
     *
     * @param  $reportToRemove The  to be removed
     * @return void
     */
    public function removeReport($reportToRemove)
    {
        $this->report->detach($reportToRemove);
    }
    
    /**
     * Returns the report
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<> report
     */
    public function getReport()
    {
        return $this->report;
    }
    
    /**
     * Sets the report
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<> $report
     * @return void
     */
    public function setReport(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $report)
    {
        $this->report = $report;
    }
    
    /**
     * Returns the alllowedResponsibleTechnicians
     *
     * @return \DanLundgren\DlIponlyestate\Domain\Model\Technician alllowedResponsibleTechnicians
     */
    public function getAlllowedResponsibleTechnicians()
    {
        return $this->alllowedResponsibleTechnicians;
    }
    
    /**
     * Sets the alllowedResponsibleTechnicians
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Technician $alllowedResponsibleTechnicians
     * @return void
     */
    public function setAlllowedResponsibleTechnicians(\DanLundgren\DlIponlyestate\Domain\Model\Technician $alllowedResponsibleTechnicians)
    {
        $this->alllowedResponsibleTechnicians = $alllowedResponsibleTechnicians;
    }
    
    /**
     * Adds a Technician
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Technician $allowedTechnician
     * @return void
     */
    public function addAllowedTechnician(\DanLundgren\DlIponlyestate\Domain\Model\Technician $allowedTechnician)
    {
        $this->allowedTechnicians->attach($allowedTechnician);
    }
    
    /**
     * Removes a Technician
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Technician $allowedTechnicianToRemove The Technician to be removed
     * @return void
     */
    public function removeAllowedTechnician(\DanLundgren\DlIponlyestate\Domain\Model\Technician $allowedTechnicianToRemove)
    {
        $this->allowedTechnicians->detach($allowedTechnicianToRemove);
    }
    
    /**
     * Returns the allowedTechnicians
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Technician> $allowedTechnicians
     */
    public function getAllowedTechnicians()
    {
        return $this->allowedTechnicians;
    }
    
    /**
     * Sets the allowedTechnicians
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Technician> $allowedTechnicians
     * @return void
     */
    public function setAllowedTechnicians(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $allowedTechnicians)
    {
        $this->allowedTechnicians = $allowedTechnicians;
    }

}