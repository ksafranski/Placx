<?php

    require_once('../config.php');
    checkAuth();
    
    // Remove Node
    unset($data->nodes[$_GET['id']]);
    
    // Save output to JSON    
    $output = json_encode($data->nodes);
    $ofile = fopen($file->nodes,'w+');
    fwrite($ofile, $output);
    fclose($ofile);
    
    // Remove Notes
    unset($data->notes[$_GET['id']]);
    
    // Save output to JSON    
    $output = json_encode($data->notes);
    $ofile = fopen($file->notes,'w+');
    fwrite($ofile, $output);
    fclose($ofile);
    
?>