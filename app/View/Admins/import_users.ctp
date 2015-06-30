<? if($importsuccess){?>
<div class="alert alert-success">
	Users uploaded successfully.<br/>
	Total Users=<?php echo $total;?><br/>
	New Users =<?php echo $new;?><br/>
	Updated Users=<?php echo $updated; ?>
</div>
<?php } ?>
  <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Users</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							Import Users
                        </div>
								 <div class="panel-body">
                                <form action="/admins/importUsers" method="post" enctype='multipart/form-data'>
									<input required type="file" name="csvfile" id="csvfile"/>
									<input type="submit" id="submit" name="submit" class="btn btn-primary">
                               </form>
                     
                           
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
