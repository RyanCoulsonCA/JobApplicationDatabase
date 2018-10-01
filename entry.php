<?php
require_once "connect.php";

$id = mysql_real_escape_string(intval($_GET['id']));

$getApp = mysql_query("SELECT * FROM `application` WHERE `id`='$id'");
$appInfo = mysql_fetch_object($getApp);
?>

<html lang="en-US">
	<head>
		<title>Job Application Database</title>

		<!-- CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="../../resources/styles/stylesheet.css" />

		<!-- favicon -->
		<link rel="shortcut icon" type="image/png" href="../../resources/media/ryan-coulson-logo3.png"/>

		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

		<!-- fort awesome icons -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	</head>

	<script>
	$(document).ready(function(){
	    $(".item-clickable").click(function() {
	        window.open($(this).data("href"), "_blank");
	        //window.location = $(this).data("href");
	    });

		var timerId = 0;
		$('textarea').focus(function() {
		    timerId = setInterval(function(){ 
				$.ajax({
				    type: "POST",
				    url: "../../savecomment.php",
				    data: { id: <?=$id?>, body: $("textarea").val() },
					success: function(response) {
						console.log(response);
						var d = new Date($.now());
						$('.lastsaved').text('Last saved: ' + d.toTimeString());
					}
				});	
		    }, 5000);
		});
		$('textarea').focusout(function() {
			$.ajax({
			    type: "POST",
			    url: "../../savecomment.php",
			    data: { id: <?=$id?>, body: $("textarea").val() },
				success: function(response) {
					console.log(response);
					var d = new Date($.now());
					$('.lastsaved').text('Last saved: ' + d.toTimeString());
				}
			});	
			clearInterval(timerId);
		});
		$(".clickable").click(function() {
	    		window.location = $(this).data("href");
	    });
	});

	</script>
	<body>

		<!-- top navigation -->
		<div class="top-navigation">
			<a href="../../index.php?key=dMb8rvHgC4wDQVF"><img src="../../resources/media/ryan-coulson-logo3.png" /></a>
			<div class="nav-btn"><i class="fa fa-file"></i>Add New</div>
			<div class="nav-btn clickable" style="background: rgb(100,40,40);" data-href="https://portal.engineering.utoronto.ca/weblogin/sites/apsc/main.asp?Page=Main"> Portal</div>
			
		</div>

		
		<div class="row" style="margin: 0px; padding: 0px;">

			<!-- side navigation -->
			<div class="col-sm-3 side-container">
				<div class="title-text">Company Name</div>
				<h2><?=$appInfo->company_name?></h2>
				<br />

				<div class="title-text">Company Position</div>
				<h4><?=$appInfo->position?></h4>
				<div class="title-text">Application Date</div>
				<h4><?=date("l, F t, Y", $appInfo->timestamp)?></h4>

				<div class="title-text">View</div>
				<div class="row">
					<div class="col-sm custom-btn btn-red item-clickable" data-href="http://ryan-coulson.com/JobApplicationDatabase/<?=$appInfo->cv?>">CV</div>
					<div class="col-sm custom-btn btn-blue item-clickable" data-href="http://ryan-coulson.com/JobApplicationDatabase/<?=$appInfo->resume?>">Resume</div>
				</div>
			</div>

			<!-- main content -->
			<div class="col-sm container" style="padding: 0px;">
				<div class="note-text">Company Notes</div>
				<textarea><?=$appInfo->notes?></textarea>
				<div class='lastsaved'>Last saved: never</div>
			</div>
		</div>
	</body>

	
</html>