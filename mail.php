<?php
	include 'include_this.php';
	/**
	 * code to create an object of group class
	 * and store group data required for current context into
	 * onject of that class
	 */
	include 'libs/groups.php';
	$grpObj = new group(100000);
	$grpObj->getMailingList();
	
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
	<link href="css/mmt.css" rel="stylesheet">
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
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Form Elements</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal">
						  <fieldset>
							<legend>Send Mails</legend>
							<div class="control-group">
								<label class="control-label">Select Group(s)</label>
								<div class="controls">
								  <?php 
								  	foreach ($grpObj->grp as $grp)
								  	{
								  		?>
								  		<label class="checkbox inline">
											<input type="checkbox" id="inlineCheckbox1" value=" <?php echo $grp['name']; ?> "> <?php echo $grp['name']; ?>
										</label>
								  		<?php 	
								  	}
								  ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="selectError1">Add Recipients</label>
								<div class="controls">
								  <select id="selectError1" multiple data-rel="chosen">
									
								  </select>
								  <span class="help-inline" id="email-all"><label class="checkbox inline"><input type="checkbox" id="inlineCheckbox2" value="All">All</label></span>
								</div>
							 </div>
							<div class="control-group">
								<label class="control-label" for="focusedInput">Subject</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="subject" type="text" placeholder="Enter Subject">
								</div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="fileInput">File input</label>
							  <div class="controls" id="file-upload-container">
								<input class="input-file uniform_on" id="fileInput" type="file">
								<span class="help-inline" id="upload-help"></span>
							  </div>
							</div>          
							<div class="control-group">
							  <label class="control-label" for="textarea2">Textarea WYSIWYG</label>
							  <div class="controls">
								<textarea class="cleditor" id="email-body" rows="3"></textarea>
							  </div>
							</div>
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary" onclick="sendemail();return false;">Save changes</button>
							  <button type="reset" class="btn">Cancel</button><br>
							  <span class="help-inline" id="email-notif" style="color:red;"></span>
							</div>
						  </fieldset>
						</form>   

					</div>
				</div>
			</div>
			<div class="row-fluid ">		

				
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
	<script>
		/**
		 * this script adds email recipients according to groups
		 * 
		 * 
		 */
		 var uploadflag=0;
		
		$(document).ready(function(){
			 $(".chzn-container").css("width","600px"); 
			 $("#email-all").css("position","relative").css("top","-14px");
		});
	<?php 
		
		foreach($grpObj->grp as $grp)
		{
			?>
				localStorage['<?php echo $grp['name']?>']="<?php echo $grp['emails'];?>";
			<?php 
		}
	?>
		$("label.checkbox").click(function(e){
			var checkbox = $(this).find("#inlineCheckbox1:checked");
			var count = 0;
			if(checkbox.length>0 && !checkbox.hasClass("added"))
			{
				checkbox.addClass("added");
				grpName = $.trim(checkbox.val());
				if(grpName=="all")
				{
					$("input[id*='inlineCheckbox1']").each(function(){
						if($.trim($(this).val())!="all")
						{
							$(this).attr("disabled","");
							$(this).parent().parent().addClass("disabled");
						}
					});
				}
				emailArray = new Array();
				emailArray = localStorage[grpName].split("- -");
				console.log(emailArray);
				for(x in emailArray)
				{
					if(emailArray[x].length>0)
					{
						$("#selectError1").append("<option grpName='"+grpName+"' value='"+emailArray[x]+"'>"+emailArray[x]+"</option>");
						$("#selectError1").trigger("liszt:updated");
					}
				}

				message = $("option:selected").map(function(){ return this.value }).get().join(", ");
				console.log(message);
				
			}
			else if(checkbox.hasClass("added"))
			{
				grpName = $.trim($(this).find("input:checkbox").val());
				if(grpName=="all")
				{
					$("input[id*='inlineCheckbox1']").each(function(){
						if($.trim($(this).val())!="all")
						{
							$(this).removeAttr("disabled");
							$(this).parent().parent().removeClass("disabled");
						}
					});
				}
				$("option[grpName*='"+grpName+"']").each(function(){$(this).remove();});
				$("#selectError1").trigger("liszt:updated");
				checkbox.removeClass("added");
			}
		});
		
		$("input#inlineCheckbox2").click(function(){
			if($(this).prop("checked"))
			{
				$("#selectError1 option").each(function(){$(this).prop("selected",true);});
				$("#selectError1").trigger("liszt:updated");
			}
			else
			{
				$("#selectError1 option").each(function(){$(this).prop("selected",false);});
				$("#selectError1").trigger("liszt:updated");
			}
		});
		
		$('#fileInput').change(function () {
			  sendFile(this.files[0]);
			});

			function sendFile(file) {
			  $.ajax({
			    type: 'post',
			    url: 'secure/upload.php?name=' + file.name,
			    data: file,
			    success: function (data) {
			    },
			    xhrFields: {
			      // add listener to XMLHTTPRequest object directly for progress (jquery doesn't have this yet)
			      onprogress: function (progress) {
			        // calculate upload progress
			        var percentage = Math.floor((progress.total / progress.totalSize) * 100);
			        // log upload progress to console
			        $("#upload-help").html(percentage+"% Uploaded");
			        if (percentage === 100) {
			        	$("#upload-help").html("Done Uploading");
			        	setupload(1);
			        }
			      }
			    },
			    processData: false,
			    contentType: file.type
			  });
			}
		function setupload(x)
		{
			uploadflag=x;
		}

		function sendemail()
		{
			var subject = $("#subject").val();
			regex = /[a-z0-9 -.]/i;
			if(!regex.test(subject)){$("#email-notif").html("Error in subject");return;}
			var body = $("#email-body").val();
			if(!(body.length>0)){$("#email-notif").html("Email body left empty");return;}

			var reci = new Array();
			$("#selectError1 option:selected").each(function(){reci[reci.length]=$(this).val();});

			var reci=reci.filter(function(itm,i,reci){
			    return i==reci.indexOf(itm);
			});
			if(uploadflag)
			{
				var uploadfile = $("#fileInput").val();
				for(var x in reci)
				{
					
						$.ajax({
							url:'libs/mailsender.php',
							type:'post',
							data:{subject:subject,text:body,attachment:uploadfile,recepient:reci[x]},
							success:function(data){
								$("#email-notif").append(data);
							}
						});
					
				}
			}
			else
			{
				for(var x in reci)
				{
					
						$.ajax({
							url:'libs/mailsender.php',
							type:'post',
							data:{subject:subject,text:body,recepient:reci[x]},
							success:function(data){
								$("#email-notif").append(data);
							}
						});
					
				}
			}
		}
	</script>
	
</body>
</html>
