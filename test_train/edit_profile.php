<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
    include ('include/header.php');
    include ('include/sidebar.php');
    is_login();
?>
    <div class="content">
        <h3>Edit Profile</h3>
        <form method="post" action="" id="avatar">
            <fieldset>
                <legend>Avatar</legend>
                <p>Cai coin card!</p>
            </fieldset>
        </form>
    </div><!-- end .content -->
</div><!-- end .main-content -->
<?php
    include ('include/footer.php');
?>
