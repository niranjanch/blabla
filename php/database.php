<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with password 'root') */
$link = mysqli_connect("localhost", "root", "root", "demo");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Attempt create table query execution
// $sql = "CREATE TABLE ".$table."(person_id INT(4) NOT NULL PRIMARY KEY AUTO_INCREMENT, first_name CHAR(30) NOT NULL, last_name TEXT, email_address VARCHAR(50))";
// foreach($temparray as $field) {
//     $sql .= ' ' . $field . ' VARCHAR( 40 ),';
// }
// $sql .= ' PRIMARY KEY ( `id` ))';
// if (mysqli_query($link, $sql)){
//     echo "Table persons created successfully";
//     exit();
// } else {
//     echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
//     exit();
// }