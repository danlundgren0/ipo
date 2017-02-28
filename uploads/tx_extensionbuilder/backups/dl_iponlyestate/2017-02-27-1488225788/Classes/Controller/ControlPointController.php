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
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        //$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        //$this->controlPointRepository = $this->objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ControlPointRepository');
        //$this->estateRepository = $this->objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\EstateRepository');
        //if ((int) $this->settings['ControlPoint'] > 0) {
        //$controlPoint = $this->controlPointRepository->findByUid((int)$this->settings['ControlPoint']);
        //$controlPoint = $this->controlPointRepository->findAll();
        $controlPoint = $this->controlPointRepository->findByUid(2);
        $estate = $this->estateRepository->findByUid(1);
        //$estate = $this->estateRepository->findAll();
        //}
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
            array(
                'class' => __CLASS__,
                'function' => __FUNCTION__,
                'TSFE' => $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_dliponlyestate_cp.'],
                'this' => $this,
                'settings' => $this->settings,
                'objectManager' => $objectManager,
                'controlPointRepository' => $this->controlPointRepository,
                'controlPoint' => $controlPoint,
                'estate' => $estate
            )
        );
    }
    
    /**
     * action show
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\ControlPoint $controlPoint
     * @return void
     */
    public function showAction(\DanLundgren\DlIponlyestate\Domain\Model\ControlPoint $controlPoint)
    {
        $this->view->assign('controlPoint', $controlPoint);
    }

}