<?php 
    if ( get_theme_mod('opsi_editor') != "false" ) {
	    $showinrest = true;
	} else {
	    $showinrest = false;
    }
	register_post_type( 'lembaga',		
	array(			
	    'menu_icon' => 'dashicons-feedback',
		'labels' => array(				
	        'name'               => __( 'Institution', 'wp-masjid' ),
			'singular_name'      => __( 'Institution', 'wp-masjid' ),		
	    ),		                	
		'public'               => true,           					            
		'has_archive'          => true,        			            
		'supports'             => array( 'title', 'editor', 'thumbnail'),            			            
		'exclude_from_search'  => false,
		'show_in_rest'         => $showinrest,
	)	
    );
	
	add_action('admin_init', 'pengurus_lembaga', 2);
	function pengurus_lembaga() {
    	add_meta_box( 'list_pengurus', __('Management List', 'wp-masjid'), 'list_pengurus', 'lembaga', 'normal', 'default');
    }

	function list_pengurus() {
    	global $post;
    	$pengurus_fields = get_post_meta($post->ID, 'pengurus_fields', true);
    	wp_nonce_field( 'pengurus_noncemeta', 'pengurus_noncemeta' );
    	?>
    
    	<script type="text/javascript">
     	jQuery(document).ready(function( $ ){
    		$( '#add-row' ).on('click', function() {
		    	var row = $( '.empty-row.screen-reader-text' ).clone(true);
		    	row.removeClass( 'empty-row screen-reader-text' );
		    	row.insertBefore( '#pengurus-fieldset-one tbody>tr:last' );
		    	return false;
	    	});
  	
	    	$( '.remove-row' ).on('click', function() {
		    	$(this).parents('tr').remove();
		    	return false;
	    	});
     	});
    	</script>
		
    	<table id="pengurus-fieldset-one">
		    <tr>
				<td><?php echo __('Name', 'wp-masjid'); ?></td>
				<td><?php echo __('Position', 'wp-masjid'); ?></td>
				<td width="30">x</td>
			</tr>
			
         	<?php if ( $pengurus_fields ) :
			foreach ( $pengurus_fields as $field ) { ?>
             	<tr>
					<td>
					    <input type="text" placeholder="<?php echo esc_attr_e('Name', 'wp-masjid'); ?>" class="tanggal widefat" name="namape[]" value="<?php if($field['namape'] != '') echo esc_attr( $field['namape'] ); ?>" />
					</td>
					<td>
					    <input type="text" placeholder="<?php echo esc_attr_e('Position', 'wp-masjid'); ?>" class="widefat" name="tugas[]" value="<?php if($field['tugas'] != '') echo esc_attr( $field['tugas'] ); ?>" />
					</td>
					<td>
					    <a class="button remove-row" href="#">x</a>
					</td>
				</tr>
				
			<?php } else : ?>
			
	    		<tr>
            		<td>
					    <input type="text" placeholder="<?php echo esc_attr_e('Name', 'wp-masjid'); ?>" class="namape widefat" name="namape[]" />
					</td>
					<td>
					    <input type="text" placeholder="<?php echo esc_attr_e('Position', 'wp-masjid'); ?>" class="widefat" name="tugas[]" />
					</td>
					<td>
					    <a class="button remove-row" href="#">x</a>
					</td>
				</tr>
				
			<?php endif; ?>
	
            	<!-- empty hidden one for jQuery -->
            	<tr class="empty-row screen-reader-text">
            		<td>
					    <input type="text" placeholder="<?php echo esc_attr_e('Name', 'wp-masjid'); ?>" class="widefat" name="namape[]" />
					</td>
					<td>
					    <input type="text" placeholder="<?php echo esc_attr_e('Position', 'wp-masjid'); ?>" class="widefat" name="tugas[]" />
					</td>
					<td>
					    <a class="button remove-row" href="#">x</a>
					</td>
				</tr>
		</table>
		
		<table>
		        <tr>
			        <td>
					    <a id="add-row" class="button button-primary button-large" href="#"><?php echo esc_html_e('Add New', 'wp-masjid'); ?></a></div> 
					</td>
				</tr>
		</table>
	
    	<?php
    }

	add_action('save_post', 'lembaga_meta_save');

	function lembaga_meta_save($post_id) {
    	if ( ! isset( $_POST['pengurus_noncemeta'] ) ||
        	! wp_verify_nonce( $_POST['pengurus_noncemeta'], 'pengurus_noncemeta' ) )
	    	return;
	
    	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
	    	return;
	
    	if (!current_user_can('edit_post', $post_id))
	    	return;
	
    	$old = get_post_meta($post_id, 'pengurus_fields', true);
    	$new = array();
	
    	$pnamape = $_POST['namape'];
    	$ptugas  = $_POST['tugas'];
	
    	$count = count( $pnamape );
	
    	for ( $i = 0; $i < $count; $i++ ) {
	    	if ( $pnamape[$i] != '' ) {
	    		$new[$i]['namape'] = stripslashes( $pnamape[$i] );
		        $new[$i]['tugas'] = stripslashes( $ptugas[$i] ); 
	    	}
    	}
		
    	if ( !empty( $new ) && $new != $old )
    		update_post_meta( $post_id, 'pengurus_fields', $new );
    	elseif ( empty($new) && $old )
    		delete_post_meta( $post_id, 'pengurus_fields', $old );
	}