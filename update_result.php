<?php
    require_once('connect.php');

    $id = $_POST['tevent'];
    $winner = $_POST['twinner'];
    $pay = 0;
    $sql="select * from result";
	$result=mysqli_query($conn,$sql);

    $check = true;

    while ($row = mysqli_fetch_assoc($result)){
        if($row['event_id'] == $id){
            $check = false;
            echo'<script>alert("This event has been set.");history.back();</script>';
        }
    }

    if($check){
        $insert_sql = "INSERT INTO result (event_id,winner,pay)  
					   VALUES ('$id', '$winner', '0')";
        if (mysqli_query($conn,$insert_sql)){
			echo'<script>alert("Sign up success!");history.back();</script>';
		}
    }

    echo $id.$winner;
?>