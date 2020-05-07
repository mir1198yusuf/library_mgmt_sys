<?php
	session_start();
	//error_reporting(0);
	require 'connect.php';
	if($_SESSION['authsession'] == null or $_SESSION['authsession'] == 'false')
	{
		echo "<script> alert('you are not allowed to access this page'); </script>";
		die();
	}
	if(isset($_POST['logoutbtn']))
	{
		$_SESSION['authsession'] = 'false';
		echo "<script>alert('you are logged out now');</script>";
		echo "<script>window.location.replace('index.php');</script>";
		die();
	}
	if(isset($_POST['searchbtn']))
	{
		$find = $_POST['searchfield'];
		$str = "";
		$stmt = $conn->prepare("select userid,uname,uaddr,ucontact,uadhar from user where uname like ?");
		$stmt->bind_param("s",$find);
		$stmt->bind_result($id,$name,$addr,$cont,$adhr);
		$stmt->execute();
		while($stmt->fetch())
		{
			$str = $str . "
					<div style='border:none; border-bottom:2px solid #0000f1; width:80%; height:2px; margin-left:65px;' ></div><br>
					User found in search <br><br>
					User-id : $id <br>
					Name : $name <br>
					Address : $addr <br>
					Contact : $cont<br>
					Aadhaar : $adhr<br><br>
			";
		}
		$stmt1 = $conn->prepare("select bkid,bkname,author,section,rack,row,status,expected from books where bkname like ?");
		$stmt1->bind_param("s",$find);
		$stmt1->bind_result($bid,$bname,$authr,$sect,$rack,$row,$sttus,$expected);
		$stmt1->execute();
		while($stmt1->fetch())
		{
			$str = $str . "
					<div style='border:none; border-bottom:2px solid #0000f1; width:80%; height:2px; margin-left:65px;' ></div><br>
					Book found in search <br><br>
					Book-id : $bid <br>
					Name : $bname <br>
					Author : $authr <br>
					Section : $sect<br>
					Rack : $rack<br>
					Row no. : $row<br>
					Status : $sttus<br>
			";
			if($sttus == 'issued')
			{
				$str = $str . "Return date : $expected<br><br>";
			}
			else
			{
				$str = $str . "<br>";
			}
		}
		echo "
			<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 20px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
			<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
			<br><br>
			Search results...<br><br>
			$str
			</div>
		";
	}
	if(isset($_POST['newuser']))
	{
		echo "
			<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 10px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
			<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
			<br><br>
			<form action='homepage.php' method='POST' >
			Name : <input type='text' name='uname' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:70%;' ><br><br>
			Address : <br><textarea name='uaddr' rows='3' style='margin-left:100px; padding:10px; background:#d9d9f1; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:70%;' ></textarea><br><br>
			Contact : <input type='text' name='ucont' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:60%;' ><br><br>
			Aadhaar No. : <input type='text' name='uadhar' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:60%;' ><br><br>
			<input type='submit' name='finaladduser' value='Add user' style='margin-left:30%; border:2px solid #0000ff; border-radius:10px; color:red; background:#d9d9f1; font-size:20px; font-family:Consolas;' >
			</form>
			</div>
		";
	}
	if(isset($_POST['finaladduser']))
	{
		$name = $_POST['uname'];
		$addr = $_POST['uaddr'];
		$cont = $_POST['ucont'];
		$adhr = $_POST['uadhar'];
		$stmt = $conn->prepare('insert into user(uname,uaddr,ucontact,uadhar) values(?,?,?,?);');
		$stmt->bind_param("ssss",$name,$addr,$cont,$adhr);
		$stmt->execute() or die("<script>alert('failed to insert user');</script>");
		$stmt1 = $conn->prepare("select userid from user order by userid desc limit 1");
		$stmt1->bind_result($id);
		$stmt1->execute();
		while($stmt1->fetch())
		{
			$str = "user created successfully<br><br> unique user-id is $id";
			echo "
				<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 20px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
				<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
				<br><br>$str<br><br>
			</div>
			";
		}
	}
	if(isset($_POST['deluser']))
	{
		echo "
			<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 20px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
			<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
			<br><br>
			<form action='homepage.php' method='POST' >
			Search user id in the search field & enter here<br><br>
			User id : <input type='text' name='userid' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:60%;' ><br><br>
			<input type='submit' name='finaldeluser' value='Delete user' style='margin-left:30%; border:2px solid #0000ff; border-radius:10px; color:red; background:#d9d9f1; font-size:20px; font-family:Consolas;' >
			</form>
			</div>
		";
	}
	if(isset($_POST['finaldeluser']))
	{
		$id = $_POST['userid'];
		$stmt = $conn->prepare('delete from user where userid=?');
		$stmt->bind_param("i",$id);
		$stmt->execute() or die("<script>alert('failed to delete user');</script>");
		$str = "user-id $id deleted successfully";
		echo "
				<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 20px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
				<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
				<br><br>$str<br><br>
			</div>
			";
	}
	if(isset($_POST['newbk']))
	{
		echo "
			<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 0px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
			<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
			<br><br>
			<form action='homepage.php' method='POST' >
			Book name : <input type='text' name='bkname' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:60%;' ><br><br>
			Author name : <input type='text' name='author' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:60%;' ><br><br>
			<br> Library location details of book<br><br>
			Section name : <input type='text' name='section' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:60%;' ><br><br>
			Rack no. : <input type='text' name='rack' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:60%;' ><br><br>
			Row no. : <input type='text' name='row' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:60%;' ><br><br>
			<input type='submit' name='finaladdbk' value='Add new book' style='margin-left:30%; border:2px solid #0000ff; border-radius:10px; color:red; background:#d9d9f1; font-size:20px; font-family:Consolas;' >
			</form>
			</div>
		";
	}
	if(isset($_POST['finaladdbk']))
	{
		$bname = $_POST['bkname'];
		$author = $_POST['author'];
		$section = $_POST['section'];
		$rack = $_POST['rack'];
		$row = $_POST['row'];
		$stmt = $conn->prepare("insert into books (bkname,author,section,rack,row,status,expected) values (?,?,?,?,?,'available','0000-00-00')");
		$stmt->bind_param("sssii",$bname,$author,$section,$rack,$row);
		$stmt->execute();
		$str = "New book added successfully";
		echo "
				<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 20px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
				<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
				<br><br>$str<br><br>
			</div>
			";
	}
	if(isset($_POST['delbk']))
	{
		echo "
			<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 20px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
			<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
			<br><br>Search book id in the search field & enter here<br><br>
			<form action='homepage.php' method='POST' >
			Book id : <input type='text' name='bkid' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:60%;' ><br><br>
			<input type='submit' name='finaldelbk' value='Delete book' style='margin-left:30%; border:2px solid #0000ff; border-radius:10px; color:red; background:#d9d9f1; font-size:20px; font-family:Consolas;' >
			</form>
			</div>
		";
	}
	if(isset($_POST['finaldelbk']))
	{
		$id = $_POST['bkid'];
		$stmt = $conn->prepare('delete from books where bkid=?');
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$str = "Book-id $id deleted successfully";
		echo "
				<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 20px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
				<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
				<br><br>$str<br><br>
			</div>
			";
	}
	if(isset($_POST['issue']))
	{
		echo "
			<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 20px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
			<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
			<br><br>
			<form action='homepage.php' method='POST' >
			User id : <input type='text' name='uid' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:60%;' ><br><br>
			Book id : <input type='text' name='bid' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:60%;' ><br><br>
			Return date (YYYY-MM-DD) : <input type='text' name='retdate' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:60%;' ><br><br>
			<input type='submit' name='finalissue' value='Issue book' style='margin-left:30%; border:2px solid #0000ff; border-radius:10px; color:red; background:#d9d9f1; font-size:20px; font-family:Consolas;' >
			</form>
			</div>
		";
	}
	if(isset($_POST['finalissue']))
	{
		$uid = $_POST['uid'];
		$bkid = $_POST['bid'];
		$date = $_POST['retdate'];
		$stmt = $conn->prepare("insert into issuebk (userid,bkid,returndate) value (?,?,?)");
		$stmt->bind_param("iis",$uid,$bkid,$date);
		$stmt->execute();
		$stmt1 = $conn->prepare("update books set status='issued', expected='$date' ");
		$stmt1->execute();
		$str = "Book-id $bkid issued to User-id $uid successfully";
		echo "
				<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 20px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
				<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
				<br><br>$str<br><br>
			</div>
			";
	}
	if(isset($_POST['return']))
	{
		echo "
			<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 20px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
			<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
			<br><br>
			<form action='homepage.php' method='POST' >
			Book-id : <input type='text' name='bid' style='background:#d9d9f1; padding:10px; border:1px solid #0000f1; font-family:Consolas; font-size:20px; width:60%;' ><br><br>
			<input type='submit' name='finalret' value='Return book' style='margin-left:30%; border:2px solid #0000ff; border-radius:10px; color:red; background:#d9d9f1; font-size:20px; font-family:Consolas;' >
			</form>
			</div>
		";
	}
	if(isset($_POST['finalret']))
	{
		$bid = $_POST['bid'];
		$stmt = $conn->prepare("delete from issuebk where bkid=?");
		$stmt->bind_param("i",$bid);
		$stmt->execute();
		$stmt = $conn->prepare("update books set status = 'available', expected = '0000-00-00' where bkid=?");
		$stmt->bind_param("i",$bid);
		$stmt->execute();
		$str = "Book-id $bid returned successfully";
		echo "
				<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 20px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
				<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
				<br><br>$str<br><br>
			</div>
			";
	}
	if(isset($_POST['view']))
	{
		$stmt = $conn->prepare("select userid,bkid,issuedate,returndate from issuebk");
		$stmt->bind_result($uid,$bid,$issue,$ret);
		$stmt->execute();
		$str = "";
		while($stmt->fetch())
		{
			$newissue = date_create($issue);
			$issue1 = date_format($newissue,'Y-m-d');
			$str = $str . "
					<div style='border:none; border-bottom:2px solid #0000f1; width:80%; height:2px; margin-left:65px;' ></div><br>
					User-id : $uid <br>
					Book-id : $bid <br>
					Issued date : $issue1 <br>
					Return date : $ret<br><br>
			";
		}
		echo "
			<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 20px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
			<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
			<br><br>List of issued books <br><br>
			$str
			</div>
		";
	}
	if(isset($_POST['help']))
	{
		echo "
			<div id='popup' style='position:absolute; margin-left:20%; margin-top:10%; padding:10px 20px 20px 20px; font-family:Consolas; font-size:20px; color:red; background:#d9d9f1; border:2px solid #0000f1; opacity:0.95; width:50%; height:fit-content;' >
			<input type='button' value='Close' style='background:#d9d9f1; margin-left:40%; color:blue; font-family:Consolas; font-size:25px; border:none; ' onclick=closedialog() >
			<br><br>
			This web-application is just a prototype for library management.<br>
			So it can be improved in many ways & new features can be added.<br><br><br>
			Only librarian is allowed to access this application.<br><br><br>
			This application assumed the storage of books in a library as follows.<br>
			-> Different sections made for storing various types of books.<br>
			-> In each section there are various racks.<br>
			-> Each rack contains rows in which books are stored.<br><br><br>
			This application assumes the book are assigned a unique-id by the system before they are entered into database.<br>
			
			</div>
		";
	}
