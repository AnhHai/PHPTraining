<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
    include ('include/header.php');
    include ('include/sidebar.php');
    is_login();
?>
    <div class="content">
        <h3>Add Pages</h3>
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $errors = array();
                $trimmed = array_map('trim', $_POST);

                if(empty($_POST['page_name'])){
                    $errors[] = 'page_name';
                }else{
                    $name = mysqli_real_escape_string($dbc, strip_tags($trimmed['page_name']));
                }

                if(filter_var($trimmed['cat'], FILTER_VALIDATE_INT, array('min_range' => 1))){
                    $cat = $trimmed['cat'];
                }else{
                    $errors[] = 'category';
                }

                if(filter_var($trimmed['pos'], FILTER_VALIDATE_INT, array('min_range' => 1))){
                    $pos = $trimmed['pos'];
                }else{
                    $errors[] = 'position';
                }

                if(empty($_POST['content'])){
                    $errors[] = 'content';
                }else{
                    $content = $trimmed['content'];
                }

                if(empty($errors)){
                    $mysqli = new mysqli('localhost', 'root', 'haibui93', 'blog');
                    check_data_conn();

                    $q = "INSERT INTO pages(user_id, cat_id, page_name, content, position, post_on) values(?, ?, ?, ?, ?, NOW())";
                    if($stmt = $mysqli->prepare($q)){
                        $stmt->bind_param('iissi', $_SESSION['uid'], $cat, $name, $content, $pos);
                        $stmt->execute() or die ("MySQL Error: {$q} " . mysqli_stmt_error());
                        if($stmt->affected_rows == 1){
                            $message = "<p class='success'>Insert Page success!</p>";
                        }else{
                            $message = "<p class='warning'>Page was not insert!</p>";
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
        <form method="post" action="" id="page">
            <fieldset>
                <legend>Add Pages</legend>
                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('page_name', $errors)){
                            echo "<p class='p-warning'>Enter page name!</p>";
                        }
                    ?>
                    <label for="page_name">Name <span class="required">*</span></label>
                    <input type="text" value="<?php if(isset($_POST['page_name'])) echo strip_tags($_POST['page_name']); ?>" name="page_name" id="page_name" tabindex="1" />
                </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('category', $errors)){
                            echo "<p class='p-warning'>Select Category!</p>";
                        }
                    ?>
                    <label for="cat">Category <span class="required">*</span> </label>
                    <select name="cat" tabindex="2">
                        <option>Select a category</option>
                        <?php
                            $query = "SELECT cat_id, cat_name FROM categories ORDER BY position ASC";
                            $r = mysqli_query($dbc, $query);
                                confirm_query($r, $query);
                            if(mysqli_num_rows($r) > 0){
                                while($cat = mysqli_fetch_array($r, MYSQLI_NUM)){
                                    echo "<option value='{$cat[0]}'";
                                        if(isset($_POST['cat']) && $_POST['cat'] == $cat[0]) echo "selected='selected'";
                                    echo ">" . $cat[1] . "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('position', $errors)){
                            echo "<p class='p-warning'>Select Position!</p>";
                        }
                    ?>
                    <label for="pos">Position <span class="required">*</span> </label>
                    <select name="pos" tabindex="3">
                        <option>Select a position.</option>
                        <?php
                            $query = "SELECT COUNT(page_id) AS count FROM pages";
                            $r = mysqli_query($dbc, $query);
                                confirm_query($r, $query);
                            if(mysqli_num_rows($r) > 0){
                                list($numb) = mysqli_fetch_array($r, MYSQLI_NUM);
                                for($i = 1; $i <= $numb + 1; $i++){
                                    echo "<option value='{$i}'";
                                        if(isset($_POST['pos']) && $_POST['pos'] == $i) echo "selected='selected'";
                                    echo ">" . $i . "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>

                <div class="row-field">
                    <?php
                        if(isset($errors) && in_array('content', $errors)){
                            echo "<p class='p-warning'>Enter content page!</p>";
                        }
                    ?>
                    <label class="box-ct" for="content">Content <span class="required">*</span> </label>
                    <textarea name="content" id="content" tabindex="4"></textarea>
                    <script type="text/javascript">CKEDITOR.replace('content'); </script>
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
