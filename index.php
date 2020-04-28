<?php
include( 'class.quick_mysqli.php' );

$db = new quick_mysqli( 'root', '', 'quick_mysqli', 'localhost' );
$db->connect();
$db->select();

echo '<pre>';

$selectQ = "SELECT * FROM _users";

echo 'selecting AS_RAW'.PHP_EOL;

$data = $db->get_results( $selectQ, null, AS_RAW);
//var_dump($data);
while ( $row = @$data->fetch_object() ){
    print_r($row);
}
echo '//--------------------------'.PHP_EOL;

//selecting OBJECT
echo 'selecting as OBJECT'.PHP_EOL;
$data = $db->get_results( $selectQ);
print_r($data);

//selecting OBJECT with Custom Index
echo '//--------------------------'.PHP_EOL;
echo 'selecting as OBJECT with Custom Index'.PHP_EOL;
$data = $db->get_results( $selectQ, 'firstname');
print_r($data);

//selecting ARRAY
echo '//--------------------------'.PHP_EOL;
echo 'selecting as ARRAY'.PHP_EOL;
$data = $db->get_results( $selectQ, null, ARRAY_A);
print_r($data);


//inserting data
echo '//--------------------------'.PHP_EOL;
echo 'inserting data'.PHP_EOL;

$insertData = array(
    'firstname' => 'Bakkas'
);
//$ret = $db->insert('_users', $insertData);
//print_r($ret);

//updating data
echo '//--------------------------'.PHP_EOL;
echo 'updating data'.PHP_EOL;

$updateData = array(
    'firstname' => 'Akkas 1'
);
$ret = $db->update('_users', $insertData, " pk_user_id = '11'");
print_r($ret);
exit();

//insert using the default query function
//$ret = $db->query("INSERT INTO _users (pk_user_id, firstname) VALUES(NULL,'Rakib'),(NULL,'Sakib')");
//print_r($ret);

//updating multiple rows
$ret = $db->query("UPDATE _users SET firstame='ZZZZ' WHERE pk_user_id='1000'");
print_r($ret);
print_r($db);
