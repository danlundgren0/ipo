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
 * Message
 */
class ReportedMeasurement extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';
    
    /**
     * unit
     *
     * @var string
     */
    protected $unit = '';
    
    /**
     * value
     *
     * @var string
     */
    protected $value = '';
    
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
     * executiveTechnician
     *
     * @var string
     */
    protected $executiveTechnician = '';
    
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
     * Returns the unit
     *
     * @return string $unit
     */
    public function getUnit()
    {
        return $this->unit;
    }
    
    /**
     * Sets the unit
     *
     * @param string $unit
     * @return void
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }
    
    /**
     * Returns the value
     *
     * @return string $value
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * Sets the value
     *
     * @param string $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
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
     * Returns the executiveTechnician
     *
     * @return string $executiveTechnician
     */
    public function getExecutiveTechnician()
    {
        return $this->executiveTechnician;
    }
    
    /**
     * Sets the executiveTechnician
     *
     * @param string $executiveTechnician
     * @return void
     */
    public function setExecutiveTechnician($executiveTechnician)
    {
        $this->executiveTechnician = $executiveTechnician;
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

}