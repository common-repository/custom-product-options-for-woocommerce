<?php

//manage columns for Post type

//Create Column
add_filter( 'manage_edit-jempa_field_group_columns', 'my_edit_jempa_field_group_columns' ) ;
function my_edit_jempa_field_group_columns( $columns ) {
//	print_r($columns);
	unset($columns['date']);
	//$columns['cpt_class_meta_field'] =  __( 'Display Rules' );
	$columns['date'] =  __( 'Date' );

	return $columns;
}

//Get meta key on  admin Column field
add_action( 'manage_jempa_field_group_posts_custom_column', 'manage_jempa_field_group_columns', 10, 2 );
function manage_jempa_field_group_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		default :
		echo '—';
			break;
	}
}
