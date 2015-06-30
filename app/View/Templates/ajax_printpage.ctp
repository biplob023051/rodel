<!DOCTYPE html>
<html>
<head>
  <title>
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
  <link rel="stylesheet" href="<?php echo $this->html->url('/css/jqpagination.css');?>">
</head>
<body style="cursor:auto">
  <?php if (isset($all_pages)) : ?>
    <?php foreach ($all_pages as $key => $questions) : ?>
      <div class="layout">
        <section class="section">
          <div class="inner-container">
            <div id="left-content">
              <div  id="image-display">
                <p class="center"><?php 
                      if ($this->Session->check('Sheet')) {
                        echo $this->Session->read('Sheet.name') . ' - Page ' . ($key+1) . ' of ' . count($all_pages); 
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
          </div>
        </section>
      </div>
    <?php endforeach; ?>
  <?php else : ?>
    <div class="layout">
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
          </div>
        </section>
      </div>
  <?php endif; ?>
 
  <style>
  .layout {
    min-height: 1320px !important;
  }
  html, body { width: 100%; height: 100%; }
  /*html, body { height: auto; }*/
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
  
  #left-content { width: 100%;}
  #image-display { margin: 0 100px;}
  #right-content { float: right; width: 18%;}
  #right-content ul li{
    list-style: none;
  }
  .center { text-align: center; padding: 5px 0;}

  .btn-primary {
    color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
  }
  .btn-default {
    color: #333;
    background-color: #fff;
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

  </body>
</html>