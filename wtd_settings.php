<?php 
if (!defined('ABSPATH')) {
  die;
}

?><div class="wrap">
<div id="icon-options-general" class="icon32"><br></div>
<h2>WooCommerce Tips & Donations At Checkout</h2>

<form action="" method="post">
<?php wp_nonce_field( 'guaven_wtd_nonce','guaven_wtd_nonce_f'); ?>
<table class="form-table" id="box-table-a">
<tbody>
<tr><td>
  <p> Tip options should be shown with 
  <label><input name="guaven_wtd_type" class="guaven_wtd_type" value="percents" type="radio" 
  <?php echo strpos(get_option("guaven_wtd_type"),'numbers')===false?'checked':'';?>>percents</label>
  <label><input name="guaven_wtd_type" class="guaven_wtd_type" value="numbers" type="radio" 
  <?php echo get_option("guaven_wtd_type")=='numbers'?'checked':'';?>>numbers</label>
  </p>
<br>
  
  <p>
  <label>Enter tip options (comma separated):
  <input name="guaven_wtd_tip_options" type="text" id="guaven_wtd_tip_options"
  value="<?php echo esc_attr(get_option("guaven_wtd_tip_options"));?>">
  </label>
  <small>f.e. <i>0,5,10,15,20</i>  - no need to use "%" character. To set default value use this format:  <i>0,5,10:default,15,20</i> </small>
</p><br>


<p>
  <label>Field name at Checkout Page:
  <input name="guaven_wtd_field_name" type="text" id="guaven_wtd_field_name"
  value="<?php echo esc_attr(get_option("guaven_wtd_field_name"));?>">
  </label>
  <small>f.e. <i>Courier Tip</i> </small>
</p>

<br>

<p>
  <label><input name="guaven_wtd_custom_amount" class="guaven_wtd_custom_amount" 
  value="1" type="checkbox" <?php echo get_option("guaven_wtd_custom_amount")!=''?'checked':'';?>>Allow customers to enter their desired 
  amount</label>
  <br>
  </p>
<br>
<p>
  <label>Custom Amount Option Name:
  <input name="guaven_wtd_custom_amount_text" type="text" id="guaven_wtd_custom_amount_text"
  value="<?php echo esc_attr(get_option("guaven_wtd_custom_amount_text"));?>">
  </label>
  <small>f.e. <i>Other amount</i>  or  <i>Other</i></small>
</p>
<br>
<p>
  <label>Custom Amount Approval Button Text:
  <input name="guaven_wtd_custom_amount_button" type="text" id="guaven_wtd_custom_amount_button"
  value="<?php echo esc_attr(get_option("guaven_wtd_custom_amount_button"));?>">
  </label>
  <small>f.e. <i>OK</i>  or  <i>Set</i></small>
</p>


<br>
<p>
  <label>Notice box at the top of checkout form:
  <input name="guaven_wtd_notice" type="text" id="guaven_wtd_notice"
  value="<?php echo esc_attr(get_option("guaven_wtd_notice"));?>" style="width:100%;max-width:500px">
  </label>
  <small>f.e. <i>Would you like to add some tips for your courier?</i> (leave empty if you don't want to use it.) </small>
</p>
<br>
<p>
<label><input name="guaven_wtd_notice_hideafter" class="guaven_wtd_notice_hideafter" 
  value="1" type="checkbox" <?php echo get_option("guaven_wtd_notice_hideafter")!=''?'checked':'';?>>Hide top-notice box if there is already added tip (by the customer)</label>
</p>

  </td>
  </tr>



</tbody></table>


<p>
<input type="hidden" name="guaven_settings" value="1">
<input type="submit" class="button button-primary" value="Save changes">
</p>
</form>

<hr>
<h4>Configuring and testing</label></h4>
<p>
1. If any question about configuration or using process, just contact us: <a href="https://guaven.com/contact">Support Page</a>
</p>
<p>
2. In some themes after installation you can have small CSS incompatilities, in such case contact our support, and we will adjust your CSS for free.
</p>

</div>
