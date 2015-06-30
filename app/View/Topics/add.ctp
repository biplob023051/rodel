<?php if(isset($message)){
 echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class='ace-icon fa fa-check'></i>$message</strong></div>";}?>
 <?php
 if(isset($message1)){
 echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button>
<strong><i class='ace-icon fa fa-times'></i>$message1</strong></div>";}?>


  <div class="row">
                <div class="col-lg-12">
				 <?php if(!$des['Topic']['id']){?>
                    <h1 class="page-header">Add Topic</h1>
				<?php }else	{?>
				 <h1 class="page-header">Edit Topic</h1>
				<?php }?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php if(!$des['Topic']['id']){?>
                    Add Topic
				<?php }else	{?>
				 Edit Topic
				<?php }?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
                 <form action="" method="post">
						
						
						
						
				<input type="hidden" name="data[Topic][id]" value="<?php echo $des['Topic']['id']; ?>" />
			
				<label class="small">Topic Name</label>
				<input required type="text" class="form-control"  name="data[Topic][topic_name]" value="<?php echo $des['Topic']['topic_name']; ?>" required/>
				
				<label class="small">Grade</label>
                <select id="tokenize" style="border:0px;padding:0px;" multiple="multiple"  name="data[Topic][grade_id][]" class="form-control tokenize-sample" >
					<option value=''>----Select Grade----</option>
                    <?php 
					
					foreach($arrGrades as $val): 
						
					?>
                   <?php if (in_array($val['GradeLevel']['id'],$gradeSelected)): ?>
	<option value="<?php echo  $val['GradeLevel']['id']; ?>" selected="selected" ><?php echo $val['GradeLevel']['level_name'];?></option>
    <?php else: ?>
    <option value="<?php echo $val['GradeLevel']['id']; ?>"><?php echo $val['GradeLevel']['level_name']; ?></option>
					<?php endif; ?>
						<?php endforeach; ?>
                   
				</select>
				<br/>
				 <label class="small"></label>
				   <?php if($des['Topic']['id']){?>
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
			
			<script type="text/javascript">
			$( document ).ready(function() {
				$('#tokenize').tokenize();
			});
   
</script>