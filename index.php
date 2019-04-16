<?php 
include( 'class.quick_mysqli.php' );

$db = new quick_mysqli( 'root', '', 'quick_mysql_test_db', 'localhost' );
$db->connect();
$db->select();

//using AS_RAW in get_results()
$data = $db->get_results( "SELECT * FROM _users", null, AS_RAW);
echo '<pre>';
while ( $row = @$data->fetch_object() ){
    print_r($row);
} 
