<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla controller library
jimport('joomla.application.component.controller');
/**
 * General Controller of Registry component
 */
ini_set('memory_limit', '512M');
class OrphanController extends JControllerLegacy
{
    public function display($cachable = false, $urlparams = false)
    {
    	JRequest::setVar('view', JRequest::getCmd('view', 'Orphans'));
        if(isset($_POST['_orphanaction']) && $_POST['_orphanaction'] == "zipIt"){
            $file = tempnam("tmp", "zip");
            $zip = new ZipArchive();
            $zip->open($file, ZipArchive::OVERWRITE);
            foreach ($_POST['tozip'] as $_file) {
                $zip->addFile(JPATH_ROOT . "/" . $_file, $_file);
            }
            $zip->close();
            header('Content-Type: application/zip');
            header('Content-Length: ' . filesize($file));
            header('Content-Disposition: attachment; filename="orphans.zip"');
            readfile($file);
            unlink($file);
            die();
        }else if(isset($_POST['_orphanaction']) && $_POST['_orphanaction'] == "delete" && isset($_POST['_confirmAction'])){
            foreach ($_POST['tozip'] as $_file) {
                unlink(JPATH_ROOT . "/" . $_file);
            }
        }
        // call parent behavior
        parent::display($cachable);
    }
}

?>