<?php

    //////////////////////////////////////////////////////////////////
    // PASSWORD
    //////////////////////////////////////////////////////////////////
    
    $password = "welcome";    
    
    //////////////////////////////////////////////////////////////////
    // Session initialization
    //////////////////////////////////////////////////////////////////
    
    ini_set('session.gc_maxlifetime', 10800);
    session_start();
    
    //////////////////////////////////////////////////////////////////
    // Files
    //////////////////////////////////////////////////////////////////
    
    $file = new StdClass();
    $file->path     = str_replace("config.php","",dirname(__FILE__)) . "/data/";
    $file->columns  = $file->path."columns.php";
    $file->nodes    = $file->path."nodes.php";
    $file->notes    = $file->path."notes.php";
    $file->password = $file->path."password.php";
    
    //////////////////////////////////////////////////////////////////
    // Data
    //////////////////////////////////////////////////////////////////
    
    $data = new StdClass();        
    $data->columns  = json_decode(file_get_contents($file->columns),true);
    $data->nodes    = json_decode(file_get_contents($file->nodes),true);
    $data->notes    = json_decode(file_get_contents($file->notes),true);
    $data->password = file_get_contents($file->password);
    
    //////////////////////////////////////////////////////////////////
    // Common
    //////////////////////////////////////////////////////////////////
    
    function shortenString($val,$len){
        if(strlen($val) > $len){ return(rtrim(substr($val, 0, $len)) . "&hellip;"); }else{ return($val); }
    }
    
    function encPassword($p){ return sha1(md5($p)); }
    
    function checkAuth(){
        if(!isset($_SESSION['placx'])){ header('location: index.php'); exit(); }
    }
    
?>