<?php 
	if ( get_theme_mod('opsi_editor') != "false" ) {
	    $showinrest = true;
	} else {
	    $showinrest = false;
    }
	register_post_type( 'galeri',		
	array(			
	    'menu_icon' => 'dashicons-images-alt2',
		'labels' => array(				
	        'name'               => __( 'Image Gallery', 'wp-masjid' ),
			'singular_name'      => __( 'Image Gallery', 'wp-masjid' ),		
	    ),		                	
		'public'               => true,           					            
		'has_archive'          => true,        			            
		'supports'             => array( 'title', 'editor', 'thumbnail', 'excerpt'),        			            
		'exclude_from_search'  => false,
		'show_in_rest'         => $showinrest,
	)	
    );