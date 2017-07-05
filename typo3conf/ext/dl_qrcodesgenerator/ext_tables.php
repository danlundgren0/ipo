<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DanLundgren.' . $_EXTKEY,
	'Qrcodesgenerator',
	'QRcodesGenerator'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_qrcodesgenerator';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_qrcodesgenerator.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'QRcodes Generator');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dlqrcodesgenerator_domain_model_qrcodesgenerator', 'EXT:dl_qrcodesgenerator/Resources/Private/Language/locallang_csh_tx_dlqrcodesgenerator_domain_model_qrcodesgenerator.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dlqrcodesgenerator_domain_model_qrcodesgenerator');
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder