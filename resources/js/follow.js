$(function(){

    $('.follow-index').on('click',function(){

        console.log('aaa');
        
        let followee_id = $(this).data('followee_id');
        let follower_id = $(this).data('follower_id');
        let url = "/test/follow/"+$(this).data('followee_id')+"/"+$(this).data('follower_id')+"/follow";
        let $this = $(this);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: url,
            // data: {
            //     'followee_id':followee_id,
            //     'follower_id':follower_id,
            //     '_method':'DELETE'
            // }
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

        // $('.follow-profile').on('click',function(){
        
    //     let url = "/follow"+$(this).date('folllowee_id')+"/"+$(this).date('folllower_id')+"/unfollow";

    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         method: "POST",
    //         url: url,
    //         // data: {
    //         // },
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