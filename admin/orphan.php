<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
// Require the base controller
jimport('joomla.application.component.controller');
// Create the controller
$controller = JControllerLegacy::getInstance('Orphan');
// Perform the Request task
$controller->execute( JRequest::getCmd('task') );
// Redirect if set by the controller
$controller->redirect();
?>