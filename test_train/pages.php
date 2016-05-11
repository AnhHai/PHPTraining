<?php
    require_once ('include/mysqli_connect.php');
    require_once ('include/function.php');
    include ('include/header.php');
    include ('include/sidebar.php');
is_login();
?>
    <div class="content view-content">
        <h3>View Pages</h3>
        <table>
            <thead>
                <tr>
                    <th><a href="pages.php?sort=page">Page Name</a></th>
                    <th><a href="pages.php?sort=cont">Content</a></th>
                    <th><a href="pages.php?sort=by">Posted By</a></th>
                    <th><a href="pages.php?sort=on">Post On</a></th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //kiem tra sort
                    $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'on';
                    //sap xep du lieu hien thi theo sort
                    $order_by = sort_pages($sort);
                    //truy van du lieu
                    $pages = fetch_pages($order_by);
                    foreach ($pages as $page) {
                        echo "
                            <tr>
                                <td>" . $page['page_name'] . "</td>
                                <td>" . the_excerpt($page['content'], 400) . "</td>
                                <td>" . $page['name'] . "</td>
                                <td>" . $page['date'] . "</td>
                                <td><a href='edit_page.php?pid=". urlencode($page['page_id']) ."'>Edit</a></td>
                                <td><a class='delete' id='{$page['page_id']}'>Delete</a></td>
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
