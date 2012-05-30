<?php

    require_once('../config.php');
    checkAuth();
    
    // Get Data
    $id = $_POST['id'];
    $notes = $_POST['notes'];
    
    // Save
    $data->notes[$id] = $notes;
    
    // Save output to JSON    
    $output = json_encode($data->notes);
    $file = fopen($file->notes,'w+');
    fwrite($file, $output);
    fclose($file);

?>