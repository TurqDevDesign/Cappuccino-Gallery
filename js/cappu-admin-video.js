jQuery(function($){

    // Set all variables to be used in scope
    var metaBox         = $('#cappu-gallery-video-attach-video.postbox'), // Meta box id
        vidLink         = metaBox.find( '.option-value #vid_link'),
        vidContainer    = metaBox.find( '#video_holder'),
        hiddenEmbedVal  = metaBox.find( '#gallery_embed_id' ),
        loadedEmbedVal  = hiddenEmbedVal.val(),
        newEmbedVal     = '',
        youtubeURLRegex = /^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/(watch\?v=)?(embed\/)?([\w\-]{11})(?!\w|\-)$/;
        //The above is to match most youtube URL variations

    function htmlEscape(str) {
    return str
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
    }

    vidLink.keyup(function(){
        if(vidLink.val()){
            if(youtubeURLRegex.test(vidLink.val())){
                var matches = youtubeURLRegex.exec(vidLink.val());
                newEmbedVal = "<iframe width='302' height='170' src='https://www.youtube.com/embed/" + matches[matches.length-1] + "?rel=0&showinfo=0' frameborder='0' allowfullscreen></iframe>";
                vidContainer.html(newEmbedVal);
                vidContainer.removeClass('no-video');
                hiddenEmbedVal.attr('value', htmlEscape(newEmbedVal));

            } else {
                hiddenEmbedVal.attr('value', loadedEmbedVal);
                vidContainer.addClass('no-video');
                vidContainer.html('Invalid URL');
            }
        } else{
            hiddenEmbedVal.attr('value', loadedEmbedVal);
            vidContainer.addClass('no-video');
            vidContainer.html('No URL');
        }
    });

});
