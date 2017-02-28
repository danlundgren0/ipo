<?php

namespace DanLundgren\DlIponlyestate\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Dan Lundgren <danlundgren0@gmail.com>, Dan Lundgren
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
	public function getNodeTypeReturnsInitialValueForNode()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getNodeType()
		);
	}

	/**
	 * @test
	 */
	public function setNodeTypeForObjectStorageContainingNodeSetsNodeType()
	{
		$nodeType = new \DanLundgren\DlIponlyestate\Domain\Model\Node();
		$objectStorageHoldingExactlyOneNodeType = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneNodeType->attach($nodeType);
		$this->subject->setNodeType($objectStorageHoldingExactlyOneNodeType);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneNodeType,
			'nodeType',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addNodeTypeToObjectStorageHoldingNodeType()
	{
		$nodeType = new \DanLundgren\DlIponlyestate\Domain\Model\Node();
		$nodeTypeObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$nodeTypeObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($nodeType));
		$this->inject($this->subject, 'nodeType', $nodeTypeObjectStorageMock);

		$this->subject->addNodeType($nodeType);
	}

	/**
	 * @test
	 */
	public function removeNodeTypeFromObjectStorageHoldingNodeType()
	{
		$nodeType = new \DanLundgren\DlIponlyestate\Domain\Model\Node();
		$nodeTypeObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$nodeTypeObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($nodeType));
		$this->inject($this->subject, 'nodeType', $nodeTypeObjectStorageMock);

		$this->subject->removeNodeType($nodeType);

	}

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
	public function getResponsibleTechnicianReturnsInitialValueForTechnician()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getResponsibleTechnician()
		);
	}

	/**
	 * @test
	 */
	public function setResponsibleTechnicianForTechnicianSetsResponsibleTechnician()
	{
		$responsibleTechnicianFixture = new \DanLundgren\DlIponlyestate\Domain\Model\Technician();
		$this->subject->setResponsibleTechnician($responsibleTechnicianFixture);

		$this->assertAttributeEquals(
			$responsibleTechnicianFixture,
			'responsibleTechnician',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTechnicianReturnsInitialValueForTechnician()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getTechnician()
		);
	}

	/**
	 * @test
	 */
	public function setTechnicianForTechnicianSetsTechnician()
	{
		$technicianFixture = new \DanLundgren\DlIponlyestate\Domain\Model\Technician();
		$this->subject->setTechnician($technicianFixture);

		$this->assertAttributeEquals(
			$technicianFixture,
			'technician',
			$this->subject
		);
	}
}
