<?php 
	if ( get_theme_mod('opsi_editor') != "false" ) {
	    $showinrest = true;
	} else {
	    $showinrest = false;
    }
	register_post_type( 'jadwal-jumat',		
	array(			
	    'menu_icon' => 'dashicons-calendar-alt',
		'labels' => array(				
	        'name'               => __( 'Friday Schedule', 'wp-masjid' ),
			'singular_name'      => __( 'Friday Schedule', 'wp-masjid' ),			
	    ),		                	
		'public'               => true,           					            
		'has_archive'          => true,        			            
		'supports'             => array( 'title'),        			            
		'exclude_from_search'  => false,
		'show_in_rest'         => $showinrest,
	)	
    );
	
	add_action('admin_init', 'jumat_jadwal', 1);
	function jumat_jadwal() {
	    add_meta_box('jumat_events', __( 'Friday Schedule', 'wp-masjid' ), 'jumat_events', 'jadwal-jumat', 'normal', 'default');
	}

	function jumat_events() {
	    global $post;
	    echo '<input type="hidden" name="jumatmeta_noncename" id="jumatmeta_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
        
		$jminus   = strtotime(get_post_meta($post->ID, '_jevents', true).get_post_meta($post->ID, '_jjam', true));
	    $jevents  = get_post_meta($post->ID, '_jevents', true);
	    $jjam     = get_post_meta($post->ID, '_jjam', true);
		$jimam    = get_post_meta($post->ID, '_jimam', true);
		$jkhatib  = get_post_meta($post->ID, '_jkhatib', true);
		$jmuadzin = get_post_meta($post->ID, '_jmuadzin', true);
		$jbilal   = get_post_meta($post->ID, '_jbilal', true);
		?>
		
		<div class="wm_metaabox">
	    	<p><?php echo __('Date', 'wp-masjid'); ?></p>
	        <input type="date" name="_jevents" value="<?php echo esc_attr( $jevents ); ?>" class="jevents widefat" />
	        <p><?php echo __('Prayer Times (example 12:05)', 'wp-masjid'); ?></p>
	        <input type="time" name="_jjam" value="<?php echo esc_attr( $jjam ); ?>" class="widefat" />
			<p><?php echo __('Imam', 'wp-masjid'); ?></p>
	        <input type="text" name="_jimam" value="<?php echo esc_attr( $jimam ); ?>" class="widefat" />
			<p><?php echo __('Khatib', 'wp-masjid'); ?></p>
	        <input type="text" name="_jkhatib" value="<?php echo esc_attr( $jkhatib ); ?>" class="widefat" />
			<p><?php echo __('Muadzin', 'wp-masjid'); ?></p>
	        <input type="text" name="_jmuadzin" value="<?php echo esc_attr( $jmuadzin ); ?>" class="widefat" />
			<p><?php echo __('Bilal', 'wp-masjid'); ?></p>
	        <input type="text" name="_jbilal" value="<?php echo esc_attr( $jbilal ); ?>" class="widefat" />
		</div>
		
		<?php
	}

	function jadwal_jumat_meta($post_id, $post) {
	    if ( !isset( $_POST['jumatmeta_noncename'] ) || !wp_verify_nonce( $_POST['jumatmeta_noncename'], plugin_basename(__FILE__) )) {
			return $post->ID;
		}

	    if ( !current_user_can( 'edit_post', $post->ID ))
	        return $post->ID;
        
		$jadwal_meta['_jminus']   = strtotime($_POST['_jevents'].$_POST['_jjam']);
	    $jadwal_meta['_jevents']  = $_POST['_jevents'];
		$jadwal_meta['_jjam']     = $_POST['_jjam'];
		$jadwal_meta['_jimam']    = $_POST['_jimam'];
		$jadwal_meta['_jkhatib']  = $_POST['_jkhatib'];
		$jadwal_meta['_jmuadzin'] = $_POST['_jmuadzin'];
		$jadwal_meta['_jbilal']   = $_POST['_jbilal'];

	    foreach ($jadwal_meta as $key => $value) {         
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

	add_action('save_post', 'jadwal_jumat_meta', 1, 2); 