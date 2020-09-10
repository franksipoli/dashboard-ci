<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="Bootstrap Admin App + jQuery">
   <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
   <title><?php echo $title?></title>
   <!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="<?php echo base_url("assets/vendor/fontawesome/css/font-awesome.min.css")?>">
   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="<?php echo base_url("assets/vendor/simple-line-icons/css/simple-line-icons.css")?>">
   <!-- ANIMATE.CSS-->
   <link rel="stylesheet" href="<?php echo base_url("assets/vendor/animate.css/animate.min.css")?>">
   <!-- WHIRL (spinners)-->
   <link rel="stylesheet" href="<?php echo base_url("assets/vendor/whirl/dist/whirl.css")?>">
   <!-- =============== PAGE VENDOR STYLES ===============-->
   <!-- WEATHER ICONS-->
   <link rel="stylesheet" href="<?php echo base_url("assets/vendor/weather-icons/css/weather-icons.min.css")?>">
   <!-- SELECT 2 -->
   <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="<?php echo base_url("assets/app/css/bootstrap.css")?>" id="bscss">
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="<?php echo base_url("assets/app/css/app.css?v=".rand(1,9999))?>" id="maincss">
   <link rel="stylesheet" href="<?php echo base_url("assets/app/css/custom.css?v=".rand(1,9999))?>" id="maincss">
   <?php
   	if (is_array($styles) && count($styles)>0){
   		foreach ($styles as $style){
   			?>
   			<link rel="stylesheet" type="text/css" href="<?php echo $style?>">
   			<?php
   		}
   	}
   ?>
</head>

