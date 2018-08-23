<html lang="en-US">
	<head>
		<title>Job Application Database</title>

		<!-- CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="resources/styles/stylesheet.css" />

		<!-- favicon -->
		<link rel="shortcut icon" type="image/png" href="resources/media/ryan-coulson-logo3.png"/>

		<!-- fort awesome icons -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	</head>
	<body>

		<!-- top navigation -->
		<div class="top-navigation">
			<img src="resources/media/ryan-coulson-logo3.png" />
			<div class="nav-btn"><i class="fa fa-file"></i>Add New</div>
		</div>

		
		<div class="row" style="margin: 0px; padding: 0px;">

			<!-- side navigation -->
			<div class="col-sm-3 side-container">
				<input type="text" name="query" placeholder="Enter Query" autocomplete="off" />

				<h3>Quick Position Search</h3>
				<div class="qs-option">
					<span class="qs-position">Software Engineering Intern</span>
					<div class="qs-number">(1)</div>
				</div>
				<div class="qs-option">
					<span class="qs-position">Graphic Design Intern</span>
					<span class="qs-number">(1)</span>
				</div>
			</div>

			<!-- main content -->
			<div class="col-sm container">
				<table style="width: 100%;">
					<tr class="row job-header">
						<td class="col-sm-6">Company Name</td>
						<td class="col-sm-3">Position</td>
						<td class="col-sm-2 job-date">Application Date</td>
						<td class="col-sm-1">Complete</td>
					</tr>
					<tr class="row job-section">
						<td class="col-sm-6">Google</td>
						<td class="col-sm-3 job-center">Software Engineering Intern</td>
						<td class="col-sm-2 job-center">08/23/2018</td>
						<td class="col-sm-1 job-complete"><i class="fa fa-check"></i></td>
					</tr>
					<tr class="row job-section">
						<td class="col-sm-6">Google</td>
						<td class="col-sm-3 job-center">Software Engineering Intern</td>
						<td class="col-sm-2 job-center">08/23/2018</td>
						<td class="col-sm-1 job-complete"><i class="fa fa-check"></i></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>