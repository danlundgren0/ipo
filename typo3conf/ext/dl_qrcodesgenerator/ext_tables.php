<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'DanLundgren.' . $_EXTKEY,
	'Qrcodesgenerator',
	'QRcodesGenerator'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'QRcodes Generator');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dlqrcodesgenerator_domain_model_qrcodesgenerator', 'EXT:dl_qrcodesgenerator/Resources/Private/Language/locallang_csh_tx_dlqrcodesgenerator_domain_model_qrcodesgenerator.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dlqrcodesgenerator_domain_model_qrcodesgenerator');
