<?php

//Load jQuery
wp_enqueue_script('jquery');

//The Javascript
function pn_refresh_on_cart_update(){ ?>
<script>
jQuery(document).ready(function($) {
    
    // When the cart is updated, refresh the page.
    jQuery(document.body).on('removed_from_cart updated_cart_totals', function () {

        location.reload();

    });
});
</script>
<?php }
add_action('wp_footer', 'pn_refresh_on_cart_update');