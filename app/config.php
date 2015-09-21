<?php
define('DB_DSN','pgsql:host=localhost;port=5432;dbname=osm;');
define('DB_USER','postgres');
define('DB_PASS','postgres');
function getConnection()
{
  $db = new PDO(DB_DSN, DB_USER, DB_PASS);
  $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  return $db;
}
 ?>
