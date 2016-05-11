<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
    include ('include/header.php');
    include ('include/sidebar.php');
?>
    <div class="content">
        <h3>Logout</h3>
        <?php
            if(!isset($_SESSION['name'])){
                redirect_to('login.php');
            }else{
                $_SESSION = array();
                session_destroy();
                setcookie(session_name(), '', time()-36000);
            }
            echo "<p>Thank you for your view page!</p>";
            redirect_to('login.php');
        ?>
    </div><!-- end .content -->
</div><!-- end #main-content -->
<?php
    include('include/footer.php');
?>
