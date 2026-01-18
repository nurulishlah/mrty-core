<?php 
    if ( get_theme_mod('opsi_editor') != "false" ) {
	    $showinrest = true;
	} else {
	    $showinrest = false;
    }
	register_post_type( 'tausiyah',		
	array(			
	    'menu_icon' => 'dashicons-format-status',
		'labels' => array(				
	        'name'               => __( 'Tausiyah', 'wp-masjid' ),
			'singular_name'      => __( 'Tausiyah', 'wp-masjid' ),		
	    ),		                	
		'public'               => true,           					            
		'has_archive'          => true,        			            
		'supports'             => array( 'title', 'editor', 'thumbnail'),        			            
		'exclude_from_search'  => false,
		'show_in_rest'         => $showinrest,
	)	
    );