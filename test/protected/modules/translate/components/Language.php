<?php

class Language extends CApplicationComponent
{
	public function encodechar($str)
	{
		return str_replace(
				array(
					"'", "\""
					),
				array(
					"&#39;", "&quot;"
				),
				$str
		);
	}
		public function decodechar($str)
	{
		return str_replace(
				array(
					"&#39;", "&quot;"
				),
				array(
					"'", "\""
					),

				$str
		);
	}
	public function createdir()
	{
		$path=Yii::app()->getModule('translate')->basePath;
		if (!file_exists($path.'/'.Yii::app()->getModule('translate')->dirpath))
		{
			mkdir($path.'/'.Yii::app()->getModule('translate')->dirpath, 0777, true);
		}
	}
	public function createlanguage($language,$temp='')
	{
		$this->createdir();
		$path=Yii::app()->getModule('translate')->basePath;
		$moduledirpath=Yii::app()->getModule('translate')->dirpath;

		if (!file_exists($path.'/'.$moduledirpath.'/'.$language.$temp.'.php'))
		{
			fopen($path.'/'.$moduledirpath.'/'.$language.$temp.'.php', "w");
		}
	}
	public function createtagfiles($languages=array())
	{

		$languages=$this->getlanguagenames();
		foreach ($languages as $language)
		{
			$path=Yii::app()->getModule('translate')->basePath;
			$moduledirpath=Yii::app()->getModule('translate')->dirpath;
			$this->createlanguage($language);
			$list=Translates::model()->findall(array('condition'=>'code= BINARY :lang','params'=>array('lang'=>$language)));
			$languagefile = fopen($path.'/'.$moduledirpath.'/'.$language.".php", "w");
			$defines = "<?php\n";
			$ss=array();
			foreach ($list as $item)
			{		$line='define("'.$this->encodechar($item->title).'", "'.$this->encodechar($item->value).'");'."\n";

				if (!in_array($item->title, $ss)) {
					array_push($ss,$item->title);
					$defines .= 'define("'.$this->encodechar($item->title).'", "'.$this->encodechar($item->value).'");'."\n";
				}
			}
			$defines .= "?>";
			fwrite($languagefile, $defines);
			fclose($languagefile);
		}
	}
	public function gettagfromdb($tag,$lang)
	{
		$item=Translates::model()->find(array('condition'=>'code= BINARY :lang and title= BINARY :tag','params'=>array('lang'=>$lang,'tag'=>$tag)));
		if ($item)
		{
		 return htmlentities($item->value);
		}
		else
		{
			return '';
		}
	}
	public function gettag($yazi)
	{
			//$yazi='bir="'." | 2='";
			define($this->encodechar($yazi),'deneme&quot;&quot;&quot;');
			echo $this->decodechar(constant($this->encodechar($yazi)));
	}
		public function getlanguagenames()
	{
		$items=Translatelanguages::model()->findall();
		$array=array();
		foreach ($items as $item)
		{
			array_push($array,$item->name);
		}
		return $array;
	}
			public function getlanguages()
	{
		$items=Translatelanguages::model()->findall();
		if ($items)
		{
			return $items;
		}
	}
		public function definedlanguage()
	{
		$cookie_value='en';
		if (strlen($_COOKIE['crmlanguage'])==2)
		{	//cooike g�venlik �artlar�n� ta��yorsa dili ayarl�yoruz.
			$language=$_COOKIE['crmlanguage'];
			return $language;
		}else
		{	//cookie g�venlik �artlar�n� ta��m�yorsa cookie tekrar olu�turuyoruz ve dili varsay�lan dile ayarl�yoruz.
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/");
			return $cookie_value;
		}
	}
	public function definedlanguageflag()
	{
		$cookie_value='en';
		if (strlen($_COOKIE['crmlanguage'])==2)
		{
			$language=$_COOKIE['crmlanguage'];
			$items=$this->getlanguages();
			if ($items)
			{
				foreach ($items as $item)
				{
					if ($item->name==$language)
					{
						 return $item->flag;
					}

				}
			}
		}else
		{
			return 'gb';
		}
	}
	public function addtagsfromarray($alltags)
	{
		$tags=	$alltags;

		foreach ($tags as $tag)
		{
			$gettag=Translates::model()->find(array('condition'=>'title= BINARY :tag','params'=>array('tag'=>$tag)));
			if (!$gettag && $tag!=null)
			{
				$item= new Translates;
				$item->title=$tag;
				$item->value=$tag;
				$item->code='en';
				$item->save();

				$languages=Translatelanguages::model()->findAll(array("condition"=>"name!='en'"));
				foreach ($languages as $language) {
					$model=new Translates;
					$model->title=$tag;
					$model->value="-";
					$model->code=$language->name;
					if(!$model->save())
					{
						var_dump($model->getErrors());
						echo '<br>';
					}
				}
			}

		}
		$this->createtagfiles();
	}
	public function autoload()
	{
	//	return 0;
	}
}

?>
