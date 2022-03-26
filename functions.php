<?php 

define('OFRC_PATH', get_template_directory());
define('OFRC_URI', get_template_directory_uri());
define('OFRC_TEXTDOMAIN', 'ofrc');
define('OFRC_VERSION', '0.0.1');


// Functions - REQUIRED
include(OFRC_PATH . '/includes/functions/functions-acf.php');
include(OFRC_PATH . '/includes/functions/functions-assets.php');
include(OFRC_PATH . '/includes/functions/functions-localize.php');
include(OFRC_PATH . '/includes/functions/functions-menus.php');
include(OFRC_PATH . '/includes/functions/functions-posts.php');
include(OFRC_PATH . '/includes/functions/functions-sidebars.php');
include(OFRC_PATH . '/includes/functions/functions-supports.php');

// Classes
include(OFRC_PATH . '/includes/classes/class-rest.php');
include(OFRC_PATH . '/includes/classes/class-member-profiles.php');
include(OFRC_PATH . '/includes/classes/class-notifications-banner.php');

// Walkers - REQUIRED
include(OFRC_PATH . '/includes/walkers/class-bootstrap-5-walker.php');
include(OFRC_PATH . '/includes/walkers/class-bootstrap-5-sidebar-walker.php');

foreach(glob(OFRC_PATH . '/includes/acf/groups/*_active.php') as $file){
	include($file);
}
