$(document).ready(function(){
    
    $(".task").livequery(function(){
        $(this).draggable({
            handle:".title",
            cursor:"move",
            revert: "invalid"
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
                $column = $(this);
                $id_status = $column.attr("id_status");
                
                $.ajax({
                    url: "http://127.0.0.1/scrum4free/public/scrum/index/ajax-change-status",
                    type: "POST",
                    data: {id_task : $element.attr("id_task"), id_status : $id_status},
                    success: function(data){
                        
                        if(data.response == "ok"){
                            $element.fadeOut(function(){
                                $element.appendTo($column)
                                .css({"top":"0","left":"0"})
                                .fadeIn();
                            });
                        }else{
//                            alert("a");
                        }
                    }
                });
            }
        });
    });
    
    /**
     * Click on add
     */
    
    $("input.addTask").click(function(){
        $(this).fadeOut();
        $(".taskAdding").fadeIn();
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
    
    $(".taskAdding input[type='submit']").click(function(){
        
        $taskAdding = $(this).parents(".taskAdding");
        
        $title = $taskAdding.find("input[name='title']");
        $time = $taskAdding.find("input[name='time']");
        $description = $taskAdding.find("textarea[name='description']");
        $actors = $taskAdding.find("input[name='actors']");
        
        $.ajax({
                url: "http://127.0.0.1/scrum4free/public/scrum/index/ajax-add-task",
                type: "POST",
                data: {
                    "title" : $title.val(),
                    "time" : $time.val(),
                    "description" : $description.val(),
                    "actors" : $actors.val()
                },
                success: function(data){
                    if(data.response == 'ok'){
                        $taskAdding.fadeOut("fast", function(){
                            addTaskToWaitColumn("",$title.val(),$time.val(),$description.val(),$actors.val());
                            $title.val("");$time.val("");$description.val("");$actors.val("");
                            $("input.addTask").fadeIn();
                        });
                    }
                }
            });
        
        return false;
    });
    
    /**
     * Delete task
     */
    
    $(".task .actions .delete").livequery(function(){
        $(this).click(function(){
            $idTask = $(this).attr("idTask");
            $task = $(this).parents(".task");
            $.ajax({
                url: "http://127.0.0.1/scrum4free/public/scrum/index/ajax-remove-task",
                type: "POST",
                data: {
                    "id_task" : $idTask
                },
                success: function(data){
                    if(data.response == 'ok'){
                        $task.fadeOut();
                    }
                }
            });
            return false;
        });
    });
    
});

function addTaskToWaitColumn($taskId, $title, $time, $description, $actors){
    
    $content = '<div class="task">'
        + '<div class="title"><span class="taskId">'+$taskId+'.</span>'+$title+'<span class="timeAmount">'+$time+'</span></div>'
        + '<div class="description">'+$description+'</div>'
        + '<div class="actors">'+$actors+'</div>'
        + '<div class="actions"></div>'
        + '</div>';
    
    $(".column:first").append($content);
}