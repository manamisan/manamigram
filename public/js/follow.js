$(function(){

    $('.follow-index').on('click',function(){

        console.log('aaa');
        
        let followee_id = $(this).data('followee_id');
        let url = $(this).data('route');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: url,
            
        }).done(function(){

            let html = '<span class="w-100 text-dark" >Followed!</span>';

            console.log('bbb');

            let followed_span = $('.follow-'+followee_id);
            followed_span.after(html);
            followed_span.remove();
            console.log('bbb');


        }).fail(function(){
            alert('error dayo');
        }).always(function(){
            console.log('finished dayo');
        });
    });

    // $('#follow-profile').on('click',function(){
    
    //     let url = $(this).data('route');

    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         method: "POST",
    //         url: url,
    //         data: { '_method':'DELETE' },
    //     }).done(function(){
    //         if($(this).attr('class')=='fa-solid fa-regular-heart')
    //         $(this).toggleClass('liked')
    //     }).fail(function(){
    //         alert('error dayo');
    //     }).always(function(){
    //         console.log('finished dayo');
    //     });

    
    // });    

});