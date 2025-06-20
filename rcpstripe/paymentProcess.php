<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//27:plan_FY2TD3gdFYUxrD
//67:plan_FY5D6akpjhvwEz
//97:plan_FY5EQDFDVljTd3

// use PHPMailer\PHPMailer\PHPMailer;
/*
$products=array(
	"pids"=>['1','2','3','4','5','6','7','8','9','10','11','12'],
	"1"=>"plan_FiBEWgB1G25qxv",
	"2"=>"plan_FiBF4Cnx4Jdbr9",
	"3"=>"plan_Fi9xqxrYlMsxV8",
	"4"=>"plan_Fi9yr5AcF9fUSq",
	"5"=>"plan_FiA0OnaCFzh2va",
	"6"=>"plan_FiA1sDci9pWdpl",
	"7"=>"plan_FiA2TNFDxtmxzu",
	"8"=>"plan_FiA3euhkvbU40b",
	"9"=>"plan_FiA3saOWlk1BER",
	"10"=>"plan_FiA4PqBeFc4oyy",
	"11"=>"plan_FiA5rYi8kouePz",
	"12"=>"plan_FiA6Q9f1M8gvaV",
);
*/

$products=array(
	"pids"=>['1','2','3','4','5','6','7','8','9','10','11','12','13'],
	"1"=>"plan_GDdF6vUHQoTl1k",
	"2"=>"plan_GDdF5Wn6tB9s6c",
	"3"=>"plan_GDdfmnUPt40ENQ",
	"4"=>"plan_GDdf1sb5DWk6gs",
	"5"=>"plan_GDdkhA9TDQ0krw",
	"6"=>"plan_GDdjZZ9yVL7LxM",
	"7"=>"plan_GDdmGtvgRwfipI",
	"8"=>"plan_GDdlojGNJ4LSBs",
	"9"=>"plan_GDdomIdUYkUkXP",
	"10"=>"plan_GDdnQVIqoYqEKc",
	"11"=>"plan_GDdq6X6eVqgMNE",
	"12"=>"plan_GDdpMgJaP1SS0S",
	"13"=>"plan_GDfdfHNWjMN1ES",
);


$products2=array(
	"1"=>1400,
	"2"=>15120,
	"3"=>1900,
	"4"=>20520,
	"5"=>4900,
	"6"=>52920,
	"7"=>11900,
	"8"=>128520,
	"9"=>23900,
	"10"=>258120,
	"11"=>47900,
	"12"=>517320,
	"13"=>0,
);


if(isset($_GET["pidm"]))
{
	 $pid=$_GET['pidm'];

}
else
{
	 $pid=$_GET['pidy'];

}
// echo $_POST['isrecurringst'];


if((!isset($_GET["pidm"]) && !isset($_GET["pidy"])) || !in_array($pid,$products['pids']) || !isset($_POST['stripeToken']) || !isset($_POST['stripeEmail'])){
	// header('Location:index.php');
	exit;
}

require_once('stripe-php-6.41.0/init.php');


	 $token  = $_POST['stripeToken'];
		  $email  = $_POST['stripeEmail'];

		 
/*
$stripe = [
  "secret_key"      => "sk_test_07owkC6bYWsmj2io57IY7kZ900b8Twri2J",
    "publishable_key" => "pk_test_nY6Nz1MJpUxsXqpCLnqHS2Xs00zqpszcNa",
];
*/
$stripe = [
  "secret_key"      => "sk_live_9EYQ9brftra5XEY8olclYlFF00PJ66qs6F",
    "publishable_key" => "pk_live_aRMc2XQf3hLumCXZHZFgcyb400BkXAJYPc",
];



\Stripe\Stripe::setApiKey($stripe['secret_key']);

		$pid=$_GET['pid'];
		 $token  = $_POST['stripeToken'];
		  $email  = $_POST['stripeEmail'];

		  $customer = \Stripe\Customer::create([
			  'email' => $email,
			  'source'  => $token,
		  ]);
			if(isset($_GET["pidm"]))
			{
				 $pid=$_GET['pidm'];

			}
			else
			{
				 $pid=$_GET['pidy'];

			}

