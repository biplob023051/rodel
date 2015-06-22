<!DOCTYPE html>
<html>
<head>
	<title>
	Rodel-math
	</title>
	<meta charset="UTF-8" />
	<!--- Meta tag viewport -->
	  <meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,initial-scale=1.0" /> 
	  <meta name="viewport" content="user-scalable = yes">
	<!--- css style -->
	<link href="<?php echo $this->html->url('/css/style.css')?>" type="text/css" rel="stylesheet"/>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>



	<link href="<?php echo $this->html->url('/fonts/fonts.css');?>" type="text/css" rel="stylesheet"/>
	<link rel="stylesheet" href="<?php echo $this->html->url('/css/jquery.mCustomScrollbar.css');?>">
</head>
<body style="cursor:auto">
<div class="layout">
	<?php echo $this->element('header'); ?>



<section class="section">
		<div class="inner-container">
			
			<div id="left-content">
        <div  id="image-display">
  				<p class="center"><?php 
                if ($this->Session->check('Sheet')) {
                  echo $this->Session->read('Sheet.name'); 
                } else {
                  echo __('Create New Worksheet'); 
                }
            ?>
          </p>
  				<div class="teacher-right">
  					<div id="trash">
                <?php if (!empty($questions)) : ?>
                  <ul class="gallery ui-helper-reset">
                    <?php foreach ($questions as $key => $question) : ?>
                      <?php if ($question['Question']['size'] == 'F') :  ?>
                        <li id="<?php echo $question['Question']['id']; ?>" class="ui-widget-content ui-corner-tr ui-draggable ui-draggable-handle" style="display: list-item; width: 100%;">
                          <img src="/img/<?php echo $question['Question']['file_name']; ?>" style="display: inline-block; height: 100%;" alt="quesimg"  class="img1 mCS_img_loaded" imgsize="<?php echo $question['Question']['size']; ?>">
                        </li>
                      <?php elseif ($question['Question']['size'] == 'H') : ?>
                        <li id="<?php echo $question['Question']['id']; ?>" class="ui-widget-content ui-corner-tr ui-draggable ui-draggable-handle" style="display: list-item; width: 100%;">
                          <img src="/img/<?php echo $question['Question']['file_name']; ?>" style="display: inline-block; height: 50%;" alt="quesimg"  class="img1 mCS_img_loaded" imgsize="<?php echo $question['Question']['size']; ?>">
                        </li>
                      <?php else : ?>
                        <li id="<?php echo $question['Question']['id']; ?>" class="ui-widget-content ui-corner-tr ui-draggable ui-draggable-handle" style="display: list-item; width: 50%;">
                          <img src="/img/<?php echo $question['Question']['file_name']; ?>" style="display: inline-block; height: 25%;" alt="quesimg"  class="img1 mCS_img_loaded" imgsize="<?php echo $question['Question']['size']; ?>">
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
        </div>
			</div>
      <div id="right-content">
        <?php if($userDetail['User']['user_role'] != 'teacher') : ?>
          <?php echo $page_count; ?>
        <?php endif; ?>
        <ul id="control-box">
          <li class="editLi"><input class="btn btn-primary" type="submit" id="editSheet" value="Edit"/></li>
          <li><input class="btn btn-default" type="submit" id="savePdf" value="Save PDF"/></li>
          <li><input class="btn btn-default" type="submit" id="printImages" value="Print"/></li>
          <li><input type="checkbox" id="spanish" name="spanish" value="S">Spanish</li>
          <li><input type="checkbox" id="answerkey" name="answerkey" value="A">Answer Key</li>
          <li style="display: none;">
            <div id="spanish_val"></div>
            <div id="answerkey_val"></div>
          <li>
        </ul>
      </div>
		</div>
	</section>
	<footer class="footer">
		<div class="inner-container">
			<div class="left">
				<img src="<?php echo $this->html->url('/img/footer-logo.jpg');?>" alt="footer-logo">
			</div>
			<div class="right">
				<h6>RodelAZ.org</h6>
				<p>&copy;2015 Rodel Foundation of Arizona</p>
			</div>
		</div>
	</footer>
</div>

</script>
<script src="<?php echo $this->html->url('/js/placeholders.min.js');?>"></script>
	
	<!-- custom scrollbar plugin -->
	<script src="<?php echo $this->html->url('/js/jquery.mCustomScrollbar.concat.min.js');?>"></script>
	
	<script>
		(function($){
			$(window).load(function(){

				$("#content-4").mCustomScrollbar({
					theme:"rounded-dots",
					scrollInertia:400
				});
	
			
			});
		})(jQuery);
	</script>
 
  <style>
  #gallery { float: left; min-height: 12em; }
  .gallery.custom-state-active { background: #eee; }
  .gallery li { float: left; text-align: center; }
  .gallery li h5 { margin: 0 0 0.4em; cursor: move; }
  .gallery li a { float: right; }
  .gallery li a.ui-icon-zoomin { float: left; }
  .gallery li img { width: 100%; cursor: move; }
 
  #trash { float: right; width: 100%;  padding: 1%; }
  #trash h4 { line-height: 16px; margin: 0 0 0.4em; }
  #trash h4 .ui-icon { float: left; }
  #trash .gallery h5 { display: none; }
  #gallery .ui-draggable-dragging { width: 300px; height: 200px; }
  
  #left-content { float: left; width: 82%;}
  #image-display { margin: 0 100px;}
  #right-content { float: right; width: 18%;}
  ul#control-box li{
    list-style: none;
    margin: 5px 0;
  }
  ul#control-box li.editLi {
    margin-top: 200px;
  }
  .center { text-align: center; padding: 5px 0;}

  .btn-primary {
    color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
  }
  .btn-default {
    color: #333;
    background-color: ash;
    border-color: #ccc;
  }
  .btn {
    box-sizing: border-box;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
  }
  </style>
  <script>
    $(function() {

      $('#spanish').on('change', function() {
          var val = this.checked ? this.value : '';
          $('#spanish_val').html(val);
      });

      $('#answerkey').on('change', function() {
          var val = this.checked ? this.value : '';
          $('#answerkey_val').html(val);
      });
      
      // save teacher pdf
      $("#savePdf").click(function(event) {
        event.preventDefault();
        $.ajax({
              data: {save_index : 0},
              type: "POST",
              url: "/users/ajax_savepage",
              success: function(data) {
                console.log('Page saved');     
              }       
        });    
      });

      // print images
      $("#printImages").click(function(event) {
        event.preventDefault();
        var spanish = $('#spanish_val').text();
        var answerkey = $('#answerkey_val').text();
        $.ajax({
              data: {save_index: 0, spanish: spanish, answerkey: answerkey},
              type: "POST",
              dataType : 'html',
              url: "/users/ajax_printpage",
              success: function(data) {
                var WindowObject = window.open("", "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
                WindowObject.document.writeln(data);
                WindowObject.document.close();
                WindowObject.focus();
                WindowObject.print();
                WindowObject.close();     
              }       
        });    
      });

    });

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

 

</body>
</html>