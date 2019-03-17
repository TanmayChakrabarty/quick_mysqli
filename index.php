<?php 
include( 'class.quick_mysqli.php' );

$db = new quick_mysqli( 'root', '', 'quick_mysql_test_db', 'localhost' );
$db->connect();
$db->select();

$data = $db->get_results( "SELECT * FROM _users", "pk_user_id", ARRAY_N );

echo '<pre>';
print_r($data);