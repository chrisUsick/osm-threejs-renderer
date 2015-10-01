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
$db = new PDO(DB_DSN, DB_USER, DB_PASS);
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


function insert_way($way){
  global $db;
  $query = $db->prepare("INSERT INTO ways (way_id, visible)
    values (:id, :vis)");
  $way_arr = $way->toArray();
  $query->execute($way_arr);
}

function insert_way_nodes($way)
{
  global $db;
  $nds = $way->get_node_refs();
  for ($i = 0; $i < count($nds); $i++) {
    $nd = $nds[$i];
    // $seq_id = array_search($nd, $nds);
    echo "inserting node in sequence $i; \n";
    $query = $db->prepare("INSERT INTO way_nodes (way_id, node_id, sequence_id)
      values (:way_id, :node_id, :sequence_id)");
    $params = array("way_id"=>$way->id, "node_id"=>$nd, "sequence_id"=>$i);
    if ($way->id == 32529049 && $nd == 365793340) {
      // echo $way->id;
    }
    $query->execute($params);
  }
}

function delete_ways()
{
  global $db;
  // delete cascade on forgien key of way_nodes ensures
  // all way_nodes are deleted too
  $query = $db->prepare("DELETE FROM ways;");
  $deleteWayNodes = $db->prepare(" DELETE FROM way_nodes");
  return ($query->execute() && $deleteWayNodes->execute());
}

$del_success = delete_ways();
if ($del_success) {
  echo "delete succeeded\n";
}
// insert all nodes into db
$ways = $xml->getElementsByTagName("way");
foreach ($ways as $wayXML) {
  // print_r($wayXML);
  $way = Way::fromXML($wayXML);
  echo "inserting way: $way->id; \n";
  $success = insert_way($way);
  $nd_success = insert_way_nodes($way);
  // echo "$success $nd_success " . " {$wayXML->getAttribute('id')}" . "\n";
}
echo "{$ways->length} ways inserted";
 ?>
