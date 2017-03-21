<?php
namespace DanLundgren\DlIponlyestate\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Dan Lundgren <danlundgren0@gmail.com>, Dan Lundgren
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * AjaxRequestController
 */
class AjaxRequestController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
    /**
     * estateRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\EstateRepository
     * @inject
     */
    protected $estateRepository = NULL;

    /**
     * noteRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\NoteRepository
     * @inject
     */
    protected $noteRepository = NULL;

    /**
     * reportRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository
     * @inject
     */
    protected $reportRepository = NULL;

    /**
     * questionRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\QuestionRepository
     * @inject
     */
    protected $questionRepository = NULL;

    /**
     * controlPointRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\ControlPointRepository
     * @inject
     */
    protected $controlPointRepository = NULL;

    /**
     * persistence manager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface
     * @inject
     */
    protected $persistenceManager = NULL;

	/**
	 * command
	 *
	 * @var string
	 */
	protected $command = NULL;

	/**
	 * arguments
	 *
	 * @var array
	 */
	protected $arguments = NULL;

	/**
	 * status
	 *
	 * @var bool
	 */
	protected $status = FALSE;

	/**
	 * message
	 *
	 * @var string
	 */
	protected $message = '';

	/**
	 * data
	 *
	 * @var array
	 */
	protected $data = FALSE;

	/**
	 * asJson
	 *
	 * @var boolean
	 */
	protected $asJson = TRUE;


	/**
	 * fileCollectionRepository
	 *
	 * @var \TYPO3\CMS\Core\Resource\FileCollectionRepository
	 */
	protected $fileCollectionRepository;
	/**
	 * Generic Ajax action
	 * Calls method named in parameter command, which then can use the arguments in parameter arguments.
	 *
	 * @return json
	 */
	public function getJsonAction() {

		$this->command = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('command');
		$this->arguments = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('arguments');

		if ( method_exists( $this, $this->command ) ) {
			$this->{$this->command}();
		} else {
			$this->message = 'Call to non-existing function (' . $this->command . ')';
		}
	    return ($this->asJson) ? $this->generateJsonReturnArray() : $this->data;
				//return $this->generateJsonReturnArray();
	}
	/**
	 * generateJsonReturnArray
	 * Used to return result in a predefined way to calling javascript
	 *
	 * @return json
	 */
	private function generateJsonReturnArray() {
		return json_encode(array (
				'status' => $this->status,
				'data' => $this->data,
				'message' => $this->message,
		));
	}
	public function getNewNoteTmpl() {
		//$ver = (int)$this->arguments['ver']+1;
		$layoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Layouts');
		$partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Partials');
		$templatePathAndFilename = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Partials/ControlPoint/Note.html');
		$extensionName = $this->request->getControllerExtensionName();
		$ajaxRenderHtmlView = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
		$ajaxRenderHtmlView->setLayoutRootPath($layoutRootPath);
		$ajaxRenderHtmlView->setPartialRootPath($partialRootPath);
		$ajaxRenderHtmlView->setTemplatePathAndFilename($templatePathAndFilename);
		$ajaxRenderHtmlView->getRequest()->setControllerExtensionName($extensionName);
		$this->data['response'] = $ajaxRenderHtmlView->render();
		$this->status = TRUE;
		$this->message = '';
	}
	public function saveNote() {
		//TODO: Come up with good versioning handling
		$cpUid = (int)$this->arguments['cpUid'];
		$questUid = (int)$this->arguments['questUid'];
		$noteUid = (int)$this->arguments['noteUid'];
		$curVer = (int)$this->arguments['ver'];
		$noteText = $this->arguments['noteText'];
		$noteState = $this->arguments['noteState'];
		$reportUid = $this->arguments['reportUid'];
		$nodeTypeUid = $this->arguments['nodeTypeUid'];
		$reportIsNew = NULL;
		//$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		//$controlPointRepository = $this->objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ControlPointRepository');
		//$questionRepository = $this->objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\QuestionRepository');
		$controlPoint = $this->controlPointRepository->findByUid($this->arguments['cpUid']);
		$question = $this->questionRepository->findByUid($this->arguments['questUid']);
		$questions = $controlPoint->getQuestions();

		$this->data['cpUid'] = $cpUid;
		$this->data['questUid'] = $questUid;
		$this->data['noteUid'] = $noteUid;
		$this->data['curVer'] = $curVer;
		$this->data['noteText'] = $noteText;
		$this->data['noteState'] = $noteState;
		$this->data['reportUid'] = $reportUid;
		$this->data['nodeTypeUid'] = $nodeTypeUid;

		if($reportUid>0) {
			$report = $this->reportRepository->findByUid($reportUid);
			$reportIsNew = FALSE;			
		}		
		if(!$report || count($report)<=0) {
			//$reportRepository = $this->objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository');
			$report = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DanLundgren\DlIponlyestate\Domain\Model\Report');
			$report->setVersion(1);
			$reportIsNew = TRUE;
			//$this->data['reportUID'] = $report->getUid();
		}


		//TODO: Set real Version not hardcoded
		
		//$report->setQuestionId($questUid);
		$datetime = new \DateTime();
		$datetime->format('Y-m-d H:i:s');
		$report->setDate($datetime);
		$report->setName($datetime->format('Y-m-d H:i').' Nr: '.$report->getVersion());
		//TODO: Add Estate id to report to know which site it belongs to

		
		$estateId = (int)$GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dliponlyestate.']['persistence.']['estateId'];		
		$estate = $this->estateRepository->findByUid($estateId);
		$report->setEstate($estateId);
		$report->setControlPoint($cpUid);
		$report->setNodeType($nodeTypeUid);
		$report->setResponsibleTechnicians($controlPoint->getResponsibleTechnician());
		$report->setResponsibleTechnicians($controlPoint->getResponsibleTechnician());
		
		$reportPid = (int)$GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dliponlyestate.']['persistence.']['reportPid'];
		$report->setPid($reportPid);
		//Add IsComplete also as property in note to make it easer to check
		//$report->setIsComplete(0);
		//$report->setTechnician($GLOBALS['TSFE']->fe_user->user['first_name'].' '.$GLOBALS['TSFE']->fe_user->user['last_name']);
		$report->setExecutiveTechnician($GLOBALS['TSFE']->fe_user->user['uid']);
		
		$note = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DanLundgren\DlIponlyestate\Domain\Model\Note');
		$newVerNo = -2;
		foreach($report->getNotes() as $prevNote) {
			if($prevNote->getVersion()>(int)$tmpVerNo && $prevNote->getQuestion()==$questUid) {
				$newVerNo = $prevNote->getVersion();
			}
		}
		$note->setVersion($newVerNo+=1);
		$note->setRemarkType($noteState);
		$note->setComment($noteText);
		$note->setState($noteState);
		if($note->getState()=='ok') {
			$note->setIsComplete(1);
		}

		$note->setQuestion($questUid);
		//TODO: Same PID as report
		$note->setPid($reportPid);
		if($noteUid == '-1') {
			$report->addNote($note);
			$note->setVersion(1);	
			$this->data['statusMessage'] = $this->data['statusMessage'].' Ny anmärkning skapad ';
		}
		else {
			$report->update($note);
			$this->data['statusMessage'] = $this->data['statusMessage'].' Anmärkning sparad ';
			//$note->setVersion($newVerNo+=1);	
		}		
		if(reportIsNew) {
			$this->reportRepository->add($report);	
			$this->data['statusMessage'] = $this->data['statusMessage'].' Ny rapport skapad';
		}
		else {
			$this->reportRepository->update($report);	
			$this->data['statusMessage'] = $this->data['statusMessage'].' Rapport sparad';
		}
		//$this->reportRepository->add($report);
		//$this->reportRepository->update($report);
		//$this->reportRepository->update($report);
		//$this->persistenceManager->persistAll();
		//$question->addReport($report);		
		$this->data['comment'] = $note->getComment();
		$this->data['note'] = $note->getState();
		$this->status = TRUE;
		$this->message = '';
		

		//$booking->addPayment($payment);
		//$this->bookingRepository->update($booking);
		//$this->persistenceManager->persistAll();

	}
}