<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
?>
<?php
    if(isset($_POST['page_id']) && filter_var($_POST['page_id'], FILTER_VALIDATE_INT)){
        $pid = $_POST['page_id'];
        $q = "DELETE FROM pages WHERE page_id = $pid LIMIT 1";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
    }
?>