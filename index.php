<?php
include( 'class.quick_mysqli.php' );

$db = new quick_mysqli( 'root', '', 'quick_mysql_test_db', 'localhost' );
$db->connect();
$db->select();

echo '<pre>';

//using AS_RAW in get_results()
$data = $db->get_results( "SELECT  FROM _users", null, AS_RAW);
echo '<pre>';
var_dump($data);
while ( $row = @$data->fetch_object() ){
    print_r($row);
}
exit();

//insert using the default query function
//$ret = $db->query("INSERT INTO _users (pk_user_id, firstname) VALUES(NULL,'Rakib'),(NULL,'Sakib')");
//print_r($ret);

//updating multiple rows
$ret = $db->query("UPDATE _users SET firstame='ZZZZ' WHERE pk_user_id='1000'");
print_r($ret);
print_r($db);
