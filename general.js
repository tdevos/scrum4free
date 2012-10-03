$(document).ready(function(){
    $(".task").draggable({
        handle:".title",
        cursor:"move",
        revert: 'invalid' 
    });
    $(".column").droppable({
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