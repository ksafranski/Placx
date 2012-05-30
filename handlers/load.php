<?php

    require_once('../config.php');
    checkAuth();
    
    $o = "";
    
    foreach($data->columns as $c_key=>$c_name){
    
        // Begin Column
        $o .= "<div data-col-id=\"$c_key\" class=\"col\">";
        $o .= "<div class=\"col_title\" title=\"" . stripslashes($c_name) . "\">" . shortenString(stripslashes($c_name),18) . "<a onclick=\"modal.load('node.edit.php?id=new&col=$c_key');\"></a></div>";
        
        // Loop Placx
        $o .= "<ul>";
        if(!empty($data->nodes)){
            foreach($data->nodes as $n_key=>$n_data){
                if($n_data['column']==$c_key && $n_key!="undefined"){
                    $o .= "<li><a data-node-id=\"$n_key\" class=\"" . $n_data['color'] . "\" title=\"" . stripslashes($n_data['title']) . "\"><div></div>" . shortenString(stripslashes($n_data['title']),25) . "</a></li>";
                }
            }
        }
        $o .= "</ul>";
        
        // End Column
        $o .= "</div>";
        
    }
    
    // Output
    echo($o);
    
?>