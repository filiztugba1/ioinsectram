Kurulum Y�nergeleri

1-) Bu klas�r� (translate), public_html/protected/modules alt�na kopyalay�n
2-) public_html/protected/config/main.php sayfas�n� a��n
3-) 	
'modules'=>array(
//////////// buras� ba�lang�� altta yaz�lan� modules in i�ine kurala uygun ekle
		'translate'=>array(
					'components'=>array(
						'language'=>array(
							'class'=>'Language',						            
						),
					),
							'parametre'=>20, // i�e yaramaz ama silme
							'dirpath'=>'languages',	// silme
				),
				/////////// buras� biti�
				'gii'=>array
4-)  public_html/index.php sayfas�n�n i�ine en �ste ekle

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



//bu k�s�m de�i�ti backup deneme
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
if(!isset($_COOKIE[$cookie_name]))   //cokie var m� kontrol ediyoruz
{	//cookie yoksa olu�turup de�i�kene varsay�lan dili at�yoruz.
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/"); 
	$language=$cookie_value;
}
else 
{	//cookie varsa kontrol ediyoruz.
	if (strlen($_COOKIE['crmlanguage'])==2)
	{	//cooike g�venlik �artlar�n� ta��yorsa dili ayarl�yoruz.
		$language=$_COOKIE['crmlanguage'];
	}else
	{	//cookie g�venlik �artlar�n� ta��m�yorsa cookie tekrar olu�turuyoruz ve dili varsay�lan dile ayarl�yoruz.
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/"); 
		$language=$cookie_value;
	}
}

// dili y�kl�yoruz
if (strlen($language)==2) 
{  //dili her ihtimale kar�� yine g�venlik �artlar�na tabi tutuyoruz. 
	$langfileurl= dirname(__FILE__).'/protected/modules/translate/languages/'.$language.'.php';
	if (file_exists($langfileurl)) //dil dosyas�n� ar�yoruz. 
	{	//dil dosyas� varsa y�kl�yoruz.
		include $langfileurl;	
	}
	else //dil dosyas� yoksa 
	{	
		if ($language<>$cookie_value) // dil varsay�lan dilden farkl�ysa 
		{ //default dili y�kl�yoruz.
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/"); 
			include $defaultlangfileurl;
		}else  // dil varsay�lan dil ile ayn�ysa
		{
			 // yapacak bir �ey yok dil dosyas� yok sistem �al��maz
		}
	}
}
else
{ // g�venlikten ge�mezse
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/"); // varsay�lan dili ayarla
	include $defaultlangfileurl; // varsay�lan dili y�kle
}

5-) Veritaban�na
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
  `title` text NOT NULL COMMENT 'sayfa i�lerinde kullanaca��m�z k�sa a��klamalar',
  `value` text NOT NULL COMMENT '�eviri i�eri�i',
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

7-)<?=t('Homepage');?>   Bu �ekilde taglar� kullan�yoruz