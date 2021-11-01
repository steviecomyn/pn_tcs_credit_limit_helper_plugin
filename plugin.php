<?php
/*
Plugin Name:	0_PageNorth - TCS Credit Limit Helper
Plugin URI:		https://www.pagenorth.co.uk
Description:	Modifications to help the new Credit Limit features on TCS.
Version:		0.2.9
Author:			PageNorth ltd
Author URI:		https://www.pagenorth.co.uk
License:		GPL-2.0+
License URI:	http://www.gnu.org/licenses/gpl-2.0.txt

This plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

This plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with This plugin. If not, see {URI to Plugin License}.
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit;

//=====================================================================================================================//

// This adds a new column to the users table that shows the users credit limit and balance.
include('add_credit_limit_to_user_table.php');
// This creates a notification in the basket when the current order total is over the customers credit limit balance.
include('credit_limit_notification.php');
// This applies some visual modifications to the reimbursement form on the company credit tab of the my account page.
include('credit_limit_reimburse_form_mods.php');
// This applies some modifications to the user edit page within the WP admin panel.
include('user_edit_page_mods.php');
// Include the ajax stuff (under development).
//include('ajax.php');