<body>
   <div class="wrapper">
      <!-- top navbar-->
      <header class="topnavbar-wrapper">
         <!-- START Top Navbar-->
         <nav role="navigation" class="navbar topnavbar">
            <!-- START navbar header-->
            <div class="navbar-header">
               <a href="<?php echo makeUrl()?>" class="navbar-brand">
                  <div class="brand-logo">
                     <img src="<?php echo base_url("assets/app/img/logo.png")?>" alt="App Logo" class="img-responsive">
                  </div>
                  <div class="brand-logo-collapsed">
                     <img src="<?php echo base_url("assets/app/img/logo-single.png")?>" alt="App Logo" class="img-responsive">
                  </div>
               </a>
            </div>
            <!-- END navbar header-->
            <!-- START Nav wrapper-->
            <div class="nav-wrapper">
               <!-- START Left navbar-->
               <ul class="nav navbar-nav">
                  <li>
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a href="#" data-toggle-state="aside-collapsed" class="hidden-xs">
                        <em class="fa fa-navicon"></em>
                     </a>
                     <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                     <a href="#" data-toggle-state="aside-toggled" data-no-persist="true" class="visible-xs sidebar-toggle">
                        <em class="fa fa-navicon"></em>
                     </a>
                  </li>
               </ul>
               <!-- END Left navbar-->
               <!-- START Right Navbar-->
               <ul class="nav navbar-nav navbar-right">
                  <!-- START Alert menu-->
                  <?php include('msgbox.php') ?>
                  <!-- END Alert menu-->
                  <!-- START Contacts button-->
                  <li>
                     <a href="<?php echo makeUrl('seg','login','logoff')?>" title="Sair" data-toggle-state="offsidebar-open" data-no-persist="true">
                        <em class="fa fa-sign-out"></em>
                     </a>
                  </li>
                  <!-- END Contacts menu-->
               </ul>
               <!-- END Right Navbar-->
            </div>
            <!-- END Nav wrapper-->
         </nav>
         <!-- END Top Navbar-->
      </header>
      <!-- sidebar-->
      <aside class="aside">
         <!-- START Sidebar (left)-->
         <div class="aside-inner">
            <nav data-sidebar-anyclick-close="" class="sidebar">
               <!-- START sidebar nav-->
               <ul class="nav">
                  <!-- START user info-->
                  <li class="has-user-block">
                     <div id="user-block">
                        <div class="item user-block">
                           <!-- User picture-->
                           <div class="user-block-picture">
                              <div class="user-block-status">
                                 <img src="<?php echo base_url("assets/app/img/user/01.jpg")?>" alt="Avatar" width="60" height="60" class="img-thumbnail img-circle">
                              </div>
                           </div>
                           <!-- Name and Job-->
                           <div class="user-block-info">
                              <span class="user-block-name"><?php echo Segusuario_model::getCurrentUserNome()?></span>
                              <span class="user-block-role"><?php echo Segusuario_model::getCurrentUserFunction()?></span>
                           </div>
                        </div>
                     </div>
                  </li>
                  <!-- END user info-->
                  <?php
                  	include("menu.php");
                  ?>
            </nav>
         </div>
         <!-- END Sidebar (left)-->
      </aside>
      <!-- Main section-->
      <section>
         <?php
         	echo $contents;
         ?>
      </section>
      <!-- Page footer-->
      <footer>
         <span>&copy; <?php echo date('Y')?> - Yoopay Soluções Tecnológicas</span>
      </footer>
   </div>
   <!-- =============== VENDOR SCRIPTS ===============-->
   <!-- MODERNIZR-->
   <script src="<?php echo base_url("assets/vendor/modernizr/modernizr.js")?>"></script>
   <!-- JQUERY-->
   <script src="<?php echo base_url("assets/vendor/jquery/dist/jquery.js")?>"></script>
   <!-- BOOTSTRAP-->
   <script src="<?php echo base_url("assets/vendor/bootstrap/dist/js/bootstrap.js")?>"></script>
   <!-- STORAGE API-->
   <script src="<?php echo base_url("assets/vendor/jQuery-Storage-API/jquery.storageapi.js")?>"></script>
   <!-- JQUERY EASING-->
   <script src="<?php echo base_url("assets/vendor/jquery.easing/js/jquery.easing.js")?>"></script>
   <!-- JQUERY MASK-->
   <script src="<?php echo base_url("assets/vendor/jquery.mask/jquery.mask.min.js")?>"></script>
   <!-- ANIMO-->
   <script src="<?php echo base_url("assets/vendor/animo.js/animo.js")?>"></script>
   <!-- SLIMSCROLL-->
   <script src="<?php echo base_url("assets/vendor/slimScroll/jquery.slimscroll.min.js")?>"></script>
   <!-- SCREENFULL-->
   <script src="<?php echo base_url("assets/vendor/screenfull/dist/screenfull.js")?>"></script>
   <!-- LOCALIZE-->
   <script src="<?php echo base_url("assets/vendor/jquery-localize-i18n/dist/jquery.localize.js")?>"></script>
   <!-- RTL demo-->
   <script src="<?php echo base_url("assets/app/js/demo/demo-rtl.js")?>"></script>
   <!-- SELECT 2 -->
   <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
   <!-- =============== PAGE VENDOR SCRIPTS ===============-->
   <!-- SPARKLINE-->
   <script src="<?php echo base_url("assets/app/vendor/sparklines/jquery.sparkline.min.js")?>"></script>
   <!-- FLOT CHART-->
   <script src="<?php echo base_url("assets/vendor/Flot/jquery.flot.js")?>"></script>
   <script src="<?php echo base_url("assets/vendor/flot.tooltip/js/jquery.flot.tooltip.min.js")?>"></script>
   <script src="<?php echo base_url("assets/vendor/Flot/jquery.flot.resize.js")?>"></script>
   <script src="<?php echo base_url("assets/vendor/Flot/jquery.flot.pie.js")?>"></script>
   <script src="<?php echo base_url("assets/vendor/Flot/jquery.flot.time.js")?>"></script>
   <script src="<?php echo base_url("assets/vendor/Flot/jquery.flot.categories.js")?>"></script>
   <script src="<?php echo base_url("assets/vendor/flot-spline/js/jquery.flot.spline.min.js")?>"></script>
   <!-- CLASSY LOADER-->
   <script src="<?php echo base_url("assets/vendor/jquery-classyloader/js/jquery.classyloader.min.js")?>"></script>
   <!-- MOMENT JS-->
   <script src="<?php echo base_url("assets/vendor/moment/min/moment-with-locales.min.js")?>"></script>
   <!-- DEBOUNCE JS-->
   <script src="<?php echo base_url("assets/vendor/debounce/ba-throttle-debounce.min.js")?>"></script>
   <!-- SKYCONS-->
   <script src="<?php echo base_url("assets/vendor/skycons/skycons.js")?>"></script>
   <!-- DEMO-->
   <script src="<?php echo base_url("assets/app/js/demo/demo-flot.js")?>"></script>
   <!-- =============== APP SCRIPTS ===============-->
   <script src="<?php echo base_url("assets/app/js/app.js?v=".rand(1,9999))?>"></script>
   <script src="<?php echo base_url("assets/app/js/custom.js?v=".rand(1,9999))?>"></script>
   <?php
   	if (is_array($scripts) && count($scripts)>0){
   		foreach ($scripts as $script){
   			?>
   			<script src="<?php echo $script?>"></script>
   			<?php
   		}
   	}
      if (is_array($includes_html) && count($includes_html)>0){
         foreach ($includes_html as $include){
            $this->load->view($include);
         }
      }
   ?>
</body>

</html>