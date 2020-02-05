<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,version,date,is_complete,node_type,control_point,executive_technician,responsible_technicians,report_is_posted,start_date,end_date,no_of_critical_remarks,no_of_remarks,no_of_old_remarks,no_of_notes,no_of_purchases,dynamic_column,notes,estate,reported_measurement,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('dl_iponlyestate') . 'Resources/Public/Icons/tx_dliponlyestate_domain_model_report.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, version, date, is_complete, node_type, control_point, executive_technician, responsible_technicians, report_is_posted, start_date, end_date, no_of_critical_remarks, no_of_remarks, no_of_old_remarks, no_of_notes, no_of_purchases, dynamic_column, notes, estate, reported_measurement',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, version, date, is_complete, node_type, control_point, executive_technician, responsible_technicians, report_is_posted, start_date, end_date, no_of_critical_remarks, no_of_remarks, no_of_old_remarks, no_of_notes, no_of_purchases, dynamic_column, notes, estate, reported_measurement, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_dliponlyestate_domain_model_report',
				'foreign_table_where' => 'AND tx_dliponlyestate_domain_model_report.pid=###CURRENT_PID### AND tx_dliponlyestate_domain_model_report.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),

		'name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'version' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.version',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			)
		),
		'date' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.date',
			'config' => array(
				'dbType' => 'date',
				'type' => 'input',
				'size' => 7,
				'eval' => 'date',
				'checkbox' => 0,
				'default' => '0000-00-00'
			),
		),
		'is_complete' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.is_complete',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'node_type' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.node_type',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'control_point' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.control_point',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'executive_technician' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.executive_technician',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'responsible_technicians' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.responsible_technicians',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'report_is_posted' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.report_is_posted',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'start_date' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.start_date',
			'config' => array(
				'dbType' => 'date',
				'type' => 'input',
				'size' => 7,
				'eval' => 'date',
				'checkbox' => 0,
				'default' => '0000-00-00'
			),
		),
		'end_date' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.end_date',
			'config' => array(
				'dbType' => 'date',
				'type' => 'input',
				'size' => 7,
				'eval' => 'date',
				'checkbox' => 0,
				'default' => '0000-00-00'
			),
		),
		'no_of_critical_remarks' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.no_of_critical_remarks',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'no_of_remarks' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.no_of_remarks',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'no_of_old_remarks' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.no_of_old_remarks',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'no_of_notes' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.no_of_notes',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'no_of_purchases' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.no_of_purchases',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'dynamic_column' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.dynamic_column',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_dliponlyestate_domain_model_dynamiccolumn',
				'foreign_field' => 'report',
				'maxitems' => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		'notes' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.notes',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_dliponlyestate_domain_model_note',
				'foreign_field' => 'report',
				'maxitems' => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		'estate' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.estate',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_dliponlyestate_domain_model_estate',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'reported_measurement' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.reported_measurement',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_dliponlyestate_domain_model_reportedmeasurement',
				'foreign_field' => 'report',
				'maxitems' => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		
	),
);## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder