<?php session_start();
	require_once('connect.php');

	$account = $_POST['taccount'];
	$password = $_POST['tpassword'];
	$email = $_POST['temail'];

	$_SESSION['loginCheck'] = false;

	$sql="select * from members_info";
	$result=mysqli_query($conn,$sql);
	//user id
	$num=mysqli_num_rows($result);
	//check account & email duplicate or no
	$check = true;
	while ($row = mysqli_fetch_assoc($result)) {
		if ($row["account"] == $account){
			$check = false;
			echo'<script>alert("Your account was used.");history.back();</script>';
		}
		else if ($row["email"] == $email){
			$check = false;
			echo'<script>alert("Your email was used.");history.back();</script>';
		}
	}
	//insert sql
	if ($check) {
		$insert_sql = "INSERT INTO members_info (member_id,account,password,coin,email)  
					   VALUES ('$num', '$account', '$password','1000', '$email')";
		if (mysqli_query($conn,$insert_sql)){
			$_SESSION['loginCheck'] = true;
			$_SESSION['account'] = $account;
			$_SESSION['coin'] = 1000;
			echo ("<SCRIPT LANGUAGE='JavaScript'>
    		window.alert('Sign up success!')
    		window.location.href='prediction.php';</SCRIPT>");
		}
	}
	/*$acsql = "select * from members_info where account = '".$account."'";
	$acresult = mysqli_query($conn,$acsql);
	$emsql = "select * from members_info where email = '".$email."'";
	$emresult = mysqli_query($conn,$emsql);
	if (mysqli_num_rows($acresult) != 0){
		echo'<script>alert("Your account was used.");history.back();</script>';
	}
	else if (mysqli_num_rows($emresult) != 0){
		echo'<script>alert("Your email was used.");history.back();</script>';
	}*/

	/*mysqli_select_db($conn,"members_info")or die ("無法選擇資料庫".mysql_error());
	mysqli_query($conn, 'SET CHARACTER SET utf8');
	$sql ="INSERT INTO members_info (id,account,password,coin,email)  VALUES ( NULL ,'$_POST['taccount']','$_POST['pasword']','1000','$_POST['email']')";
	mysqli_query($conn,$sql)or die(mysql_error());
	mysql_close($conn);*/
	
	
?>