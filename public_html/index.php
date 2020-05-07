<?php
	session_start();	/* https://www.w3schools.com/php/php_sessions.asp*/
	error_reporting(0);
	require 'connect.php';
	if(isset($_POST['usernamefield']) && isset($_POST['passwordfield']))
	{
		$flag = 0;
		$username = $_POST['usernamefield'];
		$password = $_POST['passwordfield'];
		$stmt = $conn->prepare("select username,password from auth ");
		$stmt->bind_result($uname,$pass);
		$stmt->execute();
		while($stmt->fetch())
		{
			if($username == $uname && $password == $pass)
			{
				$_SESSION['authsession'] = 'true';
				echo "<script>alert('authentication successful!');</script>";
				echo "strat";
				echo "<script> window.location.replace('homepage.php'); </script>";
				die();
			}
		}
		if($flag == 0)
		{
			echo "<script>alert('authentication failed!');</script>";
			$_SESSION['authsession'] = 'false';
			die();
		}
	} 
?>
<html>
<head>
<title>Login Page</title>
<script type='text/javascript' >
/////always do validation by php to hide validation code from user (in view-source-code)
/////just as the authentication is done by php on the same page in this file 
function validateform()
{
	var username = document.loginform.usernamefield.value.trim();
	var password = document.loginform.passwordfield.value.trim();
	var error = "";
	var flag = 1;
	if (username == "")
	{
		error += "Username is empty \n"
		flag = 0;
	}
	if (password == "")
	{
		error += "Password is empty \n"
		flag = 0;
	}
	if (flag == 0)
	{
		alert(error);
		return false
	}
	else
	{
		return true;
	}
}
</script>

</head>

<body>
<header style='background:#d9d9f1; text-align:center; color:#0000ff; font-size:25px; font-family:Consolas; padding:10px;' >
LIBRARY MANAGEMENT SYSTEM
</header>
<br>
<div style=' float:right; position:relative; left:-35%;  padding:10px; text-align:center; background:#d9d9f1; color:#0000ff; font-size:20px; font-family:Consolas;' >
<form name='loginform' action='index.php' method='POST' onsubmit='return validateform()' >
Librarian login page <br><br>
Enter username : <input type='text' name='usernamefield' style='background:#d9d9f1; border:none; border-bottom:2px solid #0000ff; border-radius:10px; color:red; font-size:20px; font-family:Consolas; padding-left:18px; padding-bottom:3px;' > <br><br>
Enter password : <input type='password' name='passwordfield' style='background:#d9d9f1; border:none; border-bottom:2px solid #0000ff; border-radius:10px; color:red; font-size:20px; font-family:Consolas; padding-left:18px; padding-bottom:3px;'  > <br><br>
<input type='submit' value='Login' style='float:right; position:relative; left:-45%; border:2px solid #0000ff; border-radius:10px; color:red; background:#d9d9f1; font-size:25px; font-family:Consolas;' > 
</form>
</div>

</body>
</html>

