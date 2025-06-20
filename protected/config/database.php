<?php

// This is the database connection configuration.
if (strpos($_SERVER['HTTP_HOST'],'velopment.insect')>=1)
{


	return array(
		'connectionString' => 'mysql:host=localhost;dbname=ioinsect_development',
		'emulatePrepare' => true,
		'username' => 'root',
		'password' => '',
		'charset' => 'utf8',
		'enableProfiling' => true,
		'enableParamLogging' => true,
		'schemaCachingDuration' => 3600,
	);
}else
{
	return array(
		'connectionString' => 'mysql:host=localhost;dbname=ioinsect_development',
		'emulatePrepare' => true,
		'username' => 'root',
		'password' => '',
		'charset' => 'utf8',
		'enableProfiling' => true,
		'enableParamLogging' => true,
		'schemaCachingDuration' => 3600,
	);
}
/*

	return array(
		'connectionString' => 'mysql:host=localhost;dbname=ioinsect_development',
		'emulatePrepare' => true,
		'username' => 'root',
		'password' => '',
		'charset' => 'utf8',
		'enableProfiling' => true,
		'enableParamLogging' => true,
		'schemaCachingDuration' => 3600,
	);
	

return array(
		'connectionString' => 'mysql:host=194.163.129.105;dbname=ioinsect_development',
		'emulatePrepare' => true,
		'username' => 'ioinsect_one2',
		'password' => '@@Safran2025!',
		'charset' => 'utf8',
		'enableProfiling' => true,
		'enableParamLogging' => true,
		'schemaCachingDuration' => 3600,
	);

	return array(
		'connectionString' => 'mysql:host=194.163.129.105;dbname=ioinsect_one',
		'emulatePrepare' => true,
		'username' => 'ioinsectram_filiz',
		'password' => '@@Safran2025!',
		'charset' => 'utf8',
		'enableProfiling' => true,
		'enableParamLogging' => true,
		'schemaCachingDuration' => 3600,
	);

return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=localhost;dbname=ioinsect_one',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => 'rHuL5x9CtScam',
	'charset' => 'utf8',
);
*/