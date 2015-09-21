<?php
header ("Content-Type:text/xml");
require 'config.php';
require 'helpers/ToXML.php'
/**
 * CenterNodes
 */
class CenterNodes extends ToXML
{
  public $nodes = array();
  function __construct()
  {

  }
}

 ?>
