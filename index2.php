<?php
ini_set("pcre.backtrack_limit", "5000000");
// Eğer komut satırında çalışıyorsa, bazı $_SERVER değişkenlerini tanımla
if (php_sapi_name() === 'cli') {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/';
    $_SERVER['SCRIPT_NAME'] = 'index.php';
    $_SERVER['HTTP_HOST'] = 'localhost';
}


if(isset($_COOKIE['utc'])) {
 date_default_timezone_set($_COOKIE['utc']); 
} else {
date_default_timezone_set('Europe/Istanbul');
}


/*
		ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

require_once __DIR__ . '/protected/modules/vendor/autoload.php';
$GLOBALS['news'] = array();
function t($str)
{
	if(defined($str) && trim(constant($str))!='' && trim(constant($str))!='-')
	{
		return trim(constant($str));
	}else
	{
		array_push($GLOBALS['news'] ,$str);
		return trim(''.$str.'');
	}
}
//bu kısım değişti backup deneme
// change the following paths if necessary
$cookie_name = "crmlanguage";
$cookie_value = "en";
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (isset($_GET['language']))
{
	$changelang=$_GET['language'];
	if(strlen($changelang)==2)
	{
		setcookie($cookie_name, $changelang, time() + (86400 * 30*12), "/");
		$actual_link=str_replace('language=', 'languageok=', $actual_link);
		header("Location: $actual_link");
		exit;
	}
}

$defaultlangfileurl= dirname(__FILE__).'/protected/modules/translate/languages/'.$cookie_value.'.php';
if(!isset($_COOKIE[$cookie_name]))   //cokie var mı kontrol ediyoruz
{	//cookie yoksa oluşturup değişkene varsayılan dili atıyoruz.
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/");
	$language=$cookie_value;
}
else
{	//cookie varsa kontrol ediyoruz.
	if (strlen($_COOKIE['crmlanguage'])==2)
	{	//cooike güvenlik şartlarını taşıyorsa dili ayarlıyoruz.
		$language=$_COOKIE['crmlanguage'];
	}else
	{	//cookie güvenlik şartlarını taşımıyorsa cookie tekrar oluşturuyoruz ve dili varsayılan dile ayarlıyoruz.
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/");
		$language=$cookie_value;
	}
}


	if(!isset($_REQUEST["deviceid"]) && !isset($_SERVER["HTTP_DEVICEID"]))
	{
		if(strstr($_SERVER['REQUEST_URI'],'/api/'))
		{
			$language="en";
		}
		// dili yüklüyoruz
		if (strlen($language)==2)
		{  //dili her ihtimale karşı yine güvenlik şartlarına tabi tutuyoruz.
			if(strstr($_SERVER['REQUEST_URI'],'/api/'))
			{
				$language="en";
			}
			$langfileurl= dirname(__FILE__).'/protected/modules/translate/languages/'.$language.'.php';
			if (file_exists($langfileurl)) //dil dosyasını arıyoruz.
			{	//dil dosyası varsa yüklüyoruz.
				include $langfileurl;
			}
			else //dil dosyası yoksa
			{
				if ($language<>$cookie_value) // dil varsayılan dilden farklıysa
				{ //default dili yüklüyoruz.
					setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/");
					include $defaultlangfileurl;
				}else  // dil varsayılan dil ile aynıysa
				{
					 // yapacak bir şey yok dil dosyası yok sistem çalışmaz
				}
			}
		}
		else
		{ // güvenlikten geçmezse
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/"); // varsayılan dili ayarla
			include $defaultlangfileurl; // varsayılan dili yükle
		}
	}else{
    if (isset($_GET['lang'])){
      		$langfileurl= dirname(__FILE__).'/protected/modules/translate/languages/'.$_GET['lang'].'.php';
		if (file_exists($langfileurl)) //dil dosyasını arıyoruz.
			{	//dil dosyası varsa yüklüyoruz.
				include $langfileurl;
			}
    }
                        if (isset($_SERVER["HTTP_LANG"])) {
                          

                          
                          
                        if ( strpos($_SERVER["HTTP_LANG"],"en" ) === false ) {
                             $ddil = "tr";
                        } else {
                           $ddil = "en";
                        }

                       		$langfileurl= dirname(__FILE__).'/protected/modules/translate/languages/'.$ddil.'.php';

                        include $langfileurl;

                    }
    
    
    
  }
//echo hello;
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
// remove the following lines when in production mode


if(isset($_GET['datahandebugccc'])) {
setcookie('datahandebugccc','1', time() + (86400 * 365 * 2), "/"); // 86400 = 1 day
}


defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once($yii);
if (php_sapi_name() === 'cli') {
    parse_str(implode('&', array_slice($argv, 1)), $_GET);
}


Yii::createWebApplication($config)->run();

