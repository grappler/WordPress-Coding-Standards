<?php

// All will give an WARNING.

add_filter( 'blog_details', function( $parameter ){
	return $parameter;
} );

add_filter( 'rest_enabled', 'wpcs_rest_enabled' );
