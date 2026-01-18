<?php 
	if ( get_theme_mod('opsi_editor') != "false" ) {
	    $showinrest = true;
	} else {
	    $showinrest = false;
    }
	register_post_type( 'inventaris',		
	array(			
	    'menu_icon' => 'dashicons-format-aside',
		'labels' => array(				
	        'name'               => __( 'Inventory', 'wp-masjid' ),
			'singular_name'      => __( 'Inventory', 'wp-masjid' ),			
	    ),		                	
		'public'               => true,           					            
		'has_archive'          => true,        			            
		'supports'             => array( 'title', 'editor', 'thumbnail'),            			            
		'exclude_from_search'  => false,
		'show_in_rest'         => $showinrest,
	)	
    );
	
	add_action('admin_init', 'inv_meta_boxes', 2);
	function inv_meta_boxes() {
    	add_meta_box( 'inv-fields', __('Inventory List', 'wp-admin'), 'inv_meta_box_display', 'inventaris', 'normal', 'default');
    }

	function inv_meta_box_display() {
    	global $post;
    	$inv_fields = get_post_meta($post->ID, 'inv_fields', true);
    	wp_nonce_field( 'inv_meta_box_nonce', 'inv_meta_box_nonce' );
    	?>
    
    	<script type="text/javascript">
         	jQuery(document).ready(function( $ ){
    	    	$( '#add-row' ).on('click', function() {
		        	var row = $( '.empty-row.screen-reader-text' ).clone(true);
		        	row.removeClass( 'empty-row screen-reader-text' );
		        	row.insertBefore( '#inv-fieldset-one tbody>tr:last' );
		        	return false;
	        	});
				$( '.remove-row' ).on('click', function() {
		        	$(this).parents('tr').remove();
		        	return false;
	        	});
        	});
    	</script>
		
    	<table width="100%" id="inv-fieldset-one">
		    <tr>
				<td><?php echo __( 'Name', 'wp-masjid' ); ?></td>
				<td><?php echo __( 'Count', 'wp-masjid' ); ?></td>
				<td><?php echo __( 'Good', 'wp-masjid' ); ?></td>
				<td><?php echo __( 'Broken', 'wp-masjid' ); ?></td>
				<td width="30">x</td>
			</tr>
			
         	<?php if ( $inv_fields ) :
			foreach ( $inv_fields as $field ) { ?>
             	<tr>
					<td>
					    <input type="text" placeholder="<?php echo esc_attr_e( 'Name', 'wp-masjid' ); ?>" class="tanggal widefat" name="namainv[]" value="<?php if($field['namainv'] != '') echo esc_attr( $field['namainv'] ); ?>" />
					</td>
					<td>
					    <input type="text" placeholder="<?php echo esc_attr_e( 'Count', 'wp-masjid' ); ?>" class="widefat" name="jumlahinv[]" value="<?php if($field['jumlahinv'] != '') echo esc_attr( $field['jumlahinv'] ); ?>" />
					</td>
					<td>
					    <input type="text" placeholder="..." class="widefat" name="kondisiinv[]" value="<?php if($field['kondisiinv'] != '') echo esc_attr( $field['kondisiinv'] ); ?>" />
					</td>
					<td>
					    <input type="text" placeholder="..." class="widefat" name="rusak[]" value="<?php if($field['rusak'] != '') echo esc_attr( $field['rusak'] ); ?>" />
					</td>
					<td>
					    <a class="button remove-row" href="#">x</a>
					</td>
				</tr>
				
			<?php } else : ?>
			
	    		<tr>
            		<td>
					    <input type="text" placeholder="<?php echo esc_attr_e( 'Name', 'wp-masjid' ); ?>" class="widefat" name="namainv[]" />
					</td>
					<td>
					    <input type="text" placeholder="<?php echo esc_attr_e( 'Count', 'wp-masjid' ); ?>" class="widefat" name="jumlahinv[]" />
					</td>
					<td>
					    <input type="text" placeholder="..." class="widefat" name="kondisiinv[]" />
					</td>
					<td>
					    <input type="text" placeholder="..." class="widefat" name="rusak[]" />
					</td>
					<td>
					    <a class="button remove-row" href="#">x</a>
					</td>
				</tr>
				
			<?php endif; ?>
	
            	<!-- empty hidden one for jQuery -->
            	<tr class="empty-row screen-reader-text">
            		<td>
					    <input type="text" placeholder="<?php echo esc_attr_e( 'Name', 'wp-masjid' ); ?>" class="widefat" name="namainv[]" />
					</td>
					<td>
					    <input type="text" placeholder="<?php echo esc_attr_e( 'Count', 'wp-masjid' ); ?>" class="widefat" name="jumlahinv[]" />
					</td>
					<td>
					    <input type="text" placeholder="..." class="widefat" name="kondisiinv[]" />
					</td>
					<td>
					    <input type="text" placeholder="..." class="widefat" name="rusak[]" />
					</td>
					<td>
					    <a class="button remove-row" href="#">x</a>
					</td>
				</tr>
		</table>
		
		<table>
		        <tr>
			        <td>
					    <a id="add-row" class="button button-primary button-large" href="#"><?php echo __( 'Add New', 'wp-masjid' ); ?></a></div> 
					</td>
				</tr>
		</table>
	
    	<?php
    }

	add_action('save_post', 'inv_meta_box_save');

	function inv_meta_box_save($post_id) {
    	if ( ! isset( $_POST['inv_meta_box_nonce'] ) ||
        	! wp_verify_nonce( $_POST['inv_meta_box_nonce'], 'inv_meta_box_nonce' ) )
	    	return;
	
    	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
	    	return;
	
    	if (!current_user_can('edit_post', $post_id))
	    	return;
	
    	$old = get_post_meta($post_id, 'inv_fields', true);
    	$new = array();
	
    	$pnamainv    = $_POST['namainv'];
    	$pjumlahinv  = $_POST['jumlahinv'];
		$pkondisiinv = $_POST['kondisiinv'];
		$prusak      = $_POST['rusak'];
	
    	$count = count( $pnamainv );
	
    	for ( $i = 0; $i < $count; $i++ ) {
	    	if ( $pnamainv[$i] != '' ) {
	    		$new[$i]['namainv'] = stripslashes( $pnamainv[$i] );
		        $new[$i]['jumlahinv'] = stripslashes( $pjumlahinv[$i] ); 
				$new[$i]['kondisiinv'] = stripslashes( $pkondisiinv[$i] ); 
				$new[$i]['rusak'] = stripslashes( $prusak[$i] ); 
	    	}
    	}
		
    	if ( !empty( $new ) && $new != $old )
    		update_post_meta( $post_id, 'inv_fields', $new );
    	elseif ( empty($new) && $old )
    		delete_post_meta( $post_id, 'inv_fields', $old );
	}