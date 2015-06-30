<link href="<?php echo $this->html->url('/css/style.css')?>" type="text/css" rel="stylesheet"/>

<link rel="stylesheet" href="<?php echo $this->html->url('/css/jquery-ui.css');?>">
 <script src="<?php echo $this->html->url('/js/jquery-1.10.2.js');?>"></script>
<script src="<?php echo $this->html->url('/js/jquery-ui.js');?>"></script>


  <link href="<?php echo $this->html->url('/fonts/fonts.css');?>" type="text/css" rel="stylesheet"/>
  <link rel="stylesheet" href="<?php echo $this->html->url('/css/jquery.mCustomScrollbar.css');?>">
  <link rel="stylesheet" href="<?php echo $this->html->url('/css/jqpagination.css');?>">

<?php if(isset($message)){
 echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class='ace-icon fa fa-check'></i>$message</strong></div>";}?>
 <?php
 if(isset($message1)){
 echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button>
<strong><i class='ace-icon fa fa-times'></i>$message1</strong></div>";}?>


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
      <?php  
        echo $this->Session->flash('notification');
        echo $this->Session->flash('error');
      ?>
      <div class="scroll-container" id="figurecont" style="float:left;margin-top:25px;width: 64%;margin-bottom: 80px; height: 500px; overflow: auto;"></div>
      
      <div class="right" id="right_content">
        <p><?php 
              if ($this->Session->check('Sheet')) {
                echo $this->Session->read('Sheet.name'); 
              } else {
                echo __('Create New Worksheet'); 
              }
          ?>
        </p>
        <div class="teacher-right">
          <div class="drag ui-widget-content ui-state-default" id="trash">
            <?php if (isset($questions)) : ?>
              <?php echo $this->element('templates/edit_sheet', array('questions' => $questions)); ?>
            <?php else : ?>
              <div><img src="<?php echo $this->html->url('/img/down-arrow.jpg');?>" alt="down-arrow" id="down-arrow">
              <h2 id="pro">Drag Problems Here</h2></div>
            <?php endif; ?>
          </div>
        </div>
        <?php if ($this->Session->check('Sheet')) : ?>
        <?php if ($template != 'teacher') : ?>
            <div id="ajaxLoadingDiv" style="display: none; margin-left: 87px;"><?php echo $this->Html->image('ajax-loader-page.gif', array('alt' => 'Content Loading')); ?></div>
            <div class="pagination">
                <a href="javascript:void(0)" class="previous disabled" data-rel="0" id="previousPage">&lsaquo;</a>
                <input id="currentPage" type="text" value="Page 1 of <?php echo !empty($page_count) ? $page_count : 1 ?>" data-rel="1" max="<?php echo !empty($page_count) ? $page_count : 1 ?>" />
                <a href="javascript:void(0)" class="next disabled"  data-rel="<?php echo !empty($page_count) ? 1 : 2 ?>" id="nextPage">&rsaquo;</a>
            </div>
          <ul>
            <li><input type="submit" id="addPage" class="btn btn-primary" value="Add Pg"/></li>
            <li><input type="submit" id="deletePage" class="btn btn-primary" value="Delete Pg"/></li>
          </ul>
          <?php endif; ?>
          <div class="review-btn"><?php echo $this->Html->link(__('Review'),array('controller' => 'templates', 'action' => 'review'), array('class'=>'review'));?>
          </div>
        <?php endif; ?>
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

<script>
function grade(id, element){  
	//$('#loadermsg').html(" Related Problems Loading....");
	$('#loadermsg').html(" Related Topics Loading....");
    $('#liloader').show();
    $('#selectedGrade').html($("#" + element).text());
    $('#selectedTopic').html('Math topics & tips');
    $('#selectedDomain').html('Domains');

    // load related problems
	// $.post("/templates/ajax_problems", { grade_id: id }, function(problems) {  
	//     if(problems) {   
	//         $('#figurecont').html(problems);
	//         drag_images(); 
	//     } 
	    // load related topics
	    
	    $.post("/templates/ajax_topics", { grade_id: id }, function(topics) {  
            if(topics){
            	$('#figurecont').html('');    
				$('#topics').html(topics);  
            }
            // load related domains
            $('#loadermsg').html(" Related Domains Loading....");
            $.post("/templates/ajax_domains", { grade_id: id }, function(domains) {  
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
        $.post("/templates/ajax_problems", { topic_id: id }, function(result){  
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
    
	$.post("/templates/ajax_problems", { domain_id: id }, function(result) {  
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
    $.post("/templates/ajax_edit_currentsheet", { id: id }, function(result) {  
        if(result){
        	// if( $('#figurecont').is(':empty') ) {
        	// 	$('#figurecont').html('<ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix ui-droppable"></ul>');
        	// }
        	drag_images(); 
            $('#right_content').html(result);
        }
        $.post("/templates/ajax_grades_dropdown", { id: id }, function(htmlData) {  
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
	if (pathname.indexOf("add") > -1) {
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
		      url: "/templates/ajax_search_image",
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

    (function($){
      // $(window).load(function(){

      //   $("#content-4").mCustomScrollbar({
      //     theme:"rounded-dots",
      //     scrollInertia:400
      //   });
      // });

      // save teacher pdf
      $("#addPage").click(function(event) {
        event.preventDefault();
        if ($("#trash").find("li").length > 0) {
          $("#trash").find("ul").html('');
        } else {
            return;
        }
        setCookie("item_size", 0, 1);
        $("#down-arrow").show();
        $("#pro").show();
        var maxPage = parseInt($("#currentPage").attr('max')) + 1;
        $("#currentPage").attr('data-rel', maxPage);
        $("#currentPage").attr('max', maxPage);
        $("#previousPage").attr('data-rel', maxPage-1);
        $("#nextPage").attr('data-rel', maxPage);
        $("#currentPage").attr('value', parseInt($("#currentPage").attr('data-rel')) + ' Pg ' + ' of ' + maxPage);
        if ($("#previousPage").attr('data-rel') > 0) {
          $("#previousPage").removeClass('disabled');
        } else {
          $("#previousPage").addClass('disabled');
        }
        if ($("#nextPage").attr('data-rel') > $("#currentPage").attr('data-rel')) {
          $("#nextPage").removeClass('disabled');
        } else {
          $("#nextPage").addClass('disabled');
        }
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
              data: {page_no: currentPage-1},
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
              data: {page_no: currentPage-1},
              type: "POST",
              dataType : 'html',
              url: "/templates/ajax_page_add",
              success: function(data) {
                $("#trash").html(data);         
              }       
        });
      });

      // delete current page
      $("#deletePage").click(function(event) {
        event.preventDefault();
        fnOpenNormalDialog();        
      });

      function fnOpenNormalDialog() {
        $("#dialog-confirm").html("Are you sure want to delete this page?");
        // Define the Dialog and its properties.
        $("#dialog-confirm").dialog({
            resizable: false,
            modal: true,
            title: "Delete Confirm",
            height: 250,
            width: 400,
            buttons: {
                "Yes": function () {
                    $(this).dialog('close');
                    callback(true);
                },
                    "No": function () {
                    $(this).dialog('close');
                    callback(false);
                }
            }
        });
      }

      function callback(value) {
          if (value) {
              var currentPage = parseInt($("#currentPage").attr('data-rel'));
              var needToDelete = currentPage;
              var previousPage =  parseInt($("#previousPage").attr('data-rel'));
              var maxPage =  parseInt($("#currentPage").attr('max'));
              var maxPageToSend = maxPage;
              var nextPage =  parseInt($("#nextPage").attr('data-rel'));

              
              if ((currentPage == 1) && (maxPage == 1)) {
                return;
              }
              

              if ((currentPage >= 1) && (currentPage < maxPage)) {
                // any page, not one page and not the last page
                currentPage = currentPage;
                maxPage = maxPage - 1;
                previousPage = previousPage;
                nextPage = nextPage;
                $("#nextPage").removeClass('disabled');
                $("#previousPage").removeClass('disabled');
              } else if ((currentPage > 1) && (currentPage == maxPage)) {
                // if last page delete
                if (maxPage == 2) {
                  nextPage = 2;
                } else {
                  nextPage = nextPage - 1;
                }
                currentPage = currentPage - 1;
                maxPage = maxPage - 1;
                previousPage = previousPage - 1;
                $("#nextPage").addClass('disabled');
              } else {
                // if one page and delete
                currentPage = 1;
                maxPage = 1;
                previousPage = 0;
                nextPage = 2;
                $("#nextPage").addClass('disabled');
                $("#previousPage").addClass('disabled');
              }

              $("#currentPage").attr('data-rel', currentPage);
              $("#currentPage").attr('max', maxPage);
              $("#previousPage").attr('data-rel', previousPage);
              $("#nextPage").attr('data-rel', nextPage);
              $("#currentPage").attr('value', currentPage + ' Pg ' + ' of ' + maxPage);

              // ajax call to remove page content
              IsLoaderForPage = true;
              $.ajax({
                    data: {page_no: needToDelete, max_page: maxPageToSend},
                    type: "POST",
                    dataType : 'html',
                    url: "/templates/ajax_page_delete",
                    success: function(data) {
                      $("#trash").html(data);         
                    }       
              });
          }
      }

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
  #gallery .ui-draggable-dragging { width: 200px !important; height: auto !important; }
  #trash ul.gallery .ui-draggable-dragging { width: 200px !important; height: auto !important; }
  #trash ul.gallery .ui-draggable-dragging img { height: 100% !important; }
  /*#trash .ui-draggable-dragging { width: 100px !important; height:  50px !important; border: 1px solid red;}*/
  a.disabled { color:gray; }
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
  label {
    display: inline-block;
    max-width: 100%;
    margin: 0;
    font-weight: normal;
  }
  </style>
  <script type="text/javascript">
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
  <?php if (!isset($questions)) : ?>
    <script>
      // initially when page load set cookie 0 for number of item
      expireActiveCookies('item_size');
      setCookie("item_size", 0, 1);
    </script>
  <?php endif; ?>
  <script>
function drag_images(){
var imgsize;
  $(function() {
    // there's the gallery and the trash
    var $gallery = $( "#gallery" ),
      $trash = $( "#trash" );
 
    // let the gallery items be draggable
    $( "li", $gallery ).draggable({
      cancel: "a.ui-icon", // clicking an icon won't initiate dragging
      revert: "invalid", // when not dropped, the item will revert back to its initial position
      containment: "document",
      helper: "clone",
      cursor: "move",
      //start: function(event, ui) { ui.helper.addClass('move'); },
    });
 
    // let the trash be droppable, accepting the gallery items
    $trash.droppable({
      accept: "#gallery > li",
      activeClass: "ui-state-highlight",
      drop: function( event, ui ) {
        imgsize=ui.draggable.find("img").attr("imgsize");
        item_size = parseInt(getCookie("item_size"));
        if (imgsize == 'F') {
          item_size = item_size + 4;
        } else if (imgsize == 'H') {
          item_size = item_size + 2;
        } else if (imgsize == 'Q') {
          item_size = item_size + 1;
        }
        if (item_size <= 4) {
          ui.draggable.find(".ui-icon-zoomin").show();
          ui.draggable.find(".ui-icon-trash").show();
          deleteImage( ui.draggable );
        } else {
          setCookie("item_size", 0, 1);
          var maxPage = parseInt($("#currentPage").attr('max')) + 1;
          $("#currentPage").attr('data-rel', maxPage);
          $("#currentPage").attr('max', maxPage);
          $("#previousPage").attr('data-rel', maxPage-1);
          $("#nextPage").attr('data-rel', maxPage);
          $("#currentPage").attr('value', parseInt($("#currentPage").attr('data-rel')) + ' Pg ' + ' of ' + maxPage);
          if ($("#previousPage").attr('data-rel') > 0) {
            $("#previousPage").removeClass('disabled');
          } else {
            $("#previousPage").addClass('disabled');
          }
          if ($("#nextPage").attr('data-rel') > $("#currentPage").attr('data-rel')) {
            $("#nextPage").removeClass('disabled');
          } else {
            $("#nextPage").addClass('disabled');
          }
          ui.draggable.find(".ui-icon-zoomin").show();
          ui.draggable.find(".ui-icon-trash").show();
          newPage(ui.draggable);
        }
      }
    });

    function newPage($item) {
      $( "ul", $trash ).html('<div><img src="/img/down-arrow.jpg" alt="down-arrow" id="down-arrow" style="display: none;"><h2 id="pro" style="display: none;">Drag Problems Here</h2></div>');
      deleteImage($item);
    }
 
    // image deletion function
    var recycle_icon = "<a href='link/to/recycle/script/when/we/have/js/off' title='Recycle this image' class='ui-icon ui-icon-refresh'>Recycle image</a>";
    function deleteImage( $item ) {
      $item.fadeOut(function() {
        var $list = $( "ul", $trash ).length ?
          $( "ul", $trash ) :
          $( "<ul class='gallery ui-helper-reset'/>" ).appendTo( $trash );
 
        $item.find( "a.ui-icon-trash" ).remove();
        $item.append( recycle_icon ).appendTo( $list ).fadeIn(function() {
         $("#pro").hide();
         $("#down-arrow").hide();
         if(imgsize=='F'){
          item_size = parseInt(getCookie("item_size")) + 4;
          setCookie("item_size", item_size, 1);
          $item
            .animate({ width: "100%" })
            .find( "img" )
              .animate({ height: "100%" });}
         else if(imgsize=='H'){
          item_size = parseInt(getCookie("item_size")) + 2;
          setCookie("item_size", item_size, 1);
          $item
            .animate({ width: "100%" })
            .find( "img" )
              .animate({ height: "50%" });}
          else if(imgsize=='Q'){
            item_size = parseInt(getCookie("item_size")) + 1;
          setCookie("item_size", item_size, 1);
 $item
            .animate({ width: "50%" })
            .find( "img" )
              .animate({ height: "25%" });
}
               });
        // order save in db on drop
        var items = [];
        $list.find("li").each(function(i) {
            items.push($(this).attr('id'));
        });
        var page_index = $("#currentPage").attr('data-rel');
        $.ajax({
              data: { items : items, page_index : page_index-1 },
              type: "GET",
              url: "/templates/save_order",
              success: function(data) {
                console.log(data);     
              }       
        });
      });
    }
 
    // image recycle function
    var trash_icon = "<a href='link/to/trash/script/when/we/have/js/off' title='Delete this image' class='ui-icon ui-icon-trash'>Delete image</a>";
    function recycleImage( $item ) {
// $("#pro").show();
// $("#down-arrow").show();
      imgsize=$item.find("img").attr("imgsize");
      if(imgsize=='F'){
        item_size = parseInt(getCookie("item_size")) - 4;
        setCookie("item_size", item_size, 1);
      } else if(imgsize=='H'){
        item_size = parseInt(getCookie("item_size")) - 2;
        setCookie("item_size", item_size, 1);
      }
      else if(imgsize=='Q'){
        item_size = parseInt(getCookie("item_size")) - 1;
        setCookie("item_size", item_size, 1);
      }

      $item.fadeOut(function() {
        $item
          .find( "a.ui-icon-refresh" )
            .remove()
          .end()
        
          //.append( trash_icon )
          .find( "img" )
            
          .end()
          .appendTo( $gallery )
          .fadeIn();
      });
      
      // order save in db on drop
      var current_item = $item.attr('id');
      var $deletelist = $( "ul", $trash );
      var deleteitems = [];
      $deletelist.find("li").each(function(i) {
          deleteitems.push($(this).attr('id'));
      });
      // remove current item from array
      var index = deleteitems.indexOf(current_item);
      if (index > -1) {
          deleteitems.splice(index, 1);
      }
      if (deleteitems.length < 1) {
        $("#pro").show();
        $("#down-arrow").show();          
      }
      var page_index = $("#currentPage").attr('data-rel');
      $.ajax({
            data: { items : deleteitems, page_index : page_index },
            type: "GET",
            url: "/templates/save_order",
            success: function(data) {
              console.log(data);    
            }       
      });
    }
 
    var theDialog = $(".mydialog").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        width: 'auto'
    });
 
    // image preview function, demonstrating the ui.dialog used as a modal window
    function viewLargerImage( $link ) {
      var src = $link.attr( "src" ),
        title = $link.siblings( "img" ).attr( "alt" );
      theDialog.html('<img src="'+src+'" width="auto" height="auto" />');
            setTimeout(function(){ theDialog.dialog('open') }, 100);
    }
 
    // resolve the icons behavior with event delegation
    $( "ul.gallery > li" ).click(function( event ) {
   
      var $item = $( this ),
        $target = $( event.target );
 
      if ( $target.is( "a.ui-icon-trash" ) ) {
        deleteImage( $item );
      } else if ( $target.is( "a.ui-icon-zoomin" ) ) {
        viewLargerImage( $target );
      } else if ( $target.is( "a.ui-icon-refresh" ) ) {
        // remove inline style for further drop
        $item.attr('style', '');
        $item.find("img").attr('style', '');
        $item.find(".ui-icon").css('display', 'none');
        $item.find(".ui-icon").css('display', 'none');
        recycleImage($item);
      }
 
      return false;
    });
  });
}

function removeInlineStyle($item) {
  $('#element').attr('style', function(i, style) {
      return style.replace(/display[^;]+;?/g, '');
  });
}

  </script>
			
<script type="text/javascript">
	$( document ).ready(function() {
		$('#tokenize').tokenize();
	});
</script>