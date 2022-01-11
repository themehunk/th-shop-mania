<!--- tab first -->
<div class="theme_link">
    <h3><?php _e('1. Install Recommended Plugins','th-shop-mania'); ?></h3>
    <p><?php _e('We highly Recommend to install ThemeHunk Customizer plugin to get all customization options in Th Shop Mania theme. Also install recommended plugins available in recommended tab.','th-shop-mania'); ?></p>
</div>
<div class="theme_link">
    <h3><?php _e('2. Setup Home Page','th-shop-mania'); ?><!-- <php echo $theme_config['plugin_title']; ?> --></h3>
        <p><?php _e('To set up the HomePage in Th Shop Mania theme, Just follow the below given Instructions.','th-shop-mania'); ?> </p>
<p><?php _e('Go to Wp Dashboard > Pages > Add New > Create a Page using “Home Page Template” available in Page attribute.','th-shop-mania'); ?> </p>
<p><?php _e('Now go to Settings > Reading > Your homepage displays > A static page (select below) and set that page as your homepage.','th-shop-mania'); ?> </p>
     <p>
        <?php
		if($this->_check_homepage_setup()){
            $class = "activated";
            $btn_text = __('Home Page Activated','th-shop-mania');
            $Bstyle = "display:none;";
            $style = "display:inline-block;";
        }else{
            $class = "default-home";
             $btn_text = __('Set Home Page','th-shop-mania');
             $Bstyle = "display:inline-block;";
            $style = "display:none;";


        }
        ?>
        <button style="<?php echo $Bstyle; ?>" class="button activate-now <?php echo $class; ?>"><?php echo esc_html($btn_text); ?></button>
		
         </p>
		 	 
		 
    <p>
        <a target="_blank" href="https://themehunk.com/docs/th-shop-mania/#homepage-setting" class="button"><?php _e('Go to Doc','th-shop-mania'); ?></a>
    </p>
</div>

<!--- tab third -->





<!--- tab second -->
<div class="theme_link">
    <h3><?php _e('3. Customize Your Website','th-shop-mania'); ?><!-- <php echo $theme_config['plugin_title']; ?> --></h3>
    <p><?php _e('Th Shop Mania theme support live customizer for home page set up. Everything visible at home page can be changed through customize panel','th-shop-mania'); ?></p>
    <p>
    <a href="<?php echo admin_url('customize.php'); ?>" class="button button-primary"><?php _e("Start Customize","th-shop-mania"); ?></a>
    </p>
</div>
<!--- tab third -->

  <div class="theme_link">
    <h3><?php _e("4. Customizer Links","th-shop-mania"); ?></h3>
    <div class="card-content">
        <div class="columns">
                <div class="col">
                    <a href="<?php echo admin_url('customize.php?autofocus[control]=custom_logo'); ?>" class="components-button is-link"><?php _e("Upload Logo","th-shop-mania"); ?></a>
                    <hr><a href="<?php echo admin_url('customize.php?autofocus[section]=th-shop-mania-gloabal-color'); ?>" class="components-button is-link"><?php _e("Global Colors","th-shop-mania"); ?></a><hr>
                    <a href="<?php echo admin_url('customize.php?autofocus[panel]=woocommerce'); ?>" class="components-button is-link"><?php _e("Woocommerce","th-shop-mania"); ?></a><hr>

                </div>

               <div class="col">
                <a href="<?php echo admin_url('customize.php?autofocus[section]=th-shop-mania-section-header-group'); ?>" class="components-button is-link"><?php _e("Header Options","th-shop-mania"); ?></a>
                <hr>

                <a href="<?php echo admin_url('customize.php?autofocus[panel]=th-shop-mania-panel-frontpage'); ?>" class="components-button is-link"><?php _e("FrontPage Sections","th-shop-mania"); ?></a><hr>


                 <a href="<?php echo admin_url('customize.php?autofocus[section]=th-shop-mania-section-footer-group'); ?>" class="components-button is-link"><?php _e("Footer Section","th-shop-mania"); ?></a><hr>
            </div>

        </div>
    </div>

</div>
<!--- tab fourth -->