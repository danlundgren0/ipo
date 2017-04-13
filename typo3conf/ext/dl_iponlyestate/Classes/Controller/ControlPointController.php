<?php
namespace DanLundgren\DlIponlyestate\Controller;

use DanLundgren\DlIponlyestate\Utility\ReportUtility as ReportUtil;
use DanLundgren\DlIponlyestate\Utility\ErrorUtility as ErrorUtil;
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
 * ControlPointController
 */
class ControlPointController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * noteRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\NoteRepository
     * @inject
     */
    protected $noteRepository = NULL;
    
    /**
     * estateRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\EstateRepository
     * @inject
     */
    protected $estateRepository = NULL;
    
    /**
     * controlPointRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\ControlPointRepository
     * @inject
     */
    protected $controlPointRepository = NULL;
    
    /**
     * reportRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository
     * @inject
     */
    protected $reportRepository = NULL;
    
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $cpId = (int) $this->settings['ControlPoint'];
        $estateId = (int) $this->settings['Estate'];
        //$reportPid = (int) $this->settings['ReportPidListView'];
        $reportPid = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dliponlyestate.']['persistence.']['reportPid'];
        $errorCode = '';
        if ($estateId <= 0) {
            $errorCode = 'noEstate';
            $this->view->assign('errorCode', $errorCode);
            return;
        }
        if ($cpId <= 0) {
            $errorCode = 'noControlPoint';
            $this->view->assign('errorCode', $errorCode);
            return;
        }
        if ($reportPid <= 0) {
            $errorCode = 'noReportPid';
            $this->view->assign('errorCode', $errorCode);
            return;
        }
        $estate = $this->estateRepository->findByUid((int) $estateId);
        $controlPoints = $estate->getControlPoints();
        $this->view->assign('estate', $estate);
        $this->view->assign('reportPid', $reportPid);
        if ($this && $this->estateRepository) {
            
        }
        $curReportWithVersion = ReportUtil::getLatestOrNewReport($reportPid, $estate);
        if ($curReportWithVersion && $curReportWithVersion->getStartDate() !== null) {
            $postedReports = ReportUtil::getPostedReports($reportPid, $estate, $curReportWithVersion->getStartDate());
        }
        if (!$GLOBALS['TSFE']->fe_user->user['first_name'] || $GLOBALS['TSFE']->fe_user->user['last_name']) {
            $this->view->assign('technician', $GLOBALS['TSFE']->fe_user->user['name']);
        } else {
            $this->view->assign('technician', $GLOBALS['TSFE']->fe_user->user['first_name'] . ' ' . $GLOBALS['TSFE']->fe_user->user['last_name']);
        }
        $this->view->assign('reportWithVersion', $curReportWithVersion);
        $this->view->assign('postedReports', $postedReports);
        $this->view->assign('reportPid', $reportPid);
    }
    
    /**
     * action show
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint $controlPoint
     * @return void
     */
    public function showAction(\DanLundgren\DlIponlyestate\Domain\Model\Note $note = NULL)
    {
        $arguments = $this->request->getArguments();

        if ($note !== NULL) {
            $this->noteRepository->update($note);
            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
                array(
                    'class' => __CLASS__,
                    'function' => __FUNCTION__,
                    'note' => $note
                )
            );
            $this->addFlashMessage('Your new Example was created.');
        }
        $rootLine1Uid = $GLOBALS['TSFE']->rootLine['1'][uid];
        $cpId = (int) $this->settings['ControlPoint'];
        $estateId = (int) $this->settings['Estate'];
        //$reportPid = (int) $this->settings['ReportPid'];
        $reportPid = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dliponlyestate.']['persistence.']['reportPid'];
        $errorCode = '';
        if ($estateId <= 0) {
            $errorCode = 'noEstate';
            $this->view->assign('errorCode', $errorCode);
            return;
        }
        if ($cpId <= 0) {
            $errorCode = 'noControlPoint';
            $this->view->assign('errorCode', $errorCode);
            return;
        }
        if ($reportPid <= 0) {
            $errorCode = 'noReportPid';
            $this->view->assign('errorCode', $errorCode);
            return;
        }
        $errorMess = '';
        $controlPoint = $this->controlPointRepository->findByUid((int) $this->settings['ControlPoint']);
        $estate = $this->estateRepository->findByUid((int) $estateId);
        //TODO: Om rapportens getIsCompleted = FALSE: returnera samma versionsnr, Om TRUE: Returnera versionnr+1
        $curReportWithVersion = ReportUtil::getLatestOrNewReport($reportPid, $estate);
        if ($curReportWithVersion && $curReportWithVersion->getStartDate() !== null) {
            $postedReports = ReportUtil::getPostedReports($reportPid, $estate, $curReportWithVersion->getStartDate());
        }
        /*
        if (count($unPostedReports) > 1) {
            $errorMess = 'You have ' . $noOfUnPostedReports . ' unposted reports. Only one is valid.';
        } else {
            if (count($report) == 0) {
                $report = ReportUtil::getNextVersionNumber($reports);
            }
        }
        */


        $questionUidsWithNotes = array();
        $questionUidsWithMeasurements = array();        
        foreach($controlPoint->getQuestions() as $question) {
            foreach($curReportWithVersion->getNotes() as $note) {
                if(!in_array($note->getQuestion()->getUid(), $questionUidsWithNotes)) {
                    $questionUidsWithNotes[] = $note->getQuestion()->getUid();
                }
                if($note->getControlPoint()->getUid() == $controlPoint->getUid() && $note->getQuestion()->getUid() == $question->getUid()) {

                }
            }
            foreach($curReportWithVersion->getReportedMeasurement() as $reportedMeasurement) {
                if(!in_array($reportedMeasurement->getQuestion()->getUid(), $questionUidsWithMeasurements)) {
                    $questionUidsWithMeasurements[] = $reportedMeasurement->getQuestion()->getUid();
                }
                if($note->getControlPoint()->getUid() == $controlPoint->getUid() && $note->getQuestion()->getUid() == $question->getUid()) {

                }
            }
        }
        $reportArr = array();
        $loopNo = 0;
        foreach($controlPoint->getQuestions() as $question) {
            if(!in_array($question->getUid(), $questionUidsWithNotes) && !in_array($question->getUid(), $questionUidsWithMeasurements)) {
                $reportArr[$question->getUid()] = '';
            }
            elseif(in_array($question->getUid(), $questionUidsWithNotes)) {
                foreach($curReportWithVersion->getNotes() as $note) {
                    if($note->getControlPoint()->getUid() == $controlPoint->getUid() && $note->getQuestion()->getUid() == $question->getUid()) {
                        $reportArr[$question->getUid()] = $note;
                    }
                }
            }
            elseif(in_array($question->getUid(), $questionUidsWithMeasurements)) {
                foreach($curReportWithVersion->getReportedMeasurement() as $reportedMeasurement) {
                    if($reportedMeasurement->getControlPoint()->getUid() == $controlPoint->getUid() && $reportedMeasurement->getQuestion()->getUid() == $question->getUid()) {
                        $reportArr[$question->getUid()] = $reportedMeasurement;
                    }
                }
            }
            $loopNo+=1;
        }
        //$unPostedReport = $unPostedReports[count($unPostedReports) - 1];
        $tmpNote = new \DanLundgren\DlIponlyestate\Domain\Model\Note();
        $this->view->assign('tmpNote', $tmpNote);
        $this->view->assign('reportArr', $reportArr);
        $this->view->assign('rootLine1Uid', $rootLine1Uid);
        $this->view->assign('reportWithVersion', $curReportWithVersion);
        $this->view->assign('unPostedReport', $unPostedReport);
        $this->view->assign('postedReports', $postedReports);
        $this->view->assign('errorMess', $errorMess);
        $this->view->assign('controlPoint', $controlPoint);
        $this->view->assign('reportPid', $reportPid);
    }
    
    /**
     * @param $argumentName
     */
    protected function setTypeConverterConfigurationForImageUpload($argumentName)
    {
        $uploadConfiguration = array(
            UploadedFileReferenceConverter::CONFIGURATION_ALLOWED_FILE_EXTENSIONS => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
            UploadedFileReferenceConverter::CONFIGURATION_UPLOAD_FOLDER => '1:/content/'
        );
        /** @var PropertyMappingConfiguration $newExampleConfiguration */
        $newExampleConfiguration = $this->arguments[$argumentName]->getPropertyMappingConfiguration();
        $newExampleConfiguration->forProperty('images')->setTypeConverterOptions('DanLundgren\\DlIponlyestate\\Property\\TypeConverter\\UploadedFileReferenceConverter', $uploadConfiguration);
    }
    
    /**
     * Set TypeConverter option for image upload
     */
    public function initializeUploadAction()
    {
        $this->setTypeConverterConfigurationForImageUpload('note');
    }
    
    /**
     * action upload
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Note $note
     * @return void
     */
    public function uploadAction(\DanLundgren\DlIponlyestate\Domain\Model\Note $note)
    {
        $this->noteRepository->update($note);
        $this->addFlashMessage('Your new Example was created.');
        $this->redirect('show');
    }

}