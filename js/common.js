pause_update = false;

//////////////////////////////////////////////////////////////////////
// ONLOAD FUNCTIONS
//////////////////////////////////////////////////////////////////////

$(function(){
    placx.load();
    // Updater
    setInterval(function(){ placx.load(); },10000);
});

//////////////////////////////////////////////////////////////////////
// HANDLERS
//////////////////////////////////////////////////////////////////////

main = $('#main');

var placx = {
    
    load : function(){
        if(pause_update==false){
            main.load('handlers/load.php',function(){
                placx.init();
            });
        }
    },
    
    init : function(){
        // Cal width for overflow
        var comp_w = $('.col').length * $('.col').outerWidth(true)+20;
        $('#main').css({ 'width' : comp_w+'px'});
        // Initialize sortable
        $('.col ul').each(function(){
            $(this).sortable({ 
               connectWith: '.col ul', 
               opacity: 0.6, 
               helper: 'clone',
               placeholder: 'col_placeholder', 
               forcePlaceholderSize: true,
               zIndex: 9999999,
               start: function(){ pause_update=true; },
               stop: function(event, ui) { 
                   placx.save_position();
                   $('.col ul li a div').hide();
                   pause_update = false;
               }
           }).disableSelection();
        });
        // Hover Edit Icon
        $('.col ul li a').each(function(){
            // Hide all
            $(this).children('div').hide();
            // Hover
            $(this).hover(function(){
                $(this).children('div').fadeIn(200);
            },function(){
                $(this).children('div').fadeOut(200)
            });
        });
        // Edit Icon Click
        $('.col ul li a div').each(function(){            
            $(this).click(function(){
                var id = $(this).parent('a').attr('data-node-id');
                modal.load('node.edit.php?id='+id);
            });
        });
        // Run positioner to remove orphans
        placx.save_position();
    },
   
    save_position : function(){
        // Create Position String
        var pos_string = "";
        $('.col ul').each(function(){
            var col = $(this).parent('.col').attr('data-col-id');
            $(this).children('li').each(function(){
                var node = $(this).children('a').attr('data-node-id');
                if(pos_string==""){
                    pos_string += col + '=>' + node;
                }else{
                    pos_string += "," + col + '=>' + node;
                }
            });
        });
        // Save Positioning
        $.post('handlers/node.position.php',{ pos_string : pos_string });
    }
    
}

var node = {

    save : function(){
        // Shorten title function
        function shorten(string){
            if(string.length > 25){
                return string.substring(0,25)+"&hellip;";
            }else{ return string; }
        } 
        // Get fields
        var ID = $('input[name="ID"]').val();
        var Title = $('input[name="Title"]').val();
        var Color = $('input[name="Color"]').val();
        var Column = $('input[name="Column"]').val();
        var Notes = $('textarea[name="Notes"]').val();
        var params = { id : ID, title : Title, color: Color, column : Column };
        if(Title==""){
            alert('You must provide a title!');
        }else{
            // Save node
            $.post('handlers/node.save.php',params,function(data){
                var Short_Title = shorten(Title);
                n_id = data;
                if(ID=="new"){
                    $('.col[data-col-id="'+Column+'"] ul').append('<li><a data-node-id="'+n_id+'" class="'+Color+'" title="'+Title+'"><div></div>'+Short_Title+'</a></li>');
                    placx.save_position();
                }else{
                    $('a[data-node-id="'+n_id+'"]').html('<div></div>'+Short_Title).attr('title',Title).attr('class',Color);
                }
                placx.init();
                modal.unload();
                // Save notes
                if(Notes!=""){ $.post('handlers/node.notes.php',{ id : n_id, notes : Notes }); }
            });
        }
        
    },
    
    delete : function(){
        var ID = $('input[name="ID"]').val();
        $.get('handlers/node.delete.php?id='+ID,function(){
            modal.unload();
            setTimeout(function(){
                $('a[data-node-id="'+ID+'"]').fadeOut(500,function(){ $(this).remove(); });
                placx.init();
            },300);
        });
    }
    
}

var settings = {

    load : function(){
        $('#overlay').fadeIn(300);
        $('#modal').load('handlers/settings.edit.php',function(){
            $(this).fadeIn(300);
            $('#column_editor').sortable({  
               opacity: 0.6, 
               helper: 'clone',
               handle: '.col_move',
               placeholder: 'col_mover_placeholder', 
               forcePlaceholderSize: true,
               zIndex: 9999999
            }).disableSelection();
         });
    },
    
    save_columns : function(){
        var len = $('#column_editor li').length;
        if(len==0){
            alert('You must have at least one column defined!');
        }else{
            var col_string = "";
            $('#column_editor li').each(function(){
                if(col_string!=""){ col_string += "[|]"; }
                var id = $(this).attr('id');
                col_string += id + "=>" + $('#title_'+id).val();
            });
            $.post('handlers/settings.save.php',{ columns: col_string },function(){
                // Reload
                placx.load();               
            });
            modal.unload();
        }
    },
    
    save_password : function(){       
        var p1 = $('input[name="pass1"]').val();
        var p2 = $('input[name="pass2"]').val();
        if(p1!=p2){ 
            alert('Passwords do not match!');
        }else{
            $.post('handlers/settings.save.php',{ password: p1 },function(){
                $('#set_password').slideUp(300);
                $('#btn_password').show().html('CHANGED!').delay(2000).html('Password');
                $('input[name="pass1"]').val('');
                $('input[name="pass2"]').val('');
            });
        }       
    }

}

var modal = {
    
    load : function(handler){
        $('#overlay').fadeIn(300);
        $('#modal').load('handlers/'+handler,function(){
            $(this).fadeIn(300);
        });   
    },
    
    unload : function(){
        $('#overlay,#modal').fadeOut(300,function(){
            $('#modal').html('');
        });
    }

}
