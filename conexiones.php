<?php
error_reporting(0);
session_start();

$database = 'forjadeartilugios';
$username = 'root';
$password = '';

try 
{ 
    $conn = new PDO("mysql:host=localhost;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch(Exception $e) 
{  
    die(print_r($e->getMessage()));
};

?>