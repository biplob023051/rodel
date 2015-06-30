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
								<li><a href="#"><label id="selectedGrade"><?php echo $selectGrade;?></label><span><img src="<?php echo $this->html->url('/img/menu-icon.png')?>" alt="icon" /></span></a>     
									<ul class="dropdown" id="gDropdown">
										<?php
											if ($this->Session->check('Sheet')) {
												if(isset($listGrade)) {
													$count=sizeof($listGrade);
													for($i=0;$i<$count;++$i)
													echo "<li><a id='grade_".$i."' href='#' onclick='grade(".$listGrade[$i]['grade_levels']['id'].", this.id)'>".$listGrade[$i]['grade_levels']['level_name']."</a></li>";

												}
											} 
										?>
									</ul>
									
								</li>
							<li><a href="#"><label id="selectedTopic"><?php echo $selectTopics;?></label> <span><img src="<?php echo $this->html->url('/img/menu-icon.png');?>" alt="icon" /></span></a>
							 <ul class="dropdown  dp-width count" id="topics"></ul>	
							</li>
							<li><a href="#"><label id="selectedDomain"><?php echo $selectDomains;?></label> <span><img src="<?php echo $this->html->url('/img/menu-icon.png');?>" alt="icon" /></span></a><ul class="dropdown  dp-width count" id="Domains"></ul>
								
							</li>
							<li><a href="#"><label id="selectedWorksheet">Saved worksheets </label> <span><img src="<?php echo $this->html->url('/img/menu-icon.png')?>" alt="icon" /></span></a>
								<ul class="dropdown">
									
									<?php if (!empty($sheets)) : ?>
										<?php if (isset($page_review)) : ?>
											<?php foreach ($sheets as $key => $sheet) : ?>
												<li><?php echo $this->Html->link($sheet['Sheet']['name'], array('controller' => 'users', 'action' => 'dashboard', $sheet['Sheet']['id']), array());?></li>
											<?php endforeach; ?>
										<?php else : ?>
											<?php foreach ($sheets as $key => $sheet) : ?>
												<li><a id='worksheet_<?php echo $sheet['Sheet']['id']; ?>' href='#' onclick="laodsheet(<?php echo $sheet['Sheet']['id']; ?>, this.id)"><?php echo $sheet['Sheet']['name']; ?></a></li>
											<?php endforeach; ?>
										<?php endif; ?>
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
function grade(id, element){  
	//$('#loadermsg').html(" Related Problems Loading....");
	$('#loadermsg').html(" Related Topics Loading....");
    $('#liloader').show();
    $('#selectedGrade').html($("#" + element).text());
    $('#selectedTopic').html('Math topics & tips');
    $('#selectedDomain').html('Domains');

    // load related problems
	// $.post("/users/ajax_problems", { grade_id: id }, function(problems) {  
	//     if(problems) {   
	//         $('#figurecont').html(problems);
	//         drag_images(); 
	//     } 
	    // load related topics
	    
	    $.post("/users/ajax_topics", { grade_id: id }, function(topics) {  
            if(topics){
            	$('#figurecont').html('');    
				$('#topics').html(topics);  
            }
            // load related domains
            $('#loadermsg').html(" Related Domains Loading....");
            $.post("/users/ajax_domains", { grade_id: id }, function(domains) {  
            	if(domains){    
					$('#Domains').html(domains);  
	            }
	            $('#liloader').hide();
	        });
        });
	// });   
  
}  
</script>
<script>
function topicProblems(id, element){  
      // Find this Topic problems
      $('#loadermsg').html(" Problems Loading....");
        $('#liloader').show();
        var str = $("#" + element).text();
		if(str.length > 16) str = str.substring(0,16);
        $('#selectedTopic').html(str);
    	$('#selectedDomain').html('Domains');
  
        //use ajax to run the check  
        $.post("/users/ajax_problems", { topic_id: id }, function(result){  
            //if the result is 1
            if(result){  
                $('#figurecont').html(result); 
                drag_images();
                $('#liloader').hide();
           } 
        });  
  
}  
</script>
<script>

function domainProblems(id, element){  
    // Find this Domain Problems
	$('#loadermsg').html(" Problems Loading....");
	$('#liloader').show();
	var str = $("#" + element).text();
	if(str.length > 16) str = str.substring(0,16);
	$('#selectedDomain').html(str);
	$('#selectedTopic').html('Math topics & tips');
    
	$.post("/users/ajax_problems", { domain_id: id }, function(result) {  
		if(result){  
			$('#figurecont').html(result);
			drag_images();
			$('#liloader').hide();
		} 
	});   
}  

// load individual saved sheets for edit 
function laodsheet(id, element){  
    $('#loadermsg').html(" Worksheet Loading....");
    $('#liloader').show();
    $('#selectedWorksheet').html($("#" + element).text());
    $.post("/users/ajax_edit_currentsheet", { id: id }, function(result) {  
        if(result){
        	// if( $('#figurecont').is(':empty') ) {
        	// 	$('#figurecont').html('<ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix ui-droppable"></ul>');
        	// }
        	drag_images(); 
            $('#right_content').html(result);
        }
        $.post("/users/ajax_grades_dropdown", { id: id }, function(htmlData) {  
	        if(htmlData){  
	            $('#gDropdown').html(htmlData); 
	        }
	        $('#liloader').hide(); 
	    });
    });  
}

$("#searchImage").submit(function(event){
	event.preventDefault(); 
	var pathname = window.location.pathname;
	if (pathname.indexOf("dashboard") > -1) {
		$('#loadermsg').html(" Searching Problems....");
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