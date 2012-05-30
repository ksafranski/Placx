<?php

    require_once('../config.php');
    checkAuth();
    
    //////////////////////////////////////////////////////////////////
    // COLUMNS
    //////////////////////////////////////////////////////////////////
    
    if(!empty($_POST['columns'])){
    
        // Get columns string
        $columns = explode("[|]",$_POST['columns']);
        
        // Rebuild
        $arr_output = array();
        foreach($columns as $val){
            $vals = explode("=>",$val);
            $arr_output[$vals[0]] = $vals[1];
        }
        
        // Save output to JSON
        $output = json_encode($arr_output);
        $file = fopen($file->columns,'w+');
        fwrite($file, $output);
        fclose($file);
    
    }
    
    //////////////////////////////////////////////////////////////////
    // PASSWORD
    //////////////////////////////////////////////////////////////////
    
    if(!empty($_POST['password'])){
        $output = encPassword($_POST['password']);
        $file = fopen($file->password,'w+');
        fwrite($file, $output);
        fclose($file);    
    }

?>