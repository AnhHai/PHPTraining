<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
    include ('include/header.php');
    include ('include/sidebar.php');
?>
    <div class="content">
        <h3>Add Category</h3>
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $errors = array();

                $trimmed = array_map('trim', $_POST);

                if(empty($_POST['cat_name'])){
                    $errors[] = 'category';
                }else{
                    $cat = mysqli_real_escape_string($dbc, strip_tags($trimmed['cat_name']));
                }

                if(filter_var($trimmed['position'], FILTER_VALIDATE_INT, array('min_range' => 1))){
                    $pos = $trimmed['position'];
                }else{
                    $errors[] = 'position';
                }

                if(empty($errors)){
                    $mysqli = new mysqli('localhost', 'root', 'haibui93', 'blog');
                    check_data_conn();

                    $q = "INSERT INTO categories (user_id, cat_name, position) values (?, ?, ?)";
                    if($stmt = $mysqli->prepare($q)){
                        $stmt->bind_param('isi', $_SESSION['uid'], $cat, $pos);
                        $stmt->execute() or die ("MySQL Error: {$query} " . mysqli_stmt_error());
                        if($stmt->affected_rows == 1){
                            $message = "<p class='success'>Insert Category success!</p>";
                        }else{
                            $message = "<p class='warning'>Category was not insert!</p>";
                        }
                    }else{
                        $message = "<p class='warning'>Could not added to the database due ti a system error. </p>";
                    }
                }else{
                    $message = "<p class='warning'>Please fill all the required fields</p>";
                }
            }
        ?>
        <?php
            if(isset($message)) echo $message;
        ?>
        <form method="post" action="" id="category">
            <fieldset>
                <legend>Add Category</legend>
                    <div class="row-field">
                        <?php
                            if(isset($errors) && in_array('category', $errors)) echo "<p class='p-warning'>Enter Category!</p>";
                        ?>
                        <label for="cat_name">Name <span class="required">*</span></label>
                        <input type="text" value="<?php if(isset($_POST['cat_name'])) echo strip_tags($_POST['cat_name']); ?>" name="cat_name" id="cat_name" tabindex="1" />
                    </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('position', $errors)){
                            echo "<p class='p-warning'>Select Position!</p>";
                        }
                    ?>
                    <label for="position">Position <span class="required">*</span></label>
                    <select name="position" tabindex="2">
                        <option>Select a position</option>
                        <?php
                        $query = "SELECT count(cat_id) AS count FROM categories";
                        $r = mysqli_query($dbc, $query);
                        confirm_query($r, $q);
                            if(mysqli_num_rows($r) > 0){
                                list($numb) = mysqli_fetch_array($r, MYSQLI_NUM);
                                for($i = 1; $i <= $numb + 1; $i++){
                                    echo "<option value='{$i}'";
                                        if(isset($_POST['position']) && $_POST['position'] == $i) echo "selected='selected'";
                                    echo ">" . $i . "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>

                <p class="button">
                    <input type="submit" name="submit" value="Add Category" />
                </p>

            </fieldset>
        </form>
    </div><!-- end .content -->
</div><!-- end .main-content -->
<?php
    include ('include/footer.php');
?>
