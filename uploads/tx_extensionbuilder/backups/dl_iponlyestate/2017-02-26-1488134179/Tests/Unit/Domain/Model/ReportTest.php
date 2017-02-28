<?php

namespace DanLundgren\DlIponlyestate\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Dan Lundgren <danlundgren0@gmail.com>, Dan Lundgren
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
	public function getCriticalRemarksReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getCriticalRemarks()
		);
	}

	/**
	 * @test
	 */
	public function setCriticalRemarksForBoolSetsCriticalRemarks()
	{
		$this->subject->setCriticalRemarks(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'criticalRemarks',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getRemarksReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getRemarks()
		);
	}

	/**
	 * @test
	 */
	public function setRemarksForBoolSetsRemarks()
	{
		$this->subject->setRemarks(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'remarks',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPurchaseReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getPurchase()
		);
	}

	/**
	 * @test
	 */
	public function setPurchaseForBoolSetsPurchase()
	{
		$this->subject->setPurchase(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'purchase',
			$this->subject
		);
	}

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
	public function getExecutiveTechnicianReturnsInitialValueForTechnician()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getExecutiveTechnician()
		);
	}

	/**
	 * @test
	 */
	public function setExecutiveTechnicianForObjectStorageContainingTechnicianSetsExecutiveTechnician()
	{
		$executiveTechnician = new \DanLundgren\DlIponlyestate\Domain\Model\Technician();
		$objectStorageHoldingExactlyOneExecutiveTechnician = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneExecutiveTechnician->attach($executiveTechnician);
		$this->subject->setExecutiveTechnician($objectStorageHoldingExactlyOneExecutiveTechnician);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneExecutiveTechnician,
			'executiveTechnician',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addExecutiveTechnicianToObjectStorageHoldingExecutiveTechnician()
	{
		$executiveTechnician = new \DanLundgren\DlIponlyestate\Domain\Model\Technician();
		$executiveTechnicianObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$executiveTechnicianObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($executiveTechnician));
		$this->inject($this->subject, 'executiveTechnician', $executiveTechnicianObjectStorageMock);

		$this->subject->addExecutiveTechnician($executiveTechnician);
	}

	/**
	 * @test
	 */
	public function removeExecutiveTechnicianFromObjectStorageHoldingExecutiveTechnician()
	{
		$executiveTechnician = new \DanLundgren\DlIponlyestate\Domain\Model\Technician();
		$executiveTechnicianObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$executiveTechnicianObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($executiveTechnician));
		$this->inject($this->subject, 'executiveTechnician', $executiveTechnicianObjectStorageMock);

		$this->subject->removeExecutiveTechnician($executiveTechnician);

	}

	/**
	 * @test
	 */
	public function getCommentsReturnsInitialValueForComment()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getComments()
		);
	}

	/**
	 * @test
	 */
	public function setCommentsForObjectStorageContainingCommentSetsComments()
	{
		$comment = new \DanLundgren\DlIponlyestate\Domain\Model\Comment();
		$objectStorageHoldingExactlyOneComments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneComments->attach($comment);
		$this->subject->setComments($objectStorageHoldingExactlyOneComments);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneComments,
			'comments',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addCommentToObjectStorageHoldingComments()
	{
		$comment = new \DanLundgren\DlIponlyestate\Domain\Model\Comment();
		$commentsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$commentsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($comment));
		$this->inject($this->subject, 'comments', $commentsObjectStorageMock);

		$this->subject->addComment($comment);
	}

	/**
	 * @test
	 */
	public function removeCommentFromObjectStorageHoldingComments()
	{
		$comment = new \DanLundgren\DlIponlyestate\Domain\Model\Comment();
		$commentsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$commentsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($comment));
		$this->inject($this->subject, 'comments', $commentsObjectStorageMock);

		$this->subject->removeComment($comment);

	}

	/**
	 * @test
	 */
	public function getPhotosReturnsInitialValueForPhoto()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getPhotos()
		);
	}

	/**
	 * @test
	 */
	public function setPhotosForObjectStorageContainingPhotoSetsPhotos()
	{
		$photo = new \DanLundgren\DlIponlyestate\Domain\Model\Photo();
		$objectStorageHoldingExactlyOnePhotos = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePhotos->attach($photo);
		$this->subject->setPhotos($objectStorageHoldingExactlyOnePhotos);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOnePhotos,
			'photos',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addPhotoToObjectStorageHoldingPhotos()
	{
		$photo = new \DanLundgren\DlIponlyestate\Domain\Model\Photo();
		$photosObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$photosObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($photo));
		$this->inject($this->subject, 'photos', $photosObjectStorageMock);

		$this->subject->addPhoto($photo);
	}

	/**
	 * @test
	 */
	public function removePhotoFromObjectStorageHoldingPhotos()
	{
		$photo = new \DanLundgren\DlIponlyestate\Domain\Model\Photo();
		$photosObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$photosObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($photo));
		$this->inject($this->subject, 'photos', $photosObjectStorageMock);

		$this->subject->removePhoto($photo);

	}
}
