<?php

class GenieSettings {
  
  public function __construct() {
    add_action('admin_menu', array($this, 'add_plugin_page'));
    add_action('admin_init', array($this, 'page_init'));
  }

  public function add_plugin_page() {
    // Add the menu item and page
    add_options_page(
        'Contact Info Plugin Settings',
        'Contact Info Settings',
        'manage_options',
        'contact_info_settings',
        array($this, 'create_admin_page')
    );
  }

  public function create_admin_page() {
    // Set class property
    $options = get_option('email');

    // Render the settings template
    include(plugin_dir_path(__FILE__) . 'templates/email-settings.php');
  }

  public function page_init() {        
    register_setting(
        'email_group', // Option group 
        'email', // Option name
        array($this, 'sanitize') // Sanitize
    );

    // Add section fields
    add_settings_section(
        'email_section_id', // ID
        'Email Settings', // Title
        array($this, 'print_section_info'), // Callback
        'contact-info-settings' // Page
    );  

    add_settings_field(
        'email', // ID
        'Email', // Title 
        array($this, 'email_callback'), // Callback
        'contact-info-settings', // Page
        'email_section_id' // Section           
    );      
  }

  public function sanitize($input) {
    $new_input = array();
    if (isset($input['email'])) {
      $new_input['email'] = sanitize_email($input['email']);
    }
    return $new_input;
  }

  public function print_section_info() {
    print 'Enter your email below:';
  }

  public function email_callback() {
    printf(
        '<input type="text" id="email" name="email[email]" value="%s" />',
        isset($options['email']) ? esc_attr($options['email']) : ''
    );
  }
}
