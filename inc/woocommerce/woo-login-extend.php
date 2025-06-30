<?php
// Disable auto-login after registration
// remove_action('woocommerce_created_customer', 'wc_registration_redirect');

// add_filter('woocommerce_registration_redirect', 'th_shop_mania_registration_redirect');
// function th_shop_mania_registration_redirect($redirect) {
//     return wc_get_page_permalink('myaccount') . '?registered=true';
// }

// 1. Add custom fields: confirm password + phone
add_action('woocommerce_register_form', function() {

    if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
    <p class="form-row form-row-wide">
        <label for="reg_password2"><?php esc_html_e('Confirm Password', 'th-shop-mania'); ?> <span class="required">*</span></label>
        <input type="password" class="input-text" name="password2" id="reg_password2" />
    </p>
    <?php endif; ?>

    <p class="form-row form-row-wide">
        <label for="reg_phone"><?php esc_html_e('Phone Number', 'th-shop-mania'); ?> <span class="required">*</span></label>
        <input type="text" class="input-text" name="phone" id="reg_phone" value="<?php echo esc_attr($_POST['phone'] ?? ''); ?>" />
    </p>
    <?php
});

// 2. Validate
add_filter('woocommerce_registration_errors', function($errors, $username, $email) {
    if (empty($_POST['phone'])) {
        $errors->add('phone_error', __('Phone number is required.', 'th-shop-mania'));
    }
   if ('no' === get_option('woocommerce_registration_generate_password')) {
        if (!empty($_POST['password']) && $_POST['password'] !== $_POST['password2']) {
            $errors->add('password_mismatch', __('Passwords do not match.', 'th-shop-mania'));
        }
    }

    return $errors;
}, 10, 3);

// 3. Save phone
add_action('woocommerce_created_customer', function($customer_id) {
    if (!empty($_POST['phone'])) {
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['phone']));
    }
});

// 4. Stop WooCommerce auto login after register
add_filter('woocommerce_registration_auth_new_customer', '__return_false');


// // 5. Redirect to ?registered=1
add_filter('woocommerce_registration_redirect', fn($u) =>
    wc_get_page_permalink('myaccount') . '?registered=1'
);

// 6. Show success message + login button
add_action('wp_footer', function() {
    ?>
    <div id="th-register-success-modal" style="display:none;">
        <div class="th-modal-inner">
            <span id="th-close-register-modal">&times;</span>
            <h2>🎉<?php esc_html_e('Successfully Registered!','th-shop-mania') ?></h2>
            <p><?php esc_html_e('You have successfully created your account.','th-shop-mania') ?></p>
            <a href="<?php echo esc_url( wc_get_page_permalink('myaccount') ); ?>" class="button"><?php esc_html_e('Login Now','th-shop-mania') ?></a>
        </div>
    </div>
    <?php
});


