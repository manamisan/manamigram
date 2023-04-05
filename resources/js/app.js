import './bootstrap';
import jQuery from 'jquery';
window.$ = jQuery;

$(()=>{

    // preview media
    // $('#media').on({
    //     change:function(){
    //         console.log(event.target.files[0]);
    //         var file = event.target.files[0];
    //         var reader = new FileReader();
            
    //         if($('#previewMedia') != null){
    //             $('#previewMedia').remove();
    //         }

    //         reader.onload = function() {
    //             if(reader.result.match(/.*?\.mp4/i)){
    //                 createPreviewVideo(reader.result);
    //                 // console.log('aa');
    //             }else{
    //                 createPreviewImage(reader.result);
    //                 console.log(reader.result);
    //             }
                
    //         }
    
    //         reader.readAsDataURL(file);
    //     }
    // });

    $('#media').on('change', function(e) {

        if($('#previewMedia') != null){
            $('#previewMedia').remove();
        }
        // 1枚だけ表示する
        var file = e.target.files[0];

        console.log(file.name);

        // ファイルのブラウザ上でのURLを取得する
        var blobUrl = window.URL.createObjectURL(file);

        console.log(blobUrl);
        // img要素に表示
        if(file.name.match(/.*?\.mp4/i)){
            createPreviewVideo(blobUrl);
            console.log(file.name);
        }else{
            createPreviewImage(blobUrl);
            console.log(file.name);
        }
    });

    function createPreviewVideo(file_name)
    {
        $('#preview').append('<video id="previewMedia" controls autoplay><source type="video/mp4"></video>');
        $('#previewMedia').children('source').attr('src',file_name);
    }

    function createPreviewImage(file_name)
    {
        $('#preview').append('<img>');
        $('#preview').children('img').attr('id','previewMedia');
        $('#previewMedia').attr('src',file_name);
    }
    //end of truncate
});

// 

// document.getElementById('app').textContent = 'Hello Vite !';