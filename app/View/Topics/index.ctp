<?php 
	if($this->Session->flash('delete')){
  echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class=ace-icon fa fa-check></i>Topic has been deleted</strong></div>";
  }
  
  if($this->Session->flash('Succsess')){
  echo   "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong>&nbsp;<i class='ace-icon fa fa-times'></i>&nbsp;Please asign a Parent for Retailer.</strong></div>";
  }
  
  ?>
  
  <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">List of Topics</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Topics List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            
                                            <th>Topic Name</th>
											<th>Grade</th>	
										    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									
									<?php 
									 while(list($key,$val)=each($designationResults))
									  {
										if(($key/2)==0)
										$class="odd";
										else
										$class="event";
									?>
									
                                        <tr class="<?php echo $class;?> gradeX">
                                            
                                            <td><?php echo $val['Topic']['topic_name'];?></td>
											<td><?php echo $val['Topic']['grades'];?></td>
										    <td class="center">
											
											
											<a class="btn btn-xs btn-info" title="Edit" href="<?php echo $this->Html->Url('/');?>topics/add/<?php echo $val['Topic']['id'];?>">
												<i class="ace-icon fa fa-pencil bigger-120"></i>
												
											</a>
									
											<a class="btn btn-xs btn-danger" title="Delete" href="<?php echo $this->Html->Url('/');?>topics/delete/<?php echo $val['Topic']['id'];?>" onclick='if (confirm("Are you sure you wish to delete this?")) { return true; } return false;'>
												<i class="ace-icon fa fa-trash-o bigger-120"></i>
												</a>
										</td>
											
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