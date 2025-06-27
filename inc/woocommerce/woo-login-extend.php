<?php
// Disable auto-login after registration
// remove_action('woocommerce_created_customer', 'wc_registration_redirect');

// add_filter('woocommerce_registration_redirect', 'custom_registration_redirect');
// function custom_registration_redirect($redirect) {
//     return wc_get_page_permalink('myaccount') . '?registered=true';
// }


// 1. Add custom fields: phone + confirm password
add_action('woocommerce_register_form', 'custom_add_register_fields');
function custom_add_register_fields() {
    ?>
    <p class="form-row form-row-wide">
        <label for="reg_password2"><?php _e('Confirm Password', 'woocommerce'); ?> <span class="required">*</span></label>
        <input type="password" class="input-text" name="password2" id="reg_password2" />
    </p>
    <p class="form-row form-row-wide">
        <label for="reg_phone"><?php _e('Phone Number', 'woocommerce'); ?> <span class="required">*</span></label>
        <input type="text" class="input-text" name="phone" id="reg_phone" value="<?php echo esc_attr($_POST['phone'] ?? ''); ?>" />
    </p>

    
    <?php
}

// 2. Validate fields
add_filter('woocommerce_registration_errors', 'custom_validate_register_fields', 10, 3);
function custom_validate_register_fields($errors, $username, $email) {
    if (empty($_POST['phone'])) {
        $errors->add('phone_error', __('Phone number is required.', 'woocommerce'));
    }

    if (!empty($_POST['password']) && $_POST['password'] !== $_POST['password2']) {
        $errors->add('password_mismatch', __('Passwords do not match.', 'woocommerce'));
    }

    return $errors;
}

// 3. Save phone field
add_action('woocommerce_created_customer', 'custom_save_register_fields');
function custom_save_register_fields($customer_id) {
    if (!empty($_POST['phone'])) {
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['phone']));
    }
}

// Disable auto-login after registration
remove_action('woocommerce_created_customer', 'wc_registration_redirect');