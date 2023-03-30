<?php

namespace MyNamespace;

if (!defined('ABSPATH')) {
    wp_die(__('Error'));
}

class Contact_Info_Plugin_Settings {
    public function __construct() {
       
        add_action( 'admin_menu', array($this, 'myplugin_add_menu'));

    }

    function myplugin_add_menu() {
        add_menu_page(
          'kk Contact form Page',  // Page title
          'kk Contact form',  // Menu title
          'manage_options',  // Capability required to access the menu item
          'myplugin-settings',  // Unique menu slug
          array($this,'myplugin_settings_page_callback'),  // Callback function to display the page content
          'dashicons-admin-generic'  // Menu icon
        );
      }

      function myplugin_settings_page_callback(){
        ?>
<div class="wrap">
    <h1><?php esc_html(get_admin_page_title());?></h1>
    <p>Welcom to kh Contact Form</p>
    <form action="options.php" method="post">
        <?php //security fields
        settings_fields('plugin options');?>


        <table class="form-table">

            <tr>
                <th><label for="first_field_id">First Field Name:</label></th>

                <td>
                    <input type='text' class="regular-text" id="first_field_id" name="first_field_name"
                        value="<?php echo get_option('first_field_name'); ?>">
                </td>
            </tr>

            <tr>
                <th><label for="second_field_id">Second Field Name:</label></th>
                <td>
                    <input type='text' class="regular-text" id="second_field_id" name="second_field_name"
                        value="<?php echo get_option('second_field_name'); ?>">
                </td>
            </tr>

            <tr>
                <th><label for="third_field_id">Third Field Name:</label></th>
                <td>
                    <input type='text' class="regular-text" id="third_field_id" name="third_field_name"
                        value="<?php echo get_option('third_field_name'); ?>">
                </td>
            </tr>
        </table>

        <?php

        //output settings section and their fields
        do_settings_sections('plugin options');

        // Output save settings button
        submit_button( 'Save Settings' );
  ?>
    </form>
</div>

<?php
      }



}
