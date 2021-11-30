<?php 

define('OFRC_PATH', get_template_directory());
define('OFRC_URI', get_template_directory_uri());
define('OFRC_TEXTDOMAIN', 'ofrc');
define('OFRC_VERSION', '0.0.1');


// Functions - REQUIRED

// Walkers - REQUIRED
include(OFRC_PATH . '/includes/walkers/class-bootstrap-5-walker.php');