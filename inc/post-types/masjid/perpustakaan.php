<?php 
    if ( get_theme_mod('opsi_editor') != "false" ) {
	    $showinrest = true;
	} else {
	    $showinrest = false;
    }
	register_post_type( 'perpustakaan',		
	array(			
	    'menu_icon' => 'dashicons-book',
		'labels' => array(				
	        'name'               => __( 'Library', 'wp-masjid' ),
			'singular_name'      => __( 'Library', 'wp-masjid' ),		
	    ),		                	
		'public'               => true,           					            
		'has_archive'          => true,        			            
		'supports'             => array( 'title', 'editor', 'thumbnail'),            			            
		'exclude_from_search'  => false,
		'show_in_rest'         => $showinrest,
	)	
    );
	
	add_action('admin_init', 'perpus', 2);
	function perpus() {
	    add_meta_box('masjid_perpus', __('Book Catalog', 'wp-masjid'), 'masjid_perpus', 'perpustakaan', 'normal', 'default');
	}

	function masjid_perpus() {
	    global $post;
	    echo '<input type="hidden" name="librarymeta_noncename" id="librarymeta_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $penulis    = get_post_meta($post->ID, '_penulis', true);
	    $penerbit   = get_post_meta($post->ID, '_penerbit', true);
		$halaman    = get_post_meta($post->ID, '_halaman', true);
		$jumlahbuku = get_post_meta($post->ID, '_jumlahbuku', true);
		?>
		
		<div class="wm_metaabox">
	    	<p><?php echo esc_html_e('Author', 'wp-masjid'); ?></p>
	        <input type="text" name="_penulis" value="<?php echo esc_attr( $penulis ); ?>" class="widefat" />
	        <p><?php echo esc_html_e('Publisher', 'wp-masjid'); ?></p>
	        <input type="text" name="_penerbit" value="<?php echo esc_attr( $penerbit ); ?>" class="widefat" />
			<p><?php echo esc_html_e('Page count', 'wp-masjid'); ?></p>
	        <input type="text" name="_halaman" value="<?php echo esc_attr( $halaman ); ?>" class="widefat" />
			<p><?php echo esc_html_e('Book count', 'wp-masjid'); ?></p>
	        <input type="text" name="_jumlahbuku" value="<?php echo esc_attr( $jumlahbuku ); ?>" class="widefat" />
		</div>
		
		<?php
	}

	function masjid_perpus_meta($post_id, $post) {

	    if ( !isset( $_POST['librarymeta_noncename'] ) || !wp_verify_nonce( $_POST['librarymeta_noncename'], plugin_basename(__FILE__) )) {
			return $post->ID;
		}

	    if ( !current_user_can( 'edit_post', $post->ID ))

	        return $post->ID;

        $perpus_meta['_penulis']    = $_POST['_penulis'];
		$perpus_meta['_penerbit']   = $_POST['_penerbit'];
		$perpus_meta['_halaman']    = $_POST['_halaman'];
		$perpus_meta['_jumlahbuku'] = $_POST['_jumlahbuku'];

	    foreach ($perpus_meta as $key => $value) {        
		    if( $post->post_type == 'revision' ) return;
	        $value = implode(',', (array)$value); 
	        if(get_post_meta($post->ID, $key, FALSE)) {
	            update_post_meta($post->ID, $key, $value);
	        } else { 
	            add_post_meta($post->ID, $key, $value);
	        }
	        if(!$value) delete_post_meta($post->ID, $key);
	    }

	}

	add_action('save_post', 'masjid_perpus_meta', 1, 2);