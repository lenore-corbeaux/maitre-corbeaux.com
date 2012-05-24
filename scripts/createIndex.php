<?php
/**
 * Create Lucene Index
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Scripts
 */

$resources = 'FrontController';
require_once 'bootstrap.php';

$lucene = $bootstrap->getOption('lucene');
Zend_Search_Lucene::create($lucene['indexDir']);