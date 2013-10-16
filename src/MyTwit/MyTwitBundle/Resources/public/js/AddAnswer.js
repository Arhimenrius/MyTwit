var token = '';
var content_length = '255';
jQuery(document).on('click', 'a.add_answer_form', function()
{    
    token = jQuery(this).parent().attr("id");
    jQuery(this).parent().append('<form><textarea id="Answer_Answer" name="Answer[Answer]" maxlength="255" cols="63" rows="3" onkeyup="answerContent()" ></textarea><br /><button class="sendAnswer" disabled="disabled">Dodaj</button><b class="length">255</b></form>');
    jQuery(this).remove();
});
function answerContent()
{
    content_length = 255 - jQuery('#'+token).children().children('#Answer_Answer').val().length;
    jQuery('#'+token).children().children('.length').text(content_length);
    
    if(content_length === 255 || content_length < 0)
    {
        jQuery('#'+token).children().children('.sendAnswer').attr('disabled', 'disabled');
    }
    else
    {
        jQuery('#'+token).children().children('.sendAnswer').removeAttr('disabled');
    }
    
    if(content_length < 0)
    {
        jQuery('#'+token).children().children('#Answer_Answer').css('border', '5px solid red');
        jQuery('#'+token).children().children('.length').text(jQuery('#'+token).children().children('.length').text() + " Maksymalna długość Tweeta to 255 znaków. Tweet nie zostanie dodany.");
    }
    else
    {
        jQuery('#'+token).children().children('#Answer_Answer').css('border', '1px solid black');
    }
}

jQuery(document).on('click', 'button.sendAnswer', function(e)
{    
    e.preventDefault();
    if(content_length >= 0)
    {
        token = jQuery(this).parent().parent().attr("id");
        var content = jQuery(this).parent().children('#Answer_Answer').val();
        var params = 
            {
                content: content, 
                token: token
            };
        jQuery.ajax
        ({
            url:'/app_dev.php/logged/home/addanswer',
            type:'POST',
            data: JSON.stringify(params),
            success: function(response){}
        });
        content_length = 255;
        jQuery('#'+token).children().children('#Answer_Answer').val('');
        jQuery('#'+token).children().children('.sendAnswer').attr('disabled', 'disabled');
        jQuery('#'+token).children().children('.length').text(content_length);
    }
});