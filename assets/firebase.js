document.addEventListener('DOMContentLoaded', function () {
    // Initialize Firebase
    const firebaseApp = firebase.initializeApp(firebaseConfig);
    const auth = firebaseApp.auth();

    const phoneInputField = document.getElementById('phone');
    const sendOtpButton = document.getElementById('send-otp');
    const verifyOtpButton = document.getElementById('verify-otp');
    const submitButton = document.getElementById('submit-message');
    const recaptchaContainer = document.getElementById('recaptcha-container');
    const otpInput = document.getElementById('otp');
    const messageField = document.getElementById('message-field');

    let confirmationResult;

    // Ensure the verify button is initially disabled
    verifyOtpButton.disabled = true;
    submitButton.style.display = 'none';

    // Initialize intl-tel-input with restricted country list and auto country code insertion
    const phoneInput = window.intlTelInput(phoneInputField, {
        preferredCountries: ["us"],
        onlyCountries: ["us", "in", "au"],
        separateDialCode: true,
        autoPlaceholder: "polite",
        initialCountry: "in",
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.min.js"
    });

    // Function to update phone input with selected country code
    function updatePhoneInputWithCode() {
        const selectedCountry = phoneInput.getSelectedCountryData();
        phoneInputField.value = `+${selectedCountry.dialCode} `;
    }

    // Add country code when the page loads (for default selected country)
    phoneInputField.addEventListener('intlTelInput.init', updatePhoneInputWithCode);

    // Auto-add country code when a flag is selected
    phoneInputField.addEventListener('countrychange', updatePhoneInputWithCode);


    // Log phone number dynamically as user types
    phoneInputField.addEventListener('input', function () {
        const fullNumber = phoneInput.getNumber();
        console.log(fullNumber); // Log the complete phone number with country code
    });

    // Render reCAPTCHA
    auth.languageCode = 'en';
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(recaptchaContainer, {
        size: 'invisible',
        callback: () => {
            console.log('reCAPTCHA verified');
            sendOtpButton.style.display = 'inline-block';
        },
    });

    sendOtpButton.addEventListener('click', () => {
        window.recaptchaVerifier.render().then(function (widgetId) {
            grecaptcha.reset(widgetId); // Reset reCAPTCHA for subsequent clicks
        });
        
        const phoneNumber = phoneInput.getNumber(); // Get formatted phone number
        const selectedCountry = phoneInput.getSelectedCountryData();

         // Ensure phone number contains the country code
        if (!phoneNumber.startsWith(`+${selectedCountry.dialCode}`)) {
            console.error('Phone number does not include the country code.');
            alert('Phone number must include the country code.');
            return;
        }   

        if (!phoneInput.isValidNumber()) {
            alert('Please enter a valid phone number.');
            return;
        }

        sendOtpButton.innerText = 'Sending...';
        sendOtpButton.disabled = true;

        auth.signInWithPhoneNumber(phoneNumber, window.recaptchaVerifier)
            .then((result) => {
                confirmationResult = result;
                alert('OTP sent successfully!');

                // Enable the "Verify OTP" button once OTP is sent
                verifyOtpButton.disabled = false;
                sendOtpButton.innerText = 'OTP Sent';
            })
            .catch((error) => {
                console.error('Error sending OTP:', error);
                alert('Failed to send OTP. Please try again.');
                sendOtpButton.innerText = 'Send OTP';
                sendOtpButton.disabled = false;
            });
    });

    verifyOtpButton.addEventListener('click', () => {
        const otp = otpInput.value;
        if (!otp) {
            alert('Please enter the OTP');
            return;
        }

        verifyOtpButton.innerText = 'Verifying...';
        verifyOtpButton.disabled = true;

        confirmationResult
            .confirm(otp)
            .then(() => {
                alert('OTP verified successfully!');

                // Hide OTP input and verify button
                otpInput.style.display = 'none';
                verifyOtpButton.style.display = 'none';

                // Show message field and submit button
                messageField.style.display = 'block';
                submitButton.style.display = 'inline-block';
            })
            .catch((error) => {
                console.error('Error verifying OTP:', error);
                alert('Invalid OTP. Please try again.');
                verifyOtpButton.innerText = 'Verify OTP';
                verifyOtpButton.disabled = false;
            });
    });

    document.getElementById('otp-contact-form').addEventListener('submit', (event) => {
        event.preventDefault();

        const formData = new FormData(event.target);
        formData.append('action', 'send_message');

        fetch(ajaxUrl, {
            method: 'POST',
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    alert('Message sent successfully!');
                } else {
                    alert('Failed to send message.');
                }
            })
            .catch((error) => {
                console.error('Error submitting form:', error);
                alert('An error occurred. Please try again.');
            });
    });

    // Set default country code on page load after intl-tel-input is initialized
    setTimeout(updatePhoneInputWithCode, 500);
});