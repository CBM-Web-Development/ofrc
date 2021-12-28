<?php 

define('OFRC_PATH', get_template_directory());
define('OFRC_URI', get_template_directory_uri());
define('OFRC_TEXTDOMAIN', 'ofrc');
define('OFRC_VERSION', '0.0.1');


// Functions - REQUIRED
include(OFRC_PATH . '/includes/functions/functions-assets.php');
include(OFRC_PATH . '/includes/functions/functions-menus.php');
include(OFRC_PATH . '/includes/functions/functions-sidebars.php');
include(OFRC_PATH . '/includes/functions/functions-supports.php');

// Walkers - REQUIRED
include(OFRC_PATH . '/includes/walkers/class-bootstrap-5-walker.php');