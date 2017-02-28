<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DanLundgren.' . $_EXTKEY,
	'Controlpoint',
	array(
		'ControlPoint' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'ControlPoint' => '',
		
	)
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder