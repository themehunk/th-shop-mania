<?php
// Disable auto-login after registration
// remove_action('woocommerce_created_customer', 'wc_registration_redirect');

// add_filter('woocommerce_registration_redirect', 'th_shop_mania_registration_redirect');
// function th_shop_mania_registration_redirect($redirect) {
//     return wc_get_page_permalink('myaccount') . '?registered=true';
// }


// 1. Add custom fields: phone + confirm password
add_action('woocommerce_register_form', 'th_shop_mania_add_register_fields');
function th_shop_mania_add_register_fields() {
    ?>
    <p class="form-row form-row-wide">
        <label for="reg_password2"><?php esc_html_e('Confirm Password', 'th-shop-mania'); ?> <span class="required">*</span></label>
        <input type="password" class="input-text" name="password2" id="reg_password2" />
    </p>
    <p class="form-row form-row-wide">
        <label for="reg_phone"><?php esc_html_e('Phone Number', 'th-shop-mania'); ?> <span class="required">*</span></label>
        <input type="text" class="input-text" name="phone" id="reg_phone" value="<?php echo esc_attr($_POST['phone'] ?? ''); ?>" />
    </p>

    
    <?php
}

// 2. Validate fields
add_filter('woocommerce_registration_errors', 'th_shop_mania_validate_register_fields', 10, 3);
function th_shop_mania_validate_register_fields($errors, $username, $email) {
    if (empty($_POST['phone'])) {
        $errors->add('phone_error', __('Phone number is required.', 'th-shop-mania'));
    }

    if (!empty($_POST['password']) && $_POST['password'] !== $_POST['password2']) {
        $errors->add('password_mismatch', __('Passwords do not match.', 'th-shop-mania'));
    }

    return $errors;
}

// 3. Save phone field
add_action('woocommerce_created_customer', 'th_shop_mania_save_register_fields');
function th_shop_mania_save_register_fields($customer_id) {
    if (!empty($_POST['phone'])) {
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['phone']));
    }
}

// Disable auto-login after registration
remove_action('woocommerce_created_customer', 'wc_registration_redirect');