if($_POST['isrecurringst']==1)
{
	\Stripe\PaymentIntent::create([
		'amount' => $products2[$pid],
		'currency' => 'gbp',
	]);

}
if($_POST['isrecurringst']==2)
{
	\Stripe\Subscription::create([
	  "customer" =>$customer->id, 
	  "items" => [
		[
		  "plan" => $products[$pid],
		],
	  ]
	]);
}



		$servername="localhost";
		$username="root";
		$password="rHuL5x9CtScam";
		$dbname="ioinsect_one";
		$usertable="translates";
		$yourfield = "value";

		
	

		// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 

		$password="qwertzuioplkjhgfdsayxcvbnm1234567890";
		$password=str_shuffle($password);
		$password=strtoupper(substr($password,0,10));
		$epassword=password_hash($password,PASSWORD_BCRYPT);
		$time=time();



			$sql = "UPDATE firm SET active=0 WHERE id=".$_GET['firm'];
			
			// echo $_GET['firm'];

			if ($conn->query($sql) === TRUE) {

?>
				<div style="    text-align: center; margin-top: 14%; font-size: 40px; color: #059a12;">Payment successfully!</div>
				<div style="text-align:center;margin-top:10px;font-size:40px">Please check your e-mail and you can enter the system by entering your password</div>
				<?php			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
						$useractivasyon='';
						$username='';
						$useremail='';
						$queryasigment = "SELECT * FROM user where firmid=".$_GET['firm'];

						$dataasigment=mysqli_query($conn,$queryasigment);   
						while($rowas=mysqli_fetch_array($dataasigment))
						{
							$useractivasyon=$rowas['code'];
							$username=$rowas['username'];
							$useremail=$rowas['email'];
						}





			


	require_once("class.phpmailer.php");
// Aktivasyon mail
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = "mail.insectram.io";
	$mail->SMTPAuth = true;
	$mail->Username = "info@insectram.io";
	$mail->Password = "@datahan2018";
	$mail->Port='587';
	$mail->SetLanguage("tr", "phpmailer/language");
	$mail->From = "info@insectram.io";
	$mail->Fromname ='insectram';
	$mail->AddAddress($email,$username);
	$mail->AddReplyTo('info@insectram.io', 'Password entry');
	$mail->Subject ="Insectram Payment Success.Your Login Details";
	$mail->isHTML(true);
	$mail->Body ="Hey<br><br>Thank you for the purchase. Your login details are below.<br><b>Username</b>:$username<br>Please update your new password <a href='https://insectram.io/site/login?code=".$useractivasyon."'<br><br>https://insectram.io/site/login?code=".$useractivasyon."</a><br>Thanks,<br>Insectram";

	if(!$mail->Send())
	{
	   echo '<font color="#F62217"><b>Gönderim Hatası: ' . $mail->ErrorInfo . '</b></font>';
	   exit;
	}
	echo '<font color="#41A317"><b>Message sent successfully.</b></font></br><a href="https://www.insectram.co.uk/"><button style="
	    background: #059a12;
    padding: 7px;
    margin-top: 9px;
    color: #fff;
    border-radius: 5px;
    border: 1px solid #04780e;cursor: pointer;">Home Page</button></a>';






// yeni firma bilgi mail
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = "mail.insectram.io";
	$mail->SMTPAuth = true;
	$mail->Username = "info@insectram.io";
	$mail->Password = "@datahan2018";
	$mail->Port='587';
	$mail->SetLanguage("tr", "phpmailer/language");
	$mail->From = "info@insectram.io";
	$mail->Fromname ='insectram';
	$mail->AddAddress("info@insectram.io","New company payment");
	$mail->AddReplyTo('fcurukcu@gmail.com', 'New company payment');
	$mail->Subject ="New company payment";
	$mail->isHTML(true);
	$mail->Body ="New company has been added and paid. Waiting to be activated!!<br><a href='https://insectram.io/firm/branch?type=firm&&id=".$_GET['firm']."'<br><br>https://insectram.io/firm/branch?type=firm&&id=".$_GET['firm']."</a><br>Thanks,<br>Insectram";

	if(!$mail->Send())
	{
	   echo '<font color="#F62217"><b>Gönderim Hatası: ' . $mail->ErrorInfo . '</b></font>';
	   exit;
	}
	// echo '<font color="#41A317"><b>Mesaj başarıyla gönderildi.</b></font>';


$conn->close();

?>
<style>
	body{
	text-align: center;
	}
</style>
<?php	exit;



	




	require_once "PHPMailer/PHPMailer.php";
	require_once "PHPMailer/SMTP.php";
	require_once "PHPMailer/Exception.php";

	$mail=new PHPMailer();

	$mails->IsSMTP();
	$mails->Host = 'mail.insectram.io';
	$mails->SMTPAuth = true;
	$mails->Username = 'info@insectram.io';
	$mails->Port='587';
	$mails->SetLanguage("tr", "phpmailer/language");
	$mails->CharSet  ="utf-8";
	$mails->Encoding="base64";
	$mails->Password = '@datahan2018';
	$mails->SetFrom('info@insectram.io','insectram');
	$mails->isHTML(true);
	$mails->Subject ="Insectram Payment Success.Your Login Details";
	$mails->Body ="Hey<br><br>Thank you for the purchase. Your login details are below.<br><b>Username</b>:$username<br>Please update your new password <a href='https://insectram.io/site/login?code=".$useractivasyon."'<br><br>https://insectram.io/site/login?code=".$useractivasyon."</a><br>Thanks,<br>Insectram";
	//$mail->MsgHTML($msg);
	$mails->AddAddress($email,$username);
	if($mails->Send())
		$error=0;
	else
	$error=1;



	
	$mail->IsSMTP();
	$mail->Host = 'mail.insectram.io';
	$mail->SMTPAuth = true;
	$mail->Username = 'info@insectram.io';
	$mail->Port='587';
	$mail->SetLanguage("tr", "phpmailer/language");
	$mail->CharSet  ="utf-8";
	$mail->Encoding="base64";
	$mail->Password = '@datahan2018';
	$mail->SetFrom('info@insectram.io','insectram');
	$mail->isHTML(true);
	$mail->Subject ="Your Login Details";
	$mail->Body ="Hey<br><br>Thank you for the purchase. Your login details are below.<br><b>Username</b>:$username<br>Please update your new password <a href='https://insectram.io/site/login?code=".$useractivasyon."'<br><br>https://insectram.io/site/login?code=".$useractivasyon."</a><br>Thanks,<br>Insectram";
	//$mail->MsgHTML($msg);
	$mail->AddAddress($email,$username);
	if($mail->Send())
		$error=0;
	else
	$error=1;




	$maile=new PHPMailer();
	
	$maile->IsSMTP();
	$maile->Host = 'mail.insectram.io';
	$maile->SMTPAuth = true;
	$maile->Username = 'info@insectram.io';
	$maile->Port='587';
	$maile->SetLanguage("tr", "phpmailer/language");
	$maile->CharSet  ="utf-8";
	$maile->Encoding="base64";
	$maile->Password = '@datahan2018';
	$maile->SetFrom('info@insectram.io','insectram');
	$maile->isHTML(true);
	$maile->Subject ="Yeni Firma Ödeme";
	$maile->Body ="Yeni firma eklendi ve ödemesi yapıldı.Aktif edilmeyi bekliyor!!<br><a href='https://insectram.io/firm/branch?type=firm&&id=".$_GET['firm']."'<br><br>https://insectram.io/firm/branch?type=firm&&id=".$_GET['firm']."</a><br>Thanks,<br>Insectram";
	//$mail->MsgHTML($msg);
	$maile->AddAddress('info@insectram.io','insectram.co.uk ödeme');
	if($maile->Send())
		$error=0;
	else
	$error=1;



// echo $error;
	exit;
	header('Location:https://www.insectram.co.uk',true,303);




?>