<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "bsdist".
 *
 * Auto generated 01-11-2016 12:44
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Bootstrap Kickstart Package',
  'description' => 'An initial page tree will be imported and bootstrap_core will be installed. A collection of files for the website layout and extension configuration is included.',
  'category' => 'distribution',
  'author' => 'Pascal Mayer',
  'author_email' => 'typo3@bsdist.ch',
  'author_company' => '',
  'state' => 'stable',
  'version' => '1.3.3',
  'uploadfolder' => false,
  'createDirs' => '',
  'clearCacheOnLoad' => 1,
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '6.2.0-7.6.99',
      'bootstrap_core' => '1.2.8-0.0.0',
      'scheduler' => '6.2.0-7.6.99',
      'recycler' => '6.2.0-7.6.99',
    ),
    'conflicts' => 
    array (
      'bootstrap_package' => '',
      'introduction' => '',
    ),
    'suggests' => 
    array (
    ),
  ),
  'clearcacheonload' => true,
);

