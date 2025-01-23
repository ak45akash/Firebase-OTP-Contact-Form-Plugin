<?php
/**
 * Plugin Name: Firebase OTP Contact Form
 * Description: A contact form with Firebase OTP verification.
 * Version: 1.0
 * Author: Akash
 */

defined('ABSPATH') || exit;

// Enqueue scripts and styles
function firebase_otp_enqueue_scripts() {
    // Firebase JS SDK from CDN
    wp_enqueue_script('firebase-app', 'https://www.gstatic.com/firebasejs/9.17.1/firebase-app-compat.js', [], null, true);
    wp_enqueue_script('firebase-auth', 'https://www.gstatic.com/firebasejs/9.17.1/firebase-auth-compat.js', ['firebase-app'], null, true);
    
    // Include intl-tel-input library
    wp_enqueue_style('intl-tel-input-css', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css');
    wp_enqueue_script('intl-tel-input-js', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js', [], null, true);


    // Custom JS for OTP functionality
    wp_enqueue_script('firebase-otp-script', plugin_dir_url(__FILE__) . 'assets/firebase.js', ['firebase-app', 'firebase-auth'], null, true);


    // Pass Firebase Config to JS
    $firebaseConfig = [
        'apiKey' => getenv('FIREBASE_API_KEY'),
        'authDomain' => getenv('FIREBASE_AUTH_DOMAIN'),
        'projectId' => getenv('FIREBASE_PROJECT_ID'),
        'storageBucket' => getenv('FIREBASE_STORAGE_BUCKET'),
        'messagingSenderId' => getenv('FIREBASE_MESSAGING_SENDER_ID'),
        'appId' => getenv('FIREBASE_APP_ID'),
        'measurementId' => getenv('FIREBASE_MEASUREMENT_ID'),
    ];

    wp_enqueue_style('firebase-otp-style', plugin_dir_url(__FILE__) . 'assets/style.css');
}
add_action('wp_enqueue_scripts', 'firebase_otp_enqueue_scripts');

// Shortcode for the contact form
function firebase_otp_contact_form() {
    ob_start();
    ?>
    <form id="otp-contact-form">
        <div id="recaptcha-container"></div>

        <div>
            <input type="text" id="name" name="name" placeholder="First Name" required>
        </div>

        <div>
            <input type="email" id="email" name="email" placeholder="Email Address" required>
        </div>

        <div>
            <input type="tel" id="phone" name="phone" placeholder=" " required>
        </div>

        <button type="button" id="send-otp">Send OTP</button>

        <div>
            <input type="text" id="otp" name="otp" placeholder="Enter OTP">
        </div>

        <button type="button" id="verify-otp">Verify OTP</button>

        <div id="message-field">
            <!-- <label for="message">Message:</label> -->
            <textarea id="message" name="message" rows="4" placeholder="Enter your message"></textarea>
        </div>

        <button type="submit" id="submit-message">Send Message</button>
    </form>

    <script>
        const ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
    <?php
    return ob_get_clean();
}



add_shortcode('firebase_otp_contact_form', 'firebase_otp_contact_form');
add_shortcode('firebase_otp_contact_form', 'firebase_otp_contact_form');

// Handle form submission via AJAX
function firebase_otp_send_email() {
    error_log('Received POST: ' . print_r($_POST, true));
    
    if (!isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['message'])) {
        wp_send_json_error(['message' => 'Invalid data.']);
    }

    // Sanitize input data
    $name = sanitize_text_field($_POST['name']);
    $user_email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $message_content = sanitize_textarea_field($_POST['message']);

    // Email to admin
    $admin_email = 'ak45.akashdeep@gmail.com';
    $admin_subject = 'New Contact Form Submission';
    $admin_message = sprintf(
        "Name: %s\nEmail: %s\nPhone: %s\nMessage: %s",
        $name,
        $user_email,
        $phone,
        $message_content
    );
    $admin_headers = ['Content-Type: text/plain; charset=UTF-8'];

    $admin_email_sent = wp_mail($admin_email, $admin_subject, $admin_message, $admin_headers);

    // Email to user (acknowledgment)
    $user_subject = 'Thank You for Your Submission';
    $user_message = sprintf(
        "Dear %s,\n\nThank you for reaching out to us! We have received your message:\n\n\"%s\"\n\nWe will get back to you shortly.\n\nBest regards,\nAUnzip Health",
        $name,
        $message_content
    );
    $user_headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: Unzip Health <akash@unziphealth.com>'
    ];

    $user_email_sent = wp_mail($user_email, $user_subject, $user_message, $user_headers);

    // Send success/failure response
    if ($admin_email_sent && $user_email_sent) {
        wp_send_json_success(['message' => 'Message sent successfully.']);
    } else {
        wp_send_json_error(['message' => 'Failed to send message.']);
    }
}
add_action('wp_ajax_send_message', 'firebase_otp_send_email');
add_action('wp_ajax_nopriv_send_message', 'firebase_otp_send_email');
