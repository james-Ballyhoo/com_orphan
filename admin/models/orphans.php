<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.modellist' );
class OrphanModelOrphans extends JModelList
{
    function human_filesize($bytes, $decimals = 2) {
      $sz = 'BKMGTP';
      $factor = floor((strlen($bytes) - 1) / 3);
      $_d = $decimals;
      if($factor == 0){$_d = 0;}
      return sprintf("%.{$_d}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
  }

  function _dirToArray($baseDir,$_removePrefix){
    $dh = opendir($baseDir);
    $files = array();
    while (false !== ($filename = readdir($dh))) {
        $loc = $baseDir . "/" . $filename;
        if($filename == "." || $filename == ".."){continue;}
        if(is_dir($loc)){
            $files = array_merge($files,$this->_dirToArray($loc,$_removePrefix));
        }
        else
        {
            $files[] = str_replace($_removePrefix, "", $loc);
        }
    }
    return $files;
}

function _getMediaFiles(){
    return $this->_dirToArray(JPATH_ROOT . "/images",JPATH_ROOT . "/");
}

function _qryRefCount($file){

    //TODO: categories.description needs scanning as well!
    $db = JFactory::getDBO();

    $qryCats = $db->getQuery(true)
    ->select('#__categories.path as articlepath')
    ->from('#__categories')
    ->where("#__categories.description LIKE '%{$file}%'");

    $query = $db->getQuery(true)
    ->select('CONCAT(#__categories.path,"/",#__content.`title`)as articlepath')
    ->from('#__content')
    ->from('#__categories')
    ->where("#__categories.id = #__content.catid AND (`introtext` LIKE '%{$file}%' OR `fulltext` LIKE '%{$file}%')")
    ->union($qryCats);

    $db->setQuery($query);
    return $db->loadColumn(0);
}

function getOrphanTable(){
    $_mediaFiles = $this->_getMediaFiles();
    $result = array();

    foreach($_mediaFiles as $_mediaFile){
        if(basename($_mediaFile) != "index.html"){
            $result[] = array(
                "file"     => $_mediaFile,
                "refs"     => $this->_qryRefCount($_mediaFile),
                "filesize" => filesize(JPATH_ROOT . "/" . $_mediaFile),
                "human_filesize" => $this->human_filesize(filesize(JPATH_ROOT . "/" . $_mediaFile))
                );
        }
    }

    usort($result,function($a, $b){
        $_d = sizeof($a["refs"]) - sizeof($b["refs"]); //Show least references first.
        $_f = $b["filesize"] - $a["filesize"]; //Show largest files first.

        if($_d < 0){
            return -1;
        }
        if($_d > 0){
            return 1;
        }

        if($_f < 0){
            return -1;
        }
        if($_f > 0){
            return 1;
        }

        return 0;
    });


    return $result;
}



}