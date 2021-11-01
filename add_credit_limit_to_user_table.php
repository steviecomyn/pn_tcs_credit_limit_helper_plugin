<?php

// Add new column to the users table.
add_filter( 'manage_users_columns', 'pn_new_modify_user_table' );

function pn_new_modify_user_table( $column ) {
    $column['credit-limit'] = 'B2B Credit Limit';
    return $column;
}

// Gather the information required to populate the new column.
add_filter( 'manage_users_custom_column', 'pn_new_modify_user_table_row', 10, 3 );

function pn_new_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'credit-limit' :

			// Get user metadata
			$key = 'b2bking_user_credit_limit';
			$key2 = 'b2bking_user_credit_consumed_balance';
			$single = true;
			$user_credit_limit = get_user_meta( $user_id, $key, $single );
			$user_credit_balance = get_user_meta( $user_id, $key2, $single );
			
			if ($user_credit_limit){
				// If credit limit is populated, show it.
				$hr_credit_limit = "£".number_format($user_credit_limit, 2, '.', ',');
				
				// If credit balance is populated, show it.
				if($user_credit_balance){
					$hr_credit_limit .= "<br>(-£".number_format($user_credit_balance, 2, '.', ',').")";
				}
				
				// Return Human-Readable credit limit/balance.
				return $hr_credit_limit;
			} else {
				// If empty, show n/a.
				return "N/A";
			}

        default:
    }
    return $val;
}