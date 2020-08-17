<?php

include_once "php/lib.php";
include_once "php/questions.php";
include_once "php/dyn.php";
include_once "php/frontend.php";


function action( $action ) {
   switch( $action ) {
       case "protocol": 
    		$result = filter_var( $_REQUEST['result'], FILTER_SANITIZE_STRING);
    		$topic  = filter_var( $_REQUEST['topic'], FILTER_SANITIZE_STRING);
    		$set    = filter_var( $_REQUEST['set'], FILTER_SANITIZE_STRING);
    		$questionId = filter_var( $_REQUEST['questionId'], FILTER_SANITIZE_STRING);
 		return json_encode( saveTry( $topic, $set, $questionId, $result ) );
       
       default:
    		return json_encode( array("Error" => "unknown request: " .  $action ) );
	
    }
}

session_start(); 
if(!isset($_SESSION["loggedIn"])){
	$_SESSION["loggedIn"] = false;
} 

if( isset(  $_REQUEST['action'] ) ) {
    $action = filter_var( $_REQUEST['action'], FILTER_SANITIZE_STRING);
    $content = action( $action );
 
} else {
    $app_info = array(
        "appName" => "BoS Gallery Manager", 
	"apiVersion" => "0.1"); 

    $content= json_encode($app_info); 
} 

echo $content;
?> 
