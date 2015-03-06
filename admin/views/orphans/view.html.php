<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view' );
class OrphanViewOrphans extends JViewLegacy
{
    function display($tpl = null)
    {
        $this->oTable = $this->get('OrphanTable');


        $this->sumTable = array(
        	"ttl_files" => sizeof($this->oTable),
            "ttl_orphans"  => array_reduce($this->oTable, function($carry,$item){
                return $carry + (sizeof($item["refs"]) == 0 ? 1 : 0);
            },0),
            "ttl_size"  => $this->getModel()->human_filesize(array_reduce($this->oTable, function($carry,$item){
              return $carry + $item["filesize"];
          },0)),
            "ttl_wasted_size"  => $this->getModel()->human_filesize(array_reduce($this->oTable, function($carry,$item){
              return $carry + (sizeof($item["refs"]) == 0 ? $item["filesize"] : 0);
          },0)
            )
            );
        $this->graphs = array(
            "total" => array(
                "size" => array_reduce($this->oTable, function($carry,$item){
                    return $carry + $item["filesize"];
                },0),
                "files" => sizeof($this->oTable)
                ),
            "good"  => array(
                "size" => array_reduce($this->oTable, function($carry,$item){
                    return $carry + (sizeof($item["refs"]) > 1 ? $item["filesize"] : 0);
                },0),
                "files" => array_reduce($this->oTable, function($carry,$item){
                    return $carry + (sizeof($item["refs"]) > 1 ? 1 : 0);
                },0)
                ),
            "single"  => array(
                "size" => array_reduce($this->oTable, function($carry,$item){
                    return $carry + (sizeof($item["refs"]) == 1 ? $item["filesize"] : 0);
                },0),
                "files" => array_reduce($this->oTable, function($carry,$item){
                    return $carry + (sizeof($item["refs"]) == 1 ? 1 : 0);
                },0)
                ),
            "orphan"  => array(
                "size" => array_reduce($this->oTable, function($carry,$item){
                    return $carry + (sizeof($item["refs"]) == 0 ? $item["filesize"] : 0);
                },0),
                "files" => array_reduce($this->oTable, function($carry,$item){
                    return $carry + (sizeof($item["refs"]) == 0 ? 1 : 0);
                },0)
                )
            );

parent::display($tpl);
}
}
