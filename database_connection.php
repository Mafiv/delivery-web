<?php

$host="Localhost";
$username="root";
$password="root";
$dbname="test";

$db=new mysqli($host,$username,$password,$dbname);

if($db->connect_error){

    die("connection failed  " .$db->connect_error);
}
else{
    // die("here we go");
}

?>