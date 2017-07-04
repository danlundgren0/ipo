<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DanLundgren.' . $_EXTKEY,
	'Qrcodesgenerator',
	array(
		'QRcodesGenerator' => 'list',
		
	),
	// non-cacheable actions
	array(
		'QRcodesGenerator' => 'list',
		
	)
);
