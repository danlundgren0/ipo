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
     * responsibleTechnician
     *
     * @var int
     */
    protected $responsibleTechnician = 0;
    
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
     * header
     *
     * @var string
     */
    protected $header = '';
    
    /**
     * description
     *
     * @var string
     */
    protected $description = '';
    
    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $image = null;
    
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
        $this->questions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the name
     *
     * @return string name
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
     * Returns the responsibleTechnician
     *
     * @return int $responsibleTechnician
     */
    public function getResponsibleTechnician()
    {
        return $this->responsibleTechnician;
    }
    
    /**
     * Sets the responsibleTechnician
     *
     * @param int $responsibleTechnician
     * @return void
     */
    public function setResponsibleTechnician($responsibleTechnician)
    {
        $this->responsibleTechnician = $responsibleTechnician;
    }
    
    /**
     * Returns the header
     *
     * @return string $header
     */
    public function getHeader()
    {
        return $this->header;
    }
    
    /**
     * Sets the header
     *
     * @param string $header
     * @return void
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }
    
    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->image = $image;
    }

}