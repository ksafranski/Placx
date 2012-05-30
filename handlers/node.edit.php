<?php

    require_once('../config.php');
    checkAuth();
    
    $id = $_GET['id'];
    
    $title = "";
    $color = "white";
    if(!empty($_GET['col'])){ $column = $_GET['col']; }
    $notes = "";
    
    if($id!="new"){
        $title = stripslashes($data->nodes[$id]['title']);
        $color = $data->nodes[$id]['color'];
        $column = $data->nodes[$id]['column'];
        // Notes?
        if($data->notes!=""){
            if(array_key_exists($id,$data->notes)){
                $notes = stripslashes($data->notes[$id]);
            }
        }
    }

?>
<input type="hidden" name="ID" value="<?php echo($id); ?>" />

<label>Title</label>
<input type="text" name="Title" value="<?php echo(stripslashes($title)); ?>" autofocus="autofocus" />

<label>Color</label>

<ul id="color_selector">
    <?php
    
    $colors = array("white","green","blue","yellow","orange","red","purple");
    
    foreach($colors as $c){
        if($color==$c){
            echo("<li rel=\"$c\" class=\"$c selected\"><a></a></li>");
        }else{
            echo("<li rel=\"$c\" class=\"$c\"><a></a></li>");
        }
    }
    
    ?>
</ul>

<label>Notes</label>
<textarea class="node_notes" name="Notes"><?php echo($notes); ?></textarea>

<input type="hidden" name="Color" value="<?php echo($color); ?>" />
<input type="hidden" name="Column" value="<?php echo($column); ?>" />

<button onclick="node.save();">Save</button>
<?php if($id!="new"){ ?><button onclick="$('#confirm_del').show(); $(this).hide();">Delete</button><?php } ?>
<button id="confirm_del" class="hide" onclick="node.delete();">Confirm Delete?</button>
<button onclick="modal.unload();">Close</button>

<script>
    $(function(){
        
        // Set focus
        $('input[name="Title"]').focus();
        
        // Textarea grow/shrink
        $('textarea[name="Notes"]')
            .focus(function(){ $(this).animate({ 'height':'300px' },300)})
            .blur(function(){ $(this).delay(200).animate({ 'height':'100px' },300)});
                                   
        // Color Selector
        $('#color_selector li a').each(function(){
            $(this).click(function(){
                $('li.selected').removeClass('selected');
                $(this).parent('li').addClass('selected');
                $('input[name="Color"]').val($(this).parent('li').attr('rel'));
            });
        });
    });
</script>