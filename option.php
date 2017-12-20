<?php session_start();
	//authentic check
	if (!$_SESSION['loginCheck']) {
		header("Location:deny.html");
	}
	if (!isset($_SESSION['account'])) {
		header("Location:deny.html");
	}
	if (!$_SESSION['adminCheck']) {
		header("Location:denyAdmin.html");
	}

	//sql connect
	require_once('connect.php');
    //get post data

	$GMopID = (int)$_POST['GMopID'];

	if ($GMopID == 1){
		$eventID = (int)$_POST['teventID'];
		$date = $_POST['tdate'];
		$category = $_POST['tcate'];
		$team1 = $_POST['tteam1'];
		$team2 = $_POST['tteam2'];
		$sql="INSERT INTO `event`(`event_id`, `date`, `category`, `contestant1`, `odds1`, `contestant2`, `odds2`) VALUES (".$eventID.",'".$date."','".$category."','".$team1."',2,'".$team2."',2)";
		mysqli_query($conn,$sql);
		header("Location:administrator.php");
	}
	else if($GMopID == 2){
		$eventID = (int)$_POST['cheventID'];
		$date = $_POST['chdate'];
		$category = $_POST['chcate'];
		$team1 = $_POST['chteam1'];
		$team2 = $_POST['chteam2'];
		$sql="UPDATE `event` SET `event_id`=".$eventID.",`date`='".$date."',`category`='".$category."',`contestant1`='".$team1."',`odds1`=2,`contestant2`='".$team2."',`odds2`=2 WHERE `event_id` = '".$eventID."'";
		mysqli_query($conn,$sql);
		header("Location:administrator.php");
	}
	else if($GMopID == 3){
		$deleteid = (int)$_POST['tdlid'];

		$sql="DELETE FROM `event` WHERE `event_id` = ".$deleteid;
		mysqli_query($conn,$sql);
		$sql="DELETE FROM `transaction` WHERE `event_id` = ".$deleteid;
		mysqli_query($conn,$sql);
	
		header("Location:administrator.php");
	}
?>
