  <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Import your csv File</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        
                               
                                <form action="/admins/importcs" method="post" enctype='multipart/form-data'>
                                           <input type="hidden" name="data[User][id]" id="user_id" value="1">
                                    <input type="file" name="csvfile" id="csvfile"/>
<input type="submit" id="submit" name="submit" class="btn btn-primary">
                                              </form>
                     
                           
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
