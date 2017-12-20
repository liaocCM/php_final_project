
<?php session_start();
    //sql connect
	require_once('connect.php');
    //get post data
    $account = $_POST['taccount'];
    $password = $_POST['tpassword'];
    //declare session variable
    $_SESSION['account'] = $account;
    $_SESSION['loginCheck'] = false;
	$_SESSION['adminCheck'] = false;
    //$_SESSION['password'] = $password;



    $sql = "select * from members_info where account = '".$account."'";
    $result = mysqli_query($conn,$sql);
    $asso_result = mysqli_fetch_assoc($result);
    if ($account == $asso_result['account']) {
        if ($password == $asso_result['password']){
			//if check success, declare session email,coin and change login check variable
				$_SESSION['email'] = $asso_result['email'];
				$_SESSION['coin'] = $asso_result['coin'];
				$_SESSION['loginCheck'] = true;
			if ($account == "GM"){
				$_SESSION['adminCheck'] = true;
				header("Location:administrator.php");
			}
			else{
				header("Location:prediction.php");
			}

        }
        else {
			echo'<script>alert("Your password is not correct.");history.back();</script>';
        }
	}
    else {
        echo'<script>alert("This account is not exist.");history.back();</script>';
    }
?>

