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
 * Test case for class \DanLundgren\DlIponlyestate\Domain\Model\ReportedMeasurement.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Dan Lundgren <danlundgren0@gmail.com>
 */
class ReportedMeasurementTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \DanLundgren\DlIponlyestate\Domain\Model\ReportedMeasurement
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \DanLundgren\DlIponlyestate\Domain\Model\ReportedMeasurement();
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
	public function getUnitReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getUnit()
		);
	}

	/**
	 * @test
	 */
	public function setUnitForStringSetsUnit()
	{
		$this->subject->setUnit('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'unit',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getValueReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getValue()
		);
	}

	/**
	 * @test
	 */
	public function setValueForStringSetsValue()
	{
		$this->subject->setValue('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'value',
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
