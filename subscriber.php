<?php
	include 'include_this.php';
	/**
	 * task: get list of subscribers from db
	 */
	$subsObj = new subscribers(20,1);
	/**
	 * this function retrieves the subscriber list and store it to the array
	 * which can be used anywhere
	 */
	$subsObj->getSubscribers();
	
	/**
	 * function to get latest 10 subscribers
	 */
	$latestSubs = subscribers::getLatestSubscribers();

	dbase::close_connection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MMT subscribers</title>
	<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/uniform.default.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="img/favicon.ico">
</head>

<body>
		<!-- topbar starts -->
	<?php include 'ui_includes/top_navbar.php';?>
	<!-- topbar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
				
			<!-- left menu starts -->
			<?php include 'ui_includes/sidebar.php';?>
			<!-- left menu ends -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<div id="content" class="span10">
			<!-- content starts -->
			

			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Subscribers</a>
					</li>
				</ul>
			</div>
			<?php include 'ui_includes/displaybox.php';?>
			<div class="row-fluid">
				<div class="box span4">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Add subscribers manually</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div class="box-content">
							<form action="javascript: addEmail();return false;" method="post">
							<div class="input-append">
									<input type="checkbox" name='sendMail' id='sendMail'> Send subscription mail
									<br><br>
									<input placeholder='someone@example.com' id="addEmailid" name="subs_search" size="16" type="email" required>
									<button class="btn" type="button" onclick="this.form.submit()">Add!</button>
									<br>
									Add multiple emails
									<br>
									<textarea id='addMultEmail' style="width: 90%;min-height: 60px;" placeholder='comma seperated...' ></textarea>
							</div>	
						</form>
						</div>
					</div>
				</div>
				<div class="box span4">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i>Latest subscribets </h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div class="box-content">
							<?php
								$len = count($latestSubs);
								for($i = 0;$i<$len;$i++)
								{
									echo " " .$latestSubs[$i]['email'] ." &nbsp;<span class='label label-info'> " .$latestSubs[$i]['date'] ." </span> <br>";
								}
							?>
						</div>
					</div>
				</div>
				<div class="box span4">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Subscription form</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div class="box-content">
							Just add this html code to your web pages to add 
							<span class="label label-success"> subscribe me </span> button!
							<br><br>
							<textarea rows="3" style="height: 100px;width: 90%"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row-fluid ">		
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-user"></i> Subscribers
							<span class="pagin_loader">
								<img src="img/ajax-loaders/ajax-loader-7.gif">
							</span>
						</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
					<div class="box-content">
						<div class="input-append" style="display: inline;width: 30%;float: left">
							<form action="" method="post">
								<input id="appendedInputButton subs_search" name="subs_search" size="16" type="text">
								<button class="btn" type="button">Search!</button>
							</form>
						</div>	
						<div style="display: inline;width: 40%;float: right">
							<?php
							if(isset($accessObj->accessLevel['group-AE']))
							{
							?>
							<a class="btn btn-info disabled" id="add_group" href="#" onclick="javascript: document.getElementById('task').value = 'ADD_GROUP';document.forms['emails'].submit();">
								<i class="icon-plus icon-white"></i>  
								Add to group                                           
							</a>
							<?php 
							}
							if(isset($accessObj->accessLevel['group-RE']))
							{
							?>
							<a class="btn btn-danger disabled" id="remove_grp" href="#"  onclick="javascript: document.getElementById('task').value = 'REMOVE_GROUP';document.forms['emails'].submit();">
							<i class="icon-trash icon-white"></i> 
							Remove from groups
							</a>
							<?php
							} 
							if(isset($accessObj->accessLevel['email-D']))
							{
							?>
								<a class="btn btn-danger disabled" href="#" id="delete_button" onclick="javascript: document.getElementById('task').value = 'REMOVE';document.forms['emails'].submit();">
								<i class="icon-fire icon-white"></i> 
								Delete
								</a>
							<?php } ?>
						</div>
						
						<div class="clearfix"></div>
					</div>
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
						<div class="row-fluid">
						<form name="emails" action="" id="emails" method="post" onsubmit="javascript:if(document.getElementById('task').value=='')return false;" >
						<input type="hidden" value="" name="task" id="task">
						<table class="table table-striped table-bordered" id="displayTable" aria-describedby="">
						  <thead>
							<tr role="row">
								<th class="sorting_asc" style="width: 40px;">
									<!-- <input type="checkbox" id="mailid" class="selectallcheckbox"> -->
								</th>
								<th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Username: activate to sort column descending" style="width: 201px;"> Email</th>
								<th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Date registered: activate to sort column ascending" style="width: 199px;">Date registered</th>
								<th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 96px;">Groups</th>
								<th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 378px;">Actions</th>
							</tr>
						  </thead>   
						  
					  <tbody role="alert" aria-live="polite" aria-relevant="all">
					  <?php 
					  	$len = count($subsObj->subs);
					  	for($i = 0; $i<$len; $i++)
					  	{
					  		echo '<tr class="odd">';
							echo "<td><input type='checkbox' name='id[]' id='mailid' class='select' value='" .$subsObj->subs[$i]['id'] ."'></td>";
					  		echo "<td class='sorting_'>" .$subsObj->subs[$i]['email'];
							echo "</td>";
					  		echo "<td class='center'>" .$subsObj->subs[$i]['date'] ."</td>";
					  		echo "<td class='center '>";
					  		$nos = count($subsObj->subs[$i]['group']);
					  		for($j = 0; $j<$nos; $j++)
					  		{
					  			echo "<span class='label label-important'>" .$subsObj->subs[$i]['group'][$j]['gp_name'] ."</span> ";
					  		}
							echo "</td>";
					  		echo "<td class='center'></td>";
					  		echo '</tr>';
					  	}
					  
					  ?>
							
						</tbody>
						</table>
						</form>
						<br>
						<div>
							<div class="pagination pagination-centered">
								<ul>
									<li class='pagin pagin_pre <?php if($subsObj->page == 1)echo " disabled"; ?>' pageno='<?php echo $subsObj->page - 1; ?>'><a href="#">Prev</a></li>
									<li class='pagin_max' style='display: none' pageno='<?php echo $subsObj->totalPages; ?>'></li>
									<?php
										for($i = 1;$i<= $subsObj->totalPages;$i++)
										{
											echo '<li class="pagin pagin_ ';
											if($subsObj->page == $i)echo '  active';
											echo '" pageno="' .$i .'"><a href="#">' .$i .'</a></li>';
										}
									?>
									<li class='pagin pagin_next <?php if($subsObj->page == $subsObj->totalPages)echo " disabled"; ?>' pageno='<?php echo $subsObj->page + 1; ?>'><a href="#">Next</a></li>
								</ul>
								<br>
								<div class="pagin_loader">
									<img src="img/ajax-loaders/ajax-loader-7.gif">
								</div>
							</div>
						</div>
					</div>            
					</div>
				</div><!--/span-->
			
			</div>
				
		<hr>

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>

		<?php include 'ui_includes/footer.php';?>
		
	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	
	<!-- jQuery UI -->
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.min.js"></script>
	<script src="js/jquery.flot.pie.min.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="js/charisma.js"></script>
	
		
</body>
</html>
