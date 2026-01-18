<?php
	if ( get_theme_mod('opsi_editor') != "false" ) {
	    $showinrest = true;
	} else {
	    $showinrest = false;
    }
	register_post_type( 'wakaf',		
	array(			
	    'menu_icon' => 'dashicons-book-alt',
		'labels' => array(				
	        'name'               => __( 'Wakaf Report', 'wp-masjid' ),
			'singular_name'      => __( 'Wakaf Report', 'wp-masjid' ),		
	    ),		                	
		'public'               => true,           					            
		'has_archive'          => true,        			            
		'supports'             => array( 'title', 'editor', 'thumbnail'),            			            
		'exclude_from_search'  => false,
		'show_in_rest'         => $showinrest,
	)	
    );
	
	add_action('admin_init', 'lap_wakaf', 1);
	function lap_wakaf() {
	    add_meta_box('masjid_wakaf', __('Wakaf Report', 'wp-masjid'), 'masjid_wakaf', 'wakaf', 'normal', 'default');
	}

	function masjid_wakaf() {
	    global $post;
	    echo '<input type="hidden" name="wakafmeta_noncename" id="wakafmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $tangwakaf = get_post_meta($post->ID, '_tangwakaf', true);
	    $jumwakaf  = get_post_meta($post->ID, '_jumwakaf', true);
		$asalwakaf = get_post_meta($post->ID, '_asalwakaf', true);
		?>
		
		<div class="wm_metaabox">
			<p><?php echo __('Complete the latest wakaf report data below', 'wp-masjid'); ?><br/></p>
			<p><?php echo __('Date', 'wp-masjid'); ?></p>
	        <input type="date" name="_tangwakaf" value="<?php echo esc_attr( $tangwakaf ); ?>" class="tanggal widefat" />
	        <p><?php echo __('Description', 'wp-masjid'); ?></p>
	        <input type="text" name="_jumwakaf" value="<?php echo esc_attr( $jumwakaf ); ?>" class="widefat" />
			<p><?php echo __('From (example : Jakarta)', 'wp-masjid'); ?></p>
	        <input type="text" name="_asalwakaf" value="<?php echo esc_attr( $asalwakaf ); ?>" class="widefat" />
		</div>
		
		<?php
	}

	function masjid_wakaf_meta($post_id, $post) {
	    if ( !isset( $_POST['wakafmeta_noncename'] ) || !wp_verify_nonce( $_POST['wakafmeta_noncename'], plugin_basename(__FILE__) )) {
			return $post->ID;
		}

	    if ( !current_user_can( 'edit_post', $post->ID ))
	        return $post->ID;

	    $events_meta['_tangwakaf'] = $_POST['_tangwakaf'];
		$events_meta['_jumwakaf']  = $_POST['_jumwakaf'];
		$events_meta['_asalwakaf'] = $_POST['_asalwakaf'];

	    foreach ($events_meta as $key => $value) {         
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

	add_action('save_post', 'masjid_wakaf_meta', 1, 2); 