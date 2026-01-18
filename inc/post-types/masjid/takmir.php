<?php 
    if ( get_theme_mod('opsi_editor') != "false" ) {
	    $showinrest = true;
	} else {
	    $showinrest = false;
    }
	register_post_type( 'takmir',		
	array(			
	    'menu_icon' => 'dashicons-feedback',
		'labels' => array(				
	        'name'               => __( 'Takmir', 'wp-masjid' ),
			'singular_name'      => __( 'Takmir', 'wp-masjid' ),			
	    ),		                	
		'public'               => true,           					            
		'has_archive'          => true,        			            
		'supports'             => array( 'title', 'editor', 'thumbnail'),            			            
		'exclude_from_search'  => false,
		'show_in_rest'         => $showinrest,
	)	
    );
	
	add_action('admin_init', 'tak_metabox', 2);
	function tak_metabox() {
	    add_meta_box('masjid_tak', __('Position', 'wp-masjid'), 'masjid_tak', 'takmir', 'normal', 'default');
	}

	function masjid_tak() {
	    global $post;
	    echo '<input type="hidden" name="takmirmeta_noncename" id="takmirmeta_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	    
		$jabat = get_post_meta($post->ID, '_jabat', true);
		?>
		
		<div class="wm_metaabox">
	    	<p><?php echo __('Position in the management structure', 'wp-masjid'); ?></p>
	        <input type="text" name="_jabat" value="<?php echo esc_attr( $jabat ); ?>" class="widefat" />
		</div>
		
		<?php
	}

	function masjid_tak_meta($post_id, $post) {

	    if ( !isset( $_POST['takmirmeta_noncename'] ) || !wp_verify_nonce( $_POST['takmirmeta_noncename'], plugin_basename(__FILE__) )) {
			return $post->ID;
		}

	    if ( !current_user_can( 'edit_post', $post->ID ))

	        return $post->ID;

	    $events_meta['_jabat'] = $_POST['_jabat'];

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

	add_action('save_post', 'masjid_tak_meta', 1, 2); 