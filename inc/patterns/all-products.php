<?php
/**
 * All Products Section
 * 
 * slug: all-products
 * title: All Products Section
 * categories: blockline
 */

return array(
    'title'      =>__( 'All Products', 'th-shop-mania' ),
    'categories' => array( 'blockline' ),
    'content'    => '<!-- wp:paragraph -->
<p>h</p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"},"blockGap":"29px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px"></div>
<!-- /wp:group -->

<!-- wp:woocommerce/all-products {"columns":4,"rows":2,"alignButtons":false,"contentVisibility":{"orderBy":true},"orderby":"date","layoutConfig":[["woocommerce/product-image",{"imageSizing":"cropped"}],["woocommerce/product-title"],["woocommerce/product-price"],["woocommerce/product-rating"],["woocommerce/product-button"]]} -->
<div class="wp-block-woocommerce-all-products wc-block-all-products" data-attributes="{&quot;alignButtons&quot;:false,&quot;columns&quot;:4,&quot;contentVisibility&quot;:{&quot;orderBy&quot;:true},&quot;isPreview&quot;:false,&quot;layoutConfig&quot;:[[&quot;woocommerce/product-image&quot;,{&quot;imageSizing&quot;:&quot;cropped&quot;}],[&quot;woocommerce/product-title&quot;],[&quot;woocommerce/product-price&quot;],[&quot;woocommerce/product-rating&quot;],[&quot;woocommerce/product-button&quot;]],&quot;orderby&quot;:&quot;date&quot;,&quot;rows&quot;:2}"></div>
<!-- /wp:woocommerce/all-products -->',
);