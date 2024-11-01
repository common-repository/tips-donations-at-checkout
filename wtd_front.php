<?php 
if (!defined('ABSPATH')) {
    die;
}
?>
<script>
function guaven_wtd_addselector_options() {
    return '<?php echo wp_kses($opt,['option' => ['value' => [], 'title' => [] ] ]); ?>';
}

function guaven_wtd_addselector(selector) {
    gwdt_appended_from_scratch = 0;
    if (selector.html() == undefined) {
        jQuery(".order-total").before(
            '<tr class="fee gwtd_fee"><th><?php echo esc_attr(get_option('guaven_wtd_field_name'));?> </th><td></td></tr>'
            );
        selector = jQuery(".gwtd_fee");
        gwdt_appended_from_scratch = 1;
    }
    if (selector.html() != '' && selector.html() != undefined && selector.html().indexOf("guaven_wtd_tipselector") == -
        1 &&
        selector.children("th").html().indexOf('<?php echo esc_attr(get_option('guaven_wtd_field_name')); ?>') > -1) {
        selector.addClass("gwtd_fee");
        selector.children("td").append('<select class="guaven_wtd_tipselector" style="margin-left:15px;padding:5px">' +
            guaven_wtd_addselector_options() +
            '</select><div style="display:none;padding:10px 5px" class="guaven_wtd_custom_amount_div">' +
            '<input type="number" step="1" min="0" name="guaven_wtd_custom_amount" class="guaven_wtd_custom_amount">' +
            '<input class="guaven_wtd_custom_amount_button" type="button" ' +
            ' value="<?php echo  esc_attr(get_option('guaven_wtd_custom_amount_button'));?>"></div>');


        if (guaven_wtd_getcookie('gwtd_tip_amount') >= 0) {
            tval = guaven_wtd_getcookie('gwtd_tip_amount');
            if (jQuery(".guaven_wtd_tipselector option[value='" + tval + "']").length == 0) jQuery(
                ".guaven_wtd_tipselector").append('<option value="' +
                tval + '">' + tval + '<?php echo esc_attr($percentsign); ?></option>');
            jQuery(".guaven_wtd_tipselector").val(guaven_wtd_getcookie('gwtd_tip_amount'));
        } else if (guaven_wtd_getcookie('gwtd_tip_amount').indexOf("_other") > -1) {
            tval = guaven_wtd_getcookie('gwtd_tip_amount');
            jQuery('.guaven_wtd_tipselector [value="-1"]').val(tval);
            jQuery(".guaven_wtd_tipselector").val(tval);
        } else if (gwdt_appended_from_scratch == 1 && jQuery(".guaven_wtd_tipselector").val() > 0) {
            jQuery(".guaven_wtd_tipselector").trigger("change");
        }
    }
}

setTimeout(function() {
    jQuery(".fee").each(function() {
        guaven_wtd_addselector(jQuery(this));
    });
}, 500);


jQuery(document).on('change', '.guaven_wtd_tipselector', function() {
    if (jQuery(this).val() == -1) {
        jQuery(".guaven_wtd_custom_amount_div").show();
        return;
    }
    jQuery(".guaven_wtd_custom_amount_div").hide();
    document.cookie = "gwtd_tip_amount=" + jQuery(this).val() + ";path=/";
    jQuery(document.body).trigger("update_checkout");
});


jQuery(document).on('click', '.guaven_wtd_custom_amount_button', function() {
    tval = jQuery(".guaven_wtd_custom_amount").val();
    tval = parseFloat(tval);
    if (jQuery(".guaven_wtd_tipselector option[value='" + tval + "_other']").length == 0) {
        jQuery('.guaven_wtd_tipselector [value="-1"]').val(tval + "_other");
        jQuery(".guaven_wtd_tipselector").trigger("change");
    }
});
jQuery(document).ajaxComplete(function() {
    guaven_wtd_addselector(jQuery(".fee"));
});



window.guaven_wtd_getcookie = function(name) {
    match = document.cookie.match(new RegExp(name + '=([^;]+)'));
    if (match)
        return match[1];
}

jQuery(".gwtd_notice_buts").on("click", function() {
    jQuery(".gwtd_notice_buts").removeClass("gwtd_selected");
    jQuery(this).addClass("gwtd_selected");
    jQuery('.guaven_wtd_tipselector').val(jQuery(this).attr("id").replace("gwtd_notice_buts_", ""));
    jQuery('.guaven_wtd_tipselector').trigger("change");
});
</script>
<style>
.guaven_wtd_custom_amount_div:before {
    content: "<?php echo esc_attr(html_entity_decode(get_woocommerce_currency_symbol())) ;?>";
    position: absolute;
    margin: 5px 5px;
}

.guaven_wtd_custom_amount {
    padding-left: 15px;
    max-width: 70%
}

.guaven_wtd_custom_amount_button {
    margin-left: 3%;
    max-width: 25%;
    padding: 5px !important;
}

.gwtd_notice_buts {
    padding: 4px 10px
}

.gwtd_selected {
    background: gray;
    color: white
}
</style>