<?php
    define('BASE_URL', 'http://localhost/haibui/test_train/');

    function redirect_to($page = 'index.php'){
        $url = BASE_URL . $page;
        header("Location: $url");
        exit();
    }

    function confirm_query($result, $query){
        global $dbc;
        if(!$result){
            die ("query {$query} \n <br /> Mysqli Error " . mysqli_error($dbc));
        }
    }

    //kiem tra ket noi
    function check_data_conn(){
        if(mysqli_connect_errno()){
            echo 'Connection fail: ' . mysqli_connect_error();
            exit();
        }
    }

    function is_login(){
        if(!isset($_SESSION['uid'])){
           redirect_to('login.php');
        }
    }
    //cat chuoi
    function the_excerpt($text, $num = 120){
        $san = htmlentities($text, ENT_COMPAT, 'UTF-8');
        $str_rep = str_replace(array("\r\n", "\n"), array("<p>", "</p>"), $san);
        if(strlen($str_rep) > 100){
            $cutStr = substr($str_rep, 0, $num);
            $word = substr($str_rep, 0, strrpos($cutStr, ' '));
            return $word;
        }else{
            return $str_rep;
        }
    }

//categories
    //sort categories
    function sort_cat($sort){
        switch($sort){
            case 'cat':
                $order_by = 'cat_name';
                break;

            case 'pos':
                $order_by = 'position';
                break;

            case 'by':
                $order_by = 'name';
                break;

            default:
                $order_by = 'position';
                break;
        }
        return $order_by;
    }
    //truy van categories
    function fetch_cat($order_by){
        global $dbc;

        $q = "SELECT c.cat_id, c.cat_name, c.position, c.user_id, CONCAT_WS(' ', u.first_name, u.last_name) AS name ";
        $q .= " FROM categories AS c ";
        $q .= " JOIN users AS u ";
        $q .= " USING (user_id) ";
        $q .= " ORDER BY {$order_by} ASC";

        $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);

        if(mysqli_num_rows($r) > 0){
            //tao mang de luu du lieu
            $cats = array();

            //hien thi du lieu
            while($result = mysqli_fetch_array($r, MYSQLI_ASSOC)){
                $cats[] = $result;
            }
            return $cats;
        }else{
            return FALSE;
        }
    }

//pages
    //sort pages
    function sort_pages($sort){
        switch($sort){
            case 'page':
                $order_by = 'page_name';
                break;

            case 'cont':
                $order_by = 'content';
                break;

            case 'by':
                $order_by = 'name';
                break;

            case 'on':
                $order_by = 'post_on';
                break;

            default:
                $order_by = 'post_on';
                break;
        }
        return $order_by;
    }
    //hien thi
    function fetch_pages($order_by){
        global $dbc;

        $q = "SELECT p.page_id, p.page_name, p.content, DATE_FORMAT(p.post_on, '%b %d %Y') AS date, CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
        $q .= " FROM pages AS p ";
        $q .= " JOIN users AS u ";
        $q .= " USING (user_id) ";
        $q .= " ORDER BY {$order_by} ASC";

        $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);

        if(mysqli_num_rows($r) > 0){
            //tao mang chua du lieu
            $pages = array();

            //hien thi du lieu
            while($result = mysqli_fetch_array($r, MYSQLI_ASSOC)){
                $pages[] = $result;
            }
            return $pages;
        }else{
            return FALSE;
        }
    }
//manage users
    //sort user
    function sort_users($sort){
        switch($sort){
            case 'fn':
                $order_by = 'first_name';
                break;

            case 'ln':
                $order_by = 'last_name';
                break;

            case 'e':
                $order_by = 'email';
                break;

            case 'level':
                $order_by = 'user_level';
                break;

            default:
                $order_by = 'first_name';
                break;
        }
        return $order_by;
    }
    //truy van user
    function fetch_user($order_by){
        global $dbc;

        $q = "SELECT * FROM users ORDER BY {$order_by}";
        $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);

        if(mysqli_num_rows($r) > 0){
            $users = array();

            //hien thi
            while($result = mysqli_fetch_array($r, MYSQLI_ASSOC)){
                $users[] = $result;
            }
            return $users;
        }else{
            return FALSE;
        }
    }

//send mail
    function send_mail($from, $to, $title, $body){
        global $mail;

        $mail = new PHPMailer();
        $mail->IsSMTP();
        //Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
        // 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
        // 1 = Thông báo lỗi ở client
        // 2 = Thông báo lỗi cả client và lỗi ở server
        $mail->SMTPDebug  = 0;
        $mail->Host = 'smtp.gmail.com';  // host smtp de gui mail
        $mail->SMTPAuth = true; // Xac thuc SMTP
        $mail->Username = 'haibui93@gmail.com'; // email
        $mail->Password = 'uogtclkvodwmcvyq';  // mat khau ung dung
        $mail->SMTPSecure = 'ssl'; // tls: cong 587, ssl: cong 465
        $mail->Port = 465; // cổng để gửi mail
        $mail->setFrom($from, 'Mailer');// thong tin nguoi gui
        $mail->addAddress($to);     //email nguoi nhan
        $mail->addReplyTo('haibui93@gmail.com');//mail khi nguoi nhan reply
        $mail->isHTML(true); // Set email format to HTML

        $mail->Subject = $title;
        $mail->Body    = $body;
        return $mail;
    }



























