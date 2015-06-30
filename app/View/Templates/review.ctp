	<!--- css style -->
	<link href="<?php echo $this->html->url('/css/style.css')?>" type="text/css" rel="stylesheet"/>

<link rel="stylesheet" href="<?php echo $this->html->url('/css/jquery-ui.css');?>">
 <script src="<?php echo $this->html->url('/js/jquery-1.10.2.js');?>"></script>
<script src="<?php echo $this->html->url('/js/jquery-ui.js');?>"></script>



	<link href="<?php echo $this->html->url('/fonts/fonts.css');?>" type="text/css" rel="stylesheet"/>
	<link rel="stylesheet" href="<?php echo $this->html->url('/css/jquery.mCustomScrollbar.css');?>">
  <link rel="stylesheet" href="<?php echo $this->html->url('/css/jqpagination.css');?>">

<div class="row">
                <div class="col-lg-12">
          <h1 class="page-header"><?php echo $title_for_layout; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title_for_layout; ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

<?php echo $this->element('/templates/template_header'); ?>
<section class="section">
		<div class="inner-container">
			
			<div id="left-content">
        <div id="image-display">
          <div id="ajax_response" class="alert alert-success fade in" style="display: none;">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Success!</strong> <?php echo __('Worksheet saved successfully'); ?>
          </div>
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
                        <li id="<?php echo $question['Question']['id']; ?>" class="ui-corner-tr ui-draggable ui-draggable-handle" style="display: list-item; width: 100%;">
                          <img src="<?php echo $this->request->base; ?>/questionimages/<?php echo $question['Question']['file_name']; ?>" style="display: inline-block; height: 100%;" alt="quesimg"  class="img1 mCS_img_loaded" imgsize="<?php echo $question['Question']['size']; ?>">
                        </li>
                      <?php elseif ($question['Question']['size'] == 'H') : ?>
                        <li id="<?php echo $question['Question']['id']; ?>" class="ui-corner-tr ui-draggable ui-draggable-handle" style="display: list-item; width: 100%;">
                          <img src="<?php echo $this->request->base; ?>/questionimages/<?php echo $question['Question']['file_name']; ?>" style="display: inline-block; height: 50%;" alt="quesimg"  class="img1 mCS_img_loaded" imgsize="<?php echo $question['Question']['size']; ?>">
                        </li>
                      <?php else : ?>
                        <li id="<?php echo $question['Question']['id']; ?>" class="ui-corner-tr ui-draggable ui-draggable-handle" style="display: list-item; width: 50%;">
                          <img src="<?php echo $this->request->base; ?>/questionimages/<?php echo $question['Question']['file_name']; ?>" style="display: inline-block; height: 25%;" alt="quesimg"  class="img1 mCS_img_loaded" imgsize="<?php echo $question['Question']['size']; ?>">
                        </li>
                      <?php endif; ?>
                    <?php endforeach; ?>  
                  </ul>
                <?php endif ?>
  					</div>
  				</div>
        </div>
			</div>
      <div id="right-content">
        <ul id="control-box">
          <?php if ($template != 'teacher') : ?>
            <div id="marginTop"></div>
            <div id="ajaxLoadingDiv" style="display: none; margin-left: -3px;"><?php echo $this->Html->image('ajax-loader-page.gif', array('alt' => 'Content Loading')); ?></div>
            <div class="pagination">
                <a href="javascript:void(0)" class="previous disabled" data-rel="0" id="previousPage">&lsaquo;</a>
                <input id="currentPage" type="text" value="Page 1 of <?php echo $page_count; ?>" data-rel="1" max="<?php echo $page_count; ?>" />
                <a href="javascript:void(0)" class="next disabled"  data-rel="1" id="nextPage">&rsaquo;</a>
            </div>
            <?php if (!isset($admin_template)) : ?>
              <li><input class="btn btn-primary" type="submit" id="editSheet" value="Edit"/></li>
            <?php endif; ?>
          <?php else : ?>
            <?php if (!isset($admin_template)) : ?>
              <li class="editLi"><input class="btn btn-primary" type="submit" id="editSheet" value="Edit"/></li>
            <?php endif; ?>
          <?php endif; ?>
          <?php if (!isset($admin_template)) : ?>
            <li><input class="btn btn-default" type="submit" id="savePdf" value="Save PDF"/></li>
            <li><input class="btn btn-default" type="submit" id="printImages" value="Print"/></li>
          <?php else : ?>
            <?php if ($template == 'teacher') : ?>
              <li class="editLi"><input class="btn btn-default" type="submit" id="printImages" value="Print"/></li>
            <?php else : ?>
              <li><input class="btn btn-default" type="submit" id="printImages" value="Print"/></li>
            <?php endif; ?>
          <?php endif; ?>
          <li><input type="checkbox" id="spanish" name="spanish" value="1"> Spanish</li>
          <li><input type="checkbox" id="answerkey" name="answerkey" value="1"> Answer Key</li>
          <li style="display: none;">
            <div id="spanish_val"></div>
            <div id="answerkey_val"></div>
          <li>
        </ul>
      </div>
		</div>
	</section>
