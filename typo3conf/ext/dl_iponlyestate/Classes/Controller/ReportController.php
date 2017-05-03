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
 * ReportController
 */
class ReportController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    
    /**
     * controlPointRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\ControlPointRepository
     * @inject
     */
    protected $controlPointRepository = NULL;

    /**
     * dynamicColumnRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\DynamicColumnRepository
     * @inject
     */
    protected $dynamicColumnRepository = NULL;
    
    /**
     * estateRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\EstateRepository
     * @inject
     */
    protected $estateRepository = NULL;
    
    /**
     * measurementValuesRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\MeasurementValuesRepository
     * @inject
     */
    protected $measurementValuesRepository = NULL;

    /**
     * nodeTypeRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\NodeTypeRepository
     * @inject
     */
    protected $nodeTypeRepository = NULL;

    /**
     * noteRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\NoteRepository
     * @inject
     */
    protected $noteRepository = NULL;
        
    /**
     * questionRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\QuestionRepository
     * @inject
     */
    protected $questionRepository = NULL;
    
    /**
     * reportedMeasurementRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\ReportedMeasurementRepository
     * @inject
     */
    protected $reportedMeasurementRepository = NULL;

    /**
     * reportRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository
     * @inject
     */
    protected $reportRepository = NULL;

    /**
     * technicianRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\TechnicianRepository
     * @inject
     */
    protected $technicianRepository = NULL;
    
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $arguments = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_dliponlyestate_reportsearch');
        $reports = $this->reportRepository->findAll();
        
        $this->view->assign('reports', $reports);
    }
    
    /**
     * action search
     *
     * @return void
     */
    public function searchAction()
    {
        $arguments = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_dliponlyestate_reportsearch');
        $this->view->assign('arguments', $arguments);
        $this->view->assign('estates', $this->getEstates());
        $this->view->assign('cities', $this->getEstateCities());
        //$estate = $this->estateRepository->findByUid(13);
        //$this->view->assign('technicians', $this->getTechnicians($estate));
        $this->view->assign('technicians', $this->getTechnicians());
        $this->view->assign('nodeTypes', $this->getNodeTypes());
        $this->view->assign('notes', $this->getNotes());
        
    }
    public function getControlPoints() {
        return $this->controlPointRepository->findAll();
    }
    public function getDynamicColumns() {
        
    }
    public function getEstateCities() {
        $estates = $this->estateRepository->findAll();
        $cities = array();
        foreach($estates as $estate) {
            if(!in_array($estate->getCity(), $cities) && $estate->getCity()!='') {
               $cities[$estate->getCity()] = $estate->getCity();
            }
        }
        $cities = array_merge(Array('*' => 'Alla'), $cities);
        return $cities;
    }
    public function getTechnicians($estate=NULL) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $technicianRepository = $objectManager->get('TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository');
        $estates = $this->estateRepository->findAll();
        $technicians = array();
        if($estate===NULL) {
            foreach($estates as $estate) {
                if($estate->getResponsibleTechnician()!=0) {
                    $technician = $technicianRepository->findByUid((int)$estate->getResponsibleTechnician());
                    if(!in_array($technician->getName(), $technicians)) {
                       $technicians[$technician->getUid()] = $technician->getName();
                    }
                }
            }
        }
        else {
            if($estate->getResponsibleTechnician()!=0) {
                $technician = $technicianRepository->findByUid((int)$estate->getResponsibleTechnician());
                if(!in_array($technician->getName(), $technicians)) {
                   $technicians[$technician->getUid()] = $technician->getName();
                }
            } 
        }
        $reports = $this->reportRepository->findAll();
        foreach($reports as $report) {
            if($report->getEstate()===$estate || $estate===NULL) {
                if($report->getResponsibleTechnicians()>0) {
                    $technician = $technicianRepository->findByUid((int)$report->getResponsibleTechnicians());
                    if(!in_array($technician->getName(), $technicians)) {
                       $technicians[$technician->getUid()] = $technician->getName();
                    }
                }
                if($report->getExecutiveTechnician()>0) {
                    $technician = $technicianRepository->findByUid((int)$report->getExecutiveTechnician());
                    if(!in_array($technician->getName(), $technicians)) {
                       $technicians[$technician->getUid()] = $technician->getName();
                    }
                }                
            }
        }
        $techniciansArr = array_merge(Array('*' => 'Alla'), $technicians);
        return $techniciansArr;
    }
    public function getEstates() {
        $estates = $this->estateRepository->findAll();
        $estatesArr = array_merge(Array('*' => 'Alla'), $estates->toArray());
        return $estatesArr;
    }
    public function getFileReferences() {
        
    }
    public function getMeasurementValues() {
        
    }
    public function getNodeTypes() {
        $nodeTypes = $this->nodeTypeRepository->findAll();
        $nodeTypesArr = array_merge(Array('*' => 'Alla'), $nodeTypes->toArray());
        return $nodeTypesArr;
    }
    public function getNotes() {
        $notes = $this->noteRepository->findAll();   
        $notesArr = array_merge(Array('*' => 'Alla'), $notes->toArray());
        return $notesArr;
    }
    public function getQuestions() {
        
    }
    public function getReports() {
        
    }
    public function getReportedMeasurements() {
        
    }
}