# 🚀 Firebase OTP Contact Form Plugin

## 📖 Overview  
The **Firebase OTP Contact Form Plugin** is a WordPress plugin that enhances form security by integrating Firebase OTP (One-Time Password) verification. It allows users to authenticate via phone number verification before submitting a contact form. The plugin supports international phone numbers, email notifications, and secure credential management.

---

## ⚙️ Features  

- **🔐 Firebase OTP Verification**  
  - Secure phone number authentication using Firebase OTP.  
  - Prevents spam submissions with phone-based verification.  

- **✉️ Email Notifications**  
  - Sends acknowledgment emails to users after successful submission.  
  - Customizable email content with company branding.  

- **🌍 intl-tel-input Integration**  
  - Provides international phone number formatting and validation.  
  - Supports country code selection with flags.  

- **⚡ AJAX Submission**  
  - Ensures seamless form submission without page reloads.  
  - Improves user experience and interaction speed.  

- **🔒 Secure Firebase Configuration**  
  - Credentials are securely managed through environment variables or the WordPress admin panel.  

- **🏷️ Easy Shortcode Integration**  
  - Use `[firebase_otp_contact_form]` to add the form to any post or page.

---

## 📚 Libraries Used  

1. **Firebase SDK**  
   - [Firebase JavaScript SDK](https://firebase.google.com/docs/web/setup) – Manages OTP authentication.

2. **intl-tel-input**  
   - [intl-tel-input](https://github.com/jackocnr/intl-tel-input) – Handles phone number formatting and validation.

3. **WordPress Core Functions**  
   - [wp_mail](https://developer.wordpress.org/reference/functions/wp_mail/) – Handles email notifications.  
   - AJAX and nonce security for form submission.

---

## 🚀 Installation  

Follow these steps to install and activate the plugin:

### 1. Clone the Repository  
```bash
git clone https://github.com/your-username/your-repository.git
cd your-repository

### 2. Upload to WordPress Plugins Folder
Copy the plugin folder into the wp-content/plugins/ directory of your WordPress installation.

### 3. Activate the Plugin
Go to Plugins in the WordPress Admin Dashboard, locate the plugin, and click Activate.

### 4. Firebase Configuration
    - **Obtain your Firebase configuration from the Firebase Console.**
    - **Add the configuration to the .env file (recommended) or define it in the wp-config.php file of your WordPress site. Future updates will allow this configuration through the admin panel.**

### 5. Use the Plugin Shortcode
Add [firebase_otp_contact_form] to any page or post to render the contact form.


## 🔮 Future Enhancements  

- **Advanced Email Templates**  
  - Use customizable HTML templates for acknowledgment emails.  

- **Phone Number Blacklist**  
  - Add functionality to detect and block blacklisted or spam numbers.  

- **Frontend Admin Page**  
  - Add a settings page in the WordPress admin panel to allow Firebase configurations directly from the dashboard, removing the need to modify PHP files manually.  

- **Google reCAPTCHA v3 Enhancements**  
  - Implement better bot detection with reCAPTCHA v3 or enterprise features.  

- **Plugin Backend Enhancements**  
  - Create a backend dashboard to view form submissions directly from the WordPress admin panel.  

- **Real-time Validation of Phone Numbers**  
  - Validate phone numbers in real-time against predefined criteria.  

