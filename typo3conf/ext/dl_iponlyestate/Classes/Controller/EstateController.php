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
 * EstateController
 */
class EstateController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * estateRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\EstateRepository
     * @inject
     */
    protected $estateRepository = NULL;
    
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $estates = $this->estateRepository->findAll();
        $estate = $this->estateRepository->findByUid((int) $this->settings['Estate']);
        $isValid=1;
        if(!$estate) {
            $this->view->assign('ErrMess', 'Fastigheten hittades ej');
            $isValid=0;
        }        
        if($isValid && !$estate->getControlPoints()) {
            $this->view->assign('ErrMess', 'Inga kontrollpunkter hittades');
            $isValid=0;
        }
        $this->view->assign('isValid', $isValid);
        if($isValid) {
            $controlPoints = $estate->getControlPoints();
            $this->view->assign('estates', $estates);
            $this->view->assign('estate', $estate);
            $this->view->assign('controlPoints', $controlPoints);            
        }
    }
    
    /**
     * action show
     *
     * @param \DanLundgren\DlIponlyestate\Domain\Model\Estate $estate
     * @return void
     */
    public function showAction(\DanLundgren\DlIponlyestate\Domain\Model\Estate $estate)
    {        
        $this->view->assign('estate', $estate);
    }

}