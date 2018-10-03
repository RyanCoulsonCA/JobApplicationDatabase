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
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>

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

		$("#upload-resume").on('change', function() {
	    	$("#resume-label").html("<i class='fas fa-spin fa-spinner icon-text'></i><div class='upload-text'>...</div>");

	    	var formData = new FormData();
	    	var fileInput = document.getElementById("upload-resume");
	    	var file = fileInput.files[0];
	    	formData.append('file', file);
	    	formData.append('type', 'resume');
	    	formData.append('update', 'true');
	    	formData.append('entryid', <?=$id?>);

			$.ajax({
			    // Your server script to process the upload
			    type: "POST",
			    url: "../../uploadfile.php",

			    // Form data
			    data: formData,

		        cache: false,
		        contentType: false,
		        processData: false,

				success: function(response) {
					if(response.substring(0,7) == "success") {
						var btn = $("#resume-label");
						btn.addClass("upload-success");
						btn.html("<i class='fas fa-check icon-text'></i><div class='upload-text'>Resume</div>");

						// Set location to the newly uploaded file
						btn.data("href", response.substring(7, response.length+1));
					} else {
						alert(response);
						$("#resume-label").html("<i class='fas fa-upload icon-text'></i><div class='upload-text'>Resume</div>");
					}
					
				}
			});
	    });

	    $("#upload-cv").on('change', function() {
	    	$("#cv-label").html("<i class='fas fa-spin fa-spinner icon-text'></i><div class='upload-text'>...</div>");

			var formData = new FormData();
	    	var fileInput = document.getElementById("upload-cv");
	    	var file = fileInput.files[0];
	    	formData.append('file', file);
	    	formData.append('type', 'cv');
	    	formData.append('update', 'true');
	    	formData.append('entryid', <?=$id?>);

			$.ajax({
			    // Your server script to process the upload
			    type: "POST",
			    url: "../../uploadfile.php",

			    // Form data
			    data: formData,

		        cache: false,
		        contentType: false,
		        processData: false,

				success: function(response) {
					if(response.substring(0,7) == "success") {
						var btn = $("#cv-label");
						btn.addClass("upload-success");
						btn.html("<i class='fas fa-check icon-text'></i><div class='upload-text'>CV</div>");

						// Set location to the newly uploaded file
						btn.data("href", response.substring(7, response.length+1));
					} else {
						alert(response);
						$("#cv-label").html("<i class='fas fa-upload icon-text'></i><div class='upload-text'>CV</div>");
					}
					
				}
			});
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
					<form action="#" style="width: 100%;" enctype="multipart/form-data">
					<?php if($appInfo->cv) { ?>
					<div class="col-sm custom-btn btn-red item-clickable" data-href="http://ryan-coulson.com/JobApplicationDatabase/<?=$appInfo->cv?>">CV</div>
					<?php } else { ?>

					<div class="col-sm upload-btn custom-btn btn-red" data-href="#" id="cv-btn">
						<button id='cv-label'>
							<i class='fas fa-upload icon-text'></i>
							<div class='upload-text'>Upload CV</div>
						</button>
						<input type="file" id="upload-cv" value="none" name="app-res"/>
					</div>

					<?php } if($appInfo->resume) { ?>
					<div class="col-sm custom-btn btn-blue item-clickable" data-href="http://ryan-coulson.com/JobApplicationDatabase/<?=$appInfo->resume?>">Resume</div>
					<?php } else {?>
					<div class="col-sm upload-btn custom-btn btn-blue" data-href="#" id="resume-btn">
						<button id='resume-label'>
							<i class='fas fa-upload icon-text'></i>
							<div class='upload-text'>Upload Resume</div>
						</button>
						<input type="file" id="upload-resume" value="none" name="app-res"/>
					</div>
					<?php } ?>
					</form>
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