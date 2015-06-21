<ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">
<?php if (!empty($questions)) : ?>
	<?php foreach ($questions as $key => $question) : ?>
    <?php if (!in_array($question['Question']['id'], $used_questions)) : ?>
        <li id="<?php echo $question['Question']['id']; ?>" class='ui-widget-content ui-corner-tr ui-draggable ui-draggable-handle'>
            <img src="/img/<?php echo $question['Question']['file_name']; ?>" alt='quesimg'  class='mCS_img_loaded img1' imgsize="<?php echo $question['Question']['size']; ?>"><a style="display: none;" href="" src="/img/<?php echo $question['Question']['file_name']; ?>" title="View larger image" class="ui-icon ui-icon-zoomin"><?php echo __('View larger'); ?></a><a style="display: none;" href='link/to/trash/script/when/we/have/js/off' title="Delete this image" class="ui-icon ui-icon-trash"><?php echo __('Delete image'); ?></a>
        </li>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endif; ?>
</ul>

