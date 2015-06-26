<header class="header">
		<div class="inner-container">
			<div class="left-content">
				<a href="/users/dashboard/"><img src="<?php echo $this->html->url('/img/logo.png');?>" alt="logo"></a>
			</div>
			<div class="right-content-inside">
					<div class="header-search-left"><h5>Create Your Worksheets</h5></div>
					<div class="header-search-right">
						<p>Hi, <?php echo $userDetail['User']['first_name']." ".$userDetail['User']['last_name'];?> <a href="/users/logout">Log out</a></p>
						<div class="header-search-textbox">
							<h5>Search</h5>
							<form><input type="text" placeholder="Standard index #" /><input type="submit" /></form>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="menu">
						<ul>
							<li><a href="#">New worksheet <span><img src="<?php echo $this->html->url('/img/menu-icon.png')?>" alt="icon" /></span></a>
								<ul class="dropdown">
									<li>
										<form>
											<input type="text" placeholder="Kevin's additions &" class="dp-textbox" />
											<input type="button" value="GO" class="dp-textbox-btn" />
										</form>
									</li>
								</ul>
							</li>
							<li><a href="#"><?php echo $selectGrade;?> <span><img src="<?php echo $this->html->url('/img/menu-icon.png')?>" alt="icon" /></span></a>                           <ul class="dropdown" id="gDropdown"><?php if(isset($listGrade)){
$count=sizeof($listGrade);
for($i=0;$i<$count;++$i)
echo "<li><a href='#' onclick='grade(".$listGrade[$i]['grade_levels']['id'].")'>".$listGrade[$i]['grade_levels']['level_name']."</a></li>";

}?></ul>
								
							</li>
							<li><a href="#"><?php echo $selectTopics;?> <span><img src="<?php echo $this->html->url('/img/menu-icon.png');?>" alt="icon" /></span></a>
							 <ul class="dropdown  dp-width count" id="topics"></ul>	
							</li>
							<li><a href="#"><?php echo $selectDomains;?> <span><img src="<?php echo $this->html->url('/img/menu-icon.png');?>" alt="icon" /></span></a><ul class="dropdown  dp-width count" id="Domains"></ul>
								
							</li>
							<li><a href="#">Saved worksheets <span><img src="<?php echo $this->html->url('/img/menu-icon.png')?>" alt="icon" /></span></a><ul class="dropdown  dp-width count" id="sheets"></ul></li>
						</ul>
<div id="liloader" style="display: none;"><img src="<?php echo $this->html->url('/img/ajax-loader.gif')?>"  style="width:18px;  vertical-align: middle;" alt="ajax-loader"><span id="loadermsg"></span></div>
					</div>
			</div>
		</div>
	</header>

<script>
function grade(id){  
  
        //get the Topic
         $('#loadermsg').html(" Topics Loading....");
         $('#liloader').show();
  
        //use ajax to run the check  
        $.post("/users/gradelevel", { id: id },  
            function(result){  
                //if the result is 1  
                
                if(result){  
                    //show that the username is available  
                    $('#topics').html(result); 
                   $('#Domains').html(''); 
$('#figurecont').html(''); 
$('#liloader').hide();
  
               } 
        });  
  
}  
</script>
<script>
function domains(id,gid){  
  
        //get the Topic
      $('#loadermsg').html(" Domains Loading....");
         $('#liloader').show();
  
        //use ajax to run the check  
        $.post("/users/topics", { id: id,gid:gid },  
            function(result){  
                //if the result is 1  
                
                if(result){  
                    //show that the username is available  
                    $('#Domains').html(result);  
                    $('#figurecont').html(''); 
                    $('#liloader').hide();
               } 
        });  
  
}  
</script>
<script>

function pics(tid,gid,id){  
  
        //get the Topic
       $('#loadermsg').html(" Figures Loading....");
         $('#liloader').show();
  
        //use ajax to run the check  
        $.post("/users/domains", { id: id,gid:gid,tid:tid },  
            function(result){  
                //if the result is 1  
                $.post("/users/ajax_sheets", { id: id }, function(htmlData){
                	$('#sheets').html(htmlData);
            	});

                if(result){  
                    //show that the username is available  
                    $('#sortableAvailable').html(result); 
                    //drag_images(); 
$('#liloader').hide();
               } 
        });  

  
}

// load individual saved sheets for edit 
function laodsheet(id){  
    $('#loadermsg').html(" Page Loading....");
    $('#liloader').show();
    $.post("/users/ajax_edit_currentsheet", { id: id }, function(result) {  
        if(result){  
            $('#sortableCurrent').html(result); 
        }
        $.post("/users/ajax_edit_availablesheet", { id: id }, function(htmlData) {  
	        if(htmlData){  
	            $('#sortableAvailable').html(htmlData); 
	            $('#liloader').hide();
	        } 
	    }); 
    });  
}  
</script>