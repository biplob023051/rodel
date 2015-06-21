<p><?php 
      if ($this->Session->check('Sheet')) {
        echo $this->Session->read('Sheet.name'); 
      } else {
        echo __('Create New Worksheet'); 
      }
      $item_size = 0;
  ?>
</p>
<div class="teacher-right">
  <div class="drag ui-widget-content ui-state-default" id="trash">
    <div><img <?php if (!empty($questions)) : ?>style="display: none;"<?php endif; ?> src="<?php echo $this->html->url('/img/down-arrow.jpg');?>" alt="down-arrow" id="down-arrow">
    <h2 <?php if (!empty($questions)) : ?>style="display: none;"<?php endif; ?> id="pro">Drag Problems Here</h2></div>
    <?php if (!empty($questions)) : ?>
      <ul class="gallery ui-helper-reset">
        <?php foreach ($questions as $key => $question) : ?>
          <?php if ($question['Question']['size'] == 'F') : $item_size = $item_size + 4; ?>
            <li id="<?php echo $question['Question']['id']; ?>" class="ui-widget-content ui-corner-tr ui-draggable ui-draggable-handle" style="display: list-item; width: 100%;">
              <img src="/img/<?php echo $question['Question']['file_name']; ?>" style="display: inline-block; height: 100%;" alt="quesimg"  class="img1 mCS_img_loaded" imgsize="<?php echo $question['Question']['size']; ?>"><a style="" href="" src="/img/<?php echo $question['Question']['file_name']; ?>" title="<?php echo __('View larger image'); ?>" class="ui-icon ui-icon-zoomin"><?php echo __('View larger'); ?></a><a href="link/to/recycle/script/when/we/have/js/off" title="<?php echo __('Recycle this image'); ?>" class="ui-icon ui-icon-refresh"><?php echo __('Recycle image'); ?></a>
            </li>
          <?php elseif ($question['Question']['size'] == 'H') : $item_size = $item_size + 2; ?>
            <li id="<?php echo $question['Question']['id']; ?>" class="ui-widget-content ui-corner-tr ui-draggable ui-draggable-handle" style="display: list-item; width: 100%;">
              <img src="/img/<?php echo $question['Question']['file_name']; ?>" style="display: inline-block; height: 50%;" alt="quesimg"  class="img1 mCS_img_loaded" imgsize="<?php echo $question['Question']['size']; ?>"><a style="" href="" src="/img/<?php echo $question['Question']['file_name']; ?>" title="<?php echo __('View larger image'); ?>" class="ui-icon ui-icon-zoomin"><?php echo __('View larger'); ?></a><a href="link/to/recycle/script/when/we/have/js/off" title="<?php echo __('Recycle this image'); ?>" class="ui-icon ui-icon-refresh"><?php echo __('Recycle image'); ?></a>
            </li>
          <?php else: $item_size = $item_size + 1; ?>
            <li id="<?php echo $question['Question']['id']; ?>" class="ui-widget-content ui-corner-tr ui-draggable ui-draggable-handle" style="display: list-item; width: 50%;">
              <img src="/img/<?php echo $question['Question']['file_name']; ?>" style="display: inline-block; height: 25%;" alt="quesimg"  class="img1 mCS_img_loaded" imgsize="<?php echo $question['Question']['size']; ?>"><a style="" href="" src="/img/<?php echo $question['Question']['file_name']; ?>" title="<?php echo __('View larger image'); ?>" class="ui-icon ui-icon-zoomin"><?php echo __('View larger'); ?></a><a href="link/to/recycle/script/when/we/have/js/off" title="<?php echo __('Recycle this image'); ?>" class="ui-icon ui-icon-refresh"><?php echo __('Recycle image'); ?></a>
            </li>
          <?php endif; ?>
        <?php endforeach; ?>  
      </ul>
    <?php endif ?>
  </div>
  <div class="teacher-problembox">
    <div class="problembox-title"><h4>Plan-What strategy will you use to help you solve this problem?</h4></div>
    <div class="problembox-content"><p>Solve</p></div>
    <div class="problembox-bottom">
      <div class="answer-label">Answer with label</div>
      <div class="answer-check">Check-Answer the question(s) with a complete sentence.</div>
    </div>
  </div>
</div>
<ul>
  <li><input type="submit" id="delete" value="Delete Pg"/></li>
</ul>
<div class="review-btn"><input type="hidden" name="problemvalue" id="problemvalue"><input type="submit" class="review" value="Review"/></div>

<script type="text/javascript">
setCookie("item_size", <?php echo $item_size; ?>, 1); 
</script>