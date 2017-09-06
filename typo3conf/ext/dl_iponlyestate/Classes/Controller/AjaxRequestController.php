<?php
namespace DanLundgren\DlIponlyestate\Controller;
use DanLundgren\DlIponlyestate\Utility\ReportUtility as ReportUtility;
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
     * nodeTypeRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\NodeTypeRepository
     * @inject
     */
    protected $nodeTypeRepository = NULL;

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
	public function createNewReport() {
		$version = $this->arguments['version'];
		$estateUid = $this->arguments['estateUid'];
		$this->data['version'] = $version;
		$this->data['estateUid'] = $estateUid;
		if((int)$version>0 && (int)$estateUid>0) {			
			$newReport = ReportUtility::createNewReport($version, $estateUid, null, true);
			$this->data['response'] = $newReport->getUid();
			$this->status = TRUE;
			$this->message = '';
		}
	}
	public function getCompleteReport() {		
		$reportUid = $this->arguments['reportUid'];
		$estateUid = $this->arguments['estateUid'];
		$completePdfPid = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dliponlyestate_pdf.']['persistence.']['completePdfPid'];
		if((int)$reportUid>0 && (int)$estateUid>0) {			
			$clickedReport = $this->reportRepository->findByUid((int)$reportUid);
			$estate = $this->estateRepository->findByUid((int)$estateUid);
			$reports = $this->reportRepository->findByEstate($estate);			
			$completeReportArr = ReportUtility::getCompleteReport($clickedReport, $estate, $reports, TRUE);
		}
		if($completeReportArr) {
			$layoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Layouts');
			$partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Partials');
			$templatePathAndFilename = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Partials/Report/GenericModalReport.html');
			$extensionName = $this->request->getControllerExtensionName();
			$ajaxRenderHtmlView = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
			$ajaxRenderHtmlView->setLayoutRootPath($layoutRootPath);
			$ajaxRenderHtmlView->setPartialRootPath($partialRootPath);
			$ajaxRenderHtmlView->setTemplatePathAndFilename($templatePathAndFilename);
			$ajaxRenderHtmlView->getRequest()->setControllerExtensionName($extensionName);
			$ajaxRenderHtmlView->assign('report', $completeReportArr);
			$ajaxRenderHtmlView->assign('completePdfPid', $completePdfPid);
			$this->data['report'] = 'getCompleteReport';
			$this->data['response'] = $ajaxRenderHtmlView->render();
			$this->status = TRUE;
			$this->message = '';
		}
	}

	public function getCriticalReport() {
		$reportUid = $this->arguments['reportUid'];
		$estateUid = $this->arguments['estateUid'];
		$criticalPdfPid = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dliponlyestate_pdf.']['persistence.']['criticalPdfPid'];
		if((int)$reportUid>0 && (int)$estateUid>0) {			
			$clickedReport = $this->reportRepository->findByUid((int)$reportUid);
			$estate = $this->estateRepository->findByUid((int)$estateUid);
			$reports = $this->reportRepository->findByEstate($estate);
			$completeReportArr = ReportUtility::getAllReportsWithRemarks($clickedReport, $estate, $reports);
		}
		if($completeReportArr) {
			$layoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Layouts');
			$partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Partials');
			$templatePathAndFilename = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Partials/Report/CriticalModalReport.html');
			$extensionName = $this->request->getControllerExtensionName();
			$ajaxRenderHtmlView = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
			$ajaxRenderHtmlView->setLayoutRootPath($layoutRootPath);
			$ajaxRenderHtmlView->setPartialRootPath($partialRootPath);
			$ajaxRenderHtmlView->setTemplatePathAndFilename($templatePathAndFilename);
			$ajaxRenderHtmlView->getRequest()->setControllerExtensionName($extensionName);
			$ajaxRenderHtmlView->assign('report', $completeReportArr);
			$ajaxRenderHtmlView->assign('criticalPdfPid', $criticalPdfPid);
			$this->data['report'] = 'CriticalReport';
			$this->data['response'] = $ajaxRenderHtmlView->render();
			$this->status = TRUE;
			$this->message = '';
		}
	}

	public function getRemarkReport() {
		$reportUid = $this->arguments['reportUid'];
		$estateUid = $this->arguments['estateUid'];
		$remarksPdfPid = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dliponlyestate_pdf.']['persistence.']['remarksPdfPid'];
		if((int)$reportUid>0 && (int)$estateUid>0) {			
			$clickedReport = $this->reportRepository->findByUid((int)$reportUid);
			$estate = $this->estateRepository->findByUid((int)$estateUid);
			$reports = $this->reportRepository->findByEstate($estate);
			$completeReportArr = ReportUtility::getAllReportsWithRemarks($clickedReport, $estate, $reports);
		}
		if($completeReportArr) {
			$layoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Layouts');
			$partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Partials');
			$templatePathAndFilename = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Partials/Report/RemarkModalReport.html');
			$extensionName = $this->request->getControllerExtensionName();
			$ajaxRenderHtmlView = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
			$ajaxRenderHtmlView->setLayoutRootPath($layoutRootPath);
			$ajaxRenderHtmlView->setPartialRootPath($partialRootPath);
			$ajaxRenderHtmlView->setTemplatePathAndFilename($templatePathAndFilename);
			$ajaxRenderHtmlView->getRequest()->setControllerExtensionName($extensionName);
			$ajaxRenderHtmlView->assign('report', $completeReportArr);
			$ajaxRenderHtmlView->assign('remarksPdfPid', $remarksPdfPid);
			$this->data['report'] = 'RemarkReport';
			$this->data['response'] = $ajaxRenderHtmlView->render();
			$this->status = TRUE;
			$this->message = '';
		}
	}

	public function getPurchaseReport() {
		$reportUid = $this->arguments['reportUid'];
		$estateUid = $this->arguments['estateUid'];
		$purchasePdfPid = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dliponlyestate_pdf.']['persistence.']['purchasePdfPid'];
		if((int)$reportUid>0 && (int)$estateUid>0) {			
			$clickedReport = $this->reportRepository->findByUid((int)$reportUid);
			$estate = $this->estateRepository->findByUid((int)$estateUid);
			$reports = $this->reportRepository->findByEstate($estate);
			$completeReportArr = ReportUtility::getAllReportsWithRemarks($clickedReport, $estate, $reports);
		}
		if($completeReportArr) {
			$layoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Layouts');
			$partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Partials');
			$templatePathAndFilename = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Partials/Report/PurchaseModalReport.html');
			$extensionName = $this->request->getControllerExtensionName();
			$ajaxRenderHtmlView = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
			$ajaxRenderHtmlView->setLayoutRootPath($layoutRootPath);
			$ajaxRenderHtmlView->setPartialRootPath($partialRootPath);
			$ajaxRenderHtmlView->setTemplatePathAndFilename($templatePathAndFilename);
			$ajaxRenderHtmlView->getRequest()->setControllerExtensionName($extensionName);
			$ajaxRenderHtmlView->assign('report', $completeReportArr);
			$ajaxRenderHtmlView->assign('purchasePdfPid', $purchasePdfPid);
			$this->data['report'] = 'PurchaseReport';
			$this->data['response'] = $ajaxRenderHtmlView->render();
			$this->status = TRUE;
			$this->message = '';
		}
	}

	public function getAllCompletedRemarksReport() {
		$reportUid = $this->arguments['reportUid'];
		$estateUid = $this->arguments['estateUid'];
		$oldRemarksPdfPid = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dliponlyestate_pdf.']['persistence.']['oldRemarksPdfPid'];
		if((int)$reportUid>0 && (int)$estateUid>0) {			
			$clickedReport = $this->reportRepository->findByUid((int)$reportUid);
			$estate = $this->estateRepository->findByUid((int)$estateUid);
			//$reports = $this->reportRepository->findByEstate($estate);
			$completeReportArr = ReportUtility::getAllCompletedRemarksReport($clickedReport, $estate);
			//$completeReportArr = ReportUtility::getAllReportsWithRemarks($clickedReport, $estate);
		}
		if($completeReportArr) {
			$layoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Layouts');
			$partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Partials');
			$templatePathAndFilename = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Partials/Report/CompletedRemarksModalReport.html');
			$extensionName = $this->request->getControllerExtensionName();
			$ajaxRenderHtmlView = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
			$ajaxRenderHtmlView->setLayoutRootPath($layoutRootPath);
			$ajaxRenderHtmlView->setPartialRootPath($partialRootPath);
			$ajaxRenderHtmlView->setTemplatePathAndFilename($templatePathAndFilename);
			$ajaxRenderHtmlView->getRequest()->setControllerExtensionName($extensionName);
			$ajaxRenderHtmlView->assign('report', $completeReportArr);
			$ajaxRenderHtmlView->assign('oldRemarksPdfPid', $oldRemarksPdfPid);
			$this->data['report'] = 'getAllCompletedRemarksReport';
			$this->data['response'] = $ajaxRenderHtmlView->render();
			$this->status = TRUE;
			$this->message = '';
		}
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
	public function saveMessages() {
		$purchase = $this->arguments['purchase'];
		$message = $this->arguments['message'];
		$reportUid = (int)$this->arguments['reportUid'];
		$report = \DanLundgren\DlIponlyestate\Utility\ReportUtility::updateReportWithMessages($reportUid, $message, $purchase);
		foreach($report->getPurchase() as $purchase) {
			$this->data['purchase'][] = self::getHtmlView('EXT:dl_iponlyestate/Resources/Private/Partials/Messages/Purchases.html', $purchase);
		}
		foreach($report->getMessage() as $message) {
			$this->data['message'][] = self::getHtmlView('EXT:dl_iponlyestate/Resources/Private/Partials/Messages/Messages.html', $message);
		}
		$this->data['reportUid'] = $reportUid;

	}

	public function getHtmlView($partialPath, $data) {
		//$ver = (int)$this->arguments['ver']+1;
		$layoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Layouts');
		$partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dl_iponlyestate/Resources/Private/Partials');
		$templatePathAndFilename = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($partialPath);
		$extensionName = $this->request->getControllerExtensionName();
		$ajaxRenderHtmlView = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
		$ajaxRenderHtmlView->setLayoutRootPath($layoutRootPath);
		$ajaxRenderHtmlView->setPartialRootPath($partialRootPath);
		$ajaxRenderHtmlView->setTemplatePathAndFilename($templatePathAndFilename);
		$ajaxRenderHtmlView->getRequest()->setControllerExtensionName($extensionName);
		$ajaxRenderHtmlView->assign('data', $data);
		return $ajaxRenderHtmlView->render();
	}
	public function saveReport() {
		$reportUid = $this->arguments['reportUid'];
		$report = \DanLundgren\DlIponlyestate\Utility\ReportUtility::saveReport($reportUid);
		$this->data['message'] = ($report->getReportIsPosted())?'Rapporten är inskickad':'Ett fel uppstod. Rapporten sparades ej.'; 
		$this->data['isPosted'] =  $report->getReportIsPosted();
		$this->data['datetime'] =  $report->getDate($datetime);
	}
	public function saveNoteFixed() {
		$noteUids = json_decode($this->arguments['noteUids']);
		$success = \DanLundgren\DlIponlyestate\Utility\ReportUtility::saveNoteFixed($noteUids);
		$this->data['noteUids'] = $noteUids;
	}
	public function saveMeasureValue() {
		$pid = (int)$this->arguments['pid'];
		$estateUid = (int)$this->arguments['estateUid'];
		$cpUid = (int)$this->arguments['cpUid'];
		$questUid = (int)$this->arguments['questUid'];
		$measureUid = (int)$this->arguments['measureUid'];
		$curVer = (int)$this->arguments['ver'];
		$reportUid = $this->arguments['reportUid'];
		$nodeTypeUid = $this->arguments['nodeTypeUid'];
		$reportPid = $this->arguments['reportPid'];

		$measureValue = $this->arguments['measureValue'];
		$measureName = $this->arguments['measureName'];
		$measureUnit = $this->arguments['measureUnit'];

		$reportIsNew = NULL;
		$controlPoint = $this->controlPointRepository->findByUid($cpUid);
		$question = $this->questionRepository->findByUid($questUid);
		$questions = $controlPoint->getQuestions();
		$datetime = new \DateTime();
		$datetime->format('Y-m-d H:i:s');

		$estate = $this->estateRepository->findByUid($estateUid);
		$responsibleTechnician = $estate->getResponsibleTechnician();
		if(!$reportUid) {
			$report = \DanLundgren\DlIponlyestate\Utility\ReportUtility::getLatestOrNewReport($reportPid, $estate, true);
			$reportUid = $report->getUid();
		}
		if((int)$reportUid>0) {
			$report = \DanLundgren\DlIponlyestate\Utility\ReportUtility::setReportProperties($estateUid, $datetime, $reportUid, $cpUid, $nodeTypeUid, $responsibleTechnician);	
			$measure = \DanLundgren\DlIponlyestate\Utility\ReportUtility::saveMeasurement($report, $cpUid, $questUid, $measureUid, $measureValue, $measureName, $measureUnit, $pid);	
			//$this->data['comment'] = $measure->getComment();
			//$this->data['note'] = $note->getState();	
		}
		else {
			$this->data['error'] = 'No reportuid';	
		}

		$this->data['estateUid'] = $estateUid;
		$this->data['cpUid'] = $cpUid;
		$this->data['questUid'] = $questUid;
		$this->data['noteUid'] = $measure->getUid();
		$this->data['curVer'] = $measure->getVersion();
		$this->data['noteText'] = $noteText;
		$this->data['reportUid'] = $reportUid;
		$this->data['nodeTypeUid'] = $nodeTypeUid;
		$this->data['reportPid'] = $reportPid;

		$this->data['measureValue'] = $measureValue;
		$this->data['measureName'] = $measureName;
		$this->data['measureUnit'] = $measureUnit;

		$this->status = TRUE;
		$this->message = '';
	}
	public function saveNote() {
		//TODO: Come up with good versioning handling
		$pid = (int)$this->arguments['pid'];
		$estateUid = (int)$this->arguments['estateUid'];
		$cpUid = (int)$this->arguments['cpUid'];
		$questUid = (int)$this->arguments['questUid'];
		$noteUid = (int)$this->arguments['noteUid'];
		$curVer = (int)$this->arguments['ver'];		
		$noteText = $this->arguments['noteText'];
		$noteState = (int)$this->arguments['noteState'];
		$reportUid = $this->arguments['reportUid'];
		$nodeTypeUid = $this->arguments['nodeTypeUid'];
		$reportPid = $this->arguments['reportPid'];		
		$reportIsNew = NULL;
		$controlPoint = $this->controlPointRepository->findByUid($cpUid);
		$question = $this->questionRepository->findByUid($questUid);
		$noteText = ($noteState==1)?$question->getHeader().' - OK':$noteText;
		$questions = $controlPoint->getQuestions();
		$datetime = new \DateTime();
		$datetime->format('Y-m-d H:i:s');

		$estate = $this->estateRepository->findByUid($estateUid);
		$responsibleTechnician = $estate->getResponsibleTechnician();
		if(!$reportUid) {
			$report = \DanLundgren\DlIponlyestate\Utility\ReportUtility::getLatestOrNewReport($reportPid, $estate, true);
			$reportUid = $report->getUid();
		}
		if((int)$reportUid>0) {
			$report = \DanLundgren\DlIponlyestate\Utility\ReportUtility::setReportProperties($estateUid, $datetime, $reportUid, $cpUid, $nodeTypeUid, $responsibleTechnician);	
			$note = \DanLundgren\DlIponlyestate\Utility\ReportUtility::saveNote($report, $cpUid, $questUid, $noteUid, $noteText, $noteState, $curVer, $pid);	
			$this->data['comment'] = $note->getComment();
			$this->data['note'] = $note->getState();	
		}
		else {
			$this->data['error'] = 'No reportuid';	
		}
		$this->data['estateUid'] = $estateUid;
		$this->data['cpUid'] = $cpUid;
		$this->data['questUid'] = $questUid;
		$this->data['noteUid'] = $note->getUid();
		$this->data['curVer'] = $note->getVersion();
		$this->data['noteText'] = $noteText;
		$this->data['noteText'] = $noteText;
		$this->data['noteState'] = $noteState;
		$this->data['reportUid'] = $reportUid;
		$this->data['nodeTypeUid'] = $nodeTypeUid;
		$this->data['reportPid'] = $reportPid;
		$this->status = TRUE;
		$this->message = '';
	}
	public function getEstateSearchSettings() {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $technicianRepository = $objectManager->get('TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository');
		$estateUid = (int)$this->arguments['estateUid'];
		$searchArr = array();
		$notes = array('0'=>'Alla');
		$cities = array();
		$nodeTypes = array();
		$technicians = array();
		$techUids = array();
		if(!$estateUid) {
			$estates = $this->estateRepository->findAll();	
		}
		else {
			$estate = $this->estateRepository->findByUid((int)$estateUid);
		}
		$reports = $this->reportRepository->findAll();		
		foreach($reports as $report) {
			if($estates) {
				foreach($estates as $estate) {
					$cities[$estate->getCity()] = $estate->getCity();
					$nodeTypes[$estate->getNodeType()->getUid()]['uid'] = $estate->getNodeType()->getUid();
					$nodeTypes[$estate->getNodeType()->getUid()]['name'] = $estate->getNodeType()->getName();
					if($report->getEstate()->getUid() == $estate->getUid()) {
						if($report->getExecutiveTechnician() && !in_array($report->getExecutiveTechnician(), $techUids)) {
							$techUids[] = $report->getExecutiveTechnician();
							$technician = $technicianRepository->findByUid((int)$report->getExecutiveTechnician());
							$technicians[$report->getExecutiveTechnician()]['uid'] = $technician->getUid();
							$technicians[$report->getExecutiveTechnician()]['comment'] = $technician->getName();
						}
						if ($report->getResponsibleTechnicians() && !in_array($report->getResponsibleTechnicians(), $techUids)) {
							$techUids[] = $report->getResponsibleTechnicians();
							$technician = $technicianRepository->findByUid((int)$report->getResponsibleTechnicians());
							$technicians[$report->getResponsibleTechnicians()]['uid'] = $technician->getUid();
							$technicians[$report->getResponsibleTechnicians()]['comment'] = $technician->getName();
						}
						if($report->getEstate()->getUid() == (int)$estateUid) {
							foreach($report->getNotes() as $note) {
								if(!array_key_exists($note->getState(), $notes)) {
									switch($note->getState()) {
										case 1:
											$notes[$note->getState()] = 'Ok';
											break;
										case 2:
											$notes[$note->getState()] = 'Kritiska';
											break;
										case 3:
											$notes[$note->getState()] = 'Anmärkningar';
											break;
										case 4:
											$notes[$note->getState()] = 'Inköp/Meddelanden';
											break;
										default:
									}
								}
								//$notes[$note->getUid()]['uid'] = $note->getUid();
								//$notes[$note->getUid()]['comment'] = $note->getComment();
							}				
						}
					}
				}				
			}
			else {
				$cities[$estate->getCity()] = $estate->getCity();
				//$nodeTypes[$estate->getNodeType()->getUid()]['uid'] = $estate->getNodeType()->getUid();
				$nodeTypes[$estate->getNodeType()->getUid()] = $estate->getNodeType()->getName();
				if($report->getEstate()->getUid() == $estate->getUid()) {
					if($report->getExecutiveTechnician() && !in_array($report->getExecutiveTechnician(), $techUids)) {
						$techUids[] = $report->getExecutiveTechnician();
						$technician = $technicianRepository->findByUid((int)$report->getExecutiveTechnician());
						$technicians[$technician->getUid()] = $technician->getName();
					}
					if ($report->getResponsibleTechnicians() && !in_array($report->getResponsibleTechnicians(), $techUids)) {
						$techUids[] = $report->getResponsibleTechnicians();
						$technician = $technicianRepository->findByUid((int)$report->getResponsibleTechnicians());
						$technicians[$technician->getUid()] = $technician->getName();
					}
					if($report->getEstate()->getUid() == (int)$estateUid) {
						foreach($report->getNotes() as $note) {
							if(!array_key_exists($note->getState(), $notes)) {
								switch($note->getState()) {
									case 1:
										$notes[$note->getState()] = 'Ok';
										break;
									case 2:
										$notes[$note->getState()] = 'Kritiska';
										break;
									case 3:
										$notes[$note->getState()] = 'Anmärkningar';
										break;
									case 4:
										$notes[$note->getState()] = 'Inköp/Meddelanden';
										break;
									default:
								}
							}
							//$notes[$note->getUid()] = $note->getComment();
						}				
					}
				}
			}
		}
		//$this->data['notes'] = array_merge(array('0' => 'Alla'), $notes);
		$this->data['notes'] = $notes;
		/*$this->data['cities'] = $estate->getCity();		
		$this->data['nodetype']['uid'] = $estate->getNodeType()->getUid();	
		$this->data['nodetype']['name'] = $estate->getNodeType()->getName();*/
		$this->data['technicians'] = array_merge(array('0' => 'Alla'), $technicians);
		$this->data['nodetype'] = $nodeTypes;
		$this->data['cities'] = $cities;
		//nodeTypeRepository
	}
}
