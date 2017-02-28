<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report',
		'label' => 'version',
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
		'searchFields' => 'version,date,critical_remarks,remarks,note,purchase,comment,question,responsible_technician,technician,dynamic_column,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('dl_iponlyestate') . 'Resources/Public/Icons/tx_dliponlyestate_domain_model_report.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, version, date, critical_remarks, remarks, note, purchase, comment, question, responsible_technician, technician, dynamic_column',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, version, date, critical_remarks, remarks, note, purchase, comment, question, responsible_technician, technician, dynamic_column, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
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

		'version' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.version',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
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
		'critical_remarks' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.critical_remarks',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'remarks' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.remarks',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'note' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.note',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'purchase' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.purchase',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'comment' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.comment',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'question' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.question',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_dliponlyestate_domain_model_question',
				'MM' => 'tx_dliponlyestate_report_question_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'module' => array(
							'name' => 'wizard_edit',
						),
						'type' => 'popup',
						'title' => 'Edit',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'module' => array(
							'name' => 'wizard_add',
						),
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_dliponlyestate_domain_model_question',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
					),
				),
			),
		),
		'responsible_technician' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.responsible_technician',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'fe_users',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'technician' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:dl_iponlyestate/Resources/Private/Language/locallang_db.xlf:tx_dliponlyestate_domain_model_report.technician',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'fe_users',
				'minitems' => 0,
				'maxitems' => 1,
			),
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
		
		'controlpoint' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder