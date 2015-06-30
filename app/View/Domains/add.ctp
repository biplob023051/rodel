
<?php if(isset($message)){
 echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class='ace-icon fa fa-check'></i>$message</strong></div>";}?>
 <?php
 if(isset($message1)){
 echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button>
<strong><i class='ace-icon fa fa-times'></i>$message1</strong></div>";}?>


  <div class="row">
                <div class="col-lg-12">
				 <?php if(!$des['Domain']['id']){?>
                    <h1 class="page-header">Add Domain</h1>
				<?php }else	{?>
				 <h1 class="page-header">Edit Domain</h1>
				<?php }?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php if(!$des['Domain']['id']){?>
                    Add Domain
				<?php }else	{?>
				 Edit Domain
				<?php }?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
                 <form action="" method="post">
						
						
						
						
				<input type="hidden" name="data[Domain][id]" value="<?php echo $des['Domain']['id']; ?>" />
			
				<label class="small">Domain Name</label>
				<input required type="text" class="form-control"  name="data[Domain][domain_name]" value="<?php echo $des['Domain']['domain_name']; ?>" required/>
				
				<label class="small">Grade</label>
                <select style="border:0px;padding:0px;" multiple="multiple" required onchange="getTopicDropdown('<?php echo $des['Domain']['topic_id'];?>');" id="gradedropdown"  name="data[Domain][grade_id][]" class="form-control tokenize-sample" >
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
				<!--
				<label class="small">Topic</label>
                <select id="topicdropdown" style="border:0px;padding:0px;" multiple="multiple" required name="data[Domain][topic_id]" class="form-control tokenize-sample" >
					<option value=''>----Select Topic----</option>
                    <?php 
					
					foreach($arrTopics as $val): 
						
					?>
                   <?php if ($val['Topic']['id']==$des['Domain']['topic_id']): ?>
						<option value="<?php echo  $val['Topic']['id']; ?>" selected="selected" ><?php echo $val['Topic']['topic_name'];?></option>
					<?php else: ?>
						<option value="<?php echo $val['Topic']['id']; ?>"><?php echo $val['Topic']['topic_name']; ?></option>
					<?php endif; ?>
				   <?php endforeach; ?>
                   
				</select>
				-->
				<br/>
				 <label class="small"></label>
				   <?php if($des['Domain']['id']){?>
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
			
			<script>
			function getTopicDropdown(selectedid)
			{
				var gradeid=$('#gradedropdown').val();
				$.post('/topics/getTopicsDropDown/'+gradeid+'/'+selectedid,{},function(data){
				
				$('#topicdropdown')
    .find('option')
    .remove()
    .end()
    .append(data);

				});
				
			}
			</script>
			
			<script type="text/javascript">
			$( document ).ready(function() {
		
				$('#gradedropdown').tokenize();
			});
   
</script>