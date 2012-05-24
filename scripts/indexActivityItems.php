<?php
/**
 * Fills Lucene Index from data
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Scripts
 */

require_once 'bootstrap.php';

$frontController = $bootstrap->getResource('FrontController');
$frontController->setParam('bootstrap', $bootstrap);

$serviceItem = new MaitreCorbeaux_Service_Activity_Item();
$items = $serviceItem->fetchAll();

$serviceSearch = new MaitreCorbeaux_Service_Activity_Search();
$serviceSearch->indexItems($items);