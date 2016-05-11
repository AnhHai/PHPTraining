<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
?>
<?php
    if(isset($_POST['user_id']) && filter_var($_POST['user_id'], FILTER_VALIDATE_INT)){
        $uid = $_POST['user_id'];
        $q = "DELETE FROM users WHERE user_id = $uid LIMIT 1";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
    }
?>