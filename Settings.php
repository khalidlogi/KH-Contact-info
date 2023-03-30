<?php

//namespace MyNamespace;

if (!defined('ABSPATH')) {
    wp_die(__('Error'));
}

class Contact_Info_Plugin_Settings {

    private $settings_api;

    public function __construct() {
       
      //Menu Settings
      $this->settings_api = new WeDevs_Settings_API;

      add_action( 'admin_init', array($this, 'admin_init') );
      add_action( 'admin_menu', array($this, 'admin_menu') );

    }


    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }
   
    function admin_menu() {
        add_options_page( 'Settings API', 'Settings API', 'delete_posts', 'settings_api_test', array($this, 'plugin_page') );
    } 
        
    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'wedevs_basics',
                'title' => __( 'Contact Form Settings', 'wedevs' )
            ),
            /*
            array(
                'id'    => 'wedevs_advanced',
                'title' => __( 'Advanced Settings', 'wedevs' )
            )*/
        );
        return $sections;
    }

 /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'wedevs_basics' => array(
                array(
                    'name'              => 'Myemail',
                    'label'             => __( 'Enter your email', 'wedevs' ),
                    'desc'              => __( '', 'wedevs' ),
                    'placeholder'       => __( 'Enter your email', 'wedevs' ),
                    'type'              => 'text',
                    'default'           => get_option('admin_email'),
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'              => 'MySuccessText',
                    'label'             => __( 'Enter success message', 'wedevs' ),
                    'desc'              => __( '', 'wedevs' ),
                    'placeholder'       => __( 'Enter Success message', 'wedevs' ),
                    'type'              => 'text',
                    'default'           => 'Data has been saved successfully',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
               /* array(
                    'name'              => 'number_input',
                    'label'             => __( 'Number Input', 'wedevs' ),
                    'desc'              => __( 'Number field with validation callback `floatval`', 'wedevs' ),
                    'placeholder'       => __( '1.99', 'wedevs' ),
                    'min'               => 0,
                    'max'               => 100,
                    'step'              => '0.01',
                    'type'              => 'number',
                    'default'           => 'Title',
                    'sanitize_callback' => 'floatval'
                ),
                array(
                    'name'        => 'textarea',
                    'label'       => __( 'Textarea Input', 'wedevs' ),
                    'desc'        => __( 'Textarea description', 'wedevs' ),
                    'placeholder' => __( 'Textarea placeholder', 'wedevs' ),
                    'type'        => 'textarea'
                ),
                array(
                    'name'        => 'html',
                    'desc'        => __( 'HTML area description. You can use any <strong>bold</strong> or other HTML elements.', 'wedevs' ),
                    'type'        => 'html'
                ),
                array(
                    'name'  => 'checkbox',
                    'label' => __( 'Checkbox', 'wedevs' ),
                    'desc'  => __( 'Checkbox Label', 'wedevs' ),
                    'type'  => 'checkbox'
                ),
                array(
                    'name'    => 'radio',
                    'label'   => __( 'Radio Button', 'wedevs' ),
                    'desc'    => __( 'A radio button', 'wedevs' ),
                    'type'    => 'radio',
                    'options' => array(
                        'yes' => 'Yes',
                        'no'  => 'No'
                    )
                ),
                array(
                    'name'    => 'selectbox',
                    'label'   => __( 'A Dropdown', 'wedevs' ),
                    'desc'    => __( 'Dropdown description', 'wedevs' ),
                    'type'    => 'select',
                    'default' => 'no',
                    'options' => array(
                        'yes' => 'Yes',
                        'no'  => 'No'
                    )
                ),
                array(
                    'name'    => 'password',
                    'label'   => __( 'Password', 'wedevs' ),
                    'desc'    => __( 'Password description', 'wedevs' ),
                    'type'    => 'password',
                    'default' => ''
                ),
                array(
                    'name'    => 'file',
                    'label'   => __( 'File', 'wedevs' ),
                    'desc'    => __( 'File description', 'wedevs' ),
                    'type'    => 'file',
                    'default' => '',
                    'options' => array(
                        'button_label' => 'Choose Image'
                    )
                )
            ),
            'wedevs_advanced' => array(
                array(
                    'name'    => 'color',
                    'label'   => __( 'Color', 'wedevs' ),
                    'desc'    => __( 'Color description', 'wedevs' ),
                    'type'    => 'color',
                    'default' => ''
                ),
                array(
                    'name'    => 'password',
                    'label'   => __( 'Password', 'wedevs' ),
                    'desc'    => __( 'Password description', 'wedevs' ),
                    'type'    => 'password',
                    'default' => ''
                ),
                array(
                    'name'    => 'wysiwyg',
                    'label'   => __( 'Advanced Editor', 'wedevs' ),
                    'desc'    => __( 'WP_Editor description', 'wedevs' ),
                    'type'    => 'wysiwyg',
                    'default' => ''
                ),
                array(
                    'name'    => 'multicheck',
                    'label'   => __( 'Multile checkbox', 'wedevs' ),
                    'desc'    => __( 'Multi checkbox description', 'wedevs' ),
                    'type'    => 'multicheck',
                    'default' => array('one' => 'one', 'four' => 'four'),
                    'options' => array(
                        'one'   => 'One',
                        'two'   => 'Two',
                        'three' => 'Three',
                        'four'  => 'Four'
                    )
                ),*/
            )
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }



   /* function myplugin_add_menu() {
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

      */



}
