<?php

/* Used to move the credit reimburse form */
add_action('wp_footer', 'pn_move_credit_reimburse_button');
function pn_move_credit_reimburse_button(){
?>
<script>
	jQuery( document ).ready(function( $ ){

		var snippet = '<div class="info-badge-wrapper"><span class="info-badge" data-tooltip="Add funds to your credit account, enter the amount and click pay now to go to the checkout.">?</span></div>';

		$('#b2bking_companycredit_header_container').append( $('#b2bking_reimburse_button_container') );

		$('#b2bking_reimburse_amount_input').attr("placeholder", "Enter amount to credit");
		$('#b2bking_reimburse_amount_button').text("Pay Now");

		$('#b2bking_reimburse_button_container').append(snippet);
	});
</script>
<?php
};

// https://codepen.io/cbracco/pen/qzukg - Tooltip code found here.


/* Change the style of the reimburse button & add tooltip code */
add_action('wp_head', 'pn_fix_reimburse_button_style', 20);
function pn_fix_reimburse_button_style() {
    ?>
	
	<style>

		#pn-credit-limit-notice-wrapper {
			background-color: #f7d6d6;
			padding: 1rem;
			border-radius: 4px;
			margin-bottom: 1.2rem;
			text-align: center;
		}

		#pn_credit_limit_notice {
			color: #d63031;
		}

		#pn_credit_limit_notice a {
			color: #d63031 !important;
			font-weight: bold;
		}


		button#b2bking_reimburse_amount_button {
			background-color: #9AC454 !important;
			border: 0 !important;
			cursor: pointer;
			padding-left: 16px;
			padding-right: 16px;
		}

		button#b2bking_reimburse_amount_button:hover {
			background-color: #7b9d43 !important;
		}

		.info-badge-wrapper {
			display: grid;
			place-items: center;
			margin-left: 20px;
		}

		.info-badge {
            font-family: Arial, Helvetica, sans-serif;
            display: inline-block;
            cursor: pointer;
            font-size: 14px;
            background-color: rgba(0,0,0,0.75);
            color: #fff;
            font-weight: bolder;
            padding: 3px 10px;
            border-radius: 50%;
        }

		/* Add this attribute to the element that needs a tooltip */
		[data-tooltip] {
		position: relative;
		z-index: 2;
		cursor: pointer;
		}

		/* Hide the tooltip content by default */
		[data-tooltip]:before,
		[data-tooltip]:after {
		visibility: hidden;
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
		filter: progid: DXImageTransform.Microsoft.Alpha(Opacity=0);
		opacity: 0;
		pointer-events: none;
		}

		/* Position tooltip above the element */
		[data-tooltip]:before {
		position: absolute;
		bottom: 150%;
		left: 50%;
		margin-bottom: 5px;
		margin-left: -80px;
		padding: 7px;
		width: 160px;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		border-radius: 3px;
		background-color: #000;
		background-color: hsla(0, 0%, 20%, 0.9);
		color: #fff;
		content: attr(data-tooltip);
		text-align: center;
		font-size: 14px;
		line-height: 1.2;
		}

		/* Triangle hack to make tooltip look like a speech bubble */
		[data-tooltip]:after {
		position: absolute;
		bottom: 150%;
		left: 50%;
		margin-left: -5px;
		width: 0;
		border-top: 5px solid #000;
		border-top: 5px solid hsla(0, 0%, 20%, 0.9);
		border-right: 5px solid transparent;
		border-left: 5px solid transparent;
		content: " ";
		font-size: 0;
		line-height: 0;
		}

		/* Show tooltip content on hover */
		[data-tooltip]:hover:before,
		[data-tooltip]:hover:after {
		visibility: visible;
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
		filter: progid: DXImageTransform.Microsoft.Alpha(Opacity=100);
		opacity: 1;
		}
	</style>

	<?php
};