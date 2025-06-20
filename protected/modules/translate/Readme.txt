Kurulum Yönergeleri

1-) Bu klasörü (translate), public_html/protected/modules altýna kopyalayýn
2-) public_html/protected/config/main.php sayfasýný açýn
3-) 	
'modules'=>array(
//////////// burasý baþlangýç altta yazýlaný modules in içine kurala uygun ekle
		'translate'=>array(
					'components'=>array(
						'language'=>array(
							'class'=>'Language',						            
						),
					),
							'parametre'=>20, // iþe yaramaz ama silme
							'dirpath'=>'languages',	// silme
				),
				/////////// burasý bitiþ
				'gii'=>array
4-)  public_html/index.php sayfasýnýn içine en üste ekle

$GLOBALS['news'] = array();
function t($str)
{
	if(defined($str))
	{
		return constant($str);
	}else
	{
		array_push($GLOBALS['news'] ,$str);
		return '___'.$str.'___';
	}
}



//bu kýsým deðiþti backup deneme
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
if(!isset($_COOKIE[$cookie_name]))   //cokie var mý kontrol ediyoruz
{	//cookie yoksa oluþturup deðiþkene varsayýlan dili atýyoruz.
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/"); 
	$language=$cookie_value;
}
else 
{	//cookie varsa kontrol ediyoruz.
	if (strlen($_COOKIE['crmlanguage'])==2)
	{	//cooike güvenlik þartlarýný taþýyorsa dili ayarlýyoruz.
		$language=$_COOKIE['crmlanguage'];
	}else
	{	//cookie güvenlik þartlarýný taþýmýyorsa cookie tekrar oluþturuyoruz ve dili varsayýlan dile ayarlýyoruz.
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/"); 
		$language=$cookie_value;
	}
}

// dili yüklüyoruz
if (strlen($language)==2) 
{  //dili her ihtimale karþý yine güvenlik þartlarýna tabi tutuyoruz. 
	$langfileurl= dirname(__FILE__).'/protected/modules/translate/languages/'.$language.'.php';
	if (file_exists($langfileurl)) //dil dosyasýný arýyoruz. 
	{	//dil dosyasý varsa yüklüyoruz.
		include $langfileurl;	
	}
	else //dil dosyasý yoksa 
	{	
		if ($language<>$cookie_value) // dil varsayýlan dilden farklýysa 
		{ //default dili yüklüyoruz.
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/"); 
			include $defaultlangfileurl;
		}else  // dil varsayýlan dil ile aynýysa
		{
			 // yapacak bir þey yok dil dosyasý yok sistem çalýþmaz
		}
	}
}
else
{ // güvenlikten geçmezse
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/"); // varsayýlan dili ayarla
	include $defaultlangfileurl; // varsayýlan dili yükle
}

5-) Veritabanýna
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `translatelanguages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `flag` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `translatelanguages` (`id`, `name`, `title`, `flag`) VALUES
(1, 'en', 'English', 'gb'),
(8, 'tr', 'Turkish', 'tr');

CREATE TABLE `translates` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL COMMENT 'sayfa içlerinde kullanacaðýmýz kýsa açýklamalar',
  `value` text NOT NULL COMMENT 'çeviri içeriði',
  `code` varchar(50) NOT NULL COMMENT 'dil kodu'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `translatelanguages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `translates`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `translatelanguages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

 ALTER TABLE `translates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

6-) footera <?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?> ekle

7-)<?=t('Homepage');?>   Bu þekilde taglarý kullanýyoruz