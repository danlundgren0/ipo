<?php

namespace DanLundgren\DlIponlyestate\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2020 Dan Lundgren <danlundgren0@gmail.com>, Dan Lundgren
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \DanLundgren\DlIponlyestate\Domain\Model\Report.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Dan Lundgren <danlundgren0@gmail.com>
 */
class ReportTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \DanLundgren\DlIponlyestate\Domain\Model\Report
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \DanLundgren\DlIponlyestate\Domain\Model\Report();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getName()
		);
	}

	/**
	 * @test
	 */
	public function setNameForStringSetsName()
	{
		$this->subject->setName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'name',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getVersionReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setVersionForIntSetsVersion()
	{	}

	/**
	 * @test
	 */
	public function getDateReturnsInitialValueForDateTime()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getDate()
		);
	}

	/**
	 * @test
	 */
	public function setDateForDateTimeSetsDate()
	{
		$dateTimeFixture = new \DateTime();
		$this->subject->setDate($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'date',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getIsCompleteReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getIsComplete()
		);
	}

	/**
	 * @test
	 */
	public function setIsCompleteForBoolSetsIsComplete()
	{
		$this->subject->setIsComplete(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'isComplete',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getNodeTypeReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setNodeTypeForIntSetsNodeType()
	{	}

	/**
	 * @test
	 */
	public function getControlPointReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setControlPointForIntSetsControlPoint()
	{	}

	/**
	 * @test
	 */
	public function getExecutiveTechnicianReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setExecutiveTechnicianForIntSetsExecutiveTechnician()
	{	}

	/**
	 * @test
	 */
	public function getResponsibleTechniciansReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setResponsibleTechniciansForIntSetsResponsibleTechnicians()
	{	}

	/**
	 * @test
	 */
	public function getReportIsPostedReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getReportIsPosted()
		);
	}

	/**
	 * @test
	 */
	public function setReportIsPostedForBoolSetsReportIsPosted()
	{
		$this->subject->setReportIsPosted(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'reportIsPosted',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getStartDateReturnsInitialValueForDateTime()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getStartDate()
		);
	}

	/**
	 * @test
	 */
	public function setStartDateForDateTimeSetsStartDate()
	{
		$dateTimeFixture = new \DateTime();
		$this->subject->setStartDate($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'startDate',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEndDateReturnsInitialValueForDateTime()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getEndDate()
		);
	}

	/**
	 * @test
	 */
	public function setEndDateForDateTimeSetsEndDate()
	{
		$dateTimeFixture = new \DateTime();
		$this->subject->setEndDate($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'endDate',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getNoOfCriticalRemarksReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setNoOfCriticalRemarksForIntSetsNoOfCriticalRemarks()
	{	}

	/**
	 * @test
	 */
	public function getNoOfRemarksReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setNoOfRemarksForIntSetsNoOfRemarks()
	{	}

	/**
	 * @test
	 */
	public function getNoOfOldRemarksReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setNoOfOldRemarksForIntSetsNoOfOldRemarks()
	{	}

	/**
	 * @test
	 */
	public function getNoOfNotesReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setNoOfNotesForIntSetsNoOfNotes()
	{	}

	/**
	 * @test
	 */
	public function getNoOfPurchasesReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setNoOfPurchasesForIntSetsNoOfPurchases()
	{	}

	/**
	 * @test
	 */
	public function getDynamicColumnReturnsInitialValueForDynamicColumn()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getDynamicColumn()
		);
	}

	/**
	 * @test
	 */
	public function setDynamicColumnForObjectStorageContainingDynamicColumnSetsDynamicColumn()
	{
		$dynamicColumn = new \DanLundgren\DlIponlyestate\Domain\Model\DynamicColumn();
		$objectStorageHoldingExactlyOneDynamicColumn = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneDynamicColumn->attach($dynamicColumn);
		$this->subject->setDynamicColumn($objectStorageHoldingExactlyOneDynamicColumn);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneDynamicColumn,
			'dynamicColumn',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addDynamicColumnToObjectStorageHoldingDynamicColumn()
	{
		$dynamicColumn = new \DanLundgren\DlIponlyestate\Domain\Model\DynamicColumn();
		$dynamicColumnObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$dynamicColumnObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($dynamicColumn));
		$this->inject($this->subject, 'dynamicColumn', $dynamicColumnObjectStorageMock);

		$this->subject->addDynamicColumn($dynamicColumn);
	}

	/**
	 * @test
	 */
	public function removeDynamicColumnFromObjectStorageHoldingDynamicColumn()
	{
		$dynamicColumn = new \DanLundgren\DlIponlyestate\Domain\Model\DynamicColumn();
		$dynamicColumnObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$dynamicColumnObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($dynamicColumn));
		$this->inject($this->subject, 'dynamicColumn', $dynamicColumnObjectStorageMock);

		$this->subject->removeDynamicColumn($dynamicColumn);

	}

	/**
	 * @test
	 */
	public function getNotesReturnsInitialValueForNote()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getNotes()
		);
	}

	/**
	 * @test
	 */
	public function setNotesForObjectStorageContainingNoteSetsNotes()
	{
		$note = new \DanLundgren\DlIponlyestate\Domain\Model\Note();
		$objectStorageHoldingExactlyOneNotes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneNotes->attach($note);
		$this->subject->setNotes($objectStorageHoldingExactlyOneNotes);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneNotes,
			'notes',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addNoteToObjectStorageHoldingNotes()
	{
		$note = new \DanLundgren\DlIponlyestate\Domain\Model\Note();
		$notesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$notesObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($note));
		$this->inject($this->subject, 'notes', $notesObjectStorageMock);

		$this->subject->addNote($note);
	}

	/**
	 * @test
	 */
	public function removeNoteFromObjectStorageHoldingNotes()
	{
		$note = new \DanLundgren\DlIponlyestate\Domain\Model\Note();
		$notesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$notesObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($note));
		$this->inject($this->subject, 'notes', $notesObjectStorageMock);

		$this->subject->removeNote($note);

	}

	/**
	 * @test
	 */
	public function getEstateReturnsInitialValueForEstate()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getEstate()
		);
	}

	/**
	 * @test
	 */
	public function setEstateForEstateSetsEstate()
	{
		$estateFixture = new \DanLundgren\DlIponlyestate\Domain\Model\Estate();
		$this->subject->setEstate($estateFixture);

		$this->assertAttributeEquals(
			$estateFixture,
			'estate',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getReportedMeasurementReturnsInitialValueForReportedMeasurement()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getReportedMeasurement()
		);
	}

	/**
	 * @test
	 */
	public function setReportedMeasurementForObjectStorageContainingReportedMeasurementSetsReportedMeasurement()
	{
		$reportedMeasurement = new \DanLundgren\DlIponlyestate\Domain\Model\ReportedMeasurement();
		$objectStorageHoldingExactlyOneReportedMeasurement = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneReportedMeasurement->attach($reportedMeasurement);
		$this->subject->setReportedMeasurement($objectStorageHoldingExactlyOneReportedMeasurement);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneReportedMeasurement,
			'reportedMeasurement',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addReportedMeasurementToObjectStorageHoldingReportedMeasurement()
	{
		$reportedMeasurement = new \DanLundgren\DlIponlyestate\Domain\Model\ReportedMeasurement();
		$reportedMeasurementObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$reportedMeasurementObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($reportedMeasurement));
		$this->inject($this->subject, 'reportedMeasurement', $reportedMeasurementObjectStorageMock);

		$this->subject->addReportedMeasurement($reportedMeasurement);
	}

	/**
	 * @test
	 */
	public function removeReportedMeasurementFromObjectStorageHoldingReportedMeasurement()
	{
		$reportedMeasurement = new \DanLundgren\DlIponlyestate\Domain\Model\ReportedMeasurement();
		$reportedMeasurementObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$reportedMeasurementObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($reportedMeasurement));
		$this->inject($this->subject, 'reportedMeasurement', $reportedMeasurementObjectStorageMock);

		$this->subject->removeReportedMeasurement($reportedMeasurement);

	}
}
