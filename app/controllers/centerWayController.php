<?php
require 'config.php';
class CenterWay {
  function __construct() {

  }

  public function index()
  {
    $db = getConnection();
    $query = $db->prepare("SELECT ST_X(coords) x, ST_Y(coords) z
                          from nodes natural join way_nodes natural join ways
                          where way_id = (select way_id
                          from nodes natural join way_nodes natural join ways
                          group by (way_id)
                          order by avg(ST_DISTANCE(st_makePoint(0,0), coords))
                          limit 1)
                          order by sequence_id");
    $success = $query->execute();
    $nodes = array();
    while ($row = $query->fetch()) {
      $nodes[] = ['x'=>$row['x'], 'z'=>$row['z']];
    }

    return json_encode($nodes);
  }
}

?>
