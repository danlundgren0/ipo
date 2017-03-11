<?php
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['type'] = 'select';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['foreign_table'] = 'tx_dliponlyestate_domain_model_question';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['foreign_table_where'] = 'AND tx_dliponlyestate_domain_model_question.hidden = 0 AND tx_dliponlyestate_domain_model_question.deleted = 0 ORDER BY tx_dliponlyestate_domain_model_question.name';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['items'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['wizards'] = array();
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['minitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['maxitems'] = 1;
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['question']['config']['size'] = 1;

$GLOBALS['TCA']['tx_dliponlyestate_domain_model_note']['columns']['remark_type']['config']['items'] = array(
					array('ok', 1),
                    array('critical', 2),
                    array('remark', 3),
                    array('purchase', 4),
				);
