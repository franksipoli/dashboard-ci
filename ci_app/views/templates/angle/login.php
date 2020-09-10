<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <title><?php echo $title?></title>
   <!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="<?php echo base_url("assets/vendor/fontawesome/css/font-awesome.min.css")?>">
   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="<?php echo base_url("assets/vendor/simple-line-icons/css/simple-line-icons.css")?>">
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="<?php echo base_url("assets/app/css/bootstrap.css")?>" id="bscss">
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="<?php echo base_url("assets/app/css/app.css")?>" id="maincss">
</head>

<body>
   <div class="wrapper">
      <div class="block-center mt-xl wd-xl">
         <!-- START panel-->
         <?php
         echo $contents;
         ?>
         <!-- END panel-->
         <div class="p-lg text-center">
            <span>&copy;</span>
            <span><?php echo date('Y')?></span>
            <span>-</span>
            <span><?php echo $title?></span>
         </div>
      </div>
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
   <!-- PARSLEY-->
   <script src="<?php echo base_url("assets/vendor/parsleyjs/dist/parsley.min.js")?>"></script>
   <!-- =============== APP SCRIPTS ===============-->
   <script src="<?php echo base_url("assets/app/js/app.js")?>"></script>
</body>

</html>