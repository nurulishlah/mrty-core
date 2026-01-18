<?php 
    if ( get_theme_mod('opsi_editor') != "false" ) {
	    $showinrest = true;
	} else {
	    $showinrest = false;
    }
	register_post_type( 'slide',		
	array(			
	    'menu_icon' => 'dashicons-format-video',
		'labels' => array(				
	        'name'               => __( 'Slide Image', 'wp-masjid' ),
			'singular_name'      => __( 'Slide Image', 'wp-masjid' ),			
	    ),		                	
		'public'               => true,           					            
		'has_archive'          => true,        			            
		'supports'             => array( 'title', 'editor', 'thumbnail'),        			            
		'exclude_from_search'  => false,
		'show_in_rest'         => $showinrest,
	)	
    );