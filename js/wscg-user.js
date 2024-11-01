/**
 */
jQuery(document).ready(function(){
    //////////////// responsive /////////////////////
    if(jQuery('.card_game_panel_small').width()<270)
    {
        jQuery('.card_game_panel_small').css({'padding-top':'58px','height':'300px','text-align':'left'});
        jQuery('.wscg_player_panel_small').css({'width':'40%','display':'block','margin-top':'0px','margin-left':'15px'});
        jQuery('.wscg_dealer_panel_small').css({'width':'40%','margin-top':'0px','margin-left':'15px'});
        jQuery('.wscg_control_panel_small').css({'width':'44%','display':'inline-block'});
    }
    ////////////////////////////////////////////////


   var ajaxurl=ajax_object.ajax_url;
    var win_message=message_object.image_url+'/winner.png';
    var lose_message=message_object.image_url+'/lose.png';
    var again_message=message_object.image_url+'/hit.png';
    var init=0;
    var obj = document.createElement("audio");
    obj.src=message_object.image_url+'/beach.mp3';
    obj.volume=0.20;
    obj.autoPlay=false;
    obj.preLoad=true;
    obj.loop=true;

    jQuery('#wscg_start_game').on('click',function(){
        if(init==0){
            obj.play();
            init++;
        }

       jQuery.ajax({
           type:"post",

           url:ajaxurl,
           data:{action:"wscg_get_card_random",wscg_start:'1'},
           success:function(response){
               var cards=jQuery.parseJSON(response);
               jQuery("#wscg_player_image").attr('src',cards.player['image']);
               jQuery("#wscg_player_link").attr('href',cards.player['link']);
               jQuery("#wscg_dealer_image").attr('src',cards.dealer['image']);
               jQuery("#wscg_dealer_link").attr('href',cards.dealer['link']);
               if(cards.player['index']>cards.dealer['index'])
               {
                   jQuery("#wscg_result_message").attr('src',win_message);


               }
               else if(cards.player['index']<cards.dealer['index'])
               {
                   jQuery("#wscg_result_message").attr('src',lose_message);
               }
               else
               {
                   jQuery("#wscg_result_message").attr('src',again_message);
               }
               jQuery("#wscg_result_message").hide('fast');
               jQuery("#wscg_result_message").show('slow');


           }
       })
    });

    jQuery('#wscg_start_game_small').on('click',function(){
        if(init==0){
            obj.play();
            init++;
        }
        jQuery.ajax({
            type:"post",

            url:ajaxurl,
            data:{action:"wscg_get_card_random_small",wscg_start:'1'},
            success:function(response){
                var cards=jQuery.parseJSON(response);
                jQuery("#wscg_player_image_small").attr('src',cards.player['image']);
                jQuery("#wscg_player_link_small").attr('href',cards.player['link']);
                jQuery("#wscg_dealer_image_small").attr('src',cards.dealer['image']);
                jQuery("#wscg_dealer_link_small").attr('href',cards.dealer['link']);
                if(cards.player['index']>cards.dealer['index'])
                {
                    jQuery("#wscg_result_message_small").attr('src',win_message);


                }
                else if(cards.player['index']<cards.dealer['index'])
                {
                    jQuery("#wscg_result_message_small").attr('src',lose_message);
                }
                else
                {
                    jQuery("#wscg_result_message_small").attr('src',again_message);
                }
                jQuery("#wscg_result_message_small").hide('fast');
                jQuery("#wscg_result_message_small").show('slow');
            }
        })
    });
    jQuery('#wscg_player_link_small').on('click',function(event){
        event.preventDefault();
        var link=jQuery(this).attr('href');
        window.open(link);
    });
    jQuery('#wscg_dealer_link_small').on('click',function(event){
        event.preventDefault();
        var link=jQuery(this).attr('href');
        window.open(link);
    });
    jQuery('#wscg_player_link').on('click',function(event){
        event.preventDefault();
        var link=jQuery(this).attr('href');
        window.open(link);
    });
    jQuery('#wscg_dealer_link').on('click',function(event){
        event.preventDefault();
        var link=jQuery(this).attr('href');
        window.open(link);
    });



});