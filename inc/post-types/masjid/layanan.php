<?php 
    if ( get_theme_mod('opsi_editor') != "false" ) {
	    $showinrest = true;
	} else {
	    $showinrest = false;
    }
	register_post_type( 'layanan',		
	array(			
	    'menu_icon' => 'dashicons-share',
		'labels' => array(				
	        'name'               => __( 'Service', 'wp-masjid' ),
			'singular_name'      => __( 'Service', 'wp-masjid' ),		
	    ),		                	
		'public'               => true,           					            
		'has_archive'          => true,        			            
		'supports'             => array( 'title', 'editor', 'thumbnail'),            			            
		'exclude_from_search'  => false,
		'show_in_rest'         => $showinrest,
	)	
    );
	
	add_action('admin_init', 'pelayanan', 2);
	function pelayanan() {
	    add_meta_box('masjid_layanan', __('Mosque Service', 'wp-masjid'), 'masjid_layanan', 'layanan', 'normal', 'core');
	}

	function masjid_layanan() {
	    global $post;
	    echo '<input type="hidden" name="layananmeta_noncename" id="layananmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
		
		$hubungi   = get_post_meta($post->ID, '_hubungi', true);
		$informasi = get_post_meta($post->ID, '_informasi', true);
		?>
		
		<div class="wm_metaabox">
			<p><?php echo __('Officer (Name of the officer to contact)', 'wp-masjid'); ?></p>
			<input type="text" name="_hubungi" value="<?php echo esc_attr( $hubungi ); ?>" class="widefat" />
			<p><?php echo __('Phone', 'wp-masjid'); ?></p>
			<input type="text" name="_informasi" value="<?php echo esc_attr( $informasi ); ?>" class="widefat" />
		</div>
		
		<?php
	}

	function layanan_meta_boxes($post_id, $post) {
	    if ( !isset( $_POST['layananmeta_noncename'] ) || !wp_verify_nonce( $_POST['layananmeta_noncename'], plugin_basename(__FILE__) )) {
			return $post->ID;
		}

	    if ( !current_user_can( 'edit_post', $post->ID ))
	        return $post->ID;

		$layanan_meta['_hubungi']   = $_POST['_hubungi'];
		$layanan_meta['_informasi'] = $_POST['_informasi'];

	    foreach ($layanan_meta as $key => $value) {      
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

	add_action('save_post', 'layanan_meta_boxes', 1, 2);