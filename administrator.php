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
	$sql="SELECT * FROM event";
	$result=mysqli_query($conn,$sql);
	$sql2="SELECT * FROM result";
	$result2=mysqli_query($conn,$sql2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="prediction.css" rel="stylesheet">
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<!--sort-->
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/jquery.tablesorter.widgets.js"></script>
	<link rel="stylesheet" href="css/jquery.tablesorter.pager.css">
	
	<style type="text/css">
	.close{
		position: absolute;
		top: 0;
		right: 0;
		color: #ffffff;
		font-size: 40px;
		font-weight: bold;
	}
	label{
		color:white;
		font-size:20px;
	}
	.modal{
		background-color:black;
		opacity:0.95;
	}
    </style>
	
</head>
<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<a id="links" class="navbar-brand" href="administrator.php">YaSeafood.com</a>
			</div>
				
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-right">
					<li ><a id="account" class="prevent" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['account']?></a></li>	
					<li ><a id="userCoin" class="prevent pulse" href="#">$<?php echo $_SESSION['coin']?></a><li>
					<li ><a id="links" href="logOut.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="row"> 
		<div class="col-md-12 col-xs-12">
		<h3>Use to push down</h3>
		</div>
		<div class="col-md-12 col-xs-12">
			<h2>Control Panel</h2>
			<p><button type="button" class="btn btn-primary" style="font-size: 150%;" onclick="openAdding()">add event</button></p>
			<table class="table table-hover tablesorter" align="l" id="controlTable">
				<thead>
					<tr>
						<th>Op</th>
						<th>Id</th>
						<th>date</th>
						<th>Category</th>
						<th>contestant1</th>
						<th>ODDs</th>
						<th>contestant2</th>
						<th>ODDs</th>
					</tr>
				</thead>
				<tbody>
					<?php
						while($row=mysqli_fetch_row($result)){
							echo "<tr id='$row[0]'>";
							echo "<td><button type=\"button\" class=\"btn btn-success\" onclick=\"openOption($row[0])\">Option</button></td>";
							for($i = 0; $i <mysqli_num_fields($result); $i++){
									echo "<td onclick='openBetting($row[0])'>$row[$i]</td>";
							}
							echo "</tr>";
						}
						echo"</tbody>";
						mysqli_free_result($result);
					?>
			  </table>
		</div>
		
		<div class="col-md-3 col-xs-6">
			<h2>Set event winner</h2>
			<form role="form" action="update_result.php" method="post">
    			<div class="form-group">
					<label class="control-label" for="account">Event ID</label>
    				<input type="text" name="tevent" class="form-control" placeholder="Enter event id" required>
    			</div>
    			<div class="form-group">
					<label class="control-label" for="pasword">Winner</label>
					<input type="text" name="twinner" class="form-control" placeholder="Enter winner" required>
    			</div>
				<button type="submit" class="btn btn-success btn-lg my_btn" value="submit">Set</button>
    		</form>
		</div>
		<div class="col-md-9 col-xs-6">
			<h2>ButterflyOUO</h2>
			<table class="table table-hover tablesorter" align="l" id="resultTable">
				<thead>
					<tr>
						<th>Event Id</th>
						<th>Winner</th>
						<th>Pay</th>
					</tr>
				</thead>
				<tbody>
					<?php
						while($row=mysqli_fetch_row($result2)){
							echo "<tr>";
							echo "<td>".$row[0]."</td>";
							echo "<td>".$row[1]."</td>";
							echo "<td>".$row[2]."</td>";
							echo "</tr>";
						}
						echo"</tbody>";
					?>
			</table>
		</div>
	</div>
	
	<div class="container modal"  id="betting">
		<span class="close" onclick="closeBetting()">&times;</span>
    	<div class="row"  align="center">
    		<h2>Which contestant do you support?</h2>
			<table>
				<tr id="tableBet" class="table">     <!--td 跟id 不能改，若要改openBetting也要改-->
					<td align="center">1 </td>
					<td align="center">2 </td>
				</tr>
				<tr id="tableBet2">
					<td align="center"></td>
					<td align="center"></td>
				</tr>
				<tr>
					<td align="center"><input type="button" id="btnCont1" value="Choose" onclick="openCont1()" class="btn btn-warning  btn-lg "></input></td>
					<td align="center"><input type="button" id="btnCont2" value="Choose" onclick="openCont2()"  class="btn btn-warning btn-lg "></input></td>
				</tr>
			</table>
			
			<div class="container modal"  id="Cont1">
			<span class="close" onclick="closeCont1()">&times;</span>
				<div class="row">
				<h2 align="center" id="Cont1Header"></h2>
				<div class="col-sm-12 .col-xs-10 ">
				<form role="form" name="betForm1" action="bet_info.php" method="post">
					<div class="form-group">
						<label class="control-label col-sm-7" for="coins">Coins:</label>
						<input type="number" name="tcoin" class="form-control" placeholder="Enter coins" id="tcoin1" onclick="mouseCheck()" required>
					</div>
					<input type="hidden" name = "tchoice"  value="1">
					<input id="event_id_o1" type="hidden" name = "tid"  value="1">
					<button type="submit" class="btn btn-success btn-lg my_btn" value="submit" >OK</button>
				</form>
				</div>
				</div>
			</div>
			<div class="container modal"  id="Cont2">
			<span class="close" onclick="closeCont2()">&times;</span>
				<div class="row">
				<h2 align="center" id="Cont2Header"></h2>
					<div class="col-sm-12 .col-xs-10 ">
						<form role="form" name="betForm2" action="bet_info.php" method="post">
							<div class="form-group">
								<label class="control-label col-sm-7" for="coins">Coins:</label>
								<input type="number" name="tcoin" class="form-control" placeholder="Enter coins" id="tcoin2" onclick="mouseCheck()" required>
								<input type="hidden" name = "tchoice" value="2">
								<input id="event_id_o2" type="hidden" name = "tid" value="1">
							</div>
							<button type="submit" class="btn btn-success btn-lg my_btn" value="submit">OK</button>
						</form>
					</div>
				</div>
			</div>
    	</div>
    </div>
	
	<div class="container modal" id="option" style="width:400px;height:300px;background-color:#660077;border:8px red double;">
    	<span class="close" onclick="closeOption()">&times;</span>
		<div class="row" align="center">		
			<h2>choose the option</h2>
			<table width="300" height="170">
				<tr>
					<td align="center"><button type="submit" class="btn btn-danger btn-lg my_btn" onclick="openChanging()">Change</button></td>
					<td align="center"><button type="button" class="btn btn-danger btn-lg my_btn" onclick="openDeleting()">Delete</button></td>
				</tr>
			</table>
    	</div>
    </div>
	
	<div class="container modal" id="deleting" style="width:400px;height:300px;background-color:#660077;border:8px red double;">
    	<div class="row" align="center">		
			<h2>Do you wanna delete?</h2>
			<table width="300" height="170">
				<tr>
					<td align="center">
					<form role="form" name="deleteForm" action="option.php" method="post">
					<input id="delete_event_id" type="hidden" name = "tdlid" value="1">
					<input id="GMopID" type="hidden" name = "GMopID" value="3">
					<button type="submit" class="btn btn-danger btn-lg my_btn" onclick="closeDeleting(1)">Yes
					</button></form></td>
					<td align="center"><button type="button" class="btn btn-danger btn-lg my_btn" onclick="closeDeleting(2)">No</button></td>
				</tr>
			</table>
    	</div>
    </div>
	
	<div class="container modal" id="changing" style="width:450px;height:450px;">
		<span class="close" onclick="closeChanging()">&times;</span>
    	<div class="row">
    		<div class="col-sm-12 .col-xs-10 ">
    		<form role="form" action="option.php" method="post">
				<table width="320" height="350" align="center">
				<tr>
					<td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td>
				</tr>
				<tr>
					<td colspan="6" align="center"><label class="control-label" for="cheventID">EventID:</label></td>
					<td colspan="10" align="center"><input id="cheventIDD" type="number" name="cheventIDD" class="form-control" placeholder="EventID" disabled></td>
					<input id="cheventID"  type="hidden" name = "cheventID">
				</tr>
				<tr>
					<td colspan="6" align="center"><label class="control-label" for="chdate">Date:</label></td>
					<td colspan="10" align="center"><input id="chdate" type="date" name="chdate" class="form-control" required></td>
				</tr>
				<tr>
					<td colspan="6" align="center"><label class="control-label" for="chcate">Category:</label></td>
					<td colspan="10" align="center">
					<select id="chcate" name="chcate" class="form-control" required>
　					<option value="LOL">LOL</option>
　					<option value="NBA">NBA</option>
　					<option value="Fight">打架</option>
					</select></td>
				</tr>
				<tr>
					<td width='20'></td><td width='20'></td>
					<td colspan="4" align="center"><label class="control-label" for="chteam1">team1</label></td>
					<td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td>
					<td colspan="4" align="center"><label class="control-label" for="chteam2">team2</label></td>
					<td width='20'></td><td width='20'></td>
				</tr>
				<tr>
					<td width='20'></td>
					<td colspan="6" align="center"><input id="chteam1" type="text" name="chteam1" class="form-control" placeholder="team1 name" required></td>
					<td width='20'></td><td width='20'></td>
					<td colspan="6" align="center"><input id="chteam2" type="text" name="chteam2" class="form-control" placeholder="team2 name" required></td>
					<td width='20'></td>
				</tr>
				<tr>
					<input id="GMopID" type="hidden" name = "GMopID" value="2">
					<td colspan="16" align="center"><button type="submit" class="btn btn-success btn-lg my_btn" value="submit">Change</button></td>
				</tr>
				</table>				
    		</form>
    		</div>
    	</div>
    </div>
	
	<div class="container modal" id="adding" style="width:450px;height:450px;">
		<span class="close" onclick="closeAdding()">&times;</span>
    	<div class="row">
    		<div class="col-sm-12 .col-xs-10 ">
    		<form role="form" action="option.php" method="post">
				<table width="320" height="350" align="center">
				<tr>
					<td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td>
				</tr>
				<tr>
					<td colspan="6" align="center"><label class="control-label" for="teventID">EventID:</label></td>
					<td colspan="10" align="center"><input type="number" name="teventID" class="form-control" placeholder="EventID" required></td>
				</tr>
				<tr>
					<td colspan="6" align="center"><label class="control-label" for="tdate">Date:</label></td>
					<td colspan="10" align="center"><input type="date" name="tdate" class="form-control" placeholder="Enter Date" required></td>
				</tr>
				<tr>
					<td colspan="6" align="center"><label class="control-label" for="tcate">Category:</label></td>
					<td colspan="10" align="center">
					<select name="tcate" class="form-control" required>
　					<option value="LOL">LOL</option>
　					<option value="NBA">NBA</option>
　					<option value="Fight">打架</option>
					</select></td>
				</tr>
				<tr>
					<td width='20'></td><td width='20'></td>
					<td colspan="4" align="center"><label class="control-label" for="tteam1">team1</label></td>
					<td width='20'></td><td width='20'></td><td width='20'></td><td width='20'></td>
					<td colspan="4" align="center"><label class="control-label" for="tteam2">team2</label></td>
					<td width='20'></td><td width='20'></td>
				</tr>
				<tr>
					<td width='20'></td>
					<td colspan="6" align="center"><input type="text" name="tteam1" class="form-control" placeholder="team1 name" required></td>
					<td width='20'></td><td width='20'></td>
					<td colspan="6" align="center"><input type="text" name="tteam2" class="form-control" placeholder="team2 name" required></td>
					<td width='20'></td>
				</tr>
				<tr>
					<input id="GMopID" type="hidden" name = "GMopID" value="1">
					<td colspan="16" align="center"><button type="submit" class="btn btn-success btn-lg my_btn" value="submit">Add</button></td>
				</tr>
				</table>				
    		</form>
    		</div>
    	</div>
    </div>
	
	<script>
		//sort
		$(document).ready(function(){
       		$("#controlTable").tablesorter();
			$("#resultTable").tablesorter();
        });
		//
		var choice = 0;
		function addkeyevent(){
			document.getElementById("tcoin1").addEventListener( "keyup", check, false );
			document.getElementById("tcoin2").addEventListener( "keyup", check, false );
		}
		function openCont1(){
			choice = 1;
			document.getElementById("Cont1").style.display = "block";
		}
		function closeCont1(){
			document.getElementById("Cont1").style.display = "none";
		}
		
		function openCont2(){
			choice = 2;
			document.getElementById("Cont2").style.display = "block";
		}
		function closeCont2()  {
			document.getElementById("Cont2").style.display = "none";
		}
		
		function closeOption()  {
			document.getElementById("option").style.display = "none";
		}
		
		function openOption(trId){
			document.getElementById("option").style.display = "block";
			document.getElementById("changing").style.display = "none";
			document.getElementById("deleting").style.display = "none";
			document.getElementById("delete_event_id").value = trId;
			var x = document.getElementById(trId);
			document.getElementById("cheventID").value = parseInt(x.cells[1].innerHTML);
			document.getElementById("cheventIDD").value = parseInt(x.cells[1].innerHTML);
			var rightNow = new Date(x.cells[2].innerHTML);
			rightNow.setMinutes(rightNow.getMinutes() - rightNow.getTimezoneOffset());
			document.getElementById("chdate").value = rightNow.toISOString().slice(0,10);
			document.getElementById("chcate").value = x.cells[3].innerHTML;
			document.getElementById("chteam1").value = x.cells[4].innerHTML;
			document.getElementById("chteam2").value = x.cells[6].innerHTML;
		}
		
		function openChanging(){
			document.getElementById("option").style.display = "none";
			document.getElementById("changing").style.display = "block";
		}
		
		function closeChanging(){
			document.getElementById("option").style.display = "block";
			document.getElementById("changing").style.display = "none";
		}
		
		function openDeleting(){
			document.getElementById("option").style.display = "none";
			document.getElementById("deleting").style.display = "block";
		}
		
		function closeDeleting(num){
			if (num == 1){document.getElementById("option").style.display = "none";}
			else if (num == 2){document.getElementById("option").style.display = "block";}
			document.getElementById("deleting").style.display = "none";
		}
		
		function openAdding(){
			document.getElementById("adding").style.display = "block";
		}
		function closeAdding(){
			document.getElementById("adding").style.display = "none";
		}
		
		function closeBetting() {
			document.getElementById("betting").style.display = "none";
		}
		function openBetting(trId) {
			document.getElementById("betting").style.display = "block";
			var x = document.getElementById(trId);
			var y = document.getElementById("tableBet");
			var z = document.getElementById("tableBet2");
			y.cells[0].innerHTML = x.cells[4].innerHTML;
			y.cells[1].innerHTML = x.cells[6].innerHTML;
			z.cells[0].innerHTML = "ODDS : " + x.cells[5].innerHTML;
			z.cells[1].innerHTML = "ODDS : " + x.cells[7].innerHTML;
			document.getElementById("Cont1Header").innerHTML=document.getElementById(trId).cells[4].innerHTML;
			document.getElementById("Cont2Header").innerHTML=document.getElementById(trId).cells[6].innerHTML;
			document.getElementById("event_id_o1").value = trId;
			document.getElementById("event_id_o2").value = trId;
		}
		function check(e){
			var userCoin = parseInt((document.getElementById("userCoin").innerHTML).substr(1));
			var keyStr=parseInt(e.keyCode);
			if((keyStr<=57 && keyStr>=48) || (keyStr<=105 && keyStr>=96))
			{
				
				var valuecoin1 = parseInt(document.getElementById("tcoin1").value);
				var valuecoin2 = parseInt(document.getElementById("tcoin2").value);
				if(valuecoin1>userCoin){
					document.getElementById("tcoin1").value = userCoin;
				}else if(valuecoin2>userCoin){
					document.getElementById("tcoin2").value = userCoin;
				}
			}
		}
		
		function mouseCheck(){
			var userCoin = parseInt((document.getElementById("userCoin").innerHTML).substr(1));
			var valuecoin1 = parseInt(document.getElementById("tcoin1").value);
			var valuecoin2 = parseInt(document.getElementById("tcoin2").value);
			if(valuecoin1>userCoin){
				document.getElementById("tcoin1").value = userCoin;
			}else if(valuecoin1<0){
				document.getElementById("tcoin1").value = '';
			}else if(valuecoin2>userCoin){
				document.getElementById("tcoin2").value = userCoin;
			}else if(valuecoin2<0){
				document.getElementById("tcoin2").value = '';
			}
		}
		
		window.addEventListener( "load", addkeyevent, false );
	</script>
	
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
