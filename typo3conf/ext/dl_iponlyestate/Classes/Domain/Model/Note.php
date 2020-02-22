<?php
namespace DanLundgren\DlIponlyestate\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Dan Lundgren <danlundgren0@gmail.com>, Dan Lundgren
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
 * Comment
 */
class Note extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * comment
     *
     * @var string
     */
    protected $comment = '';
    
    /**
     * state
     *
     * @var string
     */
    protected $state = '';
    
    /**
     * images
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $images = null;
    
    /**
     * remarkType
     *
     * @var int
     * @validate NotEmpty
     */
    protected $remarkType = 0;
    
    /**
     * version
     *
     * @var int
     * @validate NotEmpty
     */
    protected $version = 0;
    
    /**
     * isComplete
     *
     * @var bool
     * @validate NotEmpty
     */
    protected $isComplete = false;
    
    /**
     * date
     *
     * @var \DateTime
     * @validate NotEmpty
     */
    protected $date = null;
    
    /**
     * executiveTechnician
     *
     * @var string
     * @validate NotEmpty
     */
    protected $executiveTechnician = 0;
    
    /**
     * pageId
     *
     * @var int
     * @validate NotEmpty
     */
    protected $pageId = 0;
    
    /**
     * uploadedImage
     *
     * @var bool
     * @validate NotEmpty
     */
    protected $uploadedImage = false;
    
    /**
     * images2
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $images2 = null;
    
    /**
     * images3
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $images3 = null;
    
    /**
     * images4
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $images4 = null;
    
    /**
     * images5
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $images5 = null;
    
    /**
     * controlPoint
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint
     */
    protected $controlPoint = null;
    
    /**
     * question
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Model\Question
     */
    protected $question = null;
    
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
    
    /**
     * Returns the state
     *
     * @return string $state
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * Sets the state
     *
     * @param string $state
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
    }
    
    /**
     * Returns the images
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
     */
    public function getImages()
    {
        return $this->images;
    }
    
    public function getImageFileIdentifier()
    {
        return $this->images->originalFileIdentifier;
    }
    
    /**
     * Sets the images
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
     * @return void
     */
    public function setImages(\TYPO3\CMS\Extbase\Domain\Model\FileReference $images)
    {
        $this->images = $images;
    }
    
    /**
     * Removes a images
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Question $questionToRemove The Question to be removed
     * @return void
     */
    public function removeImage()
    {
        //$this->images->detach($imagesToRemove);
        $GLOBALS['TYPO3_DB']->exec_DELETEquery('sys_file_reference', 'uid=' . intval($this->images->getUid()));
    }
    
    /**
     * Returns the remarkType
     *
     * @return int $remarkType
     */
    public function getRemarkType()
    {
        return $this->remarkType;
    }
    
    /**
     * Sets the remarkType
     *
     * @param int $remarkType
     * @return void
     */
    public function setRemarkType($remarkType)
    {
        $this->remarkType = $remarkType;
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
     * Returns the controlPoint
     *
     * @return \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint $controlPoint
     */
    public function getControlPoint()
    {
        return $this->controlPoint;
    }
    
    /**
     * Sets the controlPoint
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint $controlPoint
     * @return void
     */
    public function setControlPoint(\DanLundgren\DlIponlyestate\Domain\Model\ControlPoint $controlPoint)
    {
        $this->controlPoint = $controlPoint;
    }
    
    /**
     * Returns the question
     *
     * @return \DanLundgren\DlIponlyestate\Domain\Model\Question $question
     */
    public function getQuestion()
    {
        return $this->question;
    }
    
    /**
     * Sets the question
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Question $question
     * @return void
     */
    public function setQuestion(\DanLundgren\DlIponlyestate\Domain\Model\Question $question)
    {
        $this->question = $question;
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
     * Returns the executiveTechnician
     *
     * @return string executiveTechnician
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
     * Returns the pageId
     *
     * @return int $pageId
     */
    public function getPageId()
    {
        return $this->pageId;
    }
    
    /**
     * Sets the pageId
     *
     * @param int $pageId
     * @return void
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;
    }
    
    /**
     * Returns the uploadedImage
     *
     * @return bool $uploadedImage
     */
    public function getUploadedImage()
    {
        return $this->uploadedImage;
    }
    
    /**
     * Sets the uploadedImage
     *
     * @param bool $uploadedImage
     * @return void
     */
    public function setUploadedImage($uploadedImage)
    {
        $this->uploadedImage = $uploadedImage;
    }
    
    /**
     * Returns the boolean state of uploadedImage
     *
     * @return bool
     */
    public function isUploadedImage()
    {
        return $this->uploadedImage;
    }
    
    /**
     * Returns the images2
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $images2
     */
    public function getImages2()
    {
        return $this->images2;
    }
    
    /**
     * Sets the images2
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $images2
     * @return void
     */
    public function setImages2(\TYPO3\CMS\Extbase\Domain\Model\FileReference $images2)
    {
        $this->images2 = $images2;
    }
    
    /**
     * Returns the images3
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $images3
     */
    public function getImages3()
    {
        return $this->images3;
    }
    
    /**
     * Sets the images3
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $images3
     * @return void
     */
    public function setImages3(\TYPO3\CMS\Extbase\Domain\Model\FileReference $images3)
    {
        $this->images3 = $images3;
    }
    
    /**
     * Returns the images4
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $images4
     */
    public function getImages4()
    {
        return $this->images4;
    }
    
    /**
     * Sets the images4
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $images4
     * @return void
     */
    public function setImages4(\TYPO3\CMS\Extbase\Domain\Model\FileReference $images4)
    {
        $this->images4 = $images4;
    }
    
    /**
     * Returns the images5
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $images5
     */
    public function getImages5()
    {
        return $this->images5;
    }
    
    /**
     * Sets the images5
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $images5
     * @return void
     */
    public function setImages5(\TYPO3\CMS\Extbase\Domain\Model\FileReference $images5)
    {
        $this->images5 = $images5;
    }

}