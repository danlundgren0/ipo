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
 * Test case for class \DanLundgren\DlIponlyestate\Domain\Model\Estate.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Dan Lundgren <danlundgren0@gmail.com>
 */
class EstateTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \DanLundgren\DlIponlyestate\Domain\Model\Estate
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \DanLundgren\DlIponlyestate\Domain\Model\Estate();
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
	public function getEstateDescriptionReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getEstateDescription()
		);
	}

	/**
	 * @test
	 */
	public function setEstateDescriptionForStringSetsEstateDescription()
	{
		$this->subject->setEstateDescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'estateDescription',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAdminNoteReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getAdminNote()
		);
	}

	/**
	 * @test
	 */
	public function setAdminNoteForStringSetsAdminNote()
	{
		$this->subject->setAdminNote('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'adminNote',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEnableAdminNoteReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getEnableAdminNote()
		);
	}

	/**
	 * @test
	 */
	public function setEnableAdminNoteForBoolSetsEnableAdminNote()
	{
		$this->subject->setEnableAdminNote(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'enableAdminNote',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPageLinkReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getPageLink()
		);
	}

	/**
	 * @test
	 */
	public function setPageLinkForStringSetsPageLink()
	{
		$this->subject->setPageLink('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'pageLink',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAdressReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getAdress()
		);
	}

	/**
	 * @test
	 */
	public function setAdressForStringSetsAdress()
	{
		$this->subject->setAdress('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'adress',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getImageReturnsInitialValueForFileReference()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getImage()
		);
	}

	/**
	 * @test
	 */
	public function setImageForFileReferenceSetsImage()
	{
		$fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$this->subject->setImage($fileReferenceFixture);

		$this->assertAttributeEquals(
			$fileReferenceFixture,
			'image',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPostalCodeReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getPostalCode()
		);
	}

	/**
	 * @test
	 */
	public function setPostalCodeForStringSetsPostalCode()
	{
		$this->subject->setPostalCode('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'postalCode',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getCityReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getCity()
		);
	}

	/**
	 * @test
	 */
	public function setCityForStringSetsCity()
	{
		$this->subject->setCity('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'city',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getWidthReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setWidthForIntSetsWidth()
	{	}

	/**
	 * @test
	 */
	public function getLengthReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setLengthForIntSetsLength()
	{	}

	/**
	 * @test
	 */
	public function getDoorPositionReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getDoorPosition()
		);
	}

	/**
	 * @test
	 */
	public function setDoorPositionForStringSetsDoorPosition()
	{
		$this->subject->setDoorPosition('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'doorPosition',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getLatitudeReturnsInitialValueForFloat()
	{
		$this->assertSame(
			0.0,
			$this->subject->getLatitude()
		);
	}

	/**
	 * @test
	 */
	public function setLatitudeForFloatSetsLatitude()
	{
		$this->subject->setLatitude(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'latitude',
			$this->subject,
			'',
			0.000000001
		);
	}

	/**
	 * @test
	 */
	public function getLongitudeReturnsInitialValueForFloat()
	{
		$this->assertSame(
			0.0,
			$this->subject->getLongitude()
		);
	}

	/**
	 * @test
	 */
	public function setLongitudeForFloatSetsLongitude()
	{
		$this->subject->setLongitude(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'longitude',
			$this->subject,
			'',
			0.000000001
		);
	}

	/**
	 * @test
	 */
	public function getResponsibleTechnicianReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setResponsibleTechnicianForIntSetsResponsibleTechnician()
	{	}

	/**
	 * @test
	 */
	public function getControlPointsReturnsInitialValueForControlPoint()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getControlPoints()
		);
	}

	/**
	 * @test
	 */
	public function setControlPointsForObjectStorageContainingControlPointSetsControlPoints()
	{
		$controlPoint = new \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint();
		$objectStorageHoldingExactlyOneControlPoints = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneControlPoints->attach($controlPoint);
		$this->subject->setControlPoints($objectStorageHoldingExactlyOneControlPoints);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneControlPoints,
			'controlPoints',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addControlPointToObjectStorageHoldingControlPoints()
	{
		$controlPoint = new \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint();
		$controlPointsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$controlPointsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($controlPoint));
		$this->inject($this->subject, 'controlPoints', $controlPointsObjectStorageMock);

		$this->subject->addControlPoint($controlPoint);
	}

	/**
	 * @test
	 */
	public function removeControlPointFromObjectStorageHoldingControlPoints()
	{
		$controlPoint = new \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint();
		$controlPointsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$controlPointsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($controlPoint));
		$this->inject($this->subject, 'controlPoints', $controlPointsObjectStorageMock);

		$this->subject->removeControlPoint($controlPoint);

	}

	/**
	 * @test
	 */
	public function getNodeTypeReturnsInitialValueForNodeType()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getNodeType()
		);
	}

	/**
	 * @test
	 */
	public function setNodeTypeForNodeTypeSetsNodeType()
	{
		$nodeTypeFixture = new \DanLundgren\DlIponlyestate\Domain\Model\NodeType();
		$this->subject->setNodeType($nodeTypeFixture);

		$this->assertAttributeEquals(
			$nodeTypeFixture,
			'nodeType',
			$this->subject
		);
	}
}
