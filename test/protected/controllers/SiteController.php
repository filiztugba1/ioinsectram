<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */



	public function isactiveuser()  //user,firma-branch-client-client branch aktifmi diye bakar
	{


		$user=User::model()->findbypk(Yii::app()->user->id);

		$isactive=1;




		if( isset($user->active) && $user->active==1)
		{
			if($user->firmid>0)
			{
				$firm=Firm::model()->findbypk($user->firmid);
				if($firm->active==0)
				{
					$isactive=0;
				}
			}

			if($user->mainbranchid>0 || $user->branchid>0)
			{
				$firm=Firm::model()->findbypk($user->mainbranchid);
				if($firm->active==0)
				{
					$isactive=0;
				}

				if($isactive==0)
				{
					$firm=Firm::model()->findbypk($user->branchid);
					if($firm->active==0)
					{
						$isactive=0;
					}
					else
					{
						$isactive=1;

					}
				}

			}

			if($user->clientid>0)
			{
				$firm=Client::model()->findbypk($user->clientid);
				if($firm->active==0)
				{

					$isactive=0;
				}
			}

			if($user->clientbranchid>0)
			{
				$firm=Client::model()->findbypk($user->mainclientbranchid);
				if($firm->active==0)
				{
					$isactive=0;
				}


				if($isactive==0)
				{
					$firm=Client::model()->findbypk($user->clientbranchid);
					if($firm->active==0)
					{
						$isactive=0;
					}
					else
					{
						$isactive=1;

					}
				}

			}

		}
		else
		{
			$isactive=0;
		}




		if($isactive==0)
		{


			Yii::app()->user->setFlash('error',t('Your membership is closed'));
			Yii::app()->user->logout();
		}


	}


	public function actionIndex()
	{
  
    
if (isset($_SERVER['HTTP_AUTHORIZATION']) && $_SERVER['HTTP_AUTHORIZATION']<>''){
	  $data = array();
		$data= array('Auth'=>'true');
   $yetkilistesi=User::model()->getuserauths();
   $data['yetkilistesi']=explode(',',implode(',',$yetkilistesi));
		api_response($data);
}
    
    
		$this->isactiveuser();

       if (Yii::app()->user->isGuest)
		   {
		      //Yii::app()->user->setFlash('error',t('Your membership has been disabled. Please contact the authorities for information!'));

				$this->redirect(Yii::app()->createUrl('site/login'));
		   }
	   else
		   {
     
				if (isset($_GET['changemode']))
				{  ///?changemode=Package1.SafranÇevre1.Admin
					User::model()->setauthdefault($_GET['changemode']);
				}else{

				}
		   }
		   $ax= User::model()->userobjecty('');

		 if(isset($_GET['ismaintenance']))
		 {

		  $systeminmaintenance=Systeminmaintenance::model()->find(array('condition'=>'id=1'));

    	    if(isset($_GET['ismaintenance']) && $_GET['ismaintenance']==0)
    	    {
    	        $systeminmaintenance->ismaintenance=0;

    	        Yii::app()->user->setFlash('pages/indexclient','Sistem Bakımdan çıkarıldı');
    	    }

    	     if(isset($_GET['ismaintenance']) && $_GET['ismaintenance']==1)
    	    {
    	         $systeminmaintenance->ismaintenance=1;

    	         Yii::app()->user->setFlash('pages/indexclient','Sistem Bakımdan alındı');
    	    }
	        $systeminmaintenance->createdtime=time();
	        $systeminmaintenance->save();
		 }
		  $systeminmaintenance=Systeminmaintenance::model()->find(array('condition'=>'id=1'));
		 if($systeminmaintenance->ismaintenance==1 && $ax->id!=1)
		 {
		      $this->redirect(Yii::app()->createUrl('site/login?site=bakimda'));
		 }








		   $user=User::model()->findbypk(Yii::app()->user->id);

		   if($user->mainbranchid!=$user->branchid && $user->branchid==$user->clientid)
		   {

		       $user->branchid=$user->mainbranchid;
		       $user->save();
		   }
		   if ($user->clientid<>0){
			 $this->render('pages/indexclient');
		   }else
		{
        
			 $this->render('pages/indexfirm');
			 //$this->render('index');
		}
	}

	public function GetIP(){
 if(getenv("HTTP_CLIENT_IP")) {
 $ip = getenv("HTTP_CLIENT_IP");
 } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
 $ip = getenv("HTTP_X_FORWARDED_FOR");
 if (strstr($ip, ',')) {
 $tmp = explode (',', $ip);
 $ip = trim($tmp[0]);
 }
 } else {
 $ip = getenv("REMOTE_ADDR");
 }
 return $ip;
}

	public function actionQuality()
	{
         $this->render('quality');
	}

	public function actionNewqr()
	{
		$QRs=array();
		$count=$_POST["adet"];
		for ($i=1;$i<=$count;$i++){


			$output=time()+rand(0,999999)+round(microtime(true) * 1000);
			$model=Monitoring::model()->findAll(array('condition'=>'barcodeno='.$output));
			if($model){}else{

				if(!in_array($output,$QRs))
				{
					array_push($QRs,$output);
				}

			}


		}
		include("./barcode/newBarcodelist.php");

	}

	public function actionCreatenewqr(){

		$this->render('createnewqr');
	}


	public function actionWorkorder()
	{
         $this->render('workorder');
	}

	public function actionReports()
	{
         $this->render('reports');
	}


	public function actionDetail()
	{

		 $this->render('detail');
	}

	public function actionConformitydeadline()
	{

		 $this->render('conformitydeadline');
	}

	public function actionCloseopenconformity()
	{
		$this->render('closeopenconformity');
	}

 
    public function actionLanglist(){
      $tranlateslanguage= Yii::app()->getModule('translate')->language->getlanguages();
      $list=[];
      foreach($tranlateslanguage as $item){
       
        $list[$item->name][]=['id'=>$item->id,'name'=>$item->name,'flag'=>$item->flag,'title'=>$item->title];
      }
        api_response($list);
 
   
  }


	public function actionReportssearch()
	{
		$firmid=$_POST['Reports']['firmid'];
		$branchid=$_POST['Reports']['branchid'];
		$team=$_POST['Reports']['team'];
		$staff=Workorder::model()->msplit($_POST['Reports']['staff']);
		$routeid=$_POST['Reports']['routeid'];
		$clientid=$_POST['Reports']['clientid'];
		$visittypeid=$_POST['Reports']['visittypeid'];
		$startdate=$_POST['Reports']['startdate'];
		$finishdate=$_POST['Reports']['finishdate'];

		 
	api_response(array('reports?firm='.$firmid.'&&branch='.$branchid.'&&team='.$team.'&&staff='.$staff.'&&route='.$routeid.'&&client='.$clientid.'&&visittype='.$visittypeid.'&&sdate='.$startdate.'&&fdate='.$finishdate));			
        
     Yii::app()->SetFlashes->add($model,t('Raport Search Success!'),array('reports?firm='.$firmid.'&&branch='.$branchid.'&&team='.$team.'&&staff='.$staff.'&&route='.$routeid.'&&client='.$clientid.'&&visittype='.$visittypeid.'&&sdate='.$startdate.'&&fdate='.$finishdate));

}



	/**
	 * This is the default 'crudlist' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionCrudlist()
	{

		   $this->render('crudlist');

	}

	public function actionMobile()
	{

		   $this->render('mobile');

	}

	public function actionConformityqrreports(){

		$this->render('conformityqrreports');
	}


	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

    public function actionServicereport()
    {
        if(isset($_POST["client_name"]))
        {
            $model=new Servicereport;

            $model->client_name=$_POST["client_name"];
            $model->date=$_POST["date"];
            $model->reportno=$_POST["reportno"];
            $visittypes = implode($_POST["visittype"], ', ');
            $model->visittype=$visittypes;
            $model->servicedetails=$_POST["servicedetails"];
            $model->trade_name=$_POST["trade_name"];
            $model->active_ingredient=$_POST["active_ingredient"];
            $model->amount_applied=$_POST["amount_applied"];
            $model->riskreview=$_POST["riskreview"];
            if($model->save())
            {
                $this->refresh();
            }
            else
            {
                print_r($model->getErrors());
            }
        }
        $this->render('servicereport');

    }



	public function randomPassword($length,$count, $characters) {


		// $length - the length of the generated password
		// $count - number of passwords to be generated
		// $characters - types of characters to be used in the password

		// define variables used within the function
			$symbols = array();
			$passwords = array();
			$used_symbols = '';
			$pass = '';

		// an array of different character types
			$symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
			$symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$symbols["numbers"] = '1234567890';
			$symbols["special_symbols"] = '!?~@#-_+<>[]{}';

			$characters = explode(",",$characters); // get characters types to be used for the passsword
			foreach ($characters as $key=>$value) {
				$used_symbols .= $symbols[$value]; // build a string with all characters
			}
			$symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1

			for ($p = 0; $p < $count; $p++) {
				$pass = '';
				for ($i = 0; $i < $length; $i++) {
					$n = rand(0, $symbols_length); // get a random character from the string with all characters
					$pass .= $used_symbols[$n]; // add the character to the password string
				}
				$passwords[] = $pass;
			}

			return $passwords; // return the generated password
	}




	public function actionForgotform()
	{

		$email=$_POST['LoginForm']['email'];
		$user=User::model()->find(array(
								   'condition'=>'email=:email','params'=>array('email'=>$email)
							   ));


		if($user)
		{

			  $password=$this->randomPassword(12,1,"lower_case,upper_case,numbers");
			  $password[0];
			  //$user->password=CPasswordHelper::hashPassword($password[0]);

			$user->code=$password[0];
			$user->update();

			Yii::import('application.extensions.phpmailer.JPhpMailer');
			$mail = new JPhpMailer;
			$mail->IsSMTP();
			$mail->Host = 'mail.insectram.io';
			$mail->SMTPAuth = true;
			$mail->Username = 'info@insectram.io';
			$mail->Port='587';
			$mail->Password = '@datahan2018';
			$mail->SetFrom('info@insectram.io', 'Insectram Info');
			$mail->Subject = 'New Password';
			$mail->AltBody = Yii::app()->getBaseUrl(true).'/site/login?code='.$password[0];
			$mail->MsgHTML('<h3>Please click on the following link to change password.</h3>
							<p>'.Yii::app()->getBaseUrl(true).'/site/login?code='.$password[0].'</p>');
			$mail->AddAddress($email, $user->name.' '.$user->surname);
			$mail->Send();
      api_response('ok');		
    
			Yii::app()->SetFlashes->add($user,t('Success!Please see your email'),array('login'));

			$this->redirect(array('logintemp'));

		}

	}


	public function actionCreatepassword()
	{
		$user=User::model()->find(array(
								   'condition'=>'code=:code','params'=>array('code'=>$_GET['code'])
							   ));

		if($user)
		{
			$user->password=$user->password=CPasswordHelper::hashPassword($_GET['password']);
			$user->code="";
			if($user->update())
			{
         api_response('ok');		
				echo "success";
			}
			else
			{
         api_response('error',false);		
				echo "danger";
			}
		}
		else
		{
           api_response('error',false);		
			echo "danger";
		}



	}



	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
    
    /*
      if (isset($_SERVER['HTTP_AUTHORIZATION']) && $_SERVER['HTTP_AUTHORIZATION']<>''){
          $data = array();
          $data= array('alper'=>'1');
          api_response($data);
      }*/
      
		$this->layout='login';

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}



		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			session_start();
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
        

				$user=User::model()->findbypk(Yii::app()->user->id);
       
        $firmid=$user->firmid!=0?Firm::model()->findbypk($user->firmid):null;
        $firmUserName='';
        if(!empty($firmid))
        {
          $firmUserName=$firmid->username;
        }
          $token = array(
          "id" =>$user->id,
         /* "firmid" => $user->firmid,
          "mainbranchid" => $user->mainbranchid,
          "branchid" => $user->branchid,
          "clientid" => $user->clientid,
          "clientbranchid" => $user->clientbranchid,
          "mainclientbranchid" => $user->mainclientbranchid,
          */
          "username" => $user->username,
         
          "exp" => time()+3600
          );

          $jwt = Yii::app()->JWT->encode($token);
          $_SESSION['token']=$jwt;
          