</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
</script>
<script src="<?php echo $this->html->url('/js/placeholders.min.js');?>"></script>
	
	<!-- custom scrollbar plugin -->
	<script src="<?php echo $this->html->url('/js/jquery.mCustomScrollbar.concat.min.js');?>"></script>
	
	<script>
    var maxPage = $("#currentPage").attr('max');
    if (maxPage > 1) {
      $("#nextPage").removeClass('disabled');
    }
    // ajax Loader
    var IsLoaderForPage = false;
    $(document).ajaxStart(function() {
        if (IsLoaderForPage) 
            $("#ajaxLoadingDiv").show(); 
    });
    $(document).ajaxComplete(function() {
        if (IsLoaderForPage) 
            $("#ajaxLoadingDiv").hide();
        IsLoaderForPage = false;
    });
    // previous page
    $("#previousPage").click(function(event) {
        event.preventDefault();
        if ($("#currentPage").attr('max') == 1) {
          return;
        }
        if (parseInt($("#previousPage").attr('data-rel')) == 0) {
          return;
        }
        $("#nextPage").removeClass('disabled');
        var currentPage = parseInt($("#currentPage").attr('data-rel')) - 1;
        var previousPage =  parseInt($("#previousPage").attr('data-rel')) - 1;
        var maxPage =  parseInt($("#currentPage").attr('max'));
        $("#currentPage").attr('data-rel', currentPage);
        $("#previousPage").attr('data-rel', previousPage);
        $("#nextPage").attr('data-rel', previousPage+1);
        $("#currentPage").attr('value', currentPage + ' Pg ' + ' of ' + maxPage);
        if ($("#previousPage").attr('data-rel') > 0) {
          $("#previousPage").removeClass('disabled');
        } else {
          $("#previousPage").addClass('disabled');
        }
        if ($("#nextPage").attr('data-rel') > $("#currentPage").attr('max')) {
          $("#nextPage").removeClass('disabled');
        }
        // ajax call to get page content
        IsLoaderForPage = true;
        $.ajax({
              data: {page_no: currentPage-1, review: true},
              type: "POST",
              dataType : 'html',
              url: "/templates/ajax_page_add",
              success: function(data) {
                $("#trash").html(data);         
              }       
        });
      });

      // next page
      $("#nextPage").click(function(event) {
        event.preventDefault();
        if ($("#currentPage").attr('max') == 1) {
          return;
        }
        if (parseInt($("#nextPage").attr('data-rel')) == parseInt($("#currentPage").attr('max'))) {
          return;
        }
        var currentPage = parseInt($("#currentPage").attr('data-rel')) + 1;
        var nextPage =  parseInt($("#nextPage").attr('data-rel')) + 1;
        var maxPage =  parseInt($("#currentPage").attr('max'));
        $("#currentPage").attr('data-rel', currentPage);
        $("#previousPage").attr('data-rel', nextPage - 1);
        $("#nextPage").attr('data-rel', nextPage);
        $("#currentPage").attr('value', currentPage + ' Pg ' + ' of ' + maxPage);
        if ($("#previousPage").attr('data-rel') > 0) {
          $("#previousPage").removeClass('disabled');
        } else {
          $("#previousPage").addClass('disabled');
        }
        if ($("#nextPage").attr('data-rel') == $("#currentPage").attr('max')) {
          $("#nextPage").addClass('disabled');
        }
        // ajax call to get page content
        IsLoaderForPage = true;
        $.ajax({
              data: {page_no: currentPage-1, review: true},
              type: "POST",
              dataType : 'html',
              url: "/templates/ajax_page_add",
              success: function(data) {
                $("#trash").html(data);         
              }       
        });
    });
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
    margin: 10px 0;
    color: #2e6da4;
  }
  ul#control-box li.editLi {
    margin-top: 200px;
  }
  .center { text-align: center; padding: 5px 0;}
  input[type=submit] {
    font:3em Futura, ‘Century Gothic’, AppleGothic, sans-serif;
    font-size:90%;
    cursor:pointer;
    width: 60%;
  }
  input[type="checkbox"] {
      border: 1px solid #2e6da4;
  }
  .btn-primary {
    color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
  }
  .btn-default {
    color: #333;
    background-color: ash;
    border-color: #ccc;
    color: #2e6da4;
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
    border: 1px solid #2e6da4;
    border-radius: 4px;
  }
  
  a.disabled { color:gray; }
  #marginTop{
    margin: 200px 0 0 0;
  }
  .pagination {
    display: inline-block;
    margin: 0;
  }
  label {
    display: inline-block;
    max-width: 100%;
    margin: 0;
    font-weight: normal;
  }
  .review {
    background-color: #ffffff;
    color: #4f8db3;
    font-size: 11px;
    font-weight: 500;
    line-height: 15px;
    border: 1px solid #4f8db3;
    height: 24px;
    width: 65px;
    padding: 10px;
  }
  .review-btn {
    margin: 15px 0;
  }
  </style>
  <script>
    expireActiveCookies('item_size');
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
        $("#ajax_response").hide();
        $.ajax({
              data: {save_index : 0},
              type: "POST",
              url: "/templates/ajax_savepage",
              success: function(data) {
                $("#ajax_response").show();  
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
              url: "/templates/ajax_printpage",
              success: function(data) {
                var WindowObject = window.open('about:blank');
                WindowObject.document.writeln(data);
                WindowObject.document.close();
                WindowObject.focus();
                WindowObject.print();
                WindowObject.close();     
              }       
        });    
      });

       // Edit worksheet
      $("#editSheet").click(function(event) {
        event.preventDefault();
        window.location.href = '<?php echo $this->base . "/templates/add/edit" ?>'; 
      });

      $(".close").click(function(event) {
        event.preventDefault();
        $("#ajax_response").hide();
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

    function expireActiveCookies(name) {
      var pathname = location.pathname.replace(/\/$/, ''),
          segments = pathname.split('/'),
          paths = [];

      for (var i = 0, l = segments.length, path; i < l; i++) {
          path = segments.slice(0, i + 1).join('/');

          paths.push(path);       // as file
          paths.push(path + '/'); // as directory
      }

      expireAllCookies(name, paths);
    }

    function expireAllCookies(name, paths) {
      var expires = new Date(0).toUTCString();

      // expire null-path cookies as well
      document.cookie = name + '=; expires=' + expires;

      for (var i = 0, l = paths.length; i < l; i++) {
          document.cookie = name + '=; path=' + paths[i] + '; expires=' + expires;
      }
    }
  </script>