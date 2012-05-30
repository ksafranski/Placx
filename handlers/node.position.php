<?php

    require_once('../config.php');
    checkAuth();
    
    // Get position string
    $pos_string = $_POST['pos_string'];
    
    // Explode nodes
    $arr_nodes = explode(",",$pos_string);
    
    // Rebuild
    $arr_output = array();
    foreach($arr_nodes as $node){
        $arr_node = explode("=>",$node);
        if($arr_node[1]!="undefined"){ // Cleanup
            $arr_output[$arr_node[1]] = array(
                "title" => $data->nodes[$arr_node[1]]['title'],
                "color" => $data->nodes[$arr_node[1]]['color'],
                "column" => $arr_node[0]
            );
        }
    }
    
    // Save output to JSON
    $output = json_encode($arr_output);
    $file = fopen($file->nodes,'w+');
    fwrite($file, $output);
    fclose($file);
    
?>