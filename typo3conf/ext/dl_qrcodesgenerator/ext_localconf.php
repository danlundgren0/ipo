<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DanLundgren.' . $_EXTKEY,
	'Qrcodesgenerator',
	array(
		'QRcodesGenerator' => 'list, link',
		
	),
	// non-cacheable actions
	array(
		'QRcodesGenerator' => 'list, link',
		
	)
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder