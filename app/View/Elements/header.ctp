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
							<form id="searchImage"><input id="search_index" type="text" placeholder="Standard index #" /><input type="submit" /></form>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="menu">
						<ul>
							<li><a href="#">New worksheet <span><img src="<?php echo $this->html->url('/img/menu-icon.png')?>" alt="icon" /></span></a>
								<ul class="dropdown" id="save-template">
									<li>
										<?php 
											echo $this->Form->create('User', array(
										            'class' => 'form-horizontal',
										            'type' => 'file',
										            'novalidate'=>'novalidate',
										            'url' => array('controller' => 'users', 'action' => 'dashboard')
										        ));  
											echo $this->Form->input('Sheet.name', array('label'=>false, 'class' => 'dp-textbox', 'placeholder' => __('Kevins additions')));
											echo $this->Form->submit(__('Go'), array(
						                        'div' => false,
						                        'class' => 'dp-textbox-btn'
						                    )); 
					                    ?>
					                   
									</li>
									<?php if (!empty($templates)) : ?>
										<?php foreach ($templates as $key => $template) : ?>
											<li><?php echo $this->Html->link($template['Sheet']['name'], array('controller' => 'users', 'action' => 'review', $template['Sheet']['id'])); ?></li>
										<?php endforeach; ?>
									<?php endif; ?>
								</ul>
							</li>
							<li><a href="#"><?php echo $selectGrade;?> <span><img src="<?php echo $this->html->url('/img/menu-icon.png')?>" alt="icon" /></span></a>     <ul class="dropdown" id="gDropdown">
									<?php
										if ($this->Session->check('Sheet')) {
											if(isset($listGrade)) {
												$count=sizeof($listGrade);
												for($i=0;$i<$count;++$i)
												echo "<li><a href='#' onclick='grade(".$listGrade[$i]['grade_levels']['id'].")'>".$listGrade[$i]['grade_levels']['level_name']."</a></li>";

											}
										} 
									?>
								</ul>
								
							</li>
							<li><a href="#"><?php echo $selectTopics;?> <span><img src="<?php echo $this->html->url('/img/menu-icon.png');?>" alt="icon" /></span></a>
							 <ul class="dropdown  dp-width count" id="topics"></ul>	
							</li>
							<li><a href="#"><?php echo $selectDomains;?> <span><img src="<?php echo $this->html->url('/img/menu-icon.png');?>" alt="icon" /></span></a><ul class="dropdown  dp-width count" id="Domains"></ul>
								
							</li>
							<li><a href="#">Saved worksheets <span><img src="<?php echo $this->html->url('/img/menu-icon.png')?>" alt="icon" /></span></a>
								<ul class="dropdown">
									
									<?php if (!empty($sheets)) : ?>
										<?php foreach ($sheets as $key => $sheet) : ?>
											<li><a href='#' onclick=laodsheet(<?php echo $sheet['Sheet']['id']; ?>)><?php echo $sheet['Sheet']['name']; ?></a></li>
										<?php endforeach; ?>
									<?php endif; ?>
									
								</ul>
							</li>
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
                
                if(result){  
                    //show that the username is available  
                    $('#figurecont').html(result);
                    //setCookie("item_size", 0, 1); 
                    drag_images(); 
$('#liloader').hide();
               } 
        });  

  
}  

// load individual saved sheets for edit 
function laodsheet(id){  
    $('#loadermsg').html(" Worksheet Loading....");
    $('#liloader').show();
    $.post("/users/ajax_edit_currentsheet", { id: id }, function(result) {  
        if(result){
        	// if( $('#figurecont').is(':empty') ) {
        	// 	$('#figurecont').html('<ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix ui-droppable"></ul>');
        	// }
        	drag_images();
        	$.post("/users/ajax_grades_dropdown", { id: id }, function(htmlData) {  
		        if(htmlData){  
		            $('#gDropdown').html(htmlData); 
		        } 
		    }); 
            $('#right_content').html(result); 
	        $('#liloader').hide();
        }
    });  
}

$("#searchImage").submit(function(event){
	event.preventDefault(); 
	var pathname = window.location.pathname;
	if (pathname.indexOf("dashboard") > -1) {
		$('#loadermsg').html(" Searching Images....");
	    $('#liloader').show();
		var search_index = $("#search_index").val();
		if (search_index == '') {
			return;
		}
		$.ajax({
		      data: {search_index: search_index},
		      type: "POST",
		      dataType : 'html',
		      url: "/users/ajax_search_image",
		      success: function(data) {
		        $('#figurecont').html(data);
	            drag_images(); 
				$('#liloader').hide();      
		      }       
	    });
	} else { 
		return;
	}
});
</script>