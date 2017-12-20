<?php session_start();
	//authentic check
	if (!$_SESSION['loginCheck']) {
		header("Location:deny.html");
	}
	if (!isset($_SESSION['account'])) {
		header("Location:deny.html");
	}
	date_default_timezone_set('Asia/Taipei');//台灣時間
	//sql connect
	require_once('connect.php');
	$sql="SELECT * FROM event  ORDER BY `date` DESC";
	$sqlRank="SELECT account,coin FROM `members_info` ORDER BY `members_info`.`coin` DESC";
	$sqlcoin="SELECT coin FROM `members_info` where account = '".$_SESSION['account']."'";
	$result=mysqli_query($conn,$sql);
	$rank=mysqli_query($conn,$sqlRank);
	$accoin = mysqli_query($conn,$sqlcoin);
	$money = mysqli_fetch_row($accoin); 
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
	<!--tablesorter-->
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/jquery.tablesorter.widgets.js"></script>
	<link rel="stylesheet" href="css/jquery.tablesorter.pager.css">
	<!--sweetalert-->
	<script src="sweetalert.min.js"></script>
	<link href="css/sweetalert.css" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:700" rel="stylesheet">
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
				<a id="links" class="navbar-brand opa" href="prediction.php">Chenlw.com</a>
			</div>
				
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-right">
					<li><a id="account" class="prevent" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['account']?></a></li>	
					<li><a class="prevent pulse" href="#" id="userCoin">$<?php echo $money[0]?></a><li>
					<li><a class="navbar-brand opa" href="record.php" id="links">Record</a></li>
					<li><a class="opa" href="logOut.php" id="links"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container" style="margin-top:50px">
		<div class="row">
			<!-- slide -->
			<div id="myCarousel" class="carousel slide col-md-12 col-xs-12" data-ride="carousel" style="margin-bottom:20px;">
			<!-- Indicators -->
				<ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<li data-target="#myCarousel" data-slide-to="1"></li>
					<li data-target="#myCarousel" data-slide-to="2"></li>
				</ol>
				<!-- Wrapper for slides -->
				<div class="carousel-inner">
					<div class="item active">
						<img src="img/NBA.jpg" alt="Los Angeles" style="width:100%;">
					</div>
					<div class="item">
						<img src="img/LOL.jpg" alt="Chicago" style="width:100%;">
					</div>
					<div class="item">
						<img src="img/hearthstone.jpg" alt="New york" style="width:100%;">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row" > 
			<!-- table -->
			<div class="col-md-9 col-xs-12" >
				<h2 ><strong>"Prediction"</strong></h2>
				<!--select category-->
				<div style="width:auto; height:670px; overflow:auto;">
				<table class="table table-hover  tablesorter" align="l" id="pTable" cellpadding="0" cellspacing="0" border="0">
					<thead>
						<tr>
							<th>Id</span></th>
							<th>Date</th>
							<th>Category</span></th>
							<th>Contestant1</th>
							<th>Odds</th> 
							<th>Contestant2</th>
							<th>Odds</th>
						</tr>
					</thead>
					<tbody>
						<?php
							while($row=mysqli_fetch_row($result)){
								$ed=gettingDate($row[1]);
								$nd=gettingDate(date("Y-m-d"));
								if($ed<=$nd){
										echo "<tr id='$row[0]' onclick='overdeadline()'>";
								}
								else{
									echo "<tr id='$row[0]' onclick='openBetting($row[0])'>";
								}
								for($i = 0; $i <mysqli_num_fields($result); $i++){
										echo "<td> $row[$i]</td>";
								}
								echo "</tr>";
							}
							echo"</tbody>";
							mysqli_free_result($result);
						?>
				</table>
				</div>
				<p><i>“Gamble everything for future, if you're a true human being.”</i></p>
			</div>
			<!--Rank-->
            <div class="col-md-3  col-xs-12" >
                <h2><strong>"Ranking"</strong></h2>
				<div style="width:auto; height:670px; overflow:auto;">
                <table class="table table-hover tablesorter" align="l" id="rankTable">
                    <thead>
                        <tr>
                            <th>Account</th>
                            <th>Coin</span></th>
                        </tr>
                    </thead>
                    <tbody style="color:red">
                        <?php
                        while($res = mysqli_fetch_assoc($rank)){
                            echo "<tr><td>".$res['account']."</td>";
                            echo "<td>".$res['coin']."</td></tr>";
                        }
                        echo"</tbody>";
                        ?>
                </table>
				</div>
				<p><i>“Ignore GM pls ,dude.”</i></p>
            </div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h2><strong>"Streams"</strong></h2>
			</div>
			<!--<iframe
				src="http://player.twitch.tv/?butterflyouo"
				height="720"
				width="1280"
				frameborder="0"
				scrolling="no"
				allowfullscreen="true">
    		</iframe>-->
			<div class="col-md-4">
				<blockquote class="embedly-card"><h4><a href="https://www.twitch.tv/videos/152426815">♥蝴蝶兒♥ Other Time - 開台吃雞排，讓你們垂涎三尺 2017/6/14</a></h4><p>♥♥ 訂閱youtube - http://bit.ly/2cWL02a ♥♥ Facebook 粉絲專頁 - https://www.facebook.com/Butterflyouo/ ♥♥ Twitch 直播實況台 - https://www.twitch.tv/butterflyouo ♥♥ 任何實況資訊都會在粉絲頁發布~ ✧*✧*✧*✧*✧*✧*✧*✧*✧*✧*✧*✧*✧*✧*✧ 大家好我是蝴蝶~一個有時候會穿著阿姨skin的高中生實況主 喜歡打lol，最喜歡的角色是阿璃 謝謝大家訂閱偶的youtube頻道!! 我會多開實況多回留言回報你們低 (๑╹◡╹๑) 有時候會沒聲音是因為音樂開太大聲被youtube消音惹 如果可以的話可以看我的實況唷!!!網址在上面 ✧*✧*✧*✧*✧*✧*✧*✧*✧*✧*✧*✧*✧*✧*✧</p></blockquote>
				<script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>
			</div>
			<div class="col-md-4">
				<blockquote class="embedly-card"><h4><a href="https://www.twitch.tv/videos/46529698">
				我的粉紅色鍵盤</a></h4><p>純粹鍵盤分享 非工商</p></blockquote>
				<script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>
			</div>
			<div class="col-md-4">
				<blockquote class="embedly-card"><h4><a href="https://www.twitch.tv/videos/49094973">
				橘子玩尾巴 ...</a></h4><p>Twitch is the world's leading video platform and community for gamers. More than 45 million gamers gather every month on Twitch to broadcast, watch and chat about gaming. Twitch's video platform is the backbone of both live and on-demand distribution for the entire video game ecosystem.</p></blockquote>
				<script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>
			</div>
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
	<script>
		$(document).ready(function(){

       		$("#pTable").tablesorter();
			$("#rankTable").tablesorter();
			
			$(".prevent").on("click", function(e){
				e.preventDefault();
			});

        });
		
		var choice = 0;
		function add(){
			document.getElementById("tcoin1").addEventListener( "keyup", check, false );
			document.getElementById("tcoin2").addEventListener( "keyup", check, false );
		}
		function openCont1(){
			choice = 1;
			document.getElementById("Cont1").style.display = "block";
		}
		function closeCont1(){
			document.getElementById("Cont1").style.display = "none";
			document.getElementById("tcoin1").addEventListener( "onmouseup", check, false );
		}
		function openCont2(){
			choice = 2;
			document.getElementById("Cont2").style.display = "block";
		}
		function closeCont2()  {
			document.getElementById("Cont2").style.display = "none";
			document.getElementById("tcoin2").addEventListener( "onmouseup", check, false );
		}
		function closeBetting() {
			document.getElementById("betting").style.display = "none";
		}
		function openBetting(trId) {
			document.getElementById("betting").style.display = "block";
			var x = document.getElementById(trId);
			var y = document.getElementById("tableBet");
			var z = document.getElementById("tableBet2");
			y.cells[0].innerHTML = x.cells[3].innerHTML;
			y.cells[1].innerHTML = x.cells[5].innerHTML;
			z.cells[0].innerHTML = "ODDS : " + x.cells[4].innerHTML;
			z.cells[1].innerHTML = "ODDS : " + x.cells[6].innerHTML;
			document.getElementById("Cont1Header").innerHTML=document.getElementById(trId).cells[3].innerHTML;
			document.getElementById("Cont2Header").innerHTML=document.getElementById(trId).cells[5].innerHTML;
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
				}else if(valuecoin1<0){
					document.getElementById("tcoin1").value = '';
				}else if(valuecoin2>userCoin){
					document.getElementById("tcoin2").value = userCoin;
				}else if(valuecoin2<0){
					document.getElementById("tcoin2").value = '';
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
		function overdeadline(){
			swal("The Bet Was Out Of Date!");
		}
		window.addEventListener( "load", add, false );
	</script>
	<?php
		function gettingDate($string){   //轉換時間
			$date = split("[-]",$string);
			$y=$date[0];
			$m=$date[1];
			$d=$date[2];
			return mktime(0,0,0,$m,$d,$y);
		}
	?>