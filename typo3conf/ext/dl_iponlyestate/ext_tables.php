<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DanLundgren.' . $_EXTKEY,
	'Cp',
	'ControlPoint'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_cp';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_cp.xml');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DanLundgren.' . $_EXTKEY,
	'Estate',
	'Estate'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DanLundgren.' . $_EXTKEY,
	'Ajaxrequest',
	'Ajax Request'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_ajaxrequest';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_ajaxrequest.xml');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DanLundgren.' . $_EXTKEY,
	'Reportsearch',
	'Report Search'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DanLundgren.' . $_EXTKEY,
	'Reportlist',
	'Report List'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Iponly Estate');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_estate', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_estate.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_estate');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_nodetype', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_nodetype.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_nodetype');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_controlpoint', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_controlpoint.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_controlpoint');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_question', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_question.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_question');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_dynamiccolumn', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_dynamiccolumn.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_dynamiccolumn');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_report', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_report.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_report');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_note', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_note.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_note');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_reportedmeasurement', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_reportedmeasurement.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_reportedmeasurement');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_measurementvalues', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_measurementvalues.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_measurementvalues');
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
if(!is_array($GLOBALS['SCANNED_CP'])) {
	$GLOBALS['SCANNED_CP'] = array();
}
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/TypoScript/pageTsConfig.ts">');

$pluginSignature = str_replace('_','',$_EXTKEY) . '_cp';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/ControlPoint.xml');

$pluginSignature = str_replace('_','',$_EXTKEY) . '_estate';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Estate.xml');