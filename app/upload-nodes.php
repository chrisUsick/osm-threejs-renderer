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
function insert_node($node)
{
 global $db;
 $query = $db->prepare("INSERT INTO nodes (node_id, visible, coords)
  values (:id, :vis, ST_SetSRID(ST_MakePoint(:lat, :lon), 4326))");
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
foreach ($nodes as $node) {
  $success = insert_node(Node::fromXML($node));
  echo $success . " {$node->getAttribute('id')}" . "\n";
}
echo "{$nodes->length} nodes inserted";
 ?>
