<?php
namespace DanLundgren\DlIponlyestate\Tests\Unit\Controller;
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
 * Test case for class DanLundgren\DlIponlyestate\Controller\EstateController.
 *
 * @author Dan Lundgren <danlundgren0@gmail.com>
 */
class EstateControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \DanLundgren\DlIponlyestate\Controller\EstateController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('DanLundgren\\DlIponlyestate\\Controller\\EstateController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllEstatesFromRepositoryAndAssignsThemToView()
	{

		$allEstates = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$estateRepository = $this->getMock('DanLundgren\\DlIponlyestate\\Domain\\Repository\\EstateRepository', array('findAll'), array(), '', FALSE);
		$estateRepository->expects($this->once())->method('findAll')->will($this->returnValue($allEstates));
		$this->inject($this->subject, 'estateRepository', $estateRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('estates', $allEstates);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenEstateToView()
	{
		$estate = new \DanLundgren\DlIponlyestate\Domain\Model\Estate();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('estate', $estate);

		$this->subject->showAction($estate);
	}
}
