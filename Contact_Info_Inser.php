<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//https://github.com/MateusNobreSilva/app_send_mail/tree/master/PHPMailer-master



if (!defined('ABSPATH')) {
    wp_die(__('Error'));
}

class Contact_Info_Inser {


    public function __construct() {
       
        add_action( 'wp_ajax_my_user_insert', array($this,'my_user_insert') );
        add_action( 'wp_ajax_nopriv_my_user_insert', array($this,'my_user_insert' ));
        add_shortcode( 'display_user_form', array($this,'display_user_form'));

       

    }


 
      

      
function display_user_form(){
   ob_start();
    
   require_once(plugin_dir_path( __FILE__).'html/form.php');

  $output = ob_get_clean();

  return $output;
}


//Create a PHP function to handle the AJAX request to insert user data

function my_user_insert() {

        global $wpdb;
        $response[]= array();
        $response['status'] = true;
        $data = array();



        // Get data from form submission
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $message = $_POST['m'];
    

   

        // validate name
        if (empty($name)) {
            //$response['status'] = false;
            $data["name"] = "Please enter your name";
           // $response['message'] = 'Please fill in the name correctly!';
        }

        // validate email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data["email"] = "Please enter a valid email";

        }
     


        // validate phone number
        if (empty($phone)) {
            $data["phone"] = "Please enter a valid phone number";

        } else {
            $phone = preg_replace('/[^0-9]/', '', $phone);  // remove non-numeric characters
            if (strlen($phone) !== 10) {
                $data["phone"] = "Please enter a valid phone number";
            }
        }


      

        
         // Check if all required fields exist and are not empty
    if(empty($data['name']) && empty($data['email']) && empty($data['phone'])) {
        $data['success'] = true; 
        $data['message'] = 'Thanks ...';
        //wp_send_json($data);
        $this->send_confirmation();
    }
    else {
        $data['success'] = false;
        $data['message'] = 'Error ...';
        wp_send_json($data);
    }
   

    // After Validation complete
        // Insert data into database
        $table_name = $wpdb->prefix . 'kh_contact';
        $status = $wpdb->insert(
            $table_name,
            array(
                'name' => sanitize_text_field($name),
                'email' => sanitize_email($email),
                'phone' => sanitize_text_field($phone),
                'city' => sanitize_text_field($city),
                'message' => sanitize_text_field($message),
            )
        );

        if($status === false) {
            $data['status'] = false;
            $data['message'] = 'Error Database';
            wp_send_json($data);
        } else {
        // $response['status'] = false;
                if(get_option('wedevs_basics')['MySuccessText'] !== false ) {
                    $data['message'] = get_option('wedevs_basics')['MySuccessText'] ?? '';                } else {
                    $data['message'] = "Error: MySuccessText option not found.";
                }
           wp_send_json($data);
        }

        
        
        

       

    }

    public function send_confirmation(){
        $message = isset($_POST['m']) ? $_POST['m'] : 'No message';
     //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body  = !empty($_POST['m']) ? sanitize_text_field($_POST['m']) : 'No message';

    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->addAddress('khalidlogi@gmail.com', 'Joe User');     //Add a recipient
    $mail->setFrom($_POST['email'], 'This emaail from');
    $mail->send(); /*
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'user@example.com';                     //SMTP username
    $mail->Password   = 'secret';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($_POST['email'], 'Mailer');
    $mail->addAddress('khalidlogi2@gmail.com', 'Joe User');     //Add a recipient
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
*/
    }
    
//Finally, use the shortcode [display_user_form] where you want to display the form in any page or post.
//Note: Make sure to enqueue the my-custom-scripts.js file, including it after jQuery in the footer section of your theme.


}