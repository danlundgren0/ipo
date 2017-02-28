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
     * purchase
     *
     * @var bool
     */
    protected $purchase = false;
    
    /**
     * dynamicColumn
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\DynamicColumn>
     * @cascade remove
     */
    protected $dynamicColumn = null;
    
    /**
     * The actual technician that performs the check
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<>
     * @cascade remove
     */
    protected $executiveTechnician = null;
    
    /**
     * comments
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Comment>
     * @cascade remove
     */
    protected $comments = null;
    
    /**
     * photos
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Photo>
     * @cascade remove
     */
    protected $photos = null;
    
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
        $this->executiveTechnician = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->comments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->photos = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Comment $comment
     * @return void
     */
    public function addComment(\DanLundgren\DlIponlyestate\Domain\Model\Comment $comment)
    {
        $this->comments->attach($comment);
    }
    
    /**
     * Removes a Comment
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Comment $commentToRemove The Comment to be removed
     * @return void
     */
    public function removeComment(\DanLundgren\DlIponlyestate\Domain\Model\Comment $commentToRemove)
    {
        $this->comments->detach($commentToRemove);
    }
    
    /**
     * Returns the comments
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Comment> $comments
     */
    public function getComments()
    {
        return $this->comments;
    }
    
    /**
     * Sets the comments
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Comment> $comments
     * @return void
     */
    public function setComments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $comments)
    {
        $this->comments = $comments;
    }
    
    /**
     * Adds a Photo
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Photo $photo
     * @return void
     */
    public function addPhoto(\DanLundgren\DlIponlyestate\Domain\Model\Photo $photo)
    {
        $this->photos->attach($photo);
    }
    
    /**
     * Removes a Photo
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Photo $photoToRemove The Photo to be removed
     * @return void
     */
    public function removePhoto(\DanLundgren\DlIponlyestate\Domain\Model\Photo $photoToRemove)
    {
        $this->photos->detach($photoToRemove);
    }
    
    /**
     * Returns the photos
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Photo> $photos
     */
    public function getPhotos()
    {
        return $this->photos;
    }
    
    /**
     * Sets the photos
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\Photo> $photos
     * @return void
     */
    public function setPhotos(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $photos)
    {
        $this->photos = $photos;
    }
    
    /**
     * Adds a Technician
     *
     * @param  $executiveTechnician
     * @return void
     */
    public function addExecutiveTechnician($executiveTechnician)
    {
        $this->executiveTechnician->attach($executiveTechnician);
    }
    
    /**
     * Removes a Technician
     *
     * @param  $executiveTechnicianToRemove The  to be removed
     * @return void
     */
    public function removeExecutiveTechnician($executiveTechnicianToRemove)
    {
        $this->executiveTechnician->detach($executiveTechnicianToRemove);
    }
    
    /**
     * Returns the executiveTechnician
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<> executiveTechnician
     */
    public function getExecutiveTechnician()
    {
        return $this->executiveTechnician;
    }
    
    /**
     * Sets the executiveTechnician
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<> $executiveTechnician
     * @return void
     */
    public function setExecutiveTechnician(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $executiveTechnician)
    {
        $this->executiveTechnician = $executiveTechnician;
    }

}