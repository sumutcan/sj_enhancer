<?php
/**
 * Created by PhpStorm.
 * User: umutcan
 * Date: 8/27/15
 * Time: 11:23 PM
 */

define('_JEXEC', 1);
define('JPATH_BASE', dirname(dirname(dirname(dirname(__FILE__)))));
define('DS', DIRECTORY_SEPARATOR);

require_once JPATH_BASE . DS . 'includes' . DS . 'defines.php';
require_once JPATH_BASE . DS . 'includes' . DS . 'framework.php';

$mainframe = JFactory::getApplication('site');
$mainframe->initialise();

if (!JRequest::get("entities")) {
    $session = JFactory::getSession();

    echo json_encode($session->get("entityIDs", null, "sj"));
} else {


    $entities = JRequest::get("entities");

    $session = JFactory::getSession();
    $session->set("entityIDs", $entities, "sj");
    echo "tamam";

}