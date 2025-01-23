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
