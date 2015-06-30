  <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Uploaded List</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Uploaded List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Grade</th>
                                            <th>Topic Name</th>
                                            <th>Domain Name</th>
                                            <th>Answer Key</th>
                                            <th>Size</th>
                                            <th>Index no</th>
                                            <th>Image</th>
                                           
										    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php  $i=0;
									 while(list($key,$val)=each($questions))
									  {
                    
										if(($key/2)==0)
										$class="odd";
										else
										$class="event";
									?>
									
                                        <tr class="<?php echo $class;?> gradeX">
                                            <td><?php if(!empty($questions[$i]['questions']['grade_name']))echo $questions[$i]['questions']['grade_name'];else echo "N/A"?></td>
                                            <td><?php echo $questions[$i]['questions']['topic_name'];?></td>
                                            <td><?php echo $questions[$i]['questions']['domain_name'];?></td>
                                            <td><?php echo $questions[$i]['questions']['answer_key'];?></td>
                                            <td><?php echo $questions[$i]['questions']['size'];?></td>
                                            <td><?php echo $questions[$i]['questions']['index_no'];?></td>
                                            <td><?php echo $questions[$i]['questions']['file_name'];?></td>
                                            
										    <td class="center">
											
											<a href="/admins/editGrade/<?php echo $questions[$i]['questions']['id'];?>"><button class="btn btn-primary">EDIT</button></a>
											<a onclick="confirm('Are you sure? you want to delete this?');" href="/admins/deletequestions/<?php echo $questions[$i]['questions']['id'];?>"><button class="btn btn-primary">Delete</button></a>
											
                                        </tr>
									<?php ++$i;} ?>
                                       
										 </tbody>
                                </table>
                                       
                            <!-- /.table-responsive -->
                            <?php           
                        $limit=10;
                         $n=$count/$limit;
                       for($i=0;$i<=$n;++$i){
                if($pageid=($i+1)){
                  echo "<a href='/admins/records/".($i+1)."'><button class='btn btn-primary'>".($i+1)."</button></a>";
                     }
                 else{
echo "<a href='/admins/importedlist/".($i+1)."'><button class='btn btn-default'>".($i+1)."</button></a>";
}
                 }?>
                     
                            
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