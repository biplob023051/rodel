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
                            Users List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
										<th>Role</th>	
                                            <th>Registration date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									 while(list($key,$val)=each($arrUsers))
									  {
										if(($key/2)==0)
										$class="odd";
										else
										$class="event";
									?>
									
                                        <tr class="<?php echo $class;?> gradeX">
                                            <td><?php echo $val['User']['first_name']." ".$val['User']['last_name'];?></td>
                                            <td><?php echo $val['User']['email'];?></td>
										<td><?php echo strtoupper($val['User']['user_role']);?></td>	
                                            <td><?php echo date('Y-m-d',strtotime($val['User']['created_at']));?></td>
                                            <td class="center">
											
											<!--<button class="btn btn-primary" onclick="editdeleteid('<?php echo $val['User']['id'];?>')">EDIT</button-->
											
											<?php if($val['User']['activate']==1)echo 'Approved';else echo '<Button class="btn btn-primary" onclick="assignid('.$val['User']['id'].",'".$val['User']['email']."'".');"  data-toggle="modal" data-target="#myModal">Approve</Button>';?></td>
                                            
                                        </tr>
									<?php } ?>
                                       
										 </tbody>
                                </table>
                                       
                            <!-- /.table-responsive -->
                            
                               <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h4 class="modal-title" id="myModalLabel">Select Role</h4>
                                        </div>
                                        <div class="modal-body">
                                           <form action="/admins/update" method="post">
                                           <input type="hidden" name="data[User][id]" id="user_id">
                                    <input type="hidden" name="data[User][email]" id="email_id">
                                           <select class="form-control" name="data[User][user_role]">
                                           <option value="math specialist">Math Specialist</option>
                                           <option value="teacher">Teacher</option>
                                           </select><br/>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><input type="submit" id="submitf" value="Assign" class="btn-primary btn">
                                            </form>
                                        </div>
                                        
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                     
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