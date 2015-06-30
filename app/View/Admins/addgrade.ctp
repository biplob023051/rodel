<?php if(isset($message)){
 echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class='ace-icon fa fa-check'></i>$message</strong></div>";}?>
 <?php
 if(isset($message1)){
 echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button>
<strong><i class='ace-icon fa fa-times'></i>$message1</strong></div>";}?>


  <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add Grade</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add Grade
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
                        <form action="/admins/addgrade" method="post">
						Grade Name <input type="text" class="form-control" name="grade_name"/><br>
						<button class="btn btn-primary" type="submit">Submit</button>
						</form>
						
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
