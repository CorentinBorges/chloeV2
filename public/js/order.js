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





/*
$(document).ready(function() {
    $('.js-like-article').on('click', function(e) {
        e.preventDefault();//empêche le lien de s'activer

        var $link = $(e.currentTarget);//Agis comme un this, en gros ca reviens à .js-like-article
        $link.toggleClass('fa-heart-o').toggleClass('fa-heart');

        $.ajax({
            method: 'POST',
            url: $link.attr('href')//Le controller de ce lien ajoute 1 à l'attribut en mode POST
        }).done(function(data) {
            $('.js-like-article-count').html(data.hearts);//Une fois que c'est fait (done),
            // change le html de js-like-article-count par la donnée hearts qu'envoie le JSON
        })
    });
});
*/

/*imgChange=[];

$('.ord').each(function(){
    imgChange.push(this.id);
});
*/

/*$.each(imgChange, function(key, value) {
    $('#'+value).click(function(){

        if( $('.change').length )
        {
            let changeSrc=$('.change').attr('src');
            let id2=$('.change').attr('id');
            let id1=$(this).attr('id');
            let id3='temp1';
            let id4='temp2';

            $('.change').attr('src',$(this).attr('src'));
            $(this).attr('src',changeSrc);

            $('.'+id1).addClass(id3);
            $('.'+id2).addClass(id4);
            $('.'+id3).addClass(id2).removeClass(id1).removeClass(id3);
            $('.'+id4).addClass(id1).removeClass(id2).removeClass(id4);
            $('.'+id1).attr('name',id1);
            $('.'+id2).attr('name',id2);

            //$('.'+id2', .'+id1).removeClass(id2);
            //$('.'+changeId).attr('name',$('.'+changeId).attr('class'));

            $('.change').attr('id',$(this).attr('id'));
            $(this).attr('id',id2);
            $('.change').removeClass('change');
        }

        else
        {
            $(this).addClass('change');
        }
    })

});*/
