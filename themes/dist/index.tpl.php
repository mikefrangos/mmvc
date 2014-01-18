<!doctype html>
<html lang='en'> 
<head>
  <meta charset='utf-8'/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$title?></title>
<!-- <link rel='shortcut icon' href='<?=theme_url($favicon)?>'/>   -->
  <link rel='stylesheet' href='<?=theme_url($stylesheet)?>'/>
  <?php if(isset($inline_style)): ?><style><?=$inline_style?></style><?php endif; ?>
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class='container'>

<div id='outer-wrap-header'>
  <div id='inner-wrap-header'>
    <div id='header'>
      <div id='login-menu'><?=login_menu()?></div>
      <div id='banner' class="page-header">
 <!--       <a href='<?=base_url()?>'>
        <img id='site-logo' src='<?=$logo?>' alt='logo' width='<?=$logo_width?>' height='<?=$logo_height?>' /></a> -->
        <span id='site-title'><a href='<?=base_url()?>'><?=$header?></a></span>   
        <span id='site-slogan'><?=$slogan?></span>   
      </div>
       
      <?php if(region_has_content('navbar')): ?>
        <div id='navbar' class="navbar navbar-default" role="navigation">  
          <?=render_views('navbar')?></div> 
      <?php endif; ?>
    </div>
  </div>
</div>

<?php if(region_has_content('flash')): ?>
<div id='outer-wrap-flash'>
  <div id='inner-wrap-flash'>
    <div id='flash'><?=render_views('flash')?></div>
  </div>
</div>
<?php endif; ?>

<?php if(region_has_content('featured-first', 'featured-middle', 'featured-last')): ?>
<div id='outer-wrap-featured'>
  <div id='inner-wrap-featured' class='row'>
    <div id='featured-first' class='col-md-4'><?=render_views('featured-first')?></div>
    <div id='featured-middle' class='col-md-4'><?=render_views('featured-middle')?></div>
    <div id='featured-last' class='col-md-4'><?=render_views('featured-last')?></div>
  </div>
</div>
<?php endif; ?>

<div id='outer-wrap-main'>
  <div id='inner-wrap-main' class='row'>
    <div id='primary' class='col-md-8'>
      <?=get_messages_from_session()?>
      <?=@$main?>
      <?=render_views('primary')?>
      <?=render_views()?>
    </div>
    <div id='sidebar' class='col-md-4'><?=render_views('sidebar')?></div>
  </div>
</div>

<?php if(region_has_content('column-first', 'column-middle', 'column-last')): ?>
<div id='outer-wrap-column'>
  <div id='inner-wrap-column' class='row'>
    <div id='column-first' class='col-md-4'><?=render_views('column-first')?></div>
    <div id='column-middle' class='col-md-4'><?=render_views('column-middle')?></div>
    <div id='column-last' class='col-md-4'><?=render_views('column-last')?></div>
  </div>
</div>
<?php endif; ?>

<div id='outer-wrap-footer'>
<?php if(region_has_content('footer-column-one', 'footer-column-two', 'footer-column-three', 'footer-column-four')): ?>
  <div id='inner-wrap-footer-column' class='row'>
    <div id='footer-column-one' class='col-md-3'><?=render_views('footer-column-one')?></div>
    <div id='footer-column-two' class='col-md-3'><?=render_views('footer-column-two')?></div>
    <div id='footer-column-three' class='col-md-3'><?=render_views('footer-column-three')?></div>
    <div id='footer-column-four' class='col-md-3'><?=render_views('footer-column-four')?></div>
  </div>
<?php endif; ?>
  <div id='inner-wrap-footer'>
    <div id='footer'> <?=render_views('footer')?><?=$footer?><?=get_debug()?></div>
  </div>
</div>
</div>
 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="offcanvas.js"></script>

</body>
</html>
