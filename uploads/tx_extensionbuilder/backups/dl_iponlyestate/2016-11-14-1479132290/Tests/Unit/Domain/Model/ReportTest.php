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
	public function getQuestionReturnsInitialValueForQuestion()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getQuestion()
		);
	}

	/**
	 * @test
	 */
	public function setQuestionForObjectStorageContainingQuestionSetsQuestion()
	{
		$question = new \DanLundgren\DlIponlyestate\Domain\Model\Question();
		$objectStorageHoldingExactlyOneQuestion = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneQuestion->attach($question);
		$this->subject->setQuestion($objectStorageHoldingExactlyOneQuestion);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneQuestion,
			'question',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addQuestionToObjectStorageHoldingQuestion()
	{
		$question = new \DanLundgren\DlIponlyestate\Domain\Model\Question();
		$questionObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$questionObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($question));
		$this->inject($this->subject, 'question', $questionObjectStorageMock);

		$this->subject->addQuestion($question);
	}

	/**
	 * @test
	 */
	public function removeQuestionFromObjectStorageHoldingQuestion()
	{
		$question = new \DanLundgren\DlIponlyestate\Domain\Model\Question();
		$questionObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$questionObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($question));
		$this->inject($this->subject, 'question', $questionObjectStorageMock);

		$this->subject->removeQuestion($question);

	}
}
