
$(document).ready(function () {
    //за сменящия се текст
    d = 800; //продължителноста на анимацията
    $('#header2').transition('hide');
    $('#header3').transition('hide');
    $('#header4').transition('hide');

    setTimeout(function () {

        $('#header1').transition({
            animation: 'fly down',
            duration: d,
            onComplete: function () {
                transmision(2)
            }
        })
    }, 2000);
});

/**
 * безкраен цикъл за завъртане на header-ите
 * @param i:int header-a, с който да почне
 */
function transmision(i) {
    if (i <= 4) {
        $('#header' + i).transition({
            animation: 'fly down',
            duration: d,
            onComplete: function () {
                if (i <= 3) {
                    setTimeout(function () {
                        $('#header' + i).transition({
                            animation: 'fly down',
                            duration: d,
                            onComplete: function () {
                                transmision(i + 1)
                            }
                        })
                    }, 2000)
                }
            }
        })
    }
}
