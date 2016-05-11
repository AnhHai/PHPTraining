<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
    include ('include/header.php');
    include ('include/sidebar.php');
is_login();
?>
    <div class="content">
        <h3>Edit User</h3>
        <?php
            if(isset($_GET['uid']) && filter_var($_GET['uid'], FILTER_VALIDATE_INT, array('min_range' => 1))){
                $uid = $_GET['uid'];
            }else{
                redirect_to('manage_users.php');
            }

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

                if(filter_var($trimmed['level'], FILTER_VALIDATE_INT, array('min_range' => 1))){
                    $level = $trimmed['level'];
                }else{
                    $errors[] = 'user_level';
                }

                if(empty($errors)){
                    $mysqli = new mysqli('localhost', 'root', 'haibui93', 'blog');
                    check_data_conn();

                    $query = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
                    if($stmt_sl = $mysqli->prepare($query)){
                        $stmt_sl->bind_param('si', $e, $uid);
                        $stmt_sl->execute() or die ("MySQL Error: {$query} " . mysqli_stmt_error());
                        $stmt_sl->store_result();
                        if($stmt_sl->num_rows() == 0){
                            $q = "UPDATE users SET first_name =?, last_name = ?, email = ?, user_level = ? WHERE user_id = ?";
                            if($stmt = $mysqli->prepare($q)){
                                $stmt->bind_param('sssii', $fn, $ln, $e, $level, $uid);
                                $stmt->execute() or die ("MySQL Error: {$q} " . mysqli_stmt_error());
                                if($stmt->affected_rows == 1){
                                    $message = "<p class='success'>Update Category success!</p>";
                                }else{
                                    $message = "<p class='warning'>Category was not Update!</p>";
                                }
                            }else{
                                $message = "<p class='warning'>Could not updated to the database due ti a system error. </p>";
                            }
                        }else{
                            $message = "<p class='warning'>This email is already in the system.</p>";
                        }
                    }
                }else{
                    $message = "<p class='warning'>Please fill in all the required fields. </p>";
                }
            }
        ?>
        <?php
            $q = "SELECT * FROM users WHERE user_id = {$uid}";
            $r = mysqli_query($dbc, $q);
                confirm_query($r, $q);
            if(mysqli_num_rows($r) == 1){
                $user = mysqli_fetch_array($r, MYSQLI_ASSOC);
            }else{
                $message = "<p class='warning'>User does not exist.</p>";
            }
        ?>
        <?php
            if(isset($message)) echo $message;
        ?>
        <form method="post" action="" id="edit_user">
            <fieldset>
                <legend>Edit User</legend>
                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('first_name', $errors)){
                            echo "<p class='p-warning'>Enter First Name</p>";
                        }
                    ?>
                    <label for="first_name">First Name<span class="required">*</span> </label>
                    <input type="text" value="<?php if(isset($user['first_name'])) echo strip_tags($user['first_name']); ?>" name="first_name" id="first_name" tabindex="1"/>
                </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('last_name', $errors)){
                            echo "<p class='p-warning'>Enter Last Name</p>";
                        }
                    ?>
                    <label for="last_name">Last Name<span class="required">*</span> </label>
                    <input type="text" value="<?php if(isset($user['last_name'])) echo strip_tags($user['last_name']); ?>" name="last_name" id="last_name" tabindex="2"/>
                </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('email', $errors)){
                            echo "<p class='p-warning'>Enter Email</p>";
                        }
                    ?>
                    <label for="email">Email<span class="required">*</span> </label>
                    <input type="text" value="<?php if(isset($user['email'])) echo $user['email']; ?>" name="email" id="email" tabindex="3"/>
                </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('user_level', $errors)){
                            echo "<p class='p-warning'>Select Level</p>";
                        }
                    ?>
                    <label for="level">User Level<span class="required">*</span> </label>
                    <select name="level" tabindex="4">
                        <option>Select user level</option>
                        <?php
                            $roles = array(0 => 'User', 1 => 'Admin', 2 => 'Manage User');
                            foreach($roles as $key => $role){
                                echo "<option value='{$key}'";
                                    if($key == $user['user_level']){
                                        echo "selected='selected'";
                                    }
                                echo ">" . $role ."</option>";
                            }
                        ?>
                    </select>
                </div>

                <p class="button">
                    <input type="submit" name="submit" value="Edit User" />
                </p>
            </fieldset>
        </form>
    </div><!-- end .content -->
</div><!-- end .main-content -->
<?php
    include ('include/footer.php');
?>
