<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
    include ('include/header.php');
    include ('include/sidebar.php');
?>
    <div class="content">
        <?php
            if(isset($_GET['x'], $_GET['y']) && filter_var($_GET['x'], FILTER_VALIDATE_EMAIL) && strlen($_GET['y']) == 32){
                $email = mysqli_real_escape_string($dbc, $_GET['x']);
                $active = mysqli_real_escape_string($dbc, $_GET['y']);
                $a = substr($active, 0, 30);

                $mysqli = new mysqli('localhost', 'root', 'haibui93', 'blog');
                check_data_conn();

                $q = "UPDATE users SET active = NULL WHERE email = ? AND active = ? LIMIT 1";
                if($stmt = $mysqli->prepare($q)){
                    $stmt->bind_param('ss', $email, $a);
                    $stmt->execute() or die ("MySQL Error: {$q} " . $stmt->error());
                    if($stmt->affected_rows == 1){
                        echo "<p class='success'>Your account has been activated successfully. You may <a href='".BASE_URL."login.php'>Login</a> now</p>";
                    }else{
                        echo "<p class='warning'>Your account could not be activated. Please try again later.</p>";
                    }
                }
            }else{
                redirect_to();
            }
        ?>
    </div><!-- end .content -->
</div><!-- end .main-content -->
<?php
    include ('include/footer.php');
?>
