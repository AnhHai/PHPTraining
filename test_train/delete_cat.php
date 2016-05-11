<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
?>
<?php
    if(isset($_POST['cat_id']) && filter_var($_POST['cat_id'], FILTER_VALIDATE_INT)){
        $cid = $_POST['cat_id'];
        $q = "DELETE FROM categories WHERE cat_id = $cid LIMIT 1";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
    }
?>
