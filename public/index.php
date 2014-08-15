<?php
define('bootstrap3', 1);

defined('PUBLIC_PATH')
|| define('PUBLIC_PATH', realpath(dirname(__FILE__)));

// Define path to application directory
defined('SAND_ROOT')
|| define('SAND_ROOT', realpath(dirname(__FILE__) . '/../../sand-core'));

require_once(SAND_ROOT . '/library/init.php');
require_once(SAND_ROOT . '/library/common.php');

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
); 
$application->bootstrap()
            ->run();