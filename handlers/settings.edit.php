<?php

    require_once('../config.php');
    checkAuth();
    
?>
<label>Columns</label>
<ul id="column_editor">
<?php

    $o = "";
    $max_id = 0;

    foreach($data->columns as $id=>$title){
        
        $o .= "<li id=\"$id\">";
        $o .= "<table width=\"100%\"><tr><td class=\"title_field\">";
        $o .= "<input type=\"text\" id=\"title_$id\" value=\"" . stripslashes($title) . "\" />";
        $o .= "</td><td>";
        $o .= "<a class=\"col_move\"></a>";
        $o .= "</td><td>";
        $o .= "<a rel=\"$id\" class=\"col_delete\"></a>";
        $o .= "</td></tr></table></li>";
        
        if($id>$max_id){ $max_id = $id; }
        
    }
    
    echo($o);
    echo("<input type=\"hidden\" id=\"max_id\" value=\"$max_id\" />");

?>
</ul>
<button id="btn_password">Password</button>
<button onclick="settings.save_columns();">Save</button>
<button onclick="addCol();">Add Column</button>
<button onclick="modal.unload();">Close</button>

<div id="set_password">
    <label>System Password</label>
    <table width="100%">
        <tr>
            <td><input type="password" name="pass1" /></td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="password" name="pass2" /></td>
        </tr>
    </table>
    <button onclick="settings.save_password();">Save Password</button>
    <button id="btn_pass_cancel">Cancel</button>
</div>

<script>

    $(function(){
    
        max_id = $('#max_id').val();
    
        // Delete Column
        $('.col_delete').live('click',function(){
            var id = $(this).attr('rel');
            $('li#'+id).fadeOut(300,function(){ $(this).remove(); });
        });
        
        // Password
        $('#btn_password').click(function(){ $('#set_password').slideDown(300); $('input[name="pass1"]').focus(); $(this).hide(); });
        $('#btn_pass_cancel').click(function(){ $('#set_password').slideUp(300); $('#btn_password').show(); });
        
    
    });
    
    // Add Column
    function addCol(){
        max_id++;
        var new_col = "";
        new_col += '<li id="'+max_id+'"><table width="100%"><tr>';
        new_col += '<td class="title_field"><input type="text" id="title_'+max_id+'" value="NEW COLUMN" />';
        new_col += '</td><td><a class="col_move"></a></td><td><a rel="'+max_id+'" class="col_delete"></a></td></tr></table></li>';
        $('#column_editor').append(new_col);
    }

</script>