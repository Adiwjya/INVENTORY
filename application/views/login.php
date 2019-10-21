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
        <link rel="apple-touch-icon" href="ph<?php echo base_url(); ?>app-assets/images/ico/apple-icon-120.png">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>app-assets/images/ico/favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/vendors.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/forms/icheck/icheck.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/forms/icheck/custom.css">
        <!-- END VENDOR CSS-->
        <!-- BEGIN STACK CSS-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/app.css">
        <!-- END STACK CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/menu/menu-types/vertical-menu-modern.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/core/colors/palette-gradient.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/pages/login-register.css">
        <!-- END Page Level CSS-->
        <!-- BEGIN Custom CSS-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
        <!-- END Custom CSS-->
    </head>
    <body class="vertical-layout vertical-menu-modern 1-column menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
        <div class="app-content content">
            <div class="content-wrapper">
                <div class="content-header row"></div>
                <div class="content-body">
                    <section class="flexbox-container">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="col-md-4 col-10 box-shadow-2 p-0">
                                <div class="card border-grey border-lighten-3 m-0">
                                    <div class="card-header border-0">
                                        <div class="card-title text-center">
                                            <div class="p-1">
                                                <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="branding logo" style="width: 130px; height: auto;">
                                            </div>
                                        </div>
                                        <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                            <span>Login Inventory</span>
                                        </h6>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form-horizontal form-simple" id="form">
                                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                                    <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="Your Username" autocomplete="off">
                                                    <div class="form-control-position"><i class="ft-user"></i></div>
                                                </fieldset>
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="password" class="form-control form-control-lg" id="pass" name="pass" placeholder="Enter Password">
                                                    <div class="form-control-position"><i class="fa fa-key"></i></div>
                                                </fieldset>
                                            </form>
                                            <button type="button" id="btnLogin" class="btn btn-primary btn-lg btn-block" onclick="login();"><i class="ft-unlock"></i> Login</button>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="">
                                            <p class="float-sm-left text-center m-0"><a href="recover-password.html" class="card-link">Recover password</a></p>
                                            <p class="float-sm-right text-center m-0">New to Stack? <a href="register-simple.html" class="card-link">Sign Up</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!-- ////////////////////////////////////////////////////////////////////////////-->
        <!-- BEGIN VENDOR JS-->
        <script src="<?php echo base_url(); ?>app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
        <!-- BEGIN VENDOR JS-->
        <!-- BEGIN PAGE VENDOR JS-->
        <script src="<?php echo base_url(); ?>app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
        <!-- END PAGE VENDOR JS-->
        <!-- BEGIN STACK JS-->
        <script src="<?php echo base_url(); ?>app-assets/js/core/app-menu.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>app-assets/js/core/app.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>app-assets/js/scripts/customizer.js" type="text/javascript"></script>
        <!-- END STACK JS-->
        <!-- BEGIN PAGE LEVEL JS-->
        <script src="<?php echo base_url(); ?>app-assets/js/scripts/forms/form-login-register.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL JS-->
        <script type="text/javascript">
            function login(){
                // ajax adding data to database
                var email = document.getElementById('email').value;
                var pass = document.getElementById('pass').value;
                if(email === ''){
                    alert("Username tidak boleh kosong");
                }else if(pass === ''){
                    alert("Password tidak boleh kosong");
                }else{
                    $('#btnLogin').text('Prosess...'); //change button text
                    $('#btnLogin').attr('disabled',true); //set button disable
        
                    $.ajax({
                        url : "<?php echo base_url(); ?>login/ajax_login",
                        type: "POST",
                        data: $('#form').serialize(),
                        dataType: "JSON",
                        success: function(data){
                            $('#btnLogin').text('LOGIN'); //change button text
                            $('#btnLogin').attr('disabled',false); //set button disable
                            
                            if(data.status === 'ok'){
                                window.location.href = "<?php echo base_url(); ?>home";
                            }else{
                                alert(data.status);
                            }
                        },error: function (jqXHR, textStatus, errorThrown){
                            alert("Username atau password anda salah " + errorThrown);
                            
                            $('#btnLogin').text('LOGIN'); //change button text
                            $('#btnLogin').attr('disabled',false); //set button disable
                        }
                    });
                }
            }
        </script>
    </body>
</html>