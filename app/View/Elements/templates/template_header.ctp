<header class="header">
		<div class="inner-container">
			<div class="left-content">
				<br/><br/>
				<?php echo $this->Html->link(__('Template List'),array('controller' => 'templates', 'action' => 'index'), array('class'=>'review'));?>
          		
          		<?php echo $this->Html->link(__('Template Management'),array('controller' => 'templates', 'action' => 'add'), array('class'=>'review'));?>
			</div>
			<div class="right-content-inside">
					<div class="header-search-left"><h5>Create New Template</h5></div>
					<div class="header-search-right">
						<div class="header-search-textbox">
							<h5>Search</h5>
							<form id="searchImage"><input id="search_index" type="text" placeholder="Standard index #" /><input type="submit" /></form>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="menu">
						<ul>
							<li><a href="#">New Template <span><img src="<?php echo $this->html->url('/img/menu-icon.png')?>" alt="icon" /></span></a>
								<ul class="dropdown" id="save-template">
									<li>
										<?php 
											echo $this->Form->create('User', array(
										            'class' => 'form-horizontal',
										            'type' => 'file',
										            'novalidate'=>'novalidate',
										            'url' => array('controller' => 'templates', 'action' => 'add')
										        ));  
											echo $this->Form->input('Sheet.name', array('label'=>false, 'class' => 'dp-textbox', 'placeholder' => __('Kevins additions')));
											echo $this->Form->input('Sheet.template', array('label'=> false,'options' => $templateOptions, 'class' => 'dp-textbox', 'empty' => __('Template Type') ));
											echo $this->Form->submit(__('Go'), array(
						                        'div' => false,
						                        'class' => 'dp-textbox-btn'
						                    )); 
					                    ?>
					                   
									</li>
								</ul>
							</li>
								<li><a href="#"><label id="selectedGrade">Grade Level</label><span><img src="<?php echo $this->html->url('/img/menu-icon.png')?>" alt="icon" /></span></a>     
									<ul class="dropdown" id="gDropdown">
										<?php
											if ($this->Session->check('Sheet')) {
												if(isset($listGrade)) {
													$count=sizeof($listGrade);
													for($i=0;$i<$count;++$i)
													echo "<li><a id='grade_".$i."' href='#' onclick='grade(".$listGrade[$i]['GradeLevel']['id'].", this.id)'>".$listGrade[$i]['GradeLevel']['level_name']."</a></li>";

												}
											} 
										?>
									</ul>
									
								</li>
							<li><a href="#"><label id="selectedTopic">Math topics &amp; tips</label> <span><img src="<?php echo $this->html->url('/img/menu-icon.png');?>" alt="icon" /></span></a>
							 <ul class="dropdown  dp-width count" id="topics"></ul>	
							</li>
							<li><a href="#"><label id="selectedDomain">Domains</label> <span><img src="<?php echo $this->html->url('/img/menu-icon.png');?>" alt="icon" /></span></a><ul class="dropdown  dp-width count" id="Domains"></ul>
								
							</li>
							<li><a href="#"><label id="selectedWorksheet">Saved worksheets </label> <span><img src="<?php echo $this->html->url('/img/menu-icon.png')?>" alt="icon" /></span></a>
								<ul class="dropdown">
									
									<?php if (!empty($sheets)) : ?>
										<?php foreach ($sheets as $key => $sheet) : ?>
											<li><a id='worksheet_<?php echo $sheet['Sheet']['id']; ?>' href='#' onclick="laodsheet(<?php echo $sheet['Sheet']['id']; ?>, this.id)"><?php echo $sheet['Sheet']['name']; ?></a></li>
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