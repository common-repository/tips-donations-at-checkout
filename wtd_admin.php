<?php 
if (!defined('ABSPATH')) {
  die;
}

class Guaven_WTD_Admin {

  public function __construct()
  {
      $this->guaven_wtd_load_defaults();
  }

  function guaven_wtd_load_defaults()
  {
      if (get_option("guaven_wtd_installed_100") === false) {
          update_option("guaven_wtd_type", "1");
          update_option("guaven_wtd_custom_amount", "1");
          update_option("guaven_wtd_custom_amount_text", "Other");
          update_option("guaven_wtd_custom_amount_button", "OK");
          update_option("guaven_wtd_tip_options", '0,5,10,15,20');
          update_option("guaven_wtd_field_name", 'Courier tip');
          update_option("guaven_wtd_installed_100", '1');
          update_option("guaven_wtd_notice", '');
          update_option("guaven_wtd_notice_hideafter", '');
      }
  }


  function guaven_wtd_admin()
  {
      add_submenu_page('woocommerce', 'Guaven WTD Settings', 'Tips & Donations', 'manage_options', __FILE__, array($this,'guaven_wtd_settings')); 
  }


  function guaven_wtd_settings() {
      if (isset($_POST['guaven_wtd_nonce_f']) and
      wp_verify_nonce($_POST['guaven_wtd_nonce_f'],'guaven_wtd_nonce')) {
        $this->guaven_wtd_string_setting("guaven_wtd_type", 'percents');
        $this->guaven_wtd_is_checked("guaven_wtd_custom_amount", '');
        $this->guaven_wtd_is_checked("guaven_wtd_notice_hideafter", '');
        $this->guaven_wtd_string_setting("guaven_wtd_custom_amount_text", 'Other');
        $this->guaven_wtd_string_setting("guaven_wtd_custom_amount_button", 'OK');
        $this->guaven_wtd_string_setting("guaven_wtd_tip_options", '0,5,10,15,20');
        $this->guaven_wtd_string_setting("guaven_wtd_field_name", 'Courier tip');
        $this->guaven_wtd_string_setting("guaven_wtd_notice", ''); 
    }

    require_once(dirname(__FILE__)."/wtd_settings.php");
  }


  function guaven_wtd_is_checked($par)
  {
      if (isset($_POST["guaven_settings"])) {
          if (isset($_POST[$par]))
              $k = 'checked';
          else
              $k = '';
          update_option($par, $k);
      }
  }

  function guaven_wtd_string_setting($par, $def)
  {
      if (isset($_POST[$par])) {
          if (!empty($_POST[$par]))
              $k = sanitize_text_field($_POST[$par]);
          else
              $k = $def;

          update_option($par, $k);
      }
  }

    public function guaven_wtd_get_current_language_code(){
        if (isset($_GET["lang"])) return esc_attr($_GET["lang"]);
        if (isset($_POST["lang"])) return esc_attr($_POST["lang"]);
        if (defined('ICL_LANGUAGE_CODE')) return ICL_LANGUAGE_CODE;
        return '';
    }

    function site_url(){
      return str_replace("www.","",site_url());
    }
}
