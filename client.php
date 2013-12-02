<?php
	include 'services.php';
	$servicesObj =new Services();
	$returnType = (isset($_POST['returnType']))?$_POST['returnType']:'json';

	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/
	$post_data_string = str_replace('\"','"',$_POST['post_data_string']);
	$value = json_decode($post_data_string);
	$method = $value->method;
	$data_string = $value->data_string;
	if(isset($method) && $method != ''){
		$result = $servicesObj->{$method}((array)$data_string);
		showData($result,$returnType);
	}else{
		echo "Method dosen't deifned.";
	}
	die();