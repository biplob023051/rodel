  <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Grades</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit Grade
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <form action="/admins/editgrade" method="post">
                                                <input type="hidden" name="grade_id" value="<?php echo $gradeId;?>"/>
						Grade Name <input type="text" class="form-control" name="grade_name" value="<?php echo $gradeName;?>"/>
						<button class="btn btn-primary" type="submit">update</button>
						</form>
						
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
