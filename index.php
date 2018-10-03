<?php
require_once "connect.php";

if(isset($_GET['key'])) {
	if($_GET['key'] != $_PRIVATE_KEY) {
		die("Not authorized");
	}
} else {
	die("Not authorized");
}
?>

<html lang="en-US">
	<head>
		<title>Job Application Database</title>

		<!-- CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="resources/styles/stylesheet.css" />

		<!-- favicon -->
		<link rel="shortcut icon" type="image/png" href="resources/media/ryan-coulson-logo3.png"/>

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>

		<!-- fort awesome icons -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<script>
	// Awesome live search function retrieved from https://jsfiddle.net/umaar/t82gZ/
	$(document).ready(function(){
		// allows table rows to be clicked on as a link
	    $(".item-clickable").click(function() {
	        window.location = $(this).data("href");
	    });

		// Count position occurences
		$(".qs-option").each(function(){
			var count = 0;
			var position = $(this).children('.qs-position').text();

			if(position == "All") {
				position = "";
			}

		    $(".job-section").each(function(){
		        // If the list item does not contain the text phrase fade it out
		        if ($(this).text().search(new RegExp(position, "i")) >= 0) {
		            count++;

		        // Show the list item if the phrase matches and increase the count by 1
		        }
		    });
		    $(this).children('.qs-number').text("("+count+")");
		 });

	    $("#filter").keyup(function(){
	        // Retrieve the input field text and reset the count to zero
	        var filter = $(this).val();
	 
	        // Loop through the comment list
	        $(".job-section #name").each(function(){
	 
	            // If the list item does not contain the text phrase fade it out
	            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
	                $(this).parent().fadeOut();
	 
	            // Show the list item if the phrase matches and increase the count by 1
	            } else {
	                $(this).parent().show();
	            }
	        });
	    });

	    $(".qs-option").click(function(){
	        // Retrieve the input field text and reset the count to zero
	        var position = $(this).children('.qs-position').text();

	        if(position == "All") {
	        	position = "";
	        }

			// Loop through the comment list
	        $(".job-section").each(function(){
	 
	            // If the list item does not contain the text phrase fade it out
	            if ($(this).text().search(new RegExp(position, "i")) < 0) {
	                $(this).fadeOut();
	 
	            // Show the list item if the phrase matches and increase the count by 1
	            } else {
	                $(this).show();
	            }
	        });
	    });

	    $("#add-item").click(function() {
	    	$(".new-item-container").slideToggle();
	    });


	    // BEGIN UPLOADING
	    var resume_uploaded, cv_uploaded;

	    //$("#upload-submit").hide();

	    $("#upload-resume").on('change', function() {
	    	$("#resume-label").html("<i class='fas fa-spin fa-spinner icon-text'></i><div class='upload-text'>...</div>");

	    	var formData = new FormData();
	    	var fileInput = document.getElementById("upload-resume");
	    	var file = fileInput.files[0];
	    	formData.append('file', file);
	    	formData.append('type', 'resume')

			$.ajax({
			    // Your server script to process the upload
			    type: "POST",
			    url: "uploadfile.php",

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

						// check if both have been uploaded
						resume_uploaded = 1;
						if(resume_uploaded && cv_uploaded) {
							$("#upload-submit").fadeIn();
							resume_uploaded = cv_uploaded = 0;
						}

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

			$.ajax({
			    // Your server script to process the upload
			    type: "POST",
			    url: "uploadfile.php",

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

						// check if both have been uploaded
						cv_uploaded = 1;
						if(resume_uploaded && cv_uploaded) {
							$("#upload-submit").fadeIn();
							resume_uploaded = cv_uploaded = 0;
						}

						// Set location to the newly uploaded file
						btn.data("href", response.substring(7, response.length+1));
					} else {
						alert(response);
						$("#cv-label").html("<i class='fas fa-upload icon-text'></i><div class='upload-text'>CV</div>");
					}
					
				}
			});
	    });

	    $("#upload-submit").click(function() {
	    	var resumeFile = $("#resume-label").data("href");
	    	var cvFile = $("#cv-label").data("href");
	    	var appName = $("#app-name").val();
	    	var appPos = $("#app-pos").val();

	    	$.ajax({
	    		type: "POST",
	    		url: "submitapp.php",
	    		data: {'submit': true, 'app-name': appName, 'app-pos': appPos,
	    				'app-res': resumeFile, 'app-cv': cvFile},
	    		success: function(response) {
	    			if(response.length > 0) {
	    				alert(response);
	    			} else {
	    				window.location = "index.php?key=dMb8rvHgC4wDQVF";
	    			}
	    		}
	    	});
	    });

		var positions = ["Software Developer", "Software Engineer", "Web Developer", "Full Stack Developer"];

	    $(".autofill-pos").autocomplete({
	    	source: positions
	    });
	});
	</script>
	</head>
	<body>

		<!-- top navigation -->
		<div class="top-navigation">
			<img src="resources/media/ryan-coulson-logo3.png" />
			<div class="nav-btn" id="add-item"><i class="fa fa-file"></i>Add New</div>
			<div class="nav-btn item-clickable" style="background: rgb(100,40,40);" data-href="https://www.uoftengcareerportal.ca/myAccount/dashboard.htm">Portal</div>
		</div>

		
		<div class="row" style="margin: 0px; padding: 0px;">

			<!-- side navigation -->
			<div class="col-sm-3 side-container">
				<input type="text" name="query" id="filter" placeholder="Enter Query" autocomplete="off" />

				<h3>Position Filter</h3>

				<?php
				$options = array("All", "Software Developer", "Software Engineer", "Website Developer", "Full Stack Developer");

				foreach($options as $option) {
					echo "
					<div class='qs-option'>
						<span class='qs-position'>$option</span>
						<div class='qs-number'></div>
					</div>
					";

				}
				?>
			</div>

			<!-- main container -->
			<div class="col-sm container" style="margin:0px;padding:0px;">
				<!-- slide down panel -->
				<div class="new-item-container">

					<form action="" enctype="multipart/form-data" >
						<div class="row">
							<div class="col-md-8">
								<h3>Add New Application</h3>
								<label for="name">Company Name</label>
								<input type="text" id="app-name" autocomplete="off" /><br />
								
								<label for="position">Position</label>
								<input type="text" class="autofill-pos" id="app-pos" autocomplete="off" /><br />

								<label for="submit"></label>
								<div class="custom-btn btn-green" id="upload-submit">Submit</div>
							</div>
							<div class="col-sm">
								<h3>Upload</h3>
								<div class="upload-btn btn-blue item-clickable" style="width:80px;" data-href="#" id="resume-btn">
									<button id='resume-label'>
										<i class='fas fa-upload icon-text'></i>
										<div class='upload-text'>Resume</div>
									</button>
									<input type="file" id="upload-resume" value="none" name="app-res"/>
								</div>

								<div class="upload-btn btn-red item-clickable" style="width:80px;" data-href="#" id="cv-btn">
									<button id='cv-label'>
										<i class='fas fa-upload icon-text'></i>
										<div class='upload-text'>CV</div>
									</button>
									<input type="file" id="upload-cv" name="app-cv"/>
								</div>
							</div>
						</div>
					</form>
				</div>

				<!-- content -->
				<div class="content-container">
					<table style="width: 100%;">
						<tr class="row job-header">
							<td class="col-sm-6">Company Name</td>
							<td class="col-sm-3">Position</td>
							<td class="col-sm-2 job-date">Application Date</td>
							<td class="col-sm-1">Complete</td>
						</tr>

				<?php
				$fetchApplications = mysql_query("SELECT * FROM `application` WHERE `archived`='0'");
				$countApps = mysql_num_rows($fetchApplications);

				if($countApps == 0) {
					echo "
						</table>
						<center>Nothing seems to be here.</center>
					";
				}

				while($appInfo = mysql_fetch_object($fetchApplications)) {
					echo "
						<tr class='row job-section item-clickable' data-href='app/$appInfo->id/'>
							<td class='col-sm-6' id='name'>$appInfo->company_name</td>
							<td class='col-sm-3 job-center'>$appInfo->position</td>
							<td class='col-sm-2 job-center'>".date("m/d/Y", $appInfo->timestamp)."</td>
					";

					if($appInfo->cv && $appInfo->resume) {
						echo "
							<td class='col-sm-1 job-complete'><i class='fa fa-check'></i></td>
						";					
					} else {
						echo "
							<td class='col-sm-1 job-complete'></td>
						";				
					}


					echo "
						</tr>
					";
				}
				?>
					</table>
				</div>
			</div>
		</div>
	</body>

	
</html>