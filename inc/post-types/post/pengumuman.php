<?php 
    if ( get_theme_mod('opsi_editor') != "false" ) {
	    $showinrest = true;
	} else {
	    $showinrest = false;
    }
	register_post_type( 'pengumuman',		
	array(			
	    'menu_icon' => 'dashicons-clipboard',
		'labels' => array(				
	        'name'               => __( 'Announcement', 'wp-masjid' ),
			'singular_name'      => __( 'Announcement', 'wp-masjid' ),		
	    ),		                	
		'public'               => true,           					            
		'has_archive'          => true,        			            
		'supports'             => array( 'title', 'editor', 'thumbnail'),        			            
		'exclude_from_search'  => false,
		'show_in_rest'         => $showinrest,
	)	
    );