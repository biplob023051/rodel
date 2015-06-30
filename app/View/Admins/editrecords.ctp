<?php if(isset($message)){
 echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class='ace-icon fa fa-check'></i>$message</strong></div>";}?>
  <div class="row">
                <div class="col-lg-12">
				<?php if($id){?>
                    <h1 class="page-header">Edit Record</h1>
				<?php } else {?>
				    <h1 class="page-header">Add Record</h1>
				<?php }?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
				
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit Record
                        </div>
                        <!-- /.panel-heading -->
						
                        <div class="panel-body">
						
						
                           <form method="post" action="" enctype= "multipart/form-data">
						   <input type="hidden" name="id" value="<?php echo $id;?>"/>
							
							<div>
							<label>Grade</label>
							
							<select id="gradedropdown" style="border:0px;padding:0px;" multiple="multiple" name="grade[]" class="col-md-6 form-control tokenize-sample">
								<option value=''>--Select Grade--</option>
						         <?php 
								      $count=count($gradeList);
								       for($i=0;$i<$count;++$i){
									   if(in_array($gradeList[$i]['grade_levels']['id'],$arrGradesIds)){
	echo "<option value='".$gradeList[$i]['grade_levels']['id']."' selected>".$gradeList[$i]['grade_levels']['level_name']."</option>";
									   }
									   else{
	echo "<option value='".$gradeList[$i]['grade_levels']['id']."'>".$gradeList[$i]['grade_levels']['level_name']."</option>";
									   }
									   }
								 ?>
								 </select>
</div><BR/><BR/><BR/><BR/><BR/>

<div >
								   <label>Topic Name</label>
								   <select name="topic[]" class="col-md-6 form-control tokenize-sample" id="topicdropdown"  style="border:0px;padding:0px;" multiple="multiple">
								   <option value=''>--Select Topic--</option>
						         <?php $count=count($topicList);
								       for($i=0;$i<$count;++$i)
									  {
										if(in_array($topicList[$i]['topics']['id'],$arrTopicsIds)){
														echo "<option value='".$topicList[$i]['topics']['id']."'selected>".$topicList[$i]['topics']['topic_name']."</option>";
											}
										else{
											echo "<option value='".$topicList[$i]['topics']['id']."'>".$topicList[$i]['topics']['topic_name']."</option>";
										}
									  }
								 ?>
								 </select>
								 </div>
								 <BR/><BR/><BR/><BR/><BR/>
								 
								 
								   <label>Domain Name</label>
								   <select name="domain[]" class="col-md-6 form-control tokenize-sample" id="topicdropdown1"  style="border:0px;padding:0px;" multiple="multiple">
								    <option value=''>--Select Domain--</option>
										

										<?php $count=count($domainList);
											   for($i=0;$i<$count;$i++){
											   if(in_array($domainList[$i]['domains']['id'],$arrdomainsIds)){
											   
			echo "<option value='".$domainList[$i]['domains']['id']."' selected='selected'>".$domainList[$i]['domains']['domain_name']."</option>";
											   }
											   else{
			echo "<option value='".$domainList[$i]['domains']['id']."'>".$domainList[$i]['domains']['domain_name']."</option>";
											   }
											   }
										 ?>
								 </select>
								 </div>
								 <BR/><BR/><BR/><BR/><BR/>
								 <div id="liloader" style="display: none;">
									<img src="<?php echo $this->html->url('/img/ajax-loader.gif')?>"  style="width:18px;  vertical-align: middle;" alt="ajax-loader"><span id="loadermsg"></span>
								</div>
								
								 
								<div class="panel-body">
                               <label>Question Image</label><input type="file" name="Ques_img" class="col-md-6 form-control" value="<?php echo $file_name;?>">
								<input type="hidden" name="imgvalue" value="<?php echo $file_name;?>"/>
								<img src="/questionimages/<?php echo $file_name;?>"></div>
								
								<div class="panel-body">
								<label>Answer Key </label><select name="answer_key" class="col-md-6 form-control">
								           <option value="E" <?php if($answer_key=='E') echo "selected";?>>E</option>
								<option value="A" <?php if($answer_key=='A') echo "selected";?>>A</option>
                                  <option value="S" <?php if($answer_key=='S') echo "selected";?>>S</option>
								  </select></div>
								  
								  <div class="panel-body">
								  <label>Size</label> <select name="size" class="col-md-6 form-control">
								           <option value="F" <?php if($answer_key=='F') echo "selected";?>>F</option>
								<option value="H" <?php if($answer_key=='H') echo "selected";?>>H</option>
                                  <option value="Q" <?php if($answer_key=='Q') echo "selected";?>>Q</option>
								  </select></div>
<input type="hidden" name="data['User']['value']" value="1">

<div class="panel-body">

								  <label>Index No</label><input type="text" class="col-md-6 form-control" name="index_no" value="<?php echo $index_no;?>"/></div><div class="panel-body">
								  <br><Button type="submit" name="Submit" class="btn btn-primary"><?php if($id){?>Update<?php } else {?>Submit<?php }?></Button></div>
                     </form>
                            
                       </div>
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
	$('#loadermsg').html(" Topics Loading....");
	$('#liloader').show();
 
	$.post('/topics/getTopicsDropDown/'+gradeid+'/'+selectedid,{},function(data){
		
				$('#topicdropdown').find('option')
							.remove()
							.end()
							.append(data);

		$('#liloader').hide();			
	});
}
function getDomainDropdown(selectedid)
{
	var gradeid=$('#gradedropdown').val();
    var topicid=$('#topicdropdown').val();
	$('#loadermsg').html(" Domains Loading....");
	$('#liloader').show();
 
	$.post('/domains/getDomainsDropDown/'+gradeid+'/'+topicid+'/'+selectedid,{},function(data){
		
				$('#domaindropdown').find('option')
							.remove()
							.end()
							.append(data);

		$('#liloader').hide();			
	});
}

			</script>
			
<script type="text/javascript">
			$( document ).ready(function() {
				$('#topicdropdown').tokenize();$('#topicdropdown1').tokenize();
				$('#gradedropdown').tokenize();
			$('#domaindropdown').tokenize();	
				
			});
   
</script>