<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Iponly Estate');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_estate', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_estate.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_estate');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_technician', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_technician.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_technician');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_node', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_node.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_node');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_controlpoint', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_controlpoint.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_controlpoint');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_question', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_question.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_question');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dliponlyestate_domain_model_dynamiccolumn', 'EXT:dl_iponlyestate/Resources/Private/Language/locallang_csh_tx_dliponlyestate_domain_model_dynamiccolumn.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dliponlyestate_domain_model_dynamiccolumn');
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder