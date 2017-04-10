<?php
    namespace DanLundgren\DlIponlyestate\Hooks;
    class FFControlPointSelector {
        public function getControlPoints($config,$params){
            if(($config['row']['settings.Estate']) && ((int)$config['row']['settings.Estate'][0]>0)) {
                $estateUid = (int)$config['row']['settings.Estate'][0];
                $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
                $estateRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\EstateRepository');
                $controlPointRepository = $objectManager->get('DanLundgren\DlIponlyestate\Domain\Repository\ControlPointRepository');
                $estate = $estateRepository->findByUid($estateUid);
                $cpArr = array();
                if($estate && count($estate->getControlPoints())>0) {
                    foreach($estate->getControlPoints() as $controlPoint) {
                        $cpArr[] = array($controlPoint->getName(), $controlPoint->getUid());
                    }
                }
                if(count($cpArr)==0) {
                    //return $config['items'] = array(0 => 'Inga kontrollpunkter valda');
                    $emptyList[] = array(0 => 'Inga kontrollpunkter valda');
                    return $config['items'] = array_merge($config['items'], $emptyList);
                }
                return $config['items'] = array_merge($config['items'], $cpArr);
            }
        }
    }
?>
