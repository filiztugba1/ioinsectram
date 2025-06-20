<?php

// This is the database connection configuration.
if (strpos($_SERVER['HTTP_HOST'],'velopment.insect')>=1)
{


return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=localhost;dbname=ioinsect_development',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => 'rHuL5x9CtScam',
	'charset' => 'utf8',
);
}else
{
	return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=localhost;dbname=ioinsect_development',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => 'rHuL5x9CtScam',
	'charset' => 'utf8',
);
}
