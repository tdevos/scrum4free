$(document).ready(function(){
    
    $(".task").livequery(function(){
        $(this).draggable({
            handle:".title",
            cursor:"move",
            revert: 'invalid' 
        })
    });
    $(".column").livequery(function(){
        $(this).droppable({
            hoverClass: "columnHover",
            accept : function(dropElem){
                if(dropElem.parent().html() == $(this).html()){
                    return false;
                }
                return true;
            },
            drop : function(event, ui){
                $element = ui.draggable;
                var $column = $(this);
                $element.fadeOut(function(){
                    $element.appendTo($column)
                    .css({"top":"0","left":"0"})
                    .fadeIn();
                });
            }
        });
    });
    
    /**
     * Click on add
     */
    
    $("input.addTask").click(function(){
        $('<div class="task"></div>')
            .hide()
            .append("<div class='title'><input type='text' value='Title'></div>")
            .append("<div class='description'><textarea>Description</textarea></div>")
            .append("<input type='submit' class='btn btn-primary' value='Save'>")
            .appendTo(".column:first")
            .fadeIn()
            ;
        $(this).fadeOut();
    });
    
    /**
     * Empty fields
     */

    $(".title input, .description textarea").livequery(function(){
        var $value = $(this).val();
        $(this).focus(function(){
            if($(this).val() == $value){
                $(this).val("");
            }
        }).focusout(function(){
            if($(this).val() == ""){
                $(this).val($value);
            }
        });
    });
    
    /**
     * Click on save
     */
    
    $(".task input[type='submit']").livequery(function(){
        $(this).click(function(){
            
            addTaskToWaitColumn(1, "title", "description", "actors")
            
            $(this).parents(".column").children("input.addTask").fadeIn();
            
            $(this).parents(".task").remove();
            
        });
    });
    
    /**
     * Delete task
     */
    
    $(".task .actions .delete").livequery(function(){
        $(this).click(function(){
            $(this).parents(".task").fadeOut();
            return false;
        });
    });
    
});

function addTaskToWaitColumn($taskId, $title, $description, $actors){
    
    $content = '<div class="task">'
        + '<div class="title"><span class="taskId">'+$taskId+'.</span>'+$taskId+'</div>'
        + '<div class="description">'+$description+'</div>'
        + '<div class="actors">'+$actors+'</div>'
        + '<div class="actions"><a href="#" class="delete">Delete</a></div>'
        + '</div>';
    
    $(".column:first").append($content);
}