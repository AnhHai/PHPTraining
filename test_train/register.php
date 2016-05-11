<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
    require_once ('lib/PHPMailerAutoload.php');
    include ('include/header.php');
    include ('include/sidebar.php');
?>
    <div class="content">
        <h3>Register</h3>
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $errors = array();
                $trimmed = array_map('trim', $_POST);

                if(preg_match('/^[\w]{2,10}$/i', $trimmed['first_name'])){
                    $fn = $trimmed['first_name'];
                }else{
                    $errors[] = "first_name";
                }

                if(preg_match('/^[\w]{2,10}$/i', $trimmed['last_name'])){
                    $ln = $trimmed['last_name'];
                }else{
                    $errors[] = 'last_name';
                }

                if(filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)){
                    $e = $trimmed['email'];
                }else{
                    $errors[] = 'email';
                }

                if(preg_match('/^[\w\'.-]{4,20}$/', $trimmed['pass'])){
                    if($_POST['pass'] == $_POST['re-pass']){
                        $pass = mysqli_real_escape_string($dbc, $trimmed['pass']);
                    }else{
                        $errors[] = "password not match";
                    }
                }else{
                    $errors[] = "pass";
                }

                if(empty($errors)){
                    $mysqli = new mysqli('localhost', 'root', 'haibui93', 'blog');
                    check_data_conn();

                    $query = "SELECT user_id FROM users WHERE email = ?";
                    if($stmt_sl = $mysqli->prepare($query)){
                        $stmt_sl->bind_param('s', $e);
                        $stmt_sl->execute() or die ("MySQL Error: {$query} " . $stmt_sl->error());
                        $stmt_sl->store_result();
                        if($stmt_sl->num_rows == 0){
                            //tao ra 1 chuoi activation key
                            $a = md5(uniqid(rand(), true));

                            $q = "INSERT INTO users(first_name, last_name, email, pass, active, registration_date) values(?, ?, ?, ?, ?, NOW())";
                            if($stmt = $mysqli->prepare($q)){
                                $stmt->bind_param('sssss', $fn, $ln, $e, SHA1('$pass'), $a);
                                $stmt->execute() or die ("MySQL Error: {$q} " . $stmt->error());
                                if($stmt->affected_rows == 1){
                                    $body = "Thank you for registering. An activation email has been sent to the email address you provided.
                                     Please click on the link to active your account \n\n";
                                    $body .= BASE_URL . "active.php?x=" . urlencode($e) . "&y={$a}";
                                    $from = "haibui93@gmail.com";
                                    $to = $e;
                                    $title = "Active Account!";
                                    if(send_mail($from, $to, $title, $body) -> send()){
                                        $message = "<p class='success'>Register success. Active account at {$to}</p>";
                                    }else{
                                        $message = "<p class='warning'>Sorry! Email not send.</p>";
                                    }
                                }else{
                                    $message = "<p class='warning'>Sorry, your order could not be processed due to a system error</p>";
                                }
                            }
                        }else{
                            $message = "<p class='warning'>The email was already used previously. Please use another email address</p>";
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
        <form method="post" action="" id="register">
            <fieldset>
                <legend>Register</legend>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('first_name', $errors)){
                        echo "<p class='p-warning'>Enter First Name</p>";
                    }
                    ?>
                    <label for="first_name">First Name <span class="required">*</span> </label>
                    <input type="text" value="<?php if(isset($_POST['first_name'])) echo strip_tags($_POST['first_name']); ?>" name="first_name" id="first_name" tabindex="1"/>
                </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('last_name', $errors)){
                            echo "<p class='p-warning'>Enter Last Name</p>";
                    }
                    ?>
                    <label for="last_name">Last Name <span class="required">*</span> </label>
                    <input type="text" value="<?php if(isset($_POST['last_name'])) echo strip_tags($_POST['last_name']); ?>" name="last_name" id="last_name" tabindex="1"/>
                </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('email', $errors)){
                            echo "<p class='p-warning'>Enter Email</p>";
                        }
                    ?>
                    <label for="email">Email <span class="required">*</span> </label>
                    <input type="text" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email" id="email" tabindex="1"/>
                </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('pass', $errors)){
                            echo "<p class='p-warning'>Enter Password</p>";
                    }
                    ?>
                    <label for="pass">Password <span class="required">*</span> </label>
                    <input type="password" value="" name="pass" id="pass" tabindex="1"/>
                </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('password not match', $errors)){
                            echo "<p class='p-warning'>Password not match</p>";
                        }
                    ?>
                    <label for="re-pass">Re-Password <span class="required">*</span> </label>
                    <input type="password" value="" name="re-pass" id="re-pass" tabindex="1"/>
                </div>

                <p class="button">
                    <input type="submit" name="submit" value="Register" />
                </p>
            </fieldset>
        </form>
    </div><!-- end .content -->
</div><!-- end .main-content -->
<?php
    include ('include/footer.php');
?>
