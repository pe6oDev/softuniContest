/**
 * Created by pepo on 6/23/18.
 */
/**
 * Created by nikola on 10/30/17.
 */

/**
 * Сменя месеците във calendar.blade.php
 *
 * @param $button бутона, който е кликнат
 * @param $forwardOrBackwards:int|string  1||-1||backwards||forward   дали да покаже следващия или предишния месец
 */

function changeMonths($button,$forwardOrBackwards){
    clickedId=$button.parent().attr('data-month');
    $('.monthName').hide();
    $('.month').hide();
    if($forwardOrBackwards==-1 || $forwardOrBackwards=="backwards" ){
        $('#monthName'+(clickedId-1)).show();
        $('#month'+(clickedId-1)).show();
        console.log('#monthName'+(clickedId-1))
    }
    else if($forwardOrBackwards==1 || $forwardOrBackwards=="forward"){
        $('#monthName'+(Number(clickedId)+1)).show();
        $('#month'+(Number(clickedId)+1)).show();
        console.log(clickedId);
    }
}


$(document).ready(function(){
    $('.toPreviousMonth').click(function(){
        changeMonths($(this),-1)
    });

    $('.toNextMonth').click(function(){
        changeMonths($(this),1)
    });
});
