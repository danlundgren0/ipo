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
     * nodeType
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Model\Node
     */
    protected $nodeType = null;
    
    /**
     * controlPoints
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DanLundgren\DlIponlyestate\Domain\Model\ControlPoint>
     */
    protected $controlPoints = null;
    
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
     * Returns the nodeType
     *
     * @return \DanLundgren\DlIponlyestate\Domain\Model\Node $nodeType
     */
    public function getNodeType()
    {
        return $this->nodeType;
    }
    
    /**
     * Sets the nodeType
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Node $nodeType
     * @return void
     */
    public function setNodeType(\DanLundgren\DlIponlyestate\Domain\Model\Node $nodeType)
    {
        $this->nodeType = $nodeType;
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

}