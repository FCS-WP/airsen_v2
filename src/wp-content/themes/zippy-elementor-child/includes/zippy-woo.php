<?php

function enqueue_wc_cart_fragments()
{
  wp_enqueue_script('wc-cart-fragments');
}
add_action('wp_enqueue_scripts', 'enqueue_wc_cart_fragments');

add_action('woocommerce_after_shop_loop_item_title', 'show_stock_shop', 10);

function show_stock_shop()
{
  global $product;
  if ($product->managing_stock() && (int)$product->get_stock_quantity() < 1)
    echo '<p class="shop-out-of-stock" style="color: #fff;
    font-size: 12px;
    background: #666666;
    position: absolute;
    padding: 6px 12px;
    margin: 0 auto;
    top: 5px;
    left: 5px;">' . __('Out of stock') . '</p>';
}

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

add_action('woocommerce_after_shop_loop_item', 'custom_add_to_cart_button', 20);

function custom_add_to_cart_button()
{
  global $product;

  $product_id = $product->get_id();
  $product_url = get_permalink($product_id);
  if (!function_exists('WC') || !WC()->session->get('order_mode')) : ?>
    <?php echo '<a data-product_id="' . $product_id . '" class="button add_to_cart_button">View Product</a>'; ?>
  <?php else: ?>
    <?php echo ' <a href="?add-to-cart=' . $product_id . '"  aria-describedby="woocommerce_loop_add_to_cart_link_describedby_' . $product_id . '" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="' . $product_id . '" data-product_sku="CNY010" aria-label="Add to cart: “TANGERINE TARTS”" rel="nofollow" data-success_message="“TANGERINE TARTS” has been added to your cart">Add to cart</a>'; ?>
  <?php endif; ?>

  <?php
}
