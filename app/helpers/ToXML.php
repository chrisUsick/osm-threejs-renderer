<?php
/**
 * ToXML
 */
class ToXML
{
  function createElement($doc, $parent, $elemName, $nodeValue="", $notAppendElem=false)
  {
    $elem = $doc->createElement($elemName);
    $textNode = $doc->createTextNode($nodeValue);
    $elem->appendChild($textNode);
    if(!$notAppendElem){
      $parent->appendChild($elem);
    }
    return $elem;
  }

  public function toXML()
  {
    $res = new DOMDocument();
    $root = createElement($res, $res, get_class($this));
    foreach ($this as $key => $value) {
      createElement($res, $root, $key, $value);
    }
  }
}

 ?>
