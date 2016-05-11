<?php
    session_start();
    require_once ('function.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <title>Test PHP training</title>

        <link href='https://fonts.googleapis.com/css?family=Old+Standard+TT:400,400italic,700' rel='stylesheet' type='text/css' />
        <link rel="stylesheet" href="css/style.css" />

        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/delete_cat.js"></script>
        <script type="text/javascript" src="js/delete_user.js"></script>
        <script type="text/javascript" src="js/delete_page.js"></script>
        <script type="text/javascript" src="ckeditor/ckeditor.js" ></script>
    </head>

    <body>
    <div id="wrap">
        <div class="container">
            <div id="header">
                <div class="header-top">
                    <div class="contact">
                        <ul>
                            <li><span>Email:</span> d.anh.bc@gmail.com</li>
                            <li><span>Phone:</span> 0163 4.045.172</li>
                        </ul>
                    </div><!-- end .contact -->

                    <div class="action">
                        <ul>
                            <?php
                                if(isset($_SESSION['user_level'])){
                                    switch($_SESSION['user_level']){
                                        case 1:
                                            echo "
                                                <li></li>
                                                <li><a href='#'>" . $_SESSION['name'] ."</a>
                                                    <ul class='user'>
                                                        <li><a href='edit_profile.php'>edit profile</a></li>
                                                        <li><a href='change_pass.php'>change pass</a></li>
                                                        <li><a href='#'>Admin CP</a></li>
                                                        <li><a href='logout.php'>logout</a></li>
                                                    </ul>
                                                </li>
                                            ";
                                            break;
                                        case 2:
                                            echo "
                                                <li></li>
                                                <li><a href='#'>" . $_SESSION['name'] ."</a>
                                                    <ul class='user'>
                                                        <li><a href='edit_profile.php'>edit profile</a></li>
                                                        <li><a href='change_pass.php'>change pass</a></li>
                                                        <li><a href='#'>Manager CP</a></li>
                                                        <li><a href='logout.php'>logout</a></li>
                                                    </ul>
                                                </li>
                                            ";
                                            break;
                                        default:
                                            echo "
                                                <li></li>
                                                <li><a href='#'>" . $_SESSION['name'] ."</a>
                                                    <ul class='user'>
                                                        <li><a href='edit_profile.php'>edit profile</a></li>
                                                        <li><a href='change_pass.php'>change pass</a></li>
                                                        <li><a href='logout.php'>logout</a></li>
                                                    </ul>
                                                </li>
                                            ";
                                    }
                                }else{
                                    echo "
                                        <li><a href='login.php'>Login</a></li>
                                        <li><a href='register.php'>Register</a></li>
                                    ";
                                }
                            ?>
                        </ul>
                    </div><!-- end .action -->
                </div><!-- end .header-top -->

                <div class="banner">
                    <h1 class="h1-title">Test PHP Training</h1>
                </div><!-- end .banner -->

                <div class="nav">
                    <div class="menu">
                        <ul class="mainNav">
                            <li><a href="#">home</a></li>
                            <li><a href="#">about</a></li>
                            <li><a href="#">services</a></li>
                            <li><a href="#">contact us</a></li>
                        </ul>
                    </div>

                    <div class="hello">
                        <p>Hello <?php echo (isset($_SESSION['name'])) ? $_SESSION['name'] : "Ban Hien" ?>!</p>
                    </div>
                </div>
            </div><!-- end #header -->
