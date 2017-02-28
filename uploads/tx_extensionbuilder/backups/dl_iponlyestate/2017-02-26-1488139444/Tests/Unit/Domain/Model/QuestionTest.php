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
 * Test case for class \DanLundgren\DlIponlyestate\Domain\Model\Question.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Dan Lundgren <danlundgren0@gmail.com>
 */
class QuestionTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \DanLundgren\DlIponlyestate\Domain\Model\Question
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \DanLundgren\DlIponlyestate\Domain\Model\Question();
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
	public function getReportsReturnsInitialValueForReport()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getReports()
		);
	}

	/**
	 * @test
	 */
	public function setReportsForObjectStorageContainingReportSetsReports()
	{
		$report = new \DanLundgren\DlIponlyestate\Domain\Model\Report();
		$objectStorageHoldingExactlyOneReports = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneReports->attach($report);
		$this->subject->setReports($objectStorageHoldingExactlyOneReports);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneReports,
			'reports',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addReportToObjectStorageHoldingReports()
	{
		$report = new \DanLundgren\DlIponlyestate\Domain\Model\Report();
		$reportsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$reportsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($report));
		$this->inject($this->subject, 'reports', $reportsObjectStorageMock);

		$this->subject->addReport($report);
	}

	/**
	 * @test
	 */
	public function removeReportFromObjectStorageHoldingReports()
	{
		$report = new \DanLundgren\DlIponlyestate\Domain\Model\Report();
		$reportsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$reportsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($report));
		$this->inject($this->subject, 'reports', $reportsObjectStorageMock);

		$this->subject->removeReport($report);

	}
}
