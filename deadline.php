<?php/* session_start();
	//authentic check
	if (!$_SESSION['loginCheck']) {
		header("Location:deny.html");
	}
	if (!isset($_SESSION['account'])) {
		header("Location:deny.html");
	}*/
		date_default_timezone_set('Asia/Taipei');
		$getDate = date("Y-m-d");
		echo  "$getDate";　　
	?>
