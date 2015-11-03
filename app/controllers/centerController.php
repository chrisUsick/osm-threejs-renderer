<?php
header ("Content-Type:text/xml");
require 'config.php';


function createElement($doc, $parent, $elemName, $text="", $notAppendElem=false)
{
  $elem = $doc->createElement($elemName);
  $textNode = $doc->createTextNode($text);
  $elem->appendChild($textNode);
  if(!$notAppendElem){
    $parent->appendChild($elem);
  }
  return $elem;
}

/**
 * Center
 */
class Center
{

  function __construct()
  {

  }
  public function index ()
  {
    $db = getConnection();
    $query = $db->prepare("SELECT (MAX(ST_X(coords))+MIN(ST_X(coords)))/2 AS lat, (MAX(ST_Y(coords))+MIN(ST_Y(coords)))/2 as lon FROM nodes;");
    $query->execute();
    if ($query->rowCount() > 0){
      $row = $query->fetch();
      json_encode(['x'=>$row['x']])
    }
  }
}

 ?>
