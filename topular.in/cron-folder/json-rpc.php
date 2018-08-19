<?php
require_once('includes/jsonRPCClient.php');

$google_rpc = new jsonRPCClient('https://clients6.google.com/rpc?key=AIzaSyCKSbrvQasunBoV16zDH9R33D88CeLr9gQ');


$data = array(
	"jsonrpc" => "2.0",
	"method" => "pos.plusones.get",
	"id" => "p",
	"params" => array(
		"nolog" => true,
		"id" => "%%URL%%",
		"source" => "widget",
		"userId" => "@viewer",
		"groupId" =>"@self"
		),
	"key" => "p",
	"apiVersion" => "v1"
	);
	
print_r ($data);