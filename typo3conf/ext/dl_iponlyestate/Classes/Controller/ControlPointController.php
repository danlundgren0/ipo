<?php
namespace DanLundgren\DlIponlyestate\Controller;

use DanLundgren\DlIponlyestate\Utility\ReportUtility as ReportUtil;
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
     * controlPointRepository
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
        //'TSFE' => $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dliponlyestate_cp.'],
        if ($this && $this->estateRepository) {
            
        }
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
            array(
                'class' => __CLASS__,
                'function' => __FUNCTION__,
                'controlPoints' => $controlPoints
            )
        );
    }
    
    /**
     * action show
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint $controlPoint
     * @return void
     */
    public function showAction()
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
            array(
                'class' => __CLASS__,
                'function' => __FUNCTION__,
                'TSFE' => $GLOBALS['TSFE']->fe_user->user
            )
        );
        if ((int) $this->settings['ControlPoint'] > 0) {
            $errorMess = '';
            $controlPoint = $this->controlPointRepository->findByUid((int) $this->settings['ControlPoint']);
            $estate = $this->estateRepository->findByControlPoints((int) $this->settings['ControlPoint']);
            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
                array(
                    'class' => __CLASS__,
                    'function' => __FUNCTION__,
                    'estate' => $estate
                )
            );
            //TODO: Om rapportens getIsCompleted = FALSE: returnera samma versionsnr, Om TRUE: Returnera versionnr+1
            $reportWithVersion = $this->getLatestOrNewReport();
\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
 array(
  'class' => __CLASS__,
  'function' => __FUNCTION__,
  'reportWithVersion' => $reportWithVersion,
 )
);
            $reports = $this->reportRepository->findByControlPoint((int) $this->settings['ControlPoint']);
            $unPostedReports = ReportUtil::getUnPostedReports($reports);
            $postedReports = ReportUtil::getPostedReports($reports);
            if (count($unPostedReports) > 1) {
                $errorMess = 'You have ' . $noOfUnPostedReports . ' unposted reports. Only one is valid.';
            } else {
                if (count($report) == 0) {
                    $report = ReportUtil::getNextVersionNumber($reports);
                }
            }
            $unPostedReport = $unPostedReports[count($unPostedReports) - 1];
            $this->view->assign('reportWithVersion', $reportWithVersion);
            $this->view->assign('unPostedReport', $unPostedReport);
            $this->view->assign('postedReports', $postedReports);
            $this->view->assign('errorMess', $errorMess);
            $this->view->assign('controlPoint', $controlPoint);
            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
                array(
                    'class' => __CLASS__,
                    'function' => __FUNCTION__,
                    'estate' => $estate,
                    'controlPoint' => $controlPoint,
                    'unPostedReport' => $unPostedReport,
                    'postedReports' => $postedReports,
                    'reports' => $reports
                )
            );
        }
    }
    private function getLatestOrNewReport() {
        $allReports = $this->reportRepository->findAll();
        $highestVersion = -1;
        $latestReport = NULL;
        foreach($allReports as $report) {
            if((int)$report->getVersion()>(int)$highestVersion) {
                $highestVersion = (int)$report->getVersion();
                $latestReport = $report;
            }
        }        
        $highestVersion=($highestVersion==-1)?1:$highestVersion+=1;
        if(!$latestReport->getIsComplete()) {
            return $latestReport;
        }
        $newReport = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DanLundgren\DlIponlyestate\Domain\Model\Report');
        $newReport->setVersion($highestVersion);
        return $newReport;
    }
}