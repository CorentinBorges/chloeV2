var val1=null;
var val3=null



$(document).ready(function() {

    $('.ord').on('click', function(e) {
        e.preventDefault();
        if (val1 == null) {
            val1=$(this)
            console.log(val1.next().attr('name'))
        }
        else{
            val2SRC= $(this).attr('src');
            val2ID= $(this).attr('id');

            $(this).attr('id',val1.attr('id'));
            $(this).attr('src',val1.attr('src'));
            $(this).next().attr('name',val1.attr('id'));
            val1.attr('id', val2ID);
            val1.attr('src', val2SRC);
            val1.next().attr('name',val2ID);

            val1 = null;

        }
    });
});

