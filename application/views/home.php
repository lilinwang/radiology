<!DOCTYPE html>
<html lang="en" ng-app="radiology_protocol">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Radiology Protocols</title>
	
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">    		     
	<link href="font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="css/sb-admin-2.css" rel="stylesheet">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="css/datepicker.css">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	 <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>		
	<script type="text/javascript" src="js/jquery-ui.js"></script>	
    <script type="text/javascript" src="js/bootstrap-filestyle.js"> </script>
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>
    <script src="js/sb-admin-2.js"></script>	
	<script src="js/bootbox.min.js"></script>	
	<script type="text/javascript" src="js/angular.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">	
	var opt={				
		height: 150,
        width: 250,
		autoOpen: false,		
	}
	function sentNotification(e){
		$(e).prop('disabled', true);
	}
	function upload(){						
		var file_data = $("#userfile").prop("files")[0];   		
		var fileName = $("#userfile").val();
		//var user_name = '@Session["user_name"]';
		
		if(fileName.lastIndexOf("csv")===fileName.length-3){										
			$('#upload-icon').html('<i class="fa fa-spin fa-spinner"></i>');
			var form_data = new FormData();                  
			form_data.append("file", file_data);  
			//form_data.append("username", user_name);  
			$.ajax({
                url: "ajax/upload",               
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
				enctype: 'multipart/form-data',
                complete: function(data){				
					//console.log(data['responseText']);																                   									
					var response = JSON.parse(data['responseText']);
					//console.log(response);
					$('#upload-icon').html('<i class="fa fa-upload"></i>');					
					$("#dialog").html("<p>Import success!</p>");
					var theDialog = $("#dialog").dialog(opt);					
					var dialog = theDialog.dialog("open");
					setTimeout(function() { dialog.dialog("close"); }, 1000);
					//alert(response.length);
					//$('#import-result').html(response.length);
					$('#import-result').html("<h3>Imported protocols:</h3></br>");
					
					/*for (var i=0;i<response[0].length;i++){							
						
							$('#import-result').append("<div class='form-group row'><label class='col-md-3 control-label'>"+response[0][i]+"</label><label class='col-md-3 control-label'>"+response[1][i]+"</label><label class='col-sm-2'>"+response[2][i]+"</label><button class='btn btn-primary btn-sm' onclick='sentNotification(this)'>Send Notification</button></div>");						
					}*/					
					for (var i=0;i<response[0].length;i++){							
						if (response[1][i]!=2){
							$('#import-result').append("<div class='form-group row'><label class='col-md-3 control-label'>"+response[0][i]+"</label><label class='col-md-3 control-label'>"+response[1][i]+"</label><label class='col-sm-2'>"+response[2][i]+"</label><button class='btn btn-primary btn-sm' onclick='sentNotification(this)'>Send Notification</button></div>");
						}
					}	
					for (var i=0;i<response[0].length;i++){							
						if (response[1][i]==2){
							$('#import-result').append("<div class='form-group row'><label class='col-md-3 control-label'>"+response[0][i]+"</label><label class='col-md-3 control-label'>"+response[1][i]+"</label><label class='col-sm-2'>"+response[2][i]+"</label></div>");
						}
					}
                }
			});				            			     	
		}else{
			$("#dialog").html("<p>Not csv file choosen!</p>");
			var theDialog = $("#dialog").dialog(opt);					
			var dialog = theDialog.dialog("open");
			setTimeout(function() { dialog.dialog("close"); }, 1000);
		}
	};			
	
	</script>
</head>

<body ng-controller="PanelController as panel">
<script>

