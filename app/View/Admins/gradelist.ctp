  <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Grade List</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Grades List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            
                                            <th>Grade Name</th>
										    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									 while(list($key,$val)=each($gradeList))
									  {
										if(($key/2)==0)
										$class="odd";
										else
										$class="event";
									?>
									
                                        <tr class="<?php echo $class;?> gradeX">
                                           
                                            <td><?php echo $val['grade_levels']['level_name'];?></td>
										    <td class="center">
											
											
											
											<a class="btn btn-xs btn-info" title="Edit" href="<?php echo $this->Html->Url('/');?>admins/editgrade/<?php echo $val['grade_levels']['id'];?>">
												<i class="ace-icon fa fa-pencil bigger-120"></i>
												
											</a>
									
											<a class="btn btn-xs btn-danger" title="Delete" href="<?php echo $this->Html->Url('/');?>admins/deletegrade/<?php echo $val['grade_levels']['id'];?>" onclick='if (confirm("Are you sure you wish to delete this?")) { return true; } return false;'>
												<i class="ace-icon fa fa-trash-o bigger-120"></i>
												</a>
												
												
											
											
                                        </tr>
									<?php } ?>
                                       
										 </tbody>
                                </table>
                                       
                            <!-- /.table-responsive -->
                            
                     
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
<script>
function assignid(id,email){
document.getElementById("user_id").value=id;
document.getElementById("email_id").value=email;
}
</script>