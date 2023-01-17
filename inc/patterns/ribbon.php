<?php
/**
 * Ribbon Section
 * 
 * slug: ribbon
 * title: Ribbon Section
 * categories: blockline
 */

return array(
    'title'      =>__( 'Ribbon Section', 'blockline' ),
    'categories' => array( 'blockline' ),
    'content'    => '<!-- wp:group {"style":{"spacing":{"blockGap":"0","padding":{"top":"100px","right":"20px","bottom":"100px","left":"20px"},"margin":{"top":"0","bottom":"0"}},"border":{"bottom":{"color":"#eeeeee","width":"1px"}}},"className":"has-accent-background-color has-background","layout":{"type":"default"}} -->
    <div class="wp-block-group has-accent-background-color has-background" style="border-bottom-color:#eeeeee;border-bottom-width:1px;margin-top:0;margin-bottom:0;padding-top:100px;padding-right:20px;padding-bottom:100px;padding-left:20px"><!-- wp:heading {"textAlign":"center","style":{"typography":{"fontStyle":"normal","fontWeight":"600"}},"textColor":"background","fontSize":"large"} -->
    <h2 class="has-text-align-center has-background-color has-text-color has-large-font-size" style="font-style:normal;font-weight:600">“Pleasure in the job puts perfection in the work”</h2>
    <!-- /wp:heading -->
    
    <!-- wp:spacer {"height":"50px"} -->
    <div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->
    
    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"blockGap":"0"}}} -->
    <div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"background","textColor":"foreground","style":{"border":{"radius":"4px"},"spacing":{"padding":{"top":"1rem","right":"2rem","bottom":"1rem","left":"2rem"}}},"className":"is-style-fill","fontSize":"normal"} -->
    <div class="wp-block-button has-custom-font-size is-style-fill has-normal-font-size"><a class="wp-block-button__link has-foreground-color has-background-background-color has-text-color has-background wp-element-button" style="border-radius:4px;padding-top:1rem;padding-right:2rem;padding-bottom:1rem;padding-left:2rem">Explore it</a></div>
    <!-- /wp:button --></div>
    <!-- /wp:buttons --></div>
    <!-- /wp:group -->',
);