?>
<html>

<head>
<title>Home Page</title>
<script type='text/javascript' >
function closedialog()
{
	document.getElementById('popup').remove();
}
</script>
<style type='text/css' rel='stylesheet' >
#searchbar:focus
{
	width:700px;
}
.grid-container
{
	margin-left:18%;
	margin-right:18%;
	display:grid;
	grid-template-columns: auto auto auto auto;
	padding:10px;
}
.item
{
	background:#d9d9f1;
	font-family:Consolas;
	font-size:25px;
	color:red;
	text-align:center;
	padding:20px;
	margin-bottom:10px;
	margin-right:10px;
	border:2px solid #0000f1;
	border-radius:20px;
}
.item:hover
{
	border:5px solid #0000f1;
	-webkit-transition:border 0.5s ease-in-out;
}
</style>
</head>

<body>
<header style='background:#d9d9f1; text-align:center; color:#0000ff; font-size:25px; font-family:Consolas; padding:10px;' >
LIBRARY MANAGEMENT SYSTEM
</header>
<br>
<header style='background:#d9d9f1; text-align:center; color:red; font-size:25px; font-family:Consolas; padding:10px;' >
Librarian, Welcome to Home Page! 
<form action='homepage.php' method='POST' style='float:right; position:relative; left:-5%; ' >
<input type='submit' name='logoutbtn' value='Logout' style='border:2px solid #0000ff; border-radius:10px; color:red; background:#d9d9f1; font-size:20px; font-family:Consolas;' >
</form>
</header>
<br><br>
<form action='homepage.php' method='POST' >
<div style='width:fit-content; height:fit-content; padding:5px; background:#d9d9f1; border:2px solid #0000ff; border-radius:20px; margin-left:20%;' >
<input id='searchbar' name='searchfield' type='text' placeholder='Search book or user...' style='padding:10px; font-size:20px; font-family:Consolas; color:red; background:#d9d9f1; border:none;' >
<input type='submit' name='searchbtn' style='background:url("searchbtn.png"); width:45px; height:43px; border:none; ' value=' ' >
</div>
</form>
<br>
<form action='homepage.php' method='POST' >
<div class='grid-container' >
<button type='submit' class='item' name='newuser' >Add new user</button>
<button type='submit' class='item' name='deluser' >Delete user</button>
<button type='submit' class='item' name='newbk' >Add new book</button>
<button type='submit' class='item' name='delbk' >Delete book</button>
<button type='submit' class='item' name='issue' >Issue a book</button>
<button type='submit' class='item' name='return' >Return issued book</button>
<button type='submit' class='item' name='view' >View issued books</button>
<button type='submit' class='item' name='help' >Help info</button>
</div>
</form>
</body>

</html>

