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
     * questionRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\QuestionRepository
     * @inject
     */
    protected $questionRepository = NULL;

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
        $scannedCPs = json_decode($_COOKIE['scanned_cps'], true);
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
        $subPages = $this->controlPointRepository->findSubPagesByParentPid($GLOBALS['TSFE']->id);
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
        $this->view->assign('subPages', $subPages);
        //$this->view->assign('pid', $GLOBALS['TSFE']->id);
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
        if(count($arguments)>0) {
            //Action,Controller,ExtensionName, arguments
            $note = $this->saveNote($arguments, $estate);
            $this->uploadAction($arguments, $note, $estate);
        }
        $fromCookieCPs = json_decode($_COOKIE['scanned_cps'], true);
        if (!isset($_COOKIE['scanned_cps'])) {
            $scannedCP[] = $GLOBALS['TSFE']->id;
            $toCookieCPs = json_encode($scannedCP);
            setcookie('scanned_cps', $toCookieCPs, time() + 3600 * 12, '/');
        } elseif (!in_array($GLOBALS['TSFE']->id, $fromCookieCPs)) {
            $scannedCP[] = $GLOBALS['TSFE']->id;
            $allCps = array_merge($fromCookieCPs, $scannedCP);
            $toCookieCPs = json_encode($allCps);
            setcookie('scanned_cps', $toCookieCPs, time() + 3600 * 12, '/');
        }        
        if ($note !== NULL) {
            $this->noteRepository->update($note);
        }
        $rootLine1Uid = $GLOBALS['TSFE']->rootLine['3'][uid];
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
        foreach ($controlPoint->getQuestions() as $question) {
            foreach ($curReportWithVersion->getNotes() as $note) {
                if (!in_array($note->getQuestion()->getUid(), $questionUidsWithNotes)) {
                    $questionUidsWithNotes[] = $note->getQuestion()->getUid();
                }
                if ($note->getControlPoint()->getUid() == $controlPoint->getUid() && $note->getQuestion()->getUid() == $question->getUid()) {
                    
                }
            }
            foreach ($curReportWithVersion->getReportedMeasurement() as $reportedMeasurement) {
                if (!in_array($reportedMeasurement->getQuestion()->getUid(), $questionUidsWithMeasurements)) {
                    $questionUidsWithMeasurements[] = $reportedMeasurement->getQuestion()->getUid();
                }
            }
        }
        $reportArr = array();
        $loopNo = 0;
        foreach ($controlPoint->getQuestions() as $question) {
            if (!in_array($question->getUid(), $questionUidsWithNotes) && !in_array($question->getUid(), $questionUidsWithMeasurements)) {
                $reportArr[$question->getUid()] = '';
            } elseif (in_array($question->getUid(), $questionUidsWithNotes)) {
                foreach ($curReportWithVersion->getNotes() as $note) {
                    if ($note->getControlPoint()->getUid() == $controlPoint->getUid() && $note->getQuestion()->getUid() == $question->getUid()) {
                        $reportArr[$question->getUid()] = $note;
                    }
                }
            } elseif (in_array($question->getUid(), $questionUidsWithMeasurements)) {
                foreach ($curReportWithVersion->getReportedMeasurement() as $reportedMeasurement) {
                    if ($reportedMeasurement->getControlPoint()->getUid() == $controlPoint->getUid() && $reportedMeasurement->getQuestion()->getUid() == $question->getUid()) {
                        $reportArr[$question->getUid()] = $reportedMeasurement;
                    }
                }
            }
            $loopNo += 1;
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
        $this->view->assign('pid', $GLOBALS['TSFE']->id);
    }
	public function saveNote($arguments, &$estate=NULL) {

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $this->controlPointRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ControlPointRepository');
        $this->estateRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\EstateRepository');
        $this->questionRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\QuestionRepository');
		//TODO: Come up with good versioning handling
		$pid = (int)$arguments['pid'];
		$estateUid = (int)$arguments['estateuid'];
		$cpUid = (int)$arguments['cpuid'];
		$questUid = (int)$arguments['questionuid'];
		$noteUid = (int)$arguments['noteuid'];
		$curVer = (int)$arguments['ver'];		
		$noteText = $arguments['input-note'];
		$noteState = (int)$arguments['notestate'];
		$reportUid = (int)$arguments['reportuid'];
		$nodeTypeUid = (int)$arguments['nodetypeuid'];
		$reportPid = (int)$arguments['reportpid'];		
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
            return $note;
			//$this->data['comment'] = $note->getComment();
			//$this->data['note'] = $note->getState();	
		}
        return NULL;
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
    * Upload files.
    *
    * @return void
    */
    public function uploadAction($arguments, $note, $estate) {
        //$_FILES['tx_dliponlyestate_domain_model_note'] = $_FILES['tx_dliponlyestate_domain_model_controlpoint'];
        //unset($_FILES['tx_dliponlyestate_domain_model_controlpoint']);
        if($note === NULL) {
            return $uploadError = 'Note is NULL';
        }
        $nodeTypeFolder = $note->getControlPoint()->getNodeType()->getName();
        $estateFolder = ($estate->getName()!='')?$estate->getName():$estate->getHeader();
        //$targetFalDirectory = $this->createFolders($nodeTypeFolder, $estateFolder);
        $targetFalDirectory = '1:/user_upload/';
        $overwriteExistingFiles = TRUE;
        $data = array();
        $namespace = key($_FILES);
        /*
        if(strlen($nodeTypePath)>0 && strlen($estatePath)>0) {
            $targetFalDirectory = '1:/'.$nodeTypePath.'/'.$estatePath.'/';
        }
        else {
            $targetFalDirectory = '1:/user_upload/';
        }
        */
        // Register every upload field from the form:
        $this->registerUploadField($data, $namespace, 'image', $targetFalDirectory);

        // Initializing:
        /** @var \TYPO3\CMS\Core\Utility\File\ExtendedFileUtility $fileProcessor */
        $fileProcessor = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Utility\\File\\ExtendedFileUtility');
        $fileProcessor->init(array(), $GLOBALS['TYPO3_CONF_VARS']['BE']['fileExtensions']);
        $fileProcessor->setActionPermissions(array('addFile' => TRUE));
        $fileProcessor->dontCheckForUnique = $overwriteExistingFiles ? 1 : 0;

        // Actual upload
        $fileProcessor->start($data);
        $result = $fileProcessor->processData();

        //$result['upload']['0']['0']->properties['uid']
        $uploadError = 'OK';
        if(isset($result) && isset($result['upload']) && isset($result['upload']['0']) && isset($result['upload']['0']['0']) && count($result['upload']['0']['0']->getProperties())>0 && (int)$result['upload']['0']['0']->getProperties()['uid']>0) {
            $sysFileUid = $result['upload']['0']['0']->getProperties()['uid'];
            $noteUid = $note->getUid();
            $this->setFileReference($sysFileUid, $noteUid, $tableNames='tx_dliponlyestate_domain_model_note',$tableLocal='sys_file',$fieldNAme='images');
        }
        else {
            $uploadError = 'Bilden gick inte att ladda upp';
        }
        

        // Do whatever you want with $result (array of File objects)
        foreach ($result['upload'] as $files) {
            /** @var \TYPO3\CMS\Core\Resource\File $file */
            $file = $files[0];	// Single element array due to the way we registered upload fields
        }
    }
    public function setFileReference($sysFileUid, $noteUid, $tableNames='tx_dliponlyestate_domain_model_note',$tableLocal='sys_file',$fieldName='images') {
        $GLOBALS['TYPO3_DB']->exec_INSERTquery('sys_file_reference', 
            array('uid_local' => $sysFileUid, 
                'uid_foreign' => $noteUid,
                'tablenames' => $tableNames,
                'fieldname' => $fieldName,
                'table_local' => $tableLocal
            )
        );
    }
    /**
    * Registers an uploaded file for TYPO3 native upload handling.
    * 
    * @param array &$data
    * @param string $namespace
    * @param string $fieldName
    * @param string $targetDirectory
    * @return void
    */
    protected function registerUploadField(array &$data, $namespace, $fieldName, $targetDirectory = '1:/user_upload/') {
        if (!isset($data['upload'])) {
            $data['upload'] = array();
        }
        $counter = count($data['upload']) + 1;

        $keys = array_keys($_FILES[$namespace]);
        foreach ($keys as $key) {
            $_FILES['upload_' . $counter][$key] = $_FILES[$namespace][$key][$fieldName];
        }
        $data['upload'][$counter] = array(
            'data' => $counter,
            'target' => $targetDirectory,
        );
    }
    public function createFolders($nodeTypeFolder, $estateFolder) {
        //$fullpath =  PATH_site . 'fileadmin/user_upload/'.$this->parentCustomerFolder;
        //PATH_site . 'fileadmin/';
        //$targetFalDirectory = '1:/'.$nodeTypePath.'/'.$estatePath.'/';

        $nodeTypePath =  PATH_site . 'fileadmin/user_upload/'.$nodeTypeFolder;
        if (!file_exists($nodeTypePath)) {
            \TYPO3\CMS\Core\Utility\GeneralUtility::mkdir($nodeTypePath);
        }
        $fullPath = $nodeTypePath.'/'.$estateFolder.'/';
        if (!file_exists($fullPath)) {
            \TYPO3\CMS\Core\Utility\GeneralUtility::mkdir($fullPath);
        }
        /*
        if (file_exists($fullpath)) {
            $customerFolderFullPath = $fullpath.'/'.$this->userName;
            if(!file_exists($customerFolderFullPath)) {
                \TYPO3\CMS\Core\Utility\GeneralUtility::mkdir($customerFolderFullPath);
            }
            foreach($this->customerCatNames as $catName => $subCatNames) {
                if(!file_exists($customerFolderFullPath.'/'.$catName)) {
                    $customerSubFolderFullPath = $customerFolderFullPath.'/'.$catName;
                    \TYPO3\CMS\Core\Utility\GeneralUtility::mkdir($customerSubFolderFullPath);
                }
                foreach($subCatNames as $subCatName) {
                    if(!file_exists($customerSubFolderFullPath.'/'.$subCatName)) {
                        $customerSub2FolderFullPath = $customerSubFolderFullPath.'/'.$subCatName;
                        \TYPO3\CMS\Core\Utility\GeneralUtility::mkdir($customerSub2FolderFullPath);
                    }
                }
            }
        }
        */
        if (!file_exists($fullpath)) {
            return NULL;
        }
        return $fullPath;
    }
}