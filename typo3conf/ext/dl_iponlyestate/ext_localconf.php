<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DanLundgren.' . $_EXTKEY,
	'Cp',
	array(
		'ControlPoint' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Estate' => '',
		'ControlPoint' => '',
		'Note' => '',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DanLundgren.' . $_EXTKEY,
	'Estate',
	array(
		'Estate' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Estate' => '',
		'ControlPoint' => '',
		'Note' => '',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DanLundgren.' . $_EXTKEY,
	'Ajaxrequest',
	array(
		'AjaxRequest' => 'getJson',
		
	),
	// non-cacheable actions
	array(
		'AjaxRequest' => 'getJson',
		
	)
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder