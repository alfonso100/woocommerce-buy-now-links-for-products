<?php
/**
 * @package woocommerce_buy_now_link
 * @version 1
 */
/*
Plugin Name: Buy Now Link for Woocommerce 
Plugin URI: http://moodstudio.net
Description: A simple plugin that adds a text box with a buy now link for WooCommerce products
Author: Alfonso Catron
Version: 1
Author URI: http://alfonsocatron.com

*/

define( 'WOOCOMMERCEBUYNOWLINK__PLUGIN_DIR',         plugin_dir_path( __FILE__ ) );


function woobnl_add_custom_box()
{
    $screens = ['product'];
    foreach ($screens as $screen) {
        add_meta_box(
            'woobnl_box_id',           // Unique ID
            'Buy Now link',  // Box title
            'woobnl_custom_box_html',  // Content callback, must be of type callable
            $screen                   // Post type
        );
    }
}

function woobnl_custom_box_html() { 

$product_id =  get_the_ID();; // the ID of the product to check
$_product = wc_get_product( $product_id );

if( $_product->is_type( 'simple' ) ) {

?>
	  <h4>Add to Cart</h4>
	    <p>This link adds the product to the cart, and directs the user to view the cart contents.</p>
	     <strong><?php echo the_title(); ?></strong>: <br><code><?php echo get_bloginfo('url'); ?>/cart/?add-to-cart=<?php echo the_ID();?></code>
	      <button>Copy to clipboard</button></p>
	   <a href="<?php echo get_bloginfo('url'); ?>/cart?add-to-cart" target="_blank">Add to cart &rsaquo;</a> 
	    <hr>
	
	  <h4>Add to Checkout</h4>
	    <p>This link adds the product to the cart, and directs the user to the checkout pag.</p>
		<strong><?php echo the_title(); ?></strong>: <br><code><?php echo get_bloginfo('url'); ?>/checkout/?add-to-cart=<?php echo the_ID();?></code> 
		<button>Copy to clipboard</button></p>
	    <a href="<?php echo get_bloginfo('url'); ?>/checkout/?add-to-cart" target="_blank">Buy Now &rsaquo;</a>

<?php 

} elseif( $_product->is_type( 'variable' ) ) {

$available_variations = $_product->get_available_variations();

 $add_to_cart = "";
 $add_to_checkout = "";
 
foreach ($available_variations as $key => $value) { 
            $add_to_cart .='<p><strong>'. get_the_title().' - '.implode('/',$value['attributes']).'</strong>: <br><code>'.get_bloginfo('url').'/cart/?add-to-cart='.$value['variation_id'].'</code></p>';
            $add_to_checkout .='<p><strong>'. get_the_title().' - '.implode('/',$value['attributes']).'</strong>: <br><code>'.get_bloginfo('url').'/checkout/?add-to-cart='.$value['variation_id'].'</code></p>';

  }

?>
  <h4>Add to Cart Variable</h4>
    <p>This link adds the product to the cart, and directs the user to view the cart contents.</p>
    <?php echo $add_to_cart; ?>
    <hr>

  <h4>Add to Checkout</h4>
    <p>This link adds the product to the cart, and directs the user to the checkout pag.</p>
	 <?php echo $add_to_checkout; ?>


<?php 

}


 ?>
<?php 
}


add_action('add_meta_boxes', 'woobnl_add_custom_box');

?>