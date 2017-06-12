<?php
	require_once('connect.php');
    $account = $_POST['taccount'];
    $password = $_POST['tpassword'];
    $sql = "select * from members_info where account = '".$account."'";
    $result = mysqli_query($conn,$sql);
    $asso_result = mysqli_fetch_assoc($result);
    if ($account == $asso_result['account']) {
        if ($password == $asso_result['password']){
            echo 'Welcome '.$asso_result['account'].' !';
        }
        else {
        echo 'Your password is not correct.';
        }
	}
    else {
        echo "This account is not exist.";
    }
?>