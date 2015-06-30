<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rodel Math Admin</title>

	<!-- jQuery -->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
	
    <!-- Bootstrap Core CSS -->
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="/bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<link href="/css/jquery.tokenize.css" rel="stylesheet">
<style>

.navbar-default
{

  background-color: #a0cd4e;
  border-color: #fff;
  height: 84px;
 }
 
 .sidebar
 {
 margin-top: 84px;
 }
 
 .nav>li>a{text-decoration:none;background-color:#a0cd4e}
 .sidebar ul li a.active{color:#23527c;}
 .page-header
 {
   margin: 20px 0 20px;
 }
 
 .sidebar ul li a.active
 {
 border: 1px solid #fff;
 }
 
 .btn-primary {
  color: #fff;
  margin-top: 1%;
  text-transform: uppercase;
  }
  .center
  {
  text-align:center;
  }
  
  label {
  
  margin-top: 2%;
}

div.Tokenize
{
  border: 0px;
  padding: 0px;
}
 
 .sidebar ul li a.inactive
 {
border-bottom: 0px solid #e7e7e7; 
 background-color: #a0cd4e;
 }
 
 .sidebar ul li a.editactive {
  border: 1px solid #fff;
}
.sidebar ul li a.editactive {
  color: #23527c;
}
.sidebar ul li a.editactive {
  background-color: #eee;
}

</style>
</head>

<body>

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
                <a class="navbar-brand" href="index.html"><img src="/assets/img/logo.png" alt="logo"></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        
                        <li class="divider"></li>
                        <li><a href="/admins/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
						
                            <a class="<?php echo $useractive;?>" href="/admins/index"><i class="fa fa-dashboard fa-fw"></i> Users</a>
							<ul class="nav nav-second-level">
								<li><a href="/admins/addUser" class="<?php echo $adduser;?>"><i class="fa fa-plus fa-fw"></i>Add User</a></li>
								
								<li><a href="/admins/index" class="<?php echo $listuser;?>"><i class="fa fa-th-list fa-fw"></i>List</a></li>
								<li><a href="/admins/importUsers" class="<?php echo $importuser;?>"><i class="fa fa-share fa-fw"></i>Import CSV</a></li>
							</ul>
							
                        </li>
                          <li class="<?php echo $gradeactive;?>">
                                <a class="<?php echo $gradeactive;?> <?php echo $editgradeactive;?>" href="/admins/gradelist"><i class="fa fa-dashboard fa-fw"></i> Grades</a>
                                 <ul class="nav nav-second-level <?php if($gradeactive){?> in <?php } ?>">
									<li><a href="/admins/addgrade" class="<?php echo $addgrade;?>"><i class="fa fa-plus fa-fw"></i>Add Grade</a></li>
									<li><a class="<?php echo $listgrade;?>" href="/admins/gradelist"><i class="fa fa-th-list fa-fw"></i>List</a></li>
									
								</ul>
                        </li>
						<li >
						   <a class="<?php echo $topicactive;?>" href="/topics/"><i class="fa fa-dashboard fa-fw"></i>Topics</a>
						   
							<ul class="nav nav-second-level">
								<li><a  class="<?php echo $addtopic;?>" href="/topics/add"><i class="fa fa-plus fa-fw"></i>Add Topic</a></li>
								
								<li><a  class="<?php echo $listtopic;?>"
								href="/topics"><i class="fa fa-th-list fa-fw"></i>List</a></li>
							</ul>
                        </li>
						<li>
                            <a class="<?php echo $domainactive;?>" href="/domains/"><i class="fa fa-dashboard fa-fw"></i> Domains</a>
							
							<ul class="nav nav-second-level">
								<li><a class="<?php echo $adddomain;?>" href="/domains/add"><i class="fa fa-plus fa-fw"></i>Add Domain</a></li>
								
								<li><a class="<?php echo $listdomain;?>" href="/domains"><i class="fa fa-th-list fa-fw"></i>List</a></li>
							</ul>
							
                        </li>
						<li >
                           <a href="/templates"><i class="fa fa-dashboard fa-fw"></i>Templates</a>
                            <ul class="nav nav-second-level">
                                <li><a href="/templates/add"><i class="fa fa-plus fa-fw"></i>Add Template</a></li>
                                <li><a href="/templates"><i class="fa fa-th-list fa-fw"></i>List</a></li>
                            </ul>
                        </li>
						<li>
						    <a href="#"><i class="fa fa-dashboard fa-fw"></i>Records</a>
                            
							<ul class="nav nav-second-level">
								<li><a class="<?php echo $addrecord;?>" href="/admins/editrecords/"><i class="fa fa-plus fa-fw"></i>Add Record</a></li>
								<li><a class="<?php echo $listrecord;?>" href="/admins/records/1"><i class="fa fa-th-list fa-fw"></i>  List</a></li>
								
								<li><a class="<?php echo $importrecord;?>" href="/admins/importcs"><i class="fa fa-share fa-fw"></i> Import List</a></li>
								
								
							</ul>
							
                        </li>
						
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
		
          <?php echo $this->fetch('content'); ?>
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    
	<script src="/js/jquery.tokenize.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>

</body>

</html>
