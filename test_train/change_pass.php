<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
    include ('include/header.php');
    include ('include/sidebar.php');
    is_login();
?>
    <div class="content">
        <h3>Change Password</h3>
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $errors = array();
                $trimmed = array_map('trim', $_POST);

                if(isset($_POST['pass']) && preg_match('/^[\w\'.-]{4,20}$/', $trimmed['pass'])){
                    $pass = mysqli_real_escape_string($dbc, $trimmed['pass']);
                }else{
                    $errors[] = 'password';
                }

                if(isset($_POST['new-pass']) && preg_match('/^[\w\'.-]{4,20}$/', $trimmed['new-pass'])){
                    if($_POST['new-pass'] == $_POST['re-pass']){
                        $new_pass = mysqli_real_escape_string($dbc, $trimmed['new-pass']);
                    }else{
                        $errors[] = 'not_match';
                    }
                }else{
                    $errors[] = 'new_pass';
                }

                if(empty($errors)){
                    $mysqli = new mysqli('localhost', 'root', 'haibui93', 'blog');
                    check_data_conn();

                    $q = "SELECT first_name FROM users WHERE pass = ? AND user_id = ?";
                    if($stmt_sl = $mysqli->prepare($q)){
                        $stmt_sl->bind_param('si', SHA1($pass), $_SESSION['uid']);
                        $stmt_sl->execute() or die ("MySQL Error: {$q} " . $stmt_sl->error());
                        $stmt_sl->store_result();
                        if($stmt_sl->num_rows == 1){
                            $query = "UPDATE users SET pass = ? WHERE user_id = ?";
                            if($stmt = $mysqli->prepare($query)){
                                $stmt->bind_param('si', SHA1($new_pass), $_SESSION['uid']);
                                $stmt->execute() or die ("MySQL Error: {$query} " . $stmt->error());
                                if($stmt->affected_rows == 1){
                                    $message = "<p class='success'>Your password has been successfully updated.</p>";
                                }else{
                                    $message = "<p class='warning'>Your password could not be changed due to a system error.</p>";
                                }
                            }
                        }else{
                            $message = "<p class='warning'>Your current password is incorrect. Please check your email to verify your password.</p>";
                        }
                    }
                }else{
                    $message = "<p class='warning'>Please fill in all the required fields. </p>";
                }
            }
        ?>
        <?php
            if(isset($message)) echo $message;
        ?>
        <form method="post" action="" id="change_pass">
            <fieldset>
                <legend>Change Password</legend>
                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('password', $errors)){
                            echo "<p class='p-warning'>Enter Password</p>";
                        }
                    ?>
                    <label for="pass">Password <span class="required">*</span></label>
                    <input type="password" name="pass" id="pass" tabindex="1" />
                </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('new_pass', $errors)){
                            echo "<p class='p-warning'>Enter new Pass</p>";
                        }
                    ?>
                    <label for="new-pass">New Password <span class="required">*</span></label>
                    <input type="password" name="new-pass" id="new-pass" tabindex="2" />
                </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('not_match', $errors)){
                            echo "<p class='p-warning'>Pass not match</p>";
                        }
                    ?>
                    <label for="re-pass">Re-Password <span class="required">*</span></label>
                    <input type="password" name="re-pass" id="re-pass" tabindex="3" />
                </div>

                <p class="button">
                    <input type="submit" name="submit" value="Change Password" />
                </p>
            </fieldset>
        </form>
    </div><!-- end .content -->
</div><!-- end .main-content -->
<?php
    include ('include/footer.php');
?>
