<?php
/**
 * Import Activity Items from Activity Sources
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Scripts
 */

require_once 'bootstrap.php';

$frontController = $bootstrap->getResource('FrontController');
$frontController->setParam('bootstrap', $bootstrap);

$service = new MaitreCorbeaux_Service_Activity_Import_Facade();
$service->import();