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
 * PdfController
 */
class PdfController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * reportRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository
     * @inject
     */
    protected $reportRepository = NULL;

    /**
     * estateRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\EstateRepository
     * @inject
     */
    protected $estateRepository = NULL;

    /**
     * pdfRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\PdfRepository
     * @inject
     */
    protected $pdfRepository = NULL;
    
    /**
     * action pdfcomplete
     *
     * @return void
     */
    public function pdfcompleteAction()
    {
        //$reportUid = $this->getArgument('report');
        //$estateUid = $this->getArgument('estate');
        $reportUid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('report');
        $estateUid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('estate');
        if((int)$reportUid>0 && (int)$estateUid>0) {            
            $clickedReport = $this->reportRepository->findByUid((int)$reportUid);
            $estate = $this->estateRepository->findByUid((int)$estateUid);
            $reports = $this->reportRepository->findByEstate($estate);
            $completeReportArr = ReportUtility::getCompleteReport($clickedReport, $estate, $reports);
        }
        if($completeReportArr) {
            $this->view->assign('report', $completeReportArr);
        }
    }
    
    /**
     * action pdfcritical
     *
     * @return void
     */
    public function pdfcriticalAction()
    {
        
    }
    
    /**
     * action pdfremark
     *
     * @return void
     */
    public function pdfremarkAction()
    {
        
    }
    
    /**
     * action pdfpurchase
     *
     * @return void
     */
    public function pdfpurchaseAction()
    {
        
    }
    
    /**
     * action pdfoldremarks
     *
     * @return void
     */
    public function pdfoldremarksAction()
    {
        
    }

}