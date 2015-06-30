<?php $item_size = 0; ?>
<div><img <?php if (!empty($questions)) : ?>style="display: none;"<?php endif; ?> src="<?php echo $this->html->url('/img/down-arrow.jpg');?>" alt="down-arrow" id="down-arrow">
<h2 <?php if (!empty($questions)) : ?>style="display: none;"<?php endif; ?> id="pro">Drag Problems Here</h2></div>
<?php if (!empty($questions)) : ?>
  <ul class="gallery ui-helper-reset">
    <?php foreach ($questions as $key => $question) : ?>
      <?php if ($question['Question']['size'] == 'F') : $item_size = $item_size + 4; ?>
        <li id="<?php echo $question['Question']['id']; ?>" class="<?php if (!isset($review)) : ?>ui-widget-content<?php endif; ?> ui-corner-tr ui-draggable ui-draggable-handle" style="display: list-item; width: 100%;">
          <img src="<?php echo $this->request->base; ?>/questionimages/<?php echo $question['Question']['file_name']; ?>" style="display: inline-block; height: 100%;" alt="quesimg"  class="img1 mCS_img_loaded" imgsize="<?php echo $question['Question']['size']; ?>"><?php if (!isset($review)) : ?><a style="" href="" src="<?php echo $this->request->base; ?>/questionimages/<?php echo $question['Question']['file_name']; ?>" title="<?php echo __('View larger image'); ?>" class="ui-icon ui-icon-zoomin"><?php echo __('View larger'); ?></a><a href="link/to/recycle/script/when/we/have/js/off" title="<?php echo __('Recycle this image'); ?>" class="ui-icon ui-icon-refresh"><?php echo __('Recycle image'); ?></a><?php endif; ?>
        </li>
      <?php elseif ($question['Question']['size'] == 'H') : $item_size = $item_size + 2; ?>
        <li id="<?php echo $question['Question']['id']; ?>" class="<?php if (!isset($review)) : ?>ui-widget-content<?php endif; ?> ui-corner-tr ui-draggable ui-draggable-handle" style="display: list-item; width: 100%;">
          <img src="<?php echo $this->request->base; ?>/questionimages/<?php echo $question['Question']['file_name']; ?>" style="display: inline-block; height: 50%;" alt="quesimg"  class="img1 mCS_img_loaded" imgsize="<?php echo $question['Question']['size']; ?>"><?php if (!isset($review)) : ?><a style="" href="" src="<?php echo $this->request->base; ?>/questionimages/<?php echo $question['Question']['file_name']; ?>" title="<?php echo __('View larger image'); ?>" class="ui-icon ui-icon-zoomin"><?php echo __('View larger'); ?></a><a href="link/to/recycle/script/when/we/have/js/off" title="<?php echo __('Recycle this image'); ?>" class="ui-icon ui-icon-refresh"><?php echo __('Recycle image'); ?></a><?php endif; ?>
        </li>
      <?php else: $item_size = $item_size + 1; ?>
        <li id="<?php echo $question['Question']['id']; ?>" class="<?php if (!isset($review)) : ?>ui-widget-content<?php endif; ?> ui-corner-tr ui-draggable ui-draggable-handle" style="display: list-item; width: 50%;">
          <img src="<?php echo $this->request->base; ?>/questionimages/<?php echo $question['Question']['file_name']; ?>" style="display: inline-block; height: 25%;" alt="quesimg"  class="img1 mCS_img_loaded" imgsize="<?php echo $question['Question']['size']; ?>"><?php if (!isset($review)) : ?><a style="" href="" src="<?php echo $this->request->base; ?>/questionimages/<?php echo $question['Question']['file_name']; ?>" title="<?php echo __('View larger image'); ?>" class="ui-icon ui-icon-zoomin"><?php echo __('View larger'); ?></a><a href="link/to/recycle/script/when/we/have/js/off" title="<?php echo __('Recycle this image'); ?>" class="ui-icon ui-icon-refresh"><?php echo __('Recycle image'); ?></a><?php endif; ?>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>  
  </ul>
<?php endif ?>
<?php if (!isset($review)) : ?>
  <script type="text/javascript">
  (function($){
    drag_images();
  })(jQuery);
      setCookie("item_size", <?php echo $item_size; ?>, 1); 
      // javascript cookie functions
      function setCookie(cname,cvalue,exdays) {
          var d = new Date();
          d.setTime(d.getTime() + (exdays*24*60*60*1000));
          var expires = "expires=" + d.toGMTString();
          document.cookie = cname+"="+cvalue+"; "+expires;
      }

      function getCookie(cname) {
          var name = cname + "=";
          var ca = document.cookie.split(';');
          for(var i=0; i<ca.length; i++) {
              var c = ca[i];
              while (c.charAt(0)==' ') c = c.substring(1);
              if (c.indexOf(name) == 0) {
                  return c.substring(name.length, c.length);
              }
          }
          return "";
      }

      function checkCookie() {
          var user=getCookie("username");
          if (user != "") {
              alert("Welcome again " + user);
          } else {
             user = prompt("Please enter your name:","");
             if (user != "" && user != null) {
                 setCookie("username", user, 30);
             }
          }
      }
  </script>
<?php endif; ?>