<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
    include ('include/header.php');
    include ('include/sidebar.php');
    is_login();
?>
    <div class="content">
        <h3>Manage Users</h3>
        <table>
            <thead>
                <tr>
                    <th><a href="manage_users.php?sort=fn">First Name</a></th>
                    <th><a href="manage_users.php?sort=ln">Last Name</a></th>
                    <th><a href="manage_users.php?sort=e">Email</a></th>
                    <th><a href="manage_users.php?sort=level">User Level</a></th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //kiem tra sort
                    $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'fn';
                    //sap xep du lieu
                    $order_by = sort_users($sort);
                    //truy van du lieu
                    $users = fetch_user($order_by);
                    foreach($users as $user){
                        echo "
                            <tr>
                                <td>" . $user['first_name'] . "</td>
                                <td>" . $user['last_name'] . "</td>
                                <td>" . $user['email'] . "</td>
                                <td>" . $user['user_level'] . "</td>
                                <td><a href='edit_user.php?uid=".urlencode($user['user_id'])."'>Edit</a></td>
                                <td><a class='delete' id='{$user['user_id']}'>Delete</a></td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div><!-- end .content -->
</div><!-- end .main-content -->
<?php
    include ('include/footer.php');
?>
