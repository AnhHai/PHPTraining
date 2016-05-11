<?php
    require_once('include/mysqli_connect.php');
    require_once('include/function.php');
    include('include/header.php');
    include('include/sidebar.php');
is_login();
?>
    <div class="content view-content">
        <h3>View Categories</h3>
        <table>
            <thead>
                <tr>
                    <th><a href="categories.php?sort=cat">Category name</a></th>
                    <th><a href="categories.php?sort=pos">Position</a></th>
                    <th><a href="categories.php?sort=by">Posted By</a></th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //kiem tra sort
                    $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'pos';

                    //sort du lieu
                    $order_by = sort_cat($sort);

                    //lay thong tin de hien thi ra trinh duyet
                    $cats = fetch_cat($order_by);

                    //hien thi thong tin
                    foreach($cats as $cat){
                        echo "
                            <tr>
                                <td>" . $cat['cat_name'] .  "</td>
                                <td>" . $cat['position'] .  "</td>
                                <td>" . $cat['name'] .  "</td>
                                <td><a class='edit' href='edit_cat.php?cid=". urlencode($cat['cat_id']) ."'>Edit</a></td>
                                <td><a class='delete' id='{$cat['cat_id']}'>Delete</a></td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    include('include/footer.php');
?>
