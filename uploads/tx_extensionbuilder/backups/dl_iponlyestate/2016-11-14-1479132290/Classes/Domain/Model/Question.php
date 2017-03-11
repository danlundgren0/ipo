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
 * Question
 */
class Question extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * criticalRemarks
     *
     * @var int
     */
    protected $criticalRemarks = 0;
    
    /**
     * remarks
     *
     * @var int
     */
    protected $remarks = 0;
    
    /**
     * note
     *
     * @var int
     */
    protected $note = 0;
    
    /**
     * purchase
     *
     * @var int
     */
    protected $purchase = 0;
    
    /**
     * Returns the criticalRemarks
     *
     * @return int $criticalRemarks
     */
    public function getCriticalRemarks()
    {
        return $this->criticalRemarks;
    }
    
    /**
     * Sets the criticalRemarks
     *
     * @param int $criticalRemarks
     * @return void
     */
    public function setCriticalRemarks($criticalRemarks)
    {
        $this->criticalRemarks = $criticalRemarks;
    }
    
    /**
     * Returns the remarks
     *
     * @return int $remarks
     */
    public function getRemarks()
    {
        return $this->remarks;
    }
    
    /**
     * Sets the remarks
     *
     * @param int $remarks
     * @return void
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;
    }
    
    /**
     * Returns the note
     *
     * @return int $note
     */
    public function getNote()
    {
        return $this->note;
    }
    
    /**
     * Sets the note
     *
     * @param int $note
     * @return void
     */
    public function setNote($note)
    {
        $this->note = $note;
    }
    
    /**
     * Returns the purchase
     *
     * @return int $purchase
     */
    public function getPurchase()
    {
        return $this->purchase;
    }
    
    /**
     * Sets the purchase
     *
     * @param int $purchase
     * @return void
     */
    public function setPurchase($purchase)
    {
        $this->purchase = $purchase;
    }

}