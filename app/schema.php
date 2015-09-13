<?php
/**
 * Arrayable
 */
class Arrayable
{
  public function toArray() {
   $res = array();
   foreach ($this as $key => $value) {
     $res[$key] = $value;
   }
   return $res;
  }
}


/**
* Node
*/
class Node extends Arrayable
{
 public $id;
 public $lat;
 public $lon;
 public $vis;
 function __construct($id, $lat, $lon, $vis)
 {
   $this->id = $id;
   $this->lat = $lat;
   $this->lon = $lon;
   $this->vis = $vis;
 }
 public function fromXML($node)
 {
   return new Node($node->getAttribute('id'),
    $node->getAttribute('lat'),
    $node->getAttribute('lon'),
    $node->getAttribute('visible')
  );
 }

}

/**
 * way
 */
class Way extends Arrayable
{
  public $id;
  public $vis;
  private $node_refs;
  function __construct($id, $vis, $node_refs=array())
  {
    $this->id = $id;
    $this->vis = $vis;
    $this->node_refs = $node_refs;
  }

  public static function fromXML($node)
  {
    $node_refs = array();
    foreach ($node->getElementsByTagName("nd") as $nd) {
      array_push($node_refs, $nd->getAttribute("ref"));
    }
    return new Way($node->getAttribute("id"),
      $node->getAttribute("visible"),
      $node_refs);
  }

  public function get_node_refs()
  {
    return $this->node_refs;
  }
}

 ?>
