<div id="main-content">
    <div class="sidebar">
        <ul class="sb-menu">
            <?php
                if(isset($_SESSION['user_level'])){
                    switch($_SESSION['user_level']){
                        case 1:
                            echo "
                                <li><a href='categories.php'>View Categories</a></li>
                                <li><a href='add_category.php'>Add Categories</a></li>
                                <li><a href='pages.php'>View Pages</a></li>
                                <li><a href='add_page.php'>Add Pages</a></li>
                            ";
                            break;

                        case 2:
                            echo "
                                <li><a href='categories.php'>View Categories</a></li>
                                <li><a href='add_category.php'>Add Categories</a></li>
                                <li><a href='pages.php'>View Pages</a></li>
                                <li><a href='add_page.php'>Add Pages</a></li>
                                <li><a href='manage_users.php'>Manager Users</a></li>
                            ";
                            break;

                        default:
                            echo "<li>" . (isset($_SESSION['name'])) ? $_SESSION['name'] : "Please Login!";
                            echo "</li>";
                            break;
                    }

                }
            ?>

        </ul>
    </div><!-- end .sidebar -->
