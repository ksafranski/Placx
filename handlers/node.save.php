<?php

    require_once('../config.php');
    checkAuth();
    
    // Get fields
    $id = $_POST['id'];
    $title = $_POST['title'];
    $color = $_POST['color'];
    $column = $_POST['column'];
    
    // Get new ID
    if($id=="new"){ 
        $id = 0;
        foreach($data->nodes as $n=>$d){ if($n>$id){ $id = $n; } }
        $id++;
    }
    
    // Edit node
    $data->nodes[$id] = array(
        "title" => $title,
        "color" => $color,
        "column" => $column
    );
    
    // Save output to JSON    
    $output = json_encode($data->nodes);
    $file = fopen($file->nodes,'w+');
    fwrite($file, $output);
    fclose($file);
       
    // Echo/Return ID
    echo($id);
    
?>