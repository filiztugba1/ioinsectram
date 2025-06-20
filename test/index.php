<?php
$GLOBALS['is_api']=false; 
if (isset($_SERVER['HTTP_AUTHORIZATION']) && $_SERVER['HTTP_AUTHORIZATION']<>''){
	$GLOBALS['is_api']=true; 
}

$memcache = new Memcache;

$memcache->connect('127.0.0.1', 11211) or die ("Sunucuya Baglanilamiyor...");
/*
$count=0;
$dir    = '/home/ioinsectram/public_html/test/protected/views/';
function listFolderFiles1($dir)
{

    $ffs = scandir($dir);
  if (is_countable($ffs) && count($ffs)>0) {
    //echo 'xx'.count($ffs);
    return true;
  }else{
    return false;

  }
}
function listFolderFiles($dir,$deli='-',$tab=''){
  global $count;
   if(is_dir($dir)) {
          $deli.='-';
          $tab.='&emsp;';
   }
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    // prevent empty ordered elements
    if (count($ffs) < 1)
        return;

    foreach($ffs as $ff){
      if(!is_dir($dir.'/'.$ff)){
      $count=$count+1;
          echo $tab.$ff.'<br>';
        
      }else{
          echo $tab.$deli.$ff.'<br>';
      }
      //  echo ''.$count.'-'.$ff.PHP_EOL;
      
        if(is_dir($dir.'/'.$ff)) {
         
  listFolderFiles($dir.'/'.$ff,$deli, $tab); }
        echo '';
    }
}

listFolderFiles($dir);
print_r($files1);
$dir    = '/home/ioinsectram/public_html/test/protected/controllers/';
$files1 = scandir($dir);
$pattern='function acti';
$pattern = "/^.*$pattern.*\$/m";
foreach ($files1 as $file)
{
  echo '----->'.$file.PHP_EOL;
  $file = $dir.$file;
  $ora_books = preg_grep($pattern, file($file));


// the following line prevents the browser from parsing this as HTML.

// get the file contents, assuming the file to be readable (and exist)
$fh = fopen($file, 'r') or die($php_errormsg);
while (!feof($fh)) {
    $line = fgets($fh, 4096);
    if (preg_match($pattern, $line)) { 
      
      $ora_books[ ] = $line;  
      $line=str_replace("public function ","",$line);
      $line=explode('(',$line);
      echo trim($line[0]).PHP_EOL;
                                     
                                     }
 
}
fclose($fh);
// escape special characters in the query
// finalise the regular expression, matching the whole line
// search, and store all matching occurences in $matches

}
exit;

date_default_timezone_set('Europe/Istanbul');
*/
ob_start();
	/*	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/


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
function filecached($key,$folder="filecached"){
  
  $dir='./cached/'.$folder.'/';
  $ext='.flc';
  $key=md5($key);
  $file=$dir.$key.$ext;
  $splitter='<!.!*?xtimefinish>';
  if (!file_exists($file)){ return false; }
  
   $data=  file_get_contents($file,true);
  if($data<>''){
    $delimit=strpos($data, $splitter);
    $time = substr($data, 0, $delimit);
    if(!is_numeric($time)){
    //  echo 'siindi hata';
      unlink($file);
      return false;
    }
    if ($time-time()<0){
   //   echo 'siindi';
      unlink($file);
      return false;
    }
    return unserialize(substr($data,  strpos($data,$splitter)+strlen($splitter)));
  }else{
    return false;
  }
}

function setfilecached($key,$data,$time=10,$folder="filecached"){
  $dir='./cached/'.$folder.'/';
  $ext='.flc';
  $key=md5($key);
  $file=$dir.$key.$ext;
  $splitter='<!.!*?xtimefinish>';
  $time=time()+$time;
  $data=$time.$splitter.serialize($data);
  $data=  file_put_contents($file, $data);
}

function sqlcached($key,$folder="sqlcached"){
  return filecached($key,$folder);
}
function setsqlcached($key,$data,$time=10,$folder="sqlcached"){
  return setfilecached($key,$data,$time,$folder);
}

function api_response($data=[],$status=true,$status_code=200 ,$message = '')
{
  if ($GLOBALS['is_api'] || strpos($_SERVER['REQUEST_URI'], "site/login") !== false){
      if (!$status && $status_code==200){

        $status_code=404;
      }
    if ( $message ==''){

            switch($status_code)
            {
                case 400:
                    $message = 'You must be authorized to view this page.';
                    break;
              case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'Not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

    }

      http_response_code($status_code);

    header('Content-Type: application/json; charset=utf-8');
      if ($message==''){
          echo json_encode(['data'=>$data,'status'=>$status,'time'=>time()]);
      }else{
          echo json_encode(['data'=>$data,'status'=>$status,'message'=>$message,'time'=>time()]);
      }


       exit;
    }else{

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


	if(!isset($_REQUEST["deviceid"]))
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
	}
//echo hello;
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
// remove the following lines when in production mode


if(isset($_GET['datahandebug'])) {
setcookie('datahandebug','1', time() + (86400 * 365 * 2), "/"); // 86400 = 1 day
}


defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
