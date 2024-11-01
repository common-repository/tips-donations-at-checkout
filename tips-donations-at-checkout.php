<?php
/*
Plugin Name:       Tips & Donations at WooCommerce sCheckout
Plugin URI:        https://guaven.com/woo-tips-donation
Description:       Let Customers Add Tips & Donations on WooCommerce Checkout
Version:           1.0.0
Author:            Guaven Labs
Author URI:        https://guaven.com
Text Domain:       guaven_woo_tips
Domain Path:       /languages
*/

if (!defined('ABSPATH')) {
    die;
}

require_once(dirname(__FILE__)."/wtd_admin.php");
$guaven_didyoumean_admin=new Guaven_WTD_Admin();
add_shortcode('gdym_didyoumean', array($guaven_didyoumean_admin,'guaven_wtd_didyoumean'));
add_action('admin_menu', array($guaven_didyoumean_admin,'guaven_wtd_admin'));


add_action( 'woocommerce_cart_calculate_fees', 'guaven_wtd_checkout_fee' );
function guaven_wtd_checkout_fee() {
  
  if ( (!empty($_COOKIE["gwtd_tip_amount"]))  ){
    if (strpos($_COOKIE["gwtd_tip_amount"],"_other")!==false){

      $percentage_val=str_replace("_other","",sanitize_text_field($_COOKIE["gwtd_tip_amount"]));  

      $percentage_val=intval($percentage_val);

      //validation
      if(!$percentage_val)return;

      $percentage_text=' ('.strip_tags( wc_price($percentage_val)). //get_woocommerce_currency_symbol() .esc_attr($percentage_val).
      ')';
    }
    else {
      $tippercentage=intval(sanitize_text_field($_COOKIE["gwtd_tip_amount"]));

      //validation
      if ( ! $tippercentage ) return;

      if (get_option('guaven_wtd_type')=='numbers'){
        $percentage_val=$tippercentage;
        $percentage_text=' ('.strip_tags(wc_price($tippercentage)).')';
      }
      else {
        $percentage_val=ceil((float)WC()->cart->get_subtotal()*$tippercentage*0.01);
        $percentage_text=' ('.esc_attr($tippercentage).'%)';
      }
      
    }
    if ((int)$percentage_val<=0) return;
    WC()->cart->add_fee( get_option('guaven_wtd_field_name').$percentage_text, $percentage_val ); 
  }
}

function guaven_wtd_price($price,$format){
  if ($format=='%') return $price.$format;
  return wc_price($price);
}

add_action('wp_footer',function(){
    if (!is_checkout()) return;
    $tips=get_option('guaven_wtd_tip_options');
    if (empty($tips)) return;

    $tips_arr=explode(",",$tips);
    $opt='';
    $percentsign=get_option('guaven_wtd_type')=='numbers'?'':'%';

    foreach($tips_arr as $val){
      if (strpos($val,':default')!==false) {
        $default=' selected="selected"';
        $val_checked=str_replace(":default","",$val);
      }
      else {
        $default='';
        $val_checked=$val;
      }
      $val_checked=esc_attr($val_checked);

      $opt.='<option value="'.$val_checked.'" '.$default.'>'.guaven_wtd_price($val_checked,$percentsign).'</option>';
    }
    if (get_option('guaven_wtd_custom_amount')!=''){
      $opt.='<option value="-1">'.esc_attr(get_option('guaven_wtd_custom_amount_text')).'</option>';
    }
    require_once(dirname(__FILE__)."/wtd_front.php");
});

 
add_action( 'woocommerce_before_checkout_form', 'guaven_wtd_checkout_notice' );
function guaven_wtd_checkout_notice() {
  if (get_option('guaven_wtd_notice')=='')return;
  $already_added=WC()->cart->get_fees();
  if (!empty($_COOKIE["gwtd_tip_amount"]) and get_option('guaven_wtd_notice_hideafter')!='')return;

  $tips=get_option('guaven_wtd_tip_options');
  if (empty($tips)) return;
  $tips_arr=explode(",",$tips);
  $buts='';
  $percentsign=get_option('guaven_wtd_type')=='numbers'?'':'%';
  foreach($tips_arr as $tip){
    $tipval=str_replace(":default","",$tip);
    $tipval=esc_attr($tipval);

    $buts.= '<button class="gwtd_notice_buts" id="gwtd_notice_buts_'.$tipval.'">'.
    guaven_wtd_price($tipval,$percentsign).'</button> ';
  }

  wc_add_notice( esc_attr(get_option('guaven_wtd_notice')).' <span style="padding-left:15px">'.$buts.'</span>', 'notice' ); 
}
