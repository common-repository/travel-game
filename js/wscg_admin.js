/**
 *
 */
jQuery(document).ready(function(){
    var ajaxurl=ajax_object.ajax_url;
    jQuery('#wscg_notice_support_close').click(function(event)
    {
        var data={
            action:'wscg_set_support_time',
            set_time_check:'1'
        };
        jQuery.post(ajaxurl,data,function(respond){
            jQuery("#wscg_notice_support_view").hide();
        });
        return false;
    });
    jQuery( '#wscg_notice_support_click' ).click( function (event) {
        if(document.getElementById('check_author_linking'))
        {
            document.getElementById('check_author_linking').checked = true;
        }



        var data = {

            action:'wscg_set_support_link'


        };



        jQuery.post(ajaxurl, data, function(respond) {

            jQuery("#wscg_support_title_1").hide();

            jQuery("#wscg_support_title_2").show();

            jQuery("#wscg_support_title_3").hide();

        });



    } );
    jQuery('#check_author_linking').on('click',function(){
        var state = jQuery('#check_author_linking').attr('checked') ? '1' : '0';
        var data={
            action:'wscg_set_support_link_check',
            state :state
        };
        jQuery.post(ajax_object.ajax_url,data,function(respond){
            if(jQuery('#check_author_linking').attr('checked'))
            {
                jQuery("#wscg_support_title_1").hide();

                jQuery("#wscg_support_title_2").show();

                jQuery("#wscg_support_title_3").hide();
            }
            else
            {
                jQuery("#wscg_support_title_1").show();

                jQuery("#wscg_support_title_2").hide();

                jQuery("#wscg_support_title_3").show();
            }
        })
    });

})

