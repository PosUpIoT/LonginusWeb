<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Longinus Web</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url('/assets/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url('/assets/css/uikit.css');?>" rel="stylesheet">

	<link rel="stylesheet" href="<?=base_url('/assets/css/select2.min.css');?>" type="text/css"/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="uikit/js/html5shiv.js"></script>
    <script src="uikit/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Main Navbar -->
    <nav class="main-navbar unibar unibar-lg bg-white bd-b">

      <!-- unibar container -->
      <div class="container unibar-container bg-inherit">

        <!-- header block -->
        <div class="unibar-block header-block bg-primary hide-border">
        
          <!-- /brand cell -->

          <!-- brand cell -->
          <div class="unibar-cell brand-cell">
            <a href="<?=base_url('index.php')?>" class="unibar-brand fw-bold">Longinus</a>
          </div>
          <!-- /brand cell -->
          
          <!-- brand cell -->
          <div class="unibar-cell search-toggle-cell">
            <div class="ie-fix">
              <a class="search-toggle" href="#" data-ctoggle="unhide-search" data-target=".main-navbar"><i class="fa-search hidden-toggled"></i><i class="fa-close visible-toggled"></i></a>
            </div>
          </div>
          <!-- /brand cell -->

        </div>
        <!-- /header block -->
        
        <!-- nav block -->
        <div class="unibar-block nav-block bg-inherit">
          <style>

          </style>
          <!-- nav cell -->
          <style>
              .search-box .select2-container{
                position: absolute;
                top: 0;
                bottom: 0;
                height: 34px;
                margin: auto 0;
                display: block;
              }

              .select2-result-repository__avatar {
                  float: left;
                  width: 60px;
                  margin-right: 10px;
              }

              .select2-results__option--highlighted .select2-result-repository__description {
                  color: #c6dcef;
              }
              .select2-result-repository__description {
                  font-size: 13px;
                  color: #777;
                  margin-top: 4px;
              }

              .select2-results__option--highlighted .select2-result-repository__title {
                  color: white;
              }

              .select2-result-repository__title {
                  color: black;
                  font-weight: bold;
                  word-wrap: break-word;
                  line-height: 1.1;
                  margin-bottom: 4px;
              }

              .select2-result-repository__meta {
                  margin-left: 70px;
              }
              .select2-result-repository__avatar img {
                  width: 100%;
                  height: auto;
                  border-radius: 2px;
                  max-width: 60px;
                  max-height: 60px;
              }

              .search-box  .select2-container .select2-selection--multiple {
                  box-sizing: border-box;
                  cursor: pointer;
                  display: block;
                  min-height: 34px;
                  user-select: none;
                  -webkit-user-select: none;
              }
              .search-box .select2-container--default .select2-selection--multiple {
                  background-color: white;
                  border: 1px solid #aaa;
                  border-radius: 0px;
                  cursor: text;
              }

              .search-box .select2-container--default .select2-search--inline .select2-search__field 
              {

                  padding: 10px;
                  margin: 0;
              }

              .search-box .select2-dropdown{
                 border: rgba(0, 0, 0, 0.1);
              }

              .search-box .select2-container--default.select2-container--focus .select2-selection--multiple{
                  border: none;
                  height: 34px;
                  width: 100%;
                  color: #666;
                  box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1), 0 0 2px 1px rgba(0, 0, 0, 0.1);
                  border-radius: 0;
              }
              .search-box .select2-search__field{
                width: 100% !important;
              }
              .search-box .select2-search--inline:after{
                content: '\f002';
                color:#ee304c;
                    display: inline-block;
                  font: normal normal normal 14px/1 FontAwesome;
                  font-size: 20px;
                  text-rendering: auto;
                  -webkit-font-smoothing: antialiased;
                      position: absolute;
                      right: 10px;
                      top:6px;
              }
          </style>
          <div class="unibar-cell nav-cell cell-max">
            <form class="unibar-search" method="post" action="<?=base_url('index.php/feed/quickSearch')?>">
              <div class="search-box">
                  <select id="quick-search" data-placeholder="Type to start searching our database" style="width: 60%;" class="text-box js-data-example-ajax" multiple="multiple">
                    
                  </select>
              </div>
            </form>

            <!-- unibar search 
            <form class="unibar-search" method="post" action="<?=base_url('index.php/feed/quickSearch')?>">
              <div class="search-box">
                <input class="text-box" name="search" type="text" placeholder="Search anything...">
                <button type="button" class="btn btn-primary case-u"><i class="fa-search mgr-5"></i>search</button>
              </div>
            </form>
             /unibar search -->
            
            <!-- mobile quick links -->
            <div class="visible-sm visible-xs">
            
              <!-- uninav -->
              <ul class="uninav unibar-uninav uninav-fga-primary uninav-fillh auto-invert case-u fw-bold text-center">
                <li class="active"><a href="index.html">Principal</a></li>
                <li><a href="#">Recentes</a></li>
                <li><a href="#" data-ctoggle="unhide" data-target="#menu-col1">Mais<i class="fs-80 ti-plus dd-icon toggled-rotz-135"></i></a>
                <?php if(!$this->session->has_userdata('logged_in')  || $this->session->userdata('logged_in') == FALSE ){ ?>
                <li><a href="<?php  echo base_url('/index.php/home/login'); ?>" style="color:white;">Login</a></li>
                <?php }else{ ?>
                    <li><a href="#"><?php echo $this->session->userdata('name'); ?></a></li>
                 <?php }  ?>
              </ul>
              <!-- /uninav -->
            
            </div>
            <!-- /mobile quick links -->
            
            <!-- collapsible menu -->
            <div id="menu-col1" class="unibar-collapse-sm">
            
              <!-- uninav -->
              <ul class="uninav unibar-uninav uninav-fga-primary uninav-fillh auto-invert case-u fw-bold">
                <li class="active"><a href="index.html">Principal</a></li>
                <li class="dropdown"><a href="#" data-toggle="dropdown">Categorias<i class="fs-80 ti-plus dd-icon open-rotz-135"></i></a>
                  <ul class="dropdown-menu dropdown-right case-c">
                    <li class="active"><a href="index.html">Home Version 1</a></li>
                    <li><a href="index-2.html">Home Version 2</a></li>
                    <li><a href="post.html">Post View</a></li>
                    <li><a href="search.html">Search Results</a><x/li>
                    <li class="divider"></li>
                    <li><a href="index.php/home/login">Sign In page</a></li>
                    <li><a href="register.html">Sign Up page</a></li>
                    <li><a href="error.html">404 Page</a></li>
                    <li class="divider"></li>
                    <li><a href="colors.html">Color Guide</a></li>
                    <li><a href="features.html">Selected Features</a></li>
                  </ul>
                </li>
                <?php if($this->session->has_userdata('logged_in')  && $this->session->userdata('logged_in') == TRUE ){ ?>
                <li><a href="index-2.html">Perdeu?</a></li>
                <li class="hidden-lg hidden-md"><a href="post.html">Perfil</a></li>
                <li class="hidden-lg hidden-md"><a href="<?php  echo base_url('/index.php/user/logout') ?>">Logout</a></li>
                <?php } ?>
              </ul>
              <!-- /uninav -->
            
            </div>
            <!-- collapsible menu -->
            
          </div>
          <!-- /nav cell -->
          
          <!-- cell -->
          <div class="unibar-cell hidden-xs hidden-sm cell-min case-u">
            <?php if(!$this->session->has_userdata('logged_in')  || $this->session->userdata('logged_in') == FALSE ){ ?>
            <a class="btn btn-primary" href="<?php  echo base_url('/index.php/home/login') ?>" style="color:white;">Login</a>
            <?php }else{ ?>
                <a href="#" data-toggle="dropdown"><?php echo $this->session->userdata('name'); ?><i class="fs-80 ti-plus dd-icon open-rotz-135"></i></a>
                 <ul class="dropdown-menu dropdown-right case-c">
                    <li><a href="post.html">Perfil</a></li>
                    <li><a href="<?php  echo base_url('/index.php/user/logout') ?>">Logout</a></li>
                  </ul>
             <?php }  ?>
          </div>
          <!-- /cell -->
          
        </div>
        <!-- /nav block -->

        <!-- /mega menu -->

      </div>
      <!-- /unibar Cont -->
        
    </nav>
    <!-- /Main Navbar -->
    
    <!-- Content -->
    <section class="content bg-black-3">
    
    <!-- Alerts -->
    <?php if(!empty($message)){ ?>
      <div class="alert alert-<?= $message['type']?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= $message['content']?>
      </div>
    <?php } ?>