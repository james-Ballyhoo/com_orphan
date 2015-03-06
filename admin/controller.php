<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla controller library
jimport('joomla.application.component.controller');
/**
 * General Controller of Registry component
 */
class OrphanController extends JControllerLegacy
{
    public function display($cachable = false, $urlparams = false)
    {
    	JRequest::setVar('view', JRequest::getCmd('view', 'Orphans'));

        // call parent behavior
        parent::display($cachable);
    }
}

?>