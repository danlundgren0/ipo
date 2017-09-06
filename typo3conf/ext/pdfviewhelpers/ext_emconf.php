<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "pdfviewhelpers".
 *
 * Auto generated 27-06-2017 19:07
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'PDF ViewHelpers',
  'description' => 'Provides various Fluid ViewHelpers to create PDF documents. It is possible to use existing PDFs as template and extend them using these ViewHelpers. Under the hood pdfviewhelpers uses TCPDF and FPDI.',
  'category' => 'fe',
  'author' => 'Markus Mächler, Esteban Marin',
  'author_email' => 'markus.maechler@bithost.ch, esteban.marin@bithost.ch',
  'author_company' => 'Bithost GmbH',
  'state' => 'stable',
  'uploadfolder' => false,
  'createDirs' => '',
  'clearCacheOnLoad' => 0,
  'version' => '1.3.0',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '6.2.0-8.7.99',
      'php' => '5.4.0-7.1.99',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
  'clearcacheonload' => false,
);

