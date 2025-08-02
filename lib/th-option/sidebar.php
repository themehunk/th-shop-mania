<?php
$plugin_file = 'th-shop-mania-pro/th-shop-mania-pro.php'; // Plugin slug
$plugin_installed = file_exists(WP_PLUGIN_DIR . '/' . $plugin_file);
$plugin_active = is_plugin_active($plugin_file);
?>
<div class="sidebar-section">
            <div class="section th-pro-theme-ad">
            <h3 class="hndle ui-sortable-handle">
                <span><?php esc_html_e('Th Shop Mania Pro WordPress Theme','th-shop-mania'); ?> </span>
            </h3>
            <p>
            <b><?php esc_html_e('Pre-made premium templates','th-shop-mania'); ?> </b><br>
            <?php esc_html_e('To take full advantage of all the features this theme has to offer, please install and activate the TH Shop Mania Pro','th-shop-mania'); ?> </p>
           <?php if ( ! $plugin_installed ) { ?>
                <center><a class="button ztabtn" target="_blank" href="<?php echo esc_url('https://themehunk.com/th-shop-mania/'); ?>"><?php esc_html_e('Get Pro','th-shop-mania'); ?> </a></center>
            <?php }
            elseif ( ! $plugin_active ) { ?>
                 <center><button class="button button-primary activethbtn" id="activateinsidebar-th-shop-mania-pro" data-slug="th-shop-mania-pro"><span>Activate</span><span class="dashicons dashicons-update loader"></span></button></center>
         <?php    }
             else{ ?>
                <center><button class="button button-primary" id="activate-th-shop-mania-pro" data-slug="th-shop-mania-pro" disabled><span>Activated</span></button></center>
          <?php   } ?>
            </div>
            <hr>
            <div class="section">
                <h3><?php esc_html_e('Leave us a review','th-shop-mania'); ?></h3>
                <p><?php esc_html_e('We would love to hear your feedback.','th-shop-mania'); ?> </p>
                 <a href="<?php echo esc_url('https://www.trustpilot.com/review/themehunk.com'); ?>" target="_blank" class="sidebar-link"><?php esc_html_e('Submit Review','th-shop-mania'); ?></a>

            </div>
            <hr>

            <div class="section">
                <h3><?php esc_html_e('Video Tutorials','th-shop-mania'); ?></h3>
                <p><?php esc_html_e('Want a guide? We have video tutorials to walk you through getting started.','th-shop-mania'); ?> </p>
                <a href="<?php echo esc_url('https://www.youtube.com/c/ThemeHunk'); ?>" target="_blank" class="sidebar-link"><?php esc_html_e('Watch Videos','th-shop-mania'); ?></a>
            </div>
            <hr>

            <div class="section">
                <h3><?php esc_html_e('Support','th-shop-mania'); ?> </h3>
                <p><?php esc_html_e('Have a question, we are happy to help! Get in touch with our support team.','th-shop-mania'); ?></p>
                <a href="<?php echo esc_url('https://themehunk.com/contact-us/'); ?>" target="_blank" class="sidebar-link"><?php esc_html_e('Submit a Ticket','th-shop-mania'); ?></a>
            </div>
        </div>