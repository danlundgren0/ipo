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
 * Estate
 */
class Estate extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';
    
    /**
     * estateDescription
     *
     * @var string
     */
    protected $estateDescription = '';
    
    /**
     * adress
     *
     * @var string
     */
    protected $adress = '';
    
    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $image = null;
    
    /**
     * postalCode
     *
     * @var string
     */
    protected $postalCode = '';
    
    /**
     * city
     *
     * @var string
     */
    protected $city = '';
    
    /**
     * width
     *
     * @var int
     */
    protected $width = 0;
    
    /**
     * length
     *
     * @var int
     */
    protected $length = 0;
    
    /**
     * doorPosition
     *
     * @var string
     */
    protected $doorPosition = '';
    
    /**
     * latitude
     *
     * @var float
     */
    protected $latitude = 0.0;
    
    /**
     * longitude
     *
     * @var float
     */
    protected $longitude = 0.0;
    
    /**
     * responsibleTechnician
     *
     * @var int
     */
    protected $responsibleTechnician = 0;
    
    /**
     * controlPoints
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\ControlPoint>
     */
    protected $controlPoints = null;
    
    /**
     * nodeType
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Model\NodeType
     */
    protected $nodeType = null;
    
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
        $this->controlPoints = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Adds a ControlPoint
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint $controlPoint
     * @return void
     */
    public function addControlPoint(\DanLundgren\DlIponlyestate\Domain\Model\ControlPoint $controlPoint)
    {
        $this->controlPoints->attach($controlPoint);
    }
    
    /**
     * Removes a ControlPoint
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint $controlPointToRemove The ControlPoint to be removed
     * @return void
     */
    public function removeControlPoint(\DanLundgren\DlIponlyestate\Domain\Model\ControlPoint $controlPointToRemove)
    {
        $this->controlPoints->detach($controlPointToRemove);
    }
    
    /**
     * Returns the controlPoints
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\ControlPoint> $controlPoints
     */
    public function getControlPoints()
    {
        return $this->controlPoints;
    }
    
    /**
     * Sets the controlPoints
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\ControlPoint> $controlPoints
     * @return void
     */
    public function setControlPoints(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $controlPoints)
    {
        $this->controlPoints = $controlPoints;
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
     * Returns the adress
     *
     * @return string $adress
     */
    public function getAdress()
    {
        return $this->adress;
    }
    
    /**
     * Sets the adress
     *
     * @param string $adress
     * @return void
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;
    }
    
    /**
     * Returns the postalCode
     *
     * @return string $postalCode
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }
    
    /**
     * Sets the postalCode
     *
     * @param string $postalCode
     * @return void
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
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
     * Returns the width
     *
     * @return int $width
     */
    public function getWidth()
    {
        return $this->width;
    }
    
    /**
     * Sets the width
     *
     * @param int $width
     * @return void
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }
    
    /**
     * Returns the length
     *
     * @return int $length
     */
    public function getLength()
    {
        return $this->length;
    }
    
    /**
     * Sets the length
     *
     * @param int $length
     * @return void
     */
    public function setLength($length)
    {
        $this->length = $length;
    }
    
    /**
     * Returns the doorPosition
     *
     * @return string $doorPosition
     */
    public function getDoorPosition()
    {
        return $this->doorPosition;
    }
    
    /**
     * Sets the doorPosition
     *
     * @param string $doorPosition
     * @return void
     */
    public function setDoorPosition($doorPosition)
    {
        $this->doorPosition = $doorPosition;
    }
    
    /**
     * Returns the latitude
     *
     * @return float $latitude
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
    
    /**
     * Sets the latitude
     *
     * @param float $latitude
     * @return void
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }
    
    /**
     * Returns the longitude
     *
     * @return float $longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
    
    /**
     * Sets the longitude
     *
     * @param float $longitude
     * @return void
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
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
     * Returns the estateDescription
     *
     * @return string $estateDescription
     */
    public function getEstateDescription()
    {
        return $this->estateDescription;
    }
    
    /**
     * Sets the estateDescription
     *
     * @param string $estateDescription
     * @return void
     */
    public function setEstateDescription($estateDescription)
    {
        $this->estateDescription = $estateDescription;
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

}