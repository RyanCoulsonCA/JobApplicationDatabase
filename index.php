<?php
require_once "connect.php";
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

	    $("#upload-resume").on('change', function() {
	    	$("#resume-label").html("<i class='fas fa-spin fa-spinner'></i> Uploading...");

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
						var btn = $("#resume-btn");
						btn.addClass("upload-success");
						btn.html("<i class='fas fa-check'></i> View Resume");

						// Set location to the newly uploaded file
						btn.data("href", response.substring(7, response.length+1));
					} else {
						alert(response);
						$("#resume-label").html("<i class='fas fa-upload'></i> Upload Resume");
					}
					
				}
			});
	    });

	    $("#upload-cv").on('change', function() {
	    	$("#cv-label").html("<i class='fas fa-spin fa-spinner'></i> Uploading...");

			var formData = new FormData();
	    	var fileInput = document.getElementById("upload-cv");
	    	var file = fileInput.files[0];
	    	formData.append('file', file);
	    	formData.append('type', 'cv')

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
					if(response == "success") {
						var btn = $("#cv-btn");
						btn.addClass("upload-success");
						btn.html("<i class='fas fa-check'></i> View CV");

						// Set location to the newly uploaded file
						btn.data("href", response.substring(7, response.length+1));
					} else {
						alert(response);
						$("#cv-label").html("<i class='fas fa-upload'></i> Upload CV");
					}
					
				}
			});
	    });
	});
	</script>
	</head>
	<body>

		<!-- top navigation -->
		<div class="top-navigation">
			<img src="resources/media/ryan-coulson-logo3.png" />
			<div class="nav-btn" id="add-item"><i class="fa fa-file"></i>Add New</div>
		</div>

		
		<div class="row" style="margin: 0px; padding: 0px;">

			<!-- side navigation -->
			<div class="col-sm-3 side-container">
				<input type="text" name="query" id="filter" placeholder="Enter Query" autocomplete="off" />

				<h3>Position Filter</h3>
				<div class="qs-option">
					<span class="qs-position">All</span>
					<div class="qs-number"></div>
				</div>
				<div class="qs-option">
					<span class="qs-position">Software Engineering Intern</span>
					<div class="qs-number"></div>
				</div>
				<div class="qs-option">
					<span class="qs-position">Graphic Design Intern</span>
					<span class="qs-number"></span>
				</div>
			</div>

			<!-- main container -->
			<div class="col-sm container" style="margin:0px;padding:0px;">
				<!-- slide down panel -->
				<div class="new-item-container">
					<h3>Add New Application</h3>

					<form enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm">
								Company Name
								<input type="text" />
							</div>
							<div class="col-sm">
								Position
								<input type="text" />
							</div>
						</div>
						<!-- <i class="fas fa-spin fa-spinner"></i> -->
						<center>
							<div class="upload-btn btn-blue item-clickable" data-href="#" id="resume-btn">
								<button id='resume-label'><i class='fas fa-upload'></i> Upload Resume</button>
								<input type="file" id="upload-resume" name="test"/>
							</div>

							<div class="upload-btn btn-red item-clickable" data-href="#" id="cv-btn">
								<button id='cv-label'><i class='fas fa-upload'></i> Upload CV</button>
								<input type="file" id="upload-cv" name="test"/>
							</div>
						</center>
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

					if($appInfo->complete) {
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