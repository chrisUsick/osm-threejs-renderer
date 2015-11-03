<?php
/**
* process
* insert node into db
* insert ways into db
* relations aren't important right now
*/
require 'schema.php';
require 'config.php';
$xml = DOMDocument::load('map.osm');
// echo ($xml->getElementsByTagName("node")->item(0)->nodeName);
$db = getConnection();
function insert_node($node, $centerX, $centerY)
{
  global $db;
  $query = $db->prepare("INSERT INTO nodes (node_id, visible, coords)
    values (:id, :vis, ST_MakePoint(:lat, :lon))");
  $node->normalize($centerX, $centerY);
  return $query->execute($node->toArray());
}

function delete_nodes()
{
  global $db;
  $query = $db->prepare("DELETE FROM nodes");
  return $query->execute();
}

$del_success = delete_nodes();
echo $del_success;
// insert all nodes into db
$nodes = $xml->getElementsByTagName("node");
$bounds = $xml->getElementsByTagName("bounds")->item(0);
$centerX = (floatval($bounds->attributes->getNamedItem("maxlat")->value) + floatval($bounds->attributes->getNamedItem("minlat")->value))/2;
$centerY = (floatval($bounds->attributes->getNamedItem("maxlon")->value) + floatval($bounds->attributes->getNamedItem("minlon")->value))/2;
foreach ($nodes as $node) {
  $success = insert_node(Node::fromXML($node), $centerX, $centerY);
  echo $success . " {$node->getAttribute('id')}" . "\n";
}
echo "{$nodes->length} nodes inserted";
?>
