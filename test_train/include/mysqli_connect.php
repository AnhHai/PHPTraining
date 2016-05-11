<?php
    $dbc = mysqli_connect('localhost', 'root', 'haibui93', 'blog');

    if(!$dbc){
        trigger_error("Could not connect database: " . mysqli_connect_error());
    }else{
        mysqli_set_charset($dbc, 'utf-8');
    }