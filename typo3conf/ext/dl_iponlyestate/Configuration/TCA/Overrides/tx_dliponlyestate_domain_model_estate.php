<?php
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
//$GLOBALS['TCA']['tx_dliponlyestate_domain_model_estate']['columns']['control_points']['config']['foreign_table_where'] = 'AND tx_dliponlyestate_domain_model_controlpoint.uid = '. $respTechGroupId .' ORDER BY fe_users.username';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_estate']['columns']['responsible_technician']['config']['items'] = array(
    array('Select technician', 0),
);
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_estate']['columns']['responsible_technician']['config']['foreign_table'] = 'fe_users';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_estate']['columns']['responsible_technician']['config']['foreign_table_where'] = ' AND usergroup = 2 ORDER BY username';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_estate']['columns']['page_link'] = array (
    'label' => 'LLL:EXT:cms/locallang_ttc.xlf:header_link',
    'exclude' => 1,
    'config' => array(
            'type' => 'input',
            'size' => 50,
            'max' => 1024,
            'eval' => 'trim',
            'wizards' => array(
                    '_PADDING' => 2,
                    'link' => array(
                            'type' => 'popup',
                            'title' => 'LLL:EXT:cms/locallang_ttc.xlf:header_link_formlabel',
                            'icon' => 'link_popup.gif',
                            'module' => array(
                                    'name' => 'wizard_element_browser',
                                    'urlParameters' => array(
                                            'mode' => 'wizard'
                                    )
                            ),
                            'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
                    )
            ),
            'softref' => 'typolink'
    )
);