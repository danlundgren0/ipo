<?php
namespace DanLundgren\DlIponlyestate\Utility;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Dan Lundgren <danlundgren0@gmail.com>, Dan Lundgren
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
 * General Utility
 */
class ReportUtility {

    /**
     * action getUnPostedReports
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Report $reports
     * @return array
     */    
    public static function getUnPostedReports($reports) {
        $unPostedReports = array();
        foreach($reports as $report) {                
            if(!$report->getReportIsPosted()) {
                $unPostedReports[] = $report;
            }
        }
        return $unPostedReports;
    }

    /**
     * action getUnPostedReports
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Report $reports
     * @return array
     */    
    public static function getPostedReports($reports) {
        $postedReports = array();
        foreach($reports as $report) {                
            if($report->getReportIsPosted()) {
                $postedReports[] = $report;
            }
        }
        return $postedReports;
    }

    /**
     * action getNextVersionNumber
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Report $reports
     * @return int
     */
    public static function getNextVersionNumber($reports) {
        $tmpVer = 0;
        foreach($reports as $report) {                
            if($report->getVersion()>$tmpVer) {
                $tmpVer = $report->getVersion();
            }
        }
        return $tmpVer += 1;
    }

    /**
     * action getReportWithNewVersion
     *
     * @return array
     */
    public static function getReportWithNewVersion($verNo) {
        //TODO generate and retun new version report
    }

    /**
     * action isAllNotesOk
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Report $report
     * @return boolean
     */
    public static function isLatestNoteOk($report, $question) {
        //TODO generate and retun new version report
        foreach($report->getNotes() as $note) {
            //Sort on version no. Get highest
            //if($note->getRemarkType)
        }
    }

}