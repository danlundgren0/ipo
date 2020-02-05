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
 * Test case for class \DanLundgren\DlIponlyestate\Domain\Model\Note.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Dan Lundgren <danlundgren0@gmail.com>
 */
class NoteTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \DanLundgren\DlIponlyestate\Domain\Model\Note
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \DanLundgren\DlIponlyestate\Domain\Model\Note();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getCommentReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getComment()
		);
	}

	/**
	 * @test
	 */
	public function setCommentForStringSetsComment()
	{
		$this->subject->setComment('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'comment',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getStateReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getState()
		);
	}

	/**
	 * @test
	 */
	public function setStateForStringSetsState()
	{
		$this->subject->setState('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'state',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getImagesReturnsInitialValueForFileReference()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getImages()
		);
	}

	/**
	 * @test
	 */
	public function setImagesForFileReferenceSetsImages()
	{
		$fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$this->subject->setImages($fileReferenceFixture);

		$this->assertAttributeEquals(
			$fileReferenceFixture,
			'images',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getRemarkTypeReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setRemarkTypeForIntSetsRemarkType()
	{	}

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
	public function getExecutiveTechnicianReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getExecutiveTechnician()
		);
	}

	/**
	 * @test
	 */
	public function setExecutiveTechnicianForStringSetsExecutiveTechnician()
	{
		$this->subject->setExecutiveTechnician('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'executiveTechnician',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPageIdReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setPageIdForIntSetsPageId()
	{	}

	/**
	 * @test
	 */
	public function getUploadedImageReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getUploadedImage()
		);
	}

	/**
	 * @test
	 */
	public function setUploadedImageForBoolSetsUploadedImage()
	{
		$this->subject->setUploadedImage(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'uploadedImage',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getUploadImages1ReturnsInitialValueForFileReference()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getUploadImages1()
		);
	}

	/**
	 * @test
	 */
	public function setUploadImages1ForFileReferenceSetsUploadImages1()
	{
		$fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$this->subject->setUploadImages1($fileReferenceFixture);

		$this->assertAttributeEquals(
			$fileReferenceFixture,
			'uploadImages1',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getUploadImages2ReturnsInitialValueForFileReference()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getUploadImages2()
		);
	}

	/**
	 * @test
	 */
	public function setUploadImages2ForFileReferenceSetsUploadImages2()
	{
		$fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$this->subject->setUploadImages2($fileReferenceFixture);

		$this->assertAttributeEquals(
			$fileReferenceFixture,
			'uploadImages2',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getControlPointReturnsInitialValueForControlPoint()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getControlPoint()
		);
	}

	/**
	 * @test
	 */
	public function setControlPointForControlPointSetsControlPoint()
	{
		$controlPointFixture = new \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint();
		$this->subject->setControlPoint($controlPointFixture);

		$this->assertAttributeEquals(
			$controlPointFixture,
			'controlPoint',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getQuestionReturnsInitialValueForQuestion()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getQuestion()
		);
	}

	/**
	 * @test
	 */
	public function setQuestionForQuestionSetsQuestion()
	{
		$questionFixture = new \DanLundgren\DlIponlyestate\Domain\Model\Question();
		$this->subject->setQuestion($questionFixture);

		$this->assertAttributeEquals(
			$questionFixture,
			'question',
			$this->subject
		);
	}
}
