<?php 

	add_action( 'init', 'katt_taxonomy', 0 );
	function katt_taxonomy() {
	  $labels = array(
	    'name' => _x( 'Tausiyah Categories', 'taxonomy general name', 'wp-masjid' ),
	    'singular_name' => _x( 'Tausiyah Categories', 'taxonomy singular name', 'wp-masjid' ),
	    'menu_name' => __( 'Tausiyah Categories', 'wp-masjid' ),
	  );   
	// Now register the taxonomy
	  register_taxonomy('kat-tausiyah',array('tausiyah'), array(
	    'hierarchical' => true,
	    'labels' => $labels,
	    'show_ui' => true,
	    'show_admin_column' => true,
	    'query_var' => true,
	  ));
	}
	
add_action( 'init', 'topik_taxonomy', 0 );
 
function topik_taxonomy() {
 
// Labels part for the GUI
 
  $labels = array(
    'name' => _x( 'Tausiyah Topics', 'taxonomy general name', 'wp-masjid' ),
    'singular_name' => _x( 'Tausiyah Topics', 'taxonomy singular name', 'wp-masjid' ),
    'menu_name' => __( 'Tausiyah Topics', 'wp-masjid' ),
  ); 
 
// Now register the non-hierarchical taxonomy like tag
 
  register_taxonomy('topik','tausiyah',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
  ));
}

    // PERIODE INFAQ TAHUN

	add_action( 'init', 'create_tahun_taxonomy', 0 );
	function create_tahun_taxonomy() {
	    $labels = array(
	        'name' => _x( 'Year Period (example: 2019)', 'taxonomy general name', 'wp-masjid' ),
	        'singular_name' => _x( 'Year Period', 'taxonomy singular name', 'wp-masjid' ),
	        'menu_name' => __( 'Year Period', 'wp-masjid' ),
	    );  
		
	     register_taxonomy('tahun',array('infaq'), array(
	        'hierarchical' => true,
	        'labels' => $labels,
	        'show_ui' => true,
	        'show_admin_column' => true,
	        'query_var' => true,
	    ));
	}

    // PERIODE INFAQ BULAN

	add_action( 'init', 'create_bulan_taxonomy', 0 );
	function create_bulan_taxonomy() {
	    $labels = array(
	        'name' => _x( 'Month Period (example: August 2019)', 'taxonomy general name', 'wp-masjid' ),
	        'singular_name' => _x( 'Month Period', 'taxonomy singular name', 'wp-masjid' ),
	        'menu_name' => __( 'Month Period', 'wp-masjid' ),
	    );  
		
	     register_taxonomy('bulan',array('infaq'), array(
	        'hierarchical' => true,
	        'labels' => $labels,
	        'show_ui' => true,
	        'show_admin_column' => true,
	        'query_var' => true,
	    ));
	}
	
	add_action( 'init', 'create_infaq_category', 0 );
	function create_infaq_category() {
	    $labels = array(
	        'name' => _x( 'Infaq Categories', 'taxonomy general name', 'wp-masjid' ),
	        'singular_name' => _x( 'Infaq Categories', 'taxonomy singular name', 'wp-masjid' ),
	        'menu_name' => __( 'Infaq Categories', 'wp-masjid' ),
	    );  
		
	     register_taxonomy('kat-infaq',array('infaq'), array(
	        'hierarchical' => true,
	        'labels' => $labels,
	        'show_ui' => true,
	        'show_admin_column' => true,
	        'query_var' => true,
	    ));
	}
	
?>