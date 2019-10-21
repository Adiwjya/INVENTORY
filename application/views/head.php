<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="PRAMEDIA">
        <title>INVENTORY</title>
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>app-assets/images/ico/apple-icon-120.png">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>app-assets/images/ico/favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>app-assets/css/vendors.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/extensions/unslider.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/weather-icons/climacons.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/fonts/meteocons/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/charts/morris.css">
        <!-- END VENDOR CSS-->
        <!-- BEGIN STACK CSS-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/app.css">
        <!-- END STACK CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/menu/menu-types/vertical-menu-modern.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/colors/palette-gradient.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/fonts/simple-line-icons/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/colors/palette-gradient.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/pages/timeline.css">
        <!-- END Page Level CSS-->
        <!-- BEGIN Custom CSS-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
        <!-- END Custom CSS-->
        <!-- JQUERY -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.12.3.js"></script>
        <!-- Tanggal -->
        <link href="<?php echo base_url(); ?>assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">        
        
        <script type="text/javascript">
            
            function back(){
                window.history.back();
            }
            
            function hanyaAngka(e, decimal) {
                var key;
                var keychar;
                if (window.event) {
                    key = window.event.keyCode;
                } else if (e) {
                    key = e.which;
                } else {
                    return true;
                }
                keychar = String.fromCharCode(key);
                if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
                    return true;
                } else if ((("0123456789").indexOf(keychar) > -1)) {
                    return true;
                } else if (decimal && (keychar == ".")) {
                    return true;
                } else {
                    return false;
                }
            }
            
            function batas_angka(input, max) {
                if (input.value < 0){ input.value = 0;}
                if (input.value > parseInt(max)) {input.value = parseInt(max);}
            }
        </script>
    </head>
    <body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
        <!-- fixed-top-->
        <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
            <div class="navbar-wrapper">
                <div class="navbar-header">
                    <ul class="nav navbar-nav flex-row position-relative">
                        <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                        <li class="nav-item mr-auto">
                            <a class="navbar-brand" href="<?php echo base_url(); ?>">
                                <h2 class="brand-text">INVENTORY</h2>
                            </a>
                        </li>
                        <li class="nav-item d-none d-md-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 white" data-ticon="ft-toggle-right"></i></a></li>
                        <li class="nav-item d-md-none">
                            <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-container content">
                    <div class="collapse navbar-collapse" id="navbar-mobile">
                        <ul class="nav navbar-nav mr-auto float-left">
                            <li class="dropdown nav-item mega-dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">INVENTORY Info</a>
                                <ul class="mega-dropdown-menu dropdown-menu row">
                                    <li class="col-md-2">
                                        <h6 class="dropdown-menu-header text-uppercase mb-1"><i class="fa fa-newspaper-o"></i> News</h6>
                                        <div id="mega-menu-carousel-example">
                                            <div>
                                                <img class="rounded img-fluid mb-1" src="<?php echo base_url(); ?>app-assets/images/slider/slider-2.png" alt="First slide"><a class="news-title mb-0" href="#">Poster Frame PSD</a>
                                                <p class="news-content">
                                                    <span class="font-small-2">January 26, 2016</span>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-md-3"></li>
                                    <li class="col-md-4"></li>
                                </ul>
                            </li>
                            <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
                            <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i class="ficon ft-search"></i></a>
                                <div class="search-input">
                                    <input class="input" type="text" placeholder="Explore Stack...">
                                </div>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav float-right">
                            <li class="dropdown dropdown-notification nav-item">
<!--                                <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i>
                                    <span class="badge badge-pill badge-default badge-danger badge-default badge-up">5</span>
                                </a>-->
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                    
                                    <li class="dropdown-menu-header">
                                        <h6 class="dropdown-header m-0">
                                            <span class="grey darken-2">Notifications</span>
                                            <span class="notification-tag badge badge-default badge-danger float-right m-0">5 New</span>
                                        </h6>
                                    </li>
                                    <li class="scrollable-container media-list">
                                        <a href="javascript:void(0)">
                                            <div class="media">
                                                <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div>
                                                <div class="media-body">
                                                    <h6 class="media-heading">You have new order!</h6>
                                                    <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                    <small>
                                                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutes ago</time>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)">
                                            <div class="media">
                                                <div class="media-left align-self-center"><i class="ft-download-cloud icon-bg-circle bg-red bg-darken-1"></i></div>
                                                <div class="media-body">
                                                    <h6 class="media-heading red darken-1">99% Server load</h6>
                                                    <p class="notification-text font-small-3 text-muted">Aliquam tincidunt mauris eu risus.</p>
                                                    <small>
                                                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Five hour ago</time>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li>
                                </ul>
                            </li>
                            <li class="dropdown dropdown-user nav-item">
                                <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                    <span class="avatar avatar-online">
                                        <img src="<?php echo base_url(); ?>/assets/img/user.png" alt="avatar" style="width: 50px; height: auto;"><i></i></span>
                                    <span class="user-name"><?php echo $nama; ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php
                                    if($golongan != "SU"){
                                        ?>
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>profile"><i class="ft-user"></i> Profile</a>
                                        <?php
                                    }
                                    ?>
                                    
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>changepass"><i class="ft-lock"></i> Change Password</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>home/logout"><i class="ft-power"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>