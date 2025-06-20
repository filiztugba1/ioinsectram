<?php
class SetFlashes extends CWebUser {

	function add($flashes,$body='',$redirect=array())
	{ // $flashes modelden gelen errorlar olmalý.
		 $arr=(array)$flashes;
		 $result=array();
		 foreach($arr as $a=>$t){
			if (strpos($a,'errors'))
			{
			
				$result=$t;
			}
		 }
		if ($result<>array())
		{
			foreach((object)$result as $key => $message)
			{
				foreach ($message as $a)
				{
					$content.=$a.'<br>';
				}
			}
			Yii::app()->user->setflash('error',$content);
		}else
		{
			Yii::app()->user->setflash('success',$body);
			if($redirect<>array())
			{
				Yii::app()->getController()->redirect($redirect);
			}
		}
	}
}

?>