//           if(isset($_GET['api'])){
//             $data = array();
//              api_response($jwt);
//           }
          
          

//           $decode = Yii::app()->JWT->decode($jwt);
//           var_dump($decode);

        
 			 //giriş logları
 			 $userlog=new Userlog;
 			 $userlog->userid=$user->id;
 			 $userlog->username=$user->username;
 			 $userlog->name=$user->name;
 			 $userlog->surname=$user->surname;
 			 $userlog->email=$user->email;
 			 $userlog->ipno=getenv("REMOTE_ADDR");
			 $userlog->ismobilorweb="web";
 			 $userlog->entrytime=time();
 			 $userlog->save();
        api_response(['token'=>$jwt,'name_surname'=>$user->name.' '.$user->surname]);
					/*

					if(isset($_POST['LoginForm']['rememberMe']))
					{
						$_SESSION['username']=$_POST['LoginForm']['username'];
					$_SESSION['password']=$_POST['LoginForm']['password'];
						$login=array('username'=>$_POST['LoginForm']['username'],'password'=>$_POST['LoginForm']['password']);
						$login=json_encode($login);
						setcookie('goindex',$login,time()+60*60*7);

					}
					*/
				// $this->redirect(Yii::app()->user->returnUrl,["token"=>$jwt]);
        exit;
			}else
			{
        echo 'no';exit;  
				Yii::app()->SetFlashes->add($model,t('Loged in!'),array('login'));
        

			}
		}

		// display the login form

		$this->render('logintemp',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();


		/*
			$login=(array) json_decode($_COOKIE['giris']);
			$login=array('username'=>$login['username'],'password'=>$login['password']);
			$login=json_encode($login);
						setcookie('goindex',$login,time()-60*60*7);

						*/

		//$this->redirect(Yii::app()->homeUrl);
		$this->redirect(Yii::app()->createUrl('site/login'));
	}
}
