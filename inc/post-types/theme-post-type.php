<?php 

add_action( 'init', 'create_post_type' );

function create_post_type() {

require_once('post/slide.php');
require_once('masjid/takmir.php');
require_once('post/agenda.php');
require_once('post/pengumuman.php');	
require_once('post/tausiyah.php');

require_once('jadwal/jumat.php');

require_once('laporan/infaq.php');
require_once('laporan/rekening.php');
require_once('laporan/wakaf.php');

require_once('masjid/lembaga.php');
require_once('masjid/layanan.php');
require_once('masjid/inventaris.php');
require_once('masjid/perpustakaan.php');
	
require_once('post/galeri.php');	
require_once('post/video.php');
}

require_once('theme-taxonomy.php');

?>