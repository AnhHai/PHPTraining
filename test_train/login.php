<?php
    include ('include/header.php');
    include ('include/sidebar.php');
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
?>

        <div class="content">
            <h3>Login</h3>
            <?php
                if(!isset($_SESSION['first_name'])){
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $trimmed = array_map('trim', $_POST);
                        $errors = array();

                        if(isset($_POST['email']) && filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)){
                            $e = $trimmed['email'];
                        }else{
                            $errors[] = 'email';
                        }

                        if(isset($_POST['pass']) && preg_match('/^[\w\'.-]{4,20}$/', $trimmed['pass'])){
                            $p = $trimmed['pass'];
                        }else{
                            $errors[] = 'password';
                        }

                        if(empty($errors)){
                            $q = "SELECT user_id, CONCAT_WS(' ',first_name, last_name) AS name, user_level FROM users WHERE email = '{$e}' AND pass = SHA1('$p') AND active IS NULL LIMIT 1";
                            $r = mysqli_query($dbc, $q);
                                confirm_query($r, $q);
                            if(mysqli_num_rows($r) == 1){
                                list($uid, $name, $level) = mysqli_fetch_array($r, MYSQLI_NUM);
                                $_SESSION['uid'] = $uid;
                                $_SESSION['name'] = $name;
                                $_SESSION['user_level'] = $level;

                                redirect_to();
                            }else{
                                $message = "<p class='warning'>The email or password do not match those on file. Or you have not activated your account.</p>";
                            }
                        }else{
                            $message = "<p class='warning'>Please fill in all the required fields.</p>";
                        }
                    }
                }
            ?>
            <?php
                if(isset($message)) echo $message;
            ?>
            <form method="post" action="" id="login">
                <fieldset>
                    <legend>User Login</legend>
                    <div class="row-field">
                        <?php
                            if(isset($errors) && in_array('email',$errors)) echo "<p class='p-warning'>Enter Email!</p>";
                        ?>
                        <label for="email">Email<span class="required"> *</span></label>
                        <input type="text" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email']);} ?>" name="email" id="email" tabindex="1"/>
                    </div>

                    <div class="row-field">
                        <?php
                            if(isset($errors) && in_array('password', $errors)) echo "<p class='p-warning'>Enter Password!</p>";
                        ?>
                        <label for="password">Password<span class="required"> *</span></label>
                        <input type="password" name="pass" id="pass" tabindex="2"/>
                    </div>

                    <p class="button">
                        <input type="submit" name="submit" value="Login" />
                    </p>
                </fieldset>
            </form>
        </div><!-- end .content -->
    </div><!-- end #main-content -->

<?php
    include ('include/footer.php');
?>
