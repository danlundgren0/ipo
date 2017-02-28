<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "bootstrap_core".
 *
 * Auto generated 01-11-2016 12:44
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Bootstrap for TYPO3',
  'description' => 'Bootstrap specific changes for the frontend rendering of content elements. Adds sectionframe options and layout options for images and menus.',
  'category' => 'fe',
  'author' => 'Pascal Mayer',
  'author_email' => 'typo3@bsdist.ch',
  'author_company' => '',
  'state' => 'stable',
  'version' => '1.2.8',
  'uploadfolder' => false,
  'createDirs' => '',
  'clearCacheOnLoad' => 1,
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '6.2.0-7.6.99',
    ),
    'conflicts' => 
    array (
      'bootstrap_package' => '',
    ),
    'suggests' => 
    array (
    ),
  ),
  'clearcacheonload' => true,
);

