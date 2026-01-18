<?php
// Adapted from wm-post/theme-post-type.php

add_action('init', 'mrty_create_post_types');

function mrty_create_post_types()
{
    $base_path = dirname(__FILE__);

    require_once($base_path . '/post/slide.php');
    require_once($base_path . '/masjid/takmir.php');
    require_once($base_path . '/post/agenda.php');
    require_once($base_path . '/post/pengumuman.php');
    require_once($base_path . '/post/tausiyah.php');

    require_once($base_path . '/jadwal/jumat.php');

    require_once($base_path . '/laporan/infaq.php');
    require_once($base_path . '/laporan/rekening.php');
    require_once($base_path . '/laporan/wakaf.php');

    require_once($base_path . '/masjid/lembaga.php');
    require_once($base_path . '/masjid/layanan.php');
    require_once($base_path . '/masjid/inventaris.php');
    require_once($base_path . '/masjid/perpustakaan.php');

    require_once($base_path . '/post/galeri.php');
    require_once($base_path . '/post/video.php');

    // Load Taxonomies
    require_once($base_path . '/theme-taxonomy.php');
}
