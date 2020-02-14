<?php
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['type'] = 'select';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['foreign_table'] = 'tx_dliponlyestate_domain_model_question';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['foreign_table_where'] = 'AND tx_dliponlyestate_domain_model_question.hidden = 0 AND tx_dliponlyestate_domain_model_question.deleted = 0 ORDER BY tx_dliponlyestate_domain_model_question.name';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['items'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['wizards'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['minitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['maxitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['size'] = 1;
/*
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['executive_technician']['config']['type'] = 'select';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['executive_technician']['config']['foreign_table'] = 'fe_users';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['executive_technician']['config']['foreign_table_where'] = 'AND fe_users.disable = 0 AND fe_users.deleted = 0 ORDER BY fe_users.username';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['executive_technician']['config']['items'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['executive_technician']['config']['wizards'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['executive_technician']['config']['minitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['executive_technician']['config']['maxitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['executive_technician']['config']['size'] = 1;
*/
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['remark_type']['config']['items'] = array(
					array('ok', 1),
                    array('critical', 2),
                    array('remark', 3),
                    array('purchase', 4),
                    array('photo', 5),
				);
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['images']['config']['maxitems'] = 999;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['upload_images1']['config']['minitems'] = 0;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['upload_images2']['config']['minitems'] = 0;

$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['upload_images1']['config']['foreign_match_fields'] = array(
    'fieldname' => 'upload_images1',
    'tablenames' => 'tx_dliponlyestate_domain_model_note',
    'table_local' => 'sys_file',
);
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['upload_images2']['config']['foreign_match_fields'] = array(
    'fieldname' => 'upload_images2',
    'tablenames' => 'tx_dliponlyestate_domain_model_note',
    'table_local' => 'sys_file',
);
/*
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['upload_images3']['config']['foreign_match_fields'] = array(
    'fieldname' => 'upload_images3',
    'tablenames' => 'tx_dliponlyestate_domain_model_note',
    'table_local' => 'sys_file',
);
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['upload_images4']['config']['foreign_match_fields'] = array(
    'fieldname' => 'upload_images4',
    'tablenames' => 'tx_dliponlyestate_domain_model_note',
    'table_local' => 'sys_file',
);
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['upload_images5']['config']['foreign_match_fields'] = array(
    'fieldname' => 'upload_images5',
    'tablenames' => 'tx_dliponlyestate_domain_model_note',
    'table_local' => 'sys_file',
);
*/