<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DanLundgren.' . $_EXTKEY,
	'Cp',
	array(
		'ControlPoint' => 'list, show, upload',
		
	),
	// non-cacheable actions
	array(
		'ControlPoint' => 'list, show, upload',
		
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
		'Estate' => 'list, show',
		
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
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:dl_iponlyestate/Classes/Hooks/copyPageTree.php:DanLundgren\DlIponlyestate\Hooks\injectCopyAndPaste';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] = 'EXT:dl_iponlyestate/Classes/Hooks/copyPageTree.php:DanLundgren\DlIponlyestate\Hooks\injectCopyAndPaste';
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter('DanLundgren\\DlIponlyestate\\Property\\TypeConverter\\UploadedFileReferenceConverter');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter('DanLundgren\\DlIponlyestate\\Property\\TypeConverter\\ObjectStorageConverter');