</script>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home">Radiology Protocols</a>
            </div>
            <!-- /.navbar-header -->
			<ul class="nav navbar-top-links navbar-left">
				<li ng-repeat="section in sections" ng-class="{ active: panel.isSelected(section)}">
					<a href ng-click="panel.select(section)">{{section}}</a> 
				</li>					
			</ul>
			
            <ul class="nav navbar-top-links navbar-right">      
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/radiology/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
					
            <div class="navbar-default sidebar" role="navigation">				
                <div class="sidebar-nav navbar-collapse">					
                    <ul class="nav" id="side-menu">
						<li>
							<h4 class="navbar-brand">protocols</h4>
						</li>
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" ng-model="search_key" ng-keyup="$event.keyCode == 13 && panel.searchprotocols()" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" ng-click="panel.searchprotocols()" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Neuro CT<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li> <a href ng-click="panel.selectprotocols('CT','head')">Head</a></li>						                               
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','neck')">Neck</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Cervical Spine')">Cervical Spine</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Thoracic Spine')">Thoracic Spine</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Lumbar Spine')">Lumbar Spine</a>
                                </li>
								<li>
                                    <a href ng-click="panel.selectprotocols('CT','Lumbar Spinal Cord')">Lumbar Spinal Cord</a>
                                </li>
								<li>
                                    <a href ng-click="panel.selectprotocols('CT','Brachial Plexus')">Brachial Plexus</a>
                                </li>
								<li>
                                    <a href ng-click="panel.selectprotocols('CT','Facial Bones')">Facial Bones</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Musculoskeletal CT<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Ankle')">Ankle</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Foot')">Foot</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','neShoulderck')">Shoulder</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Wrist')">Wrist</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Hand')">Hand</a>
                                </li>
								<li>
                                    <a href ng-click="panel.selectprotocols('CT','Pelvis')">Pelvis</a>
                                </li>
								<li>
                                    <a href ng-click="panel.selectprotocols('CT','Hip')">Hip</a>
                                </li>
								<li>
                                    <a href ng-click="panel.selectprotocols('CT','Knee')">Knee</a>
                                </li>
								<li>
                                    <a href ng-click="panel.selectprotocols('CT','Variable')">Variable</a>
                                </li>								
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Body CT<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Abdomen/Pelvis')">Abdomen/Pelvis</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Others')">Others</a>
                                </li>                                	
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Cardiac CT<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Heart')">Heart</a>
                                </li>                                                          
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href href ng-click="panel.selectprotocols('MR','')"><i class="fa fa-wrench fa-fw"></i> Body MR</a>                            
                        </li>
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Neuro MR<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href ng-click="panel.selectprotocols('MR','Head')">Head</a>
                                </li>                                                          
								<li>
                                    <a href ng-click="panel.selectprotocols('MR','neck')">Neck</a>
                                </li> 
								<li>
                                    <a href ng-click="panel.selectprotocols('MR','Cervical Spine')"> Cervical Spine</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('MR','Thoracic Spine')">Thoracic Spine</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('MR','Lumbar Spine')">Lumbar Spine</a>
                                </li>
								<li>
                                    <a href ng-click="panel.selectprotocols('MR','CTL Spine')">CTL Spine</a>
                                </li> 
								<li>
                                    <a href ng-click="panel.selectprotocols('MR','Variable')">Variable</a>
                                </li> 
								<li>
                                    <a href ng-click="panel.selectprotocols('MR','others')">others</a>
                                </li> 
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper" name="home">
			<div ng-show="panel.isSelected('Home')">				 
			<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Home</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>            
            <!-- /.row -->
			<div class="row">
                <div class="col-lg-12">
				Welcome to the radiology.com web site. This is the world’s first site that can convert MR & CT scanning sequence parameters in machine language directly into an easily readable format, and allow you to download a file to import directly into your own scanner without the time consuming practice of entering every sequence manually. Please visit our about page for more information. We are currently adding new protocols to this site in every category.
				</div>
			</div>
			</div>
					
			
			<div ng-show="panel.isSelected('Import')">						
						<div  class="input-group" style="width:500px;margin-left:15px;height:50px;">
							<span class="input-group-btn">
								<span class="input-group-btn">
								<input type="file" class="filestyle" data-buttonText="Choose csv file" id="userfile" name='userfile' >
								</span>
                                <span class="input-group-btn">
									
                                    <button class="btn btn-default" onclick="upload()" name="submit" type="button" id="upload-icon">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </span>
							</span>
                        </div>									
						<div id='import-result'></div>
			</div>
			
			
			<div ng-show="panel.isSelected('Protocols')">				 
			<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Protocols</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>       
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DataTables Advanced Tables
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
											<th>protocol ID</th>
                                            <th>protocol Name</th>
                                            <th>Code</th>
                                            <th>Description</th>
											<th>Modality</th>
                                            <th>General Body Part</th>
											<th>Body Part Code</th>
                                            <th>Detailed Body Part</th>
                                            <th>Approval date</th>
                                            <th>Golive date</th>
                                            <th>Approved by</th>																				
										</tr>
                                    </thead>
                                    <tbody>										 																			
                                        <tr class="odd gradeX" ng-repeat="protocol in protocols" ng-click="panel.showDetailedProtocol(protocol.protocol_number,protocol.modality,protocol.bodypart_full)" style="cursor: pointer">										
											<td>	
												{{protocol.protocol_number}}																
											</td>
                                            <td>{{protocol.protocol_name}}</td>											
                                            <td>{{protocol.code}}</td>
                                            <td>{{protocol.description}}</td>
											<td>{{protocol.modality}}</td>
                                            <td class="center">{{protocol.bodypart}}</td>
                                            <td class="center">{{protocol.bodypart_code}}</td>
											<td>{{protocol.bodypart_full}}</td>
                                            <td>{{protocol.approval_date}}</td>
                                            <td>{{protocol.golive_date}}</td>
											<td>{{protocol.approved_by}}</td>                                            								
                                        </tr>                                       
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->                           
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			</div>	
						
		 <div class="row" ng-show="panel.isSelected('DetailedProtocol')">
							 
			<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Detailed Protocol</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>       
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Protocol
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
											<th>protocol ID</th>
                                            <th>protocol Name</th>
                                            <th>Code</th>
                                            <th>Description</th>
											<th>Modality</th>
                                            <th>General Body Part</th>
											<th>Body Part Code</th>
                                            <th>Detailed Body Part</th>
                                            <th>Approval_date</th>
                                            <th>Golive date</th>
                                            <th>Approved by</th>									
										</tr>
                                    </thead>
                                    <tbody>										 																			
                                        <tr class="odd gradeX" ng-repeat="protocol in protocols">										
											<td>		
												{{protocol.protocol_number}}
											</td>
                                            <td>{{protocol.protocol_name}}</td>											
                                            <td>{{protocol.code}}</td>
                                            <td>{{protocol.description}}</td>
											<td>{{protocol.modality}}</td>
                                            <td class="center">{{protocol.bodypart}}</td>
                                            <td class="center">{{protocol.bodypart_code}}</td>
											<td>{{protocol.bodypart_full}}</td>
                                            <td>{{protocol.approval_date}}</td>
                                            <td>{{protocol.golive_date}}</td>
											<td>{{protocol.approved_by}}</td>                                            									 
                                        </tr>                                       
                                    </tbody>
                                </table>
								 </div>
                            <!-- /.table-responsive -->                           
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
					<div class="panel panel-default">
                        <div class="panel-heading">
                            Series of Protocol
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
											<th>Series</th>
                                            <th>Indication</th>
                                            <th>Patient Orientation</th>
                                            <th>Landmark</th>
											<th>Intravenous Contrast</th>
                                            <th>Scout</th>
											<th>Scanning Mode</th>
                                            <th>Range/Direction</th>
                                            <th>Gantry Angle</th>
                                            <th>Algorithm</th>
                                            <th>Collimation</th>
											<th>Slice Thickness</th>
                                            <th>Interval</th>	
											<th>Table Speed (mm/rotation)</th>
                                            <th>Pitch</th>	
											<th>kVp</th>
                                            <th>mA</th>	
											<th>Noise Reduction</th>
											<th>Rotation Time</th>
                                            <th>Scan FOV</th>
                                            <th>Display FOV</th>
                                            <th>Post Processing</th>
                                            <th>Transfer Images</th>
                                            <th>Notes</th>                                            										
										</tr>
                                    </thead>
                                    <tbody>										 																			
                                        <tr class="odd gradeX" ng-repeat="serie in series">										
											<td>{{serie.series_name}}</td>
                                            <td>{{serie.indication}}</td>											
                                            <td>{{serie.patient_orientation}}</td>
                                            <td>{{serie.landmark}}</td>
											<td>{{serie.intravenous_contrast}}</td>
                                            <td class="center">{{serie.scout}}</td>
                                            <td class="center">{{serie.scanning_mode}}</td>
											<td>{{serie.range_direction}}</td>
                                            <td>{{serie.gantry_angle}}</td>
                                            <td>{{serie.algorithm}}</td>
											<td>{{serie.collimation}}</td>    
											<td>{{serie.slice_thickness}}</td>
                                            <td>{{serie.interval}}</td>
                                            <td>{{serie.table_speed}}</td>
											<td>{{serie.pitch}}</td>  
											<td>{{serie.kvp}}</td>
                                            <td>{{serie.am}}</td>
											<td>{{serie.noise_reduction}}</td>
                                            <td>{{serie.rotation_time}}</td>
											<td>{{serie.scan_fov}}</td>  
											<td>{{serie.display_fov}}</td>
                                            <td>{{serie.post_processing}}</td>
                                            <td>{{serie.transfer_images}}</td>
											<td>{{serie.notes}}</td>  											                                                                  								
                                        </tr>                                       
                                    </tbody>
                                </table>
								
                            </div>
                            <!-- /.table-responsive -->                           
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
			</div>
			
			<button class="btn btn-default" ng-click="panel.deleteprotocol()" type="button">
				DELETE PROTOCOL
            </button>
			<p id='result'></p>
		</div>	
		
		
		<div class="row" ng-show="panel.isSelected('History')">
			<div class="row" style="margin-top:15px; margin-bottom:15px;">
                <div class="span5 col-md-5">
					<div class="input-daterange input-group" id="datepicker">
						<input id="datepicker_start" data-date-format="yyyy-mm-dd" ng-model="history_start" type="text" class="input-sm form-control" name="start" value="02/08/2015">
						<script>
						$("#datepicker_start").datepicker("setDate", new Date());
						</script>
						<span class="input-group-addon">to</span>
						<input id="datepicker_end" data-date-format="yyyy-mm-dd" ng-model="history_end" type="text" class="input-sm form-control" name="end" >
						<script>
						$("#datepicker_end").datepicker("setDate", new Date());
						</script>						
											
					</div>					
				</div>
				<button class="btn btn-default"  type="button" ng-click="panel.showHistory()">Show History</button>
            </div>    
			
			<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            History of protocols
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
                                        <tr>
											<th>Status</th>
                                            <th>Protocol ID</th>
                                            <th>Protocol Name</th>
                                            <th>Created By</th>											                                          									
											<th>Created At</th>
										</tr>
									</thead>
									<tbody>										 																			
                                        <tr class="odd gradeX" ng-repeat="record in records" >												
											<td>{{record.status}}</td>
                                            <td>{{record.protocol_number}}</td>											
                                            <td>{{record.protocol_name}}</td>
                                            <td>{{record.created_by}}</td>
											<td>{{record.created_at}}</td>                                                                                    							
                                        </tr>                                       
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
			
						
    </div>
    <!-- /#wrapper -->

	
	<div id="dialog" title="Alerts">
</body>

</html>
