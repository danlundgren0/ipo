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
 * Test case for class DanLundgren\DlIponlyestate\Controller\NoteController.
 *
 * @author Dan Lundgren <danlundgren0@gmail.com>
 */
class NoteControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \DanLundgren\DlIponlyestate\Controller\NoteController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('DanLundgren\\DlIponlyestate\\Controller\\NoteController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllNotesFromRepositoryAndAssignsThemToView()
	{

		$allNotes = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$noteRepository = $this->getMock('DanLundgren\\DlIponlyestate\\Domain\\Repository\\NoteRepository', array('findAll'), array(), '', FALSE);
		$noteRepository->expects($this->once())->method('findAll')->will($this->returnValue($allNotes));
		$this->inject($this->subject, 'noteRepository', $noteRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('notes', $allNotes);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenNoteToView()
	{
		$note = new \DanLundgren\DlIponlyestate\Domain\Model\Note();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('note', $note);

		$this->subject->showAction($note);
	}
}
