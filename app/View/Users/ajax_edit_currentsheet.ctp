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
    <?php echo $this->element('users/edit_sheet', array('questions' => $questions)); ?>
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
  <?php if ($this->Session->check('Sheet')) : ?>
    <?php if (isset($page_count)) : ?>
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
    <div class="review-btn"><?php echo $this->Html->link(__('Review'),array('controller' => 'users', 'action' => 'review'), array('class'=>'review'));?>
    </div>
  <?php endif; ?>

<?php if (isset($page_count)) : ?>
<script>
    var maxPage = $("#currentPage").attr('max');
    if (maxPage > 1) {
      $("#nextPage").removeClass('disabled');
    }
    // ajax loader
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
              data: {page_no: currentPage-1},
              type: "POST",
              dataType : 'html',
              url: "/users/ajax_page_add",
              success: function(data) {
                $("#trash").html(data);         
              }       
        });
      });

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
              url: "/users/ajax_page_add",
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
                    url: "/users/ajax_page_delete",
                    success: function(data) {
                      $("#trash").html(data);         
                    }       
              });
          }
      }
</script>
<?php endif; ?>