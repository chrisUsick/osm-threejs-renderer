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
    $query = $db->prepare("SELECT (MAX(latitude)-MIN(latitude))/2 AS lat, (MAX(longitude)-MIN(longitude))/2 as lon FROM nodes;");
    $query->execute();
    if ($query->rowCount() > 0){
      $row = $query->fetch(PDO::FETCH_ASSOC);
      $xml = new DOMDocument();
      $center = createElement($xml, $xml, 'center');
      createElement($xml, $center, 'latitude', $row['lat']);
      createElement($xml, $center, 'longitude', $row['lon']);
      return $xml->saveXML();
    }
  }
}

 ?>
