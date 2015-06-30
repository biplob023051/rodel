
<?php if(isset($message)){
 echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class='ace-icon fa fa-check'></i>$message</strong></div>";}?>
 <?php
 if(isset($message1)){
 echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button>
<strong><i class='ace-icon fa fa-times'></i>$message1</strong></div>";}?>


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
                            <?php if(!$des['User']['id']){
							$required='required';
							?>
                    Add User
				<?php }else	{
				$required='';
				?>
				 Edit User
				<?php }?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
                 <form action="" method="post">
						
						
				<input type="hidden" name="data[User][id]" value="<?php echo $des['User']['id']; ?>" />
			
				<label class="small">First Name</label>
				<input type="text" <?php echo $required;?> class="form-control"  name="data[User][first_name]" value="<?php echo $des['User']['first_name']; ?>" />
				
				
				<label class="small">Last Name</label>
				<input type="text" class="form-control"  name="data[User][last_name]" value="<?php echo $des['User']['last_name']; ?>" />
				
				<label class="small">Email</label>
				<input type="text" <?php echo $required;  if(!$required) echo " disabled ";?> class="form-control"  name="data[User][email]" value="<?php echo $des['User']['email']; ?>" />
				
				<label class="small">Password</label>
				<input type="text" <?php echo $required;?> class="form-control"  name="data[User][user_password]" value="<?php echo $des['User']['user_password']; ?>" />
				
				<label class="small">Role</label>
                <select <?php echo $required;?> name="data[User][user_role]" class="form-control" >
					<option value=''>----Select Role----</option>
					<option value='teacher' <?php if($des['User']['user_role']=='teacher'){ echo 'selected';  } ?> >TEACHER</option>
					<option value='math specialist' <?php if($des['User']['user_role']=='math specialist'){ echo 'selected'; }?> >MATH SPECIALIST</option>
                </select>
				
				<label class="small">Status</label>
                <select <?php echo $required;?> name="data[User][activate]" class="form-control" >
					<option value=''>----Unapproved----</option>
					<option value='1' <?php if($des['User']['activate']=='1'){ echo 'selected';  } ?> >Approved</option>
					<option value='0' <?php  if($des['User']['activate']=='0'){ echo 'selected';  } ?> >Disapproved</option>
                </select>
				
				
				<br/>
				 <label class="small"></label>
				   <?php if($des['User']['id']){?>
				   <input type="submit" class="btn btn-primary" value="Update">
				   <?php }else{?>
				   <input type="submit" class="btn btn-primary" value="Submit">
				   <?php }?>
				   
				 
			</form>
			
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			