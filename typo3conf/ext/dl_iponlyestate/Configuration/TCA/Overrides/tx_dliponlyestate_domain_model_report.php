<?php
//$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['estate']['config']['items'] = array(
//    array('Select technician', 0),
//);
//$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['estate']['config']['foreign_table']

$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['estate']['config']['type'] = 'select';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['estate']['config']['foreign_table'] = 'tx_dliponlyestate_domain_model_estate';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['estate']['config']['foreign_table_where'] = 'AND tx_dliponlyestate_domain_model_estate.hidden = 0 AND tx_dliponlyestate_domain_model_estate.deleted = 0 ORDER BY tx_dliponlyestate_domain_model_estate.name';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['estate']['config']['items'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['estate']['config']['wizards'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['estate']['config']['minitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['estate']['config']['maxitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['estate']['config']['size'] = 1;


//$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['technician']['config']['type'] = 'select';
//$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['technician']['config']['foreign_table'] = 'fe_users';
//$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['technician']['config']['foreign_table_where'] = 'AND fe_users.disable = 0 AND fe_users.deleted = 0 ORDER BY fe_users.username';
//$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['technician']['config']['items'] = array();
//$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['technician']['config']['wizards'] = array();
//$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['technician']['config']['minitems'] = 1;
//$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['technician']['config']['maxitems'] = 1;
//$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['technician']['config']['size'] = 1;

$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['node_type']['config']['type'] = 'select';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['node_type']['config']['foreign_table'] = 'tx_dliponlyestate_domain_model_nodetype';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['node_type']['config']['foreign_table_where'] = 'AND tx_dliponlyestate_domain_model_nodetype.hidden = 0 AND tx_dliponlyestate_domain_model_nodetype.deleted = 0 ORDER BY tx_dliponlyestate_domain_model_nodetype.name';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['node_type']['config']['items'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['node_type']['config']['wizards'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['node_type']['config']['minitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['node_type']['config']['maxitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['node_type']['config']['size'] = 1;

$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['control_point']['config']['type'] = 'select';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['control_point']['config']['foreign_table'] = 'tx_dliponlyestate_domain_model_controlpoint';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['control_point']['config']['foreign_table_where'] = 'AND tx_dliponlyestate_domain_model_controlpoint.hidden = 0 AND tx_dliponlyestate_domain_model_controlpoint.deleted = 0 ORDER BY tx_dliponlyestate_domain_model_controlpoint.name';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['control_point']['config']['items'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['control_point']['config']['wizards'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['control_point']['config']['minitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['control_point']['config']['maxitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['control_point']['config']['size'] = 1;

$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['responsible_technicians']['config']['type'] = 'select';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['responsible_technicians']['config']['foreign_table'] = 'fe_users';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['responsible_technicians']['config']['foreign_table_where'] = 'AND fe_users.disable = 0 AND fe_users.deleted = 0 ORDER BY fe_users.username';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['responsible_technicians']['config']['items'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['responsible_technicians']['config']['wizards'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['responsible_technicians']['config']['minitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['responsible_technicians']['config']['maxitems'] = 999;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['responsible_technicians']['config']['size'] = 10;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['responsible_technicians']['config']['renderType'] = 'selectMultipleSideBySide';

$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['executive_technician']['config']['type'] = 'select';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['executive_technician']['config']['foreign_table'] = 'fe_users';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['executive_technician']['config']['foreign_table_where'] = 'AND fe_users.disable = 0 AND fe_users.deleted = 0 ORDER BY fe_users.username';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['executive_technician']['config']['items'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['executive_technician']['config']['wizards'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['executive_technician']['config']['minitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['executive_technician']['config']['maxitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_report']['columns']['executive_technician']['config']['size'] = 1;
