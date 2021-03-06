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
 * Test case for class \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Dan Lundgren <danlundgren0@gmail.com>
 */
class ControlPointTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint();
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
	public function getReportReturnsInitialValueFor()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getReport()
		);
	}

	/**
	 * @test
	 */
	public function setReportForObjectStorageContainingSetsReport()
	{
		$report = new ();
		$objectStorageHoldingExactlyOneReport = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneReport->attach($report);
		$this->subject->setReport($objectStorageHoldingExactlyOneReport);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneReport,
			'report',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addReportToObjectStorageHoldingReport()
	{
		$report = new ();
		$reportObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$reportObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($report));
		$this->inject($this->subject, 'report', $reportObjectStorageMock);

		$this->subject->addReport($report);
	}

	/**
	 * @test
	 */
	public function removeReportFromObjectStorageHoldingReport()
	{
		$report = new ();
		$reportObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$reportObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($report));
		$this->inject($this->subject, 'report', $reportObjectStorageMock);

		$this->subject->removeReport($report);

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

	/**
	 * @test
	 */
	public function getQuestionsReturnsInitialValueForQuestion()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getQuestions()
		);
	}

	/**
	 * @test
	 */
	public function setQuestionsForObjectStorageContainingQuestionSetsQuestions()
	{
		$question = new \DanLundgren\DlIponlyestate\Domain\Model\Question();
		$objectStorageHoldingExactlyOneQuestions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneQuestions->attach($question);
		$this->subject->setQuestions($objectStorageHoldingExactlyOneQuestions);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneQuestions,
			'questions',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addQuestionToObjectStorageHoldingQuestions()
	{
		$question = new \DanLundgren\DlIponlyestate\Domain\Model\Question();
		$questionsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$questionsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($question));
		$this->inject($this->subject, 'questions', $questionsObjectStorageMock);

		$this->subject->addQuestion($question);
	}

	/**
	 * @test
	 */
	public function removeQuestionFromObjectStorageHoldingQuestions()
	{
		$question = new \DanLundgren\DlIponlyestate\Domain\Model\Question();
		$questionsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$questionsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($question));
		$this->inject($this->subject, 'questions', $questionsObjectStorageMock);

		$this->subject->removeQuestion($question);

	}

	/**
	 * @test
	 */
	public function getAllowedTechniciansReturnsInitialValueForTechnician()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getAllowedTechnicians()
		);
	}

	/**
	 * @test
	 */
	public function setAllowedTechniciansForObjectStorageContainingTechnicianSetsAllowedTechnicians()
	{
		$allowedTechnician = new \DanLundgren\DlIponlyestate\Domain\Model\Technician();
		$objectStorageHoldingExactlyOneAllowedTechnicians = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneAllowedTechnicians->attach($allowedTechnician);
		$this->subject->setAllowedTechnicians($objectStorageHoldingExactlyOneAllowedTechnicians);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneAllowedTechnicians,
			'allowedTechnicians',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addAllowedTechnicianToObjectStorageHoldingAllowedTechnicians()
	{
		$allowedTechnician = new \DanLundgren\DlIponlyestate\Domain\Model\Technician();
		$allowedTechniciansObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$allowedTechniciansObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($allowedTechnician));
		$this->inject($this->subject, 'allowedTechnicians', $allowedTechniciansObjectStorageMock);

		$this->subject->addAllowedTechnician($allowedTechnician);
	}

	/**
	 * @test
	 */
	public function removeAllowedTechnicianFromObjectStorageHoldingAllowedTechnicians()
	{
		$allowedTechnician = new \DanLundgren\DlIponlyestate\Domain\Model\Technician();
		$allowedTechniciansObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$allowedTechniciansObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($allowedTechnician));
		$this->inject($this->subject, 'allowedTechnicians', $allowedTechniciansObjectStorageMock);

		$this->subject->removeAllowedTechnician($allowedTechnician);

	}

	/**
	 * @test
	 */
	public function getAlllowedResponsibleTechniciansReturnsInitialValueForTechnician()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getAlllowedResponsibleTechnicians()
		);
	}

	/**
	 * @test
	 */
	public function setAlllowedResponsibleTechniciansForTechnicianSetsAlllowedResponsibleTechnicians()
	{
		$alllowedResponsibleTechniciansFixture = new \DanLundgren\DlIponlyestate\Domain\Model\Technician();
		$this->subject->setAlllowedResponsibleTechnicians($alllowedResponsibleTechniciansFixture);

		$this->assertAttributeEquals(
			$alllowedResponsibleTechniciansFixture,
			'alllowedResponsibleTechnicians',
			$this->subject
		);
	}
}
