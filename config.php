<?php
$config = array(
	'host' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'bible'
);

$db = new mysqli(
			$config['host'],
			$config['username'],
			$config['password'],
			$config['database']
		);

if (mysqli_connect_errno()) {
	echo 'An error occured. Please try again later.';
	exit;
}