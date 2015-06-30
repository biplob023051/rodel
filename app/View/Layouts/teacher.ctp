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

<link rel="stylesheet" href="<?php echo $this->html->url('/css/jquery-ui.css');?>">
 <script src="<?php echo $this->html->url('/js/jquery-1.10.2.js');?>"></script>
<script src="<?php echo $this->html->url('/js/jquery-ui.js');?>"></script>



  <link href="<?php echo $this->html->url('/fonts/fonts.css');?>" type="text/css" rel="stylesheet"/>
  <link rel="stylesheet" href="<?php echo $this->html->url('/css/jquery.mCustomScrollbar.css');?>">
</head>
<body style="cursor:auto">
<div class="layout">
  <?php echo $this->element('header'); ?>



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
              <?php echo $this->element('users/edit_sheet', array('questions' => $questions)); ?>
            <?php else : ?>
              <div><img src="<?php echo $this->html->url('/img/down-arrow.jpg');?>" alt="down-arrow" id="down-arrow">
              <h2 id="pro">Drag Problems Here</h2></div>
            <?php endif; ?>
          </div>
          <!-- <div class="teacher-problembox">
            <div class="problembox-title"><h4>Plan-What strategy will you use to help you solve this problem?</h4></div>
            <div class="problembox-content"><p>Solve</p></div>
            <div class="problembox-bottom">
              <div class="answer-label">Answer with label</div>
              <div class="answer-check">Check-Answer the question(s) with a complete sentence.</div>
            </div>
          </div> -->
        </div>
        <?php if ($userDetail['User']['user_role'] != 'teacher') : ?>
          <ul>
            <li><input type="submit" id="delete" value="Delete Pg"/></li>
          </ul>
        <?php endif; ?>
        <div class="review-btn"><?php echo $this->Html->link(__('Review'),array('controller' => 'users', 'action' => 'review'), array('class'=>'review'));?>
        </div>
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
  <div class="mydialog" style="display: none;">
  </div>
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
  #trash ul.gallery .ui-draggable-dragging { width: 300px !important; height: 200px !important; }
  #trash ul.gallery .ui-draggable-dragging img { height: 100% !important; }
  /*#trash .ui-draggable-dragging { width: 100px !important; height:  50px !important; border: 1px solid red;}*/
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
          //nextPage(ui.draggable);
          //alert('Not allowed, may be your page full or need small image');
        }
      }
    }).sortable({
      items: "li"
    });

    $( "#trash li" ).disableSelection();
 
    // let the gallery be droppable as well, accepting items from the trash
    // $gallery.droppable({
    //   accept: "#trash li",
    //   activeClass: "custom-state-active",
    //   drop: function( event, ui ) {
    //     imgsize=ui.draggable.find("img").attr("imgsize");
    //     ui.draggable.find(".ui-icon-zoomin").hide();
    //     ui.draggable.find(".ui-icon-trash").hide();
    //     recycleImage( ui.draggable );
    //   }
    // });

    function nextPage($item) {
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
        $.ajax({
              data: { items : items },
              type: "GET",
              url: "/users/save_order",
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
      $.ajax({
            data: { items : deleteitems },
            type: "GET",
            url: "/users/save_order",
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
  $item.attr('style', function(i, style) {
      return style.replace(/display[^;]+;?/g, '');
  });
}

  </script>

 

</body>
</html>