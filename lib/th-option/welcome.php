<!--- tab first -->
<div class="theme_link">
    <h3><?php _e('1. Install Recommended Plugins','th-shop-mania'); ?></h3>
    <p><?php _e('We highly Recommend to install Hunk Companion plugin to get all customization options in Th Shop Mania theme. Also install recommended plugins available in recommended tab.','th-shop-mania'); ?></p>
</div>
<div class="theme_link">
    <h3><?php _e('2. Setup Home Page','th-shop-mania'); ?><!-- <php echo $theme_config['plugin_title']; ?> --></h3>
        <p><?php _e('To set up the HomePage in Th Shop Mania theme, Just follow the below given Instructions.','th-shop-mania'); ?> </p>
<p><?php _e('Go to Wp Dashboard > Pages > Add New','th-shop-mania'); ?> </p>
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

  <div class="theme_link custommizer_link">
    <h3><?php _e("4. Customizer Links","th-shop-mania"); ?></h3>
    <div class="card-content">
        <div class="columns">
                <div class="col">
                    <a href="<?php echo admin_url('customize.php?autofocus[control]=custom_logo'); ?>" class="components-button is-link"><?php _e("Upload Logo","th-shop-mania"); ?></a>
                    <hr><a href="<?php echo admin_url('customize.php?autofocus[section]=th-shop-mania-gloabal-color'); ?>" class="components-button is-link"><?php _e("Global Colors","th-shop-mania"); ?></a><hr>
                    <a href="<?php echo admin_url('customize.php?autofocus[panel]=woocommerce'); ?>" class="components-button is-link"><?php _e("Woocommerce","th-shop-mania"); ?></a><hr>
                    <a href="<?php echo admin_url('customize.php?autofocus[section]=header_image'); ?>" class="components-button is-link"><?php _e("Header Image","th-shop-mania"); ?></a><hr>
                    <a href="<?php echo admin_url('customize.php?autofocus[panel]=widgets'); ?>" class="components-button is-link"><?php _e("Widgets","th-shop-mania"); ?></a><hr>


                 <a href="<?php echo admin_url('customize.php?autofocus[section]=th-shop-mania-bottom-footer'); ?>" class="components-button is-link"><?php _e("Footer Section","th-shop-mania"); ?></a><hr>
            </div>

        </div>
    </div>

</div>
<!--- tab fourth -->

<div class="theme_link more">
    <h3><?php _e('More Options available with Th Shop Mania Pro','th-shop-mania'); ?></h3>
    <div class="th-more-options-wrapper">
       <ul>
        <li class="option-list"><a href="#"><?php _e('5 Types of Product Gallery Slider','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>

        <li class="option-list"><a href="#"><?php _e('Product Image Hover Styles','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
        <li class="option-list"><a href="#"><?php _e('Quick View','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
        <li class="option-list"><a href="#"><?php _e('Prodcut Layouts','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
        <li class="option-list"><a href="#"><?php _e('Step Checkout','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
         <li class="option-list"><a href="#"><?php _e('Distraction Free Checkout','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
         <li class="option-list"><a href="#"><?php _e('Shop Page Pagination','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
         <li class="option-list"><a href="#"><?php _e('Cross Sell & Upsell Options','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
          <li class="option-list"><a href="#"><?php _e('Sale Badge Option','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
          <li class="option-list"><a href="#"><?php _e('Preloader Option','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
           <li class="option-list"><a href="#"><?php _e('Background & Color','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
            <li class="option-list"><a href="#"><?php _e('Above Header Options','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
            <li class="option-list"><a href="#"><?php _e('Main Header Options','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
            <li class="option-list"><a href="#"><?php _e('Below Header Options','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
            <li class="option-list"><a href="#"><?php _e('Sticky Header','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
            <li class="option-list"><a href="#"><?php _e('Category Options','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
            <li class="option-list"><a href="#"><?php _e('Transparent Header','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
            <li class="option-list"><a href="#"><?php _e('Page Header','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
            <li class="option-list"><a href="#"><?php _e('Sticky Sidebar','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
            <li class="option-list"><a href="#"><?php _e('Box Container Layout','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
             <li class="option-list"><a href="#"><?php _e('Wide Container Layout','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
             <li class="option-list"><a href="#"><?php _e('Above Footer Options','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
             <li class="option-list"><a href="#"><?php _e('Widget Footer Options','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
             <li class="option-list"><a href="#"><?php _e('Below Footer Options','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
              <li class="option-list"><a href="#"><?php _e('Fixed Footer','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
              <li class="option-list"><a href="#"><?php _e('Move To Top Option','th-shop-mania'); ?></a> <a href="#" class="learn-more"><?php _e('Learn More','th-shop-mania'); ?></a></li>
       </ul> 
    </div>
</div>