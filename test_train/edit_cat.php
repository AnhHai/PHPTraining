<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
    include ('include/header.php');
    include ('include/sidebar.php');
is_login();
?>
    <div class="content">
        <h3>Edit Category</h3>
        <?php
            if(isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' => 1))){
                $cid = $_GET['cid'];
            }else{
                redirect_to('categories.php');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $errors = array();
                $trimmed = array_map('trim', $_POST);

                if(empty($_POST['cat_name'])){
                    $errors[] = 'category';
                }else{
                    $cat = mysqli_real_escape_string($dbc, strip_tags($trimmed['cat_name']));
                }

                if(filter_var($trimmed['pos'], FILTER_VALIDATE_INT, array('min_range' => 1))){
                    $pos = $trimmed['pos'];
                }else{
                    $errors[] = 'position';
                }

                if(empty($errors)){
                    $mysqli = new mysqli('localhost', 'root', 'haibui93', 'blog');
                    check_data_conn();

                    $q = "UPDATE categories SET cat_name = ?, position = ? WHERE cat_id = ?";
                    if($stmt = $mysqli->prepare($q)){
                        $stmt->bind_param('sii', $cat, $pos, $cid);
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
                    $message = "<p class='warning'>Please fill all the required fields</p>";
                }
            }
        ?>
        <?php
            $q = "SELECT cat_name, position FROM categories WHERE cat_id = {$cid}";
            $r = mysqli_query($dbc, $q);
                confirm_query($r, $q);
            if(mysqli_num_rows($r) == 1){
                list($category, $position) = mysqli_fetch_array($r, MYSQLI_NUM);
            }else{
                $message = "<p class='warning'>The category does not exits</p>";
            }
        ?>
        <?php
            if(isset($message)) echo $message;
        ?>
        <form method="post" action="" id="edit_cat">
            <fieldset>
                <legend>Edit Category</legend>
                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('category', $errors)){
                            echo "<p class='p-warning'>Enter Category</p>";
                        }
                    ?>
                    <label for="cat_name">Name <span class="required">*</span> </label>
                    <input type="type" value="<?php if(isset($category)) echo strip_tags($category); ?>" name="cat_name" id="cat_name" tabindex="1" />
                </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('position', $errors)){
                            echo "<p class='p-warning'>Select position</p>";
                        }
                    ?>
                    <label for="pos">Position <span class="required">*</span> </label>
                    <select name="pos" tabindex="2">
                        <option>Select a position</option>
                        <?php
                            $q = "SELECT COUNT(cat_id) AS count FROM categories";
                            $r = mysqli_query($dbc, $q);
                                confirm_query($r, $q);
                            if(mysqli_num_rows($r) > 0){
                                list($numb) = mysqli_fetch_array($r, MYSQLI_NUM);
                                for($i = 1; $i <= $numb + 1; $i++){
                                    echo "<option value='{$i}'";
                                        if(isset($position) && $position == $i) echo "selected='selected'";
                                    echo ">" . $i . "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>

                <p class="button">
                    <input type="submit" name="submit" value="Edit Category" />
                </p>
            </fieldset>
        </form>
    </div><!-- end .content -->
</div><!-- end .main-content -->
<?php
    include ('include/footer.php');
?>
