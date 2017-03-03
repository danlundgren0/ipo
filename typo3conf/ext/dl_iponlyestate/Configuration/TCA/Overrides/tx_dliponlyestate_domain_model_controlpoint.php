<?php
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['dl_iponlyestate']);
$respTechGroupId = $extensionConfiguration['responsibleTechnicians'];
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_controlpoint']['columns']['responsible_technician']['config']['items'] = array(
    array('Select technician', 0),
);
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_controlpoint']['columns']['responsible_technician']['config']['foreign_table'] = 'fe_users';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_controlpoint']['columns']['responsible_technician']['config']['foreign_table_where'] = 'AND fe_users.usergroup = '. $respTechGroupId .' ORDER BY fe_users.username';
//$GLOBALS['TCA']['tx_dliponlyestate_domain_model_controlpoint']['columns']['responsible_technician']['config']['foreign_table_where'] = 'AND sys_category.usergroup = '. .' ORDER BY sys_category.title';
$GLOBALS['TCA']['tx_dliponlyestate_domain_model_controlpoint']['types'] = array(
	'1' => array('showitem' => '
		sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, header, description;;;richtext:rte_transform[mode=ts_links], image,
		--div--;Settings, responsible_technician, node_type, questions,
		--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime
	'),
);
