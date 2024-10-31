<?php

$base_dir = dirname( __DIR__ );

$classes = array(
    'HelpCenter_Intergrations\\HelpCenter_Client'                        => $base_dir . '/src/help-center-client.php',
	'HelpCenter_Intergrations\\Source'                        => $base_dir . '/src/source.php',
	'HelpCenter_Intergrations\\Source\\WP_Foro_Origin'               => $base_dir . '/src/source/wpforo.php',
	'HelpCenter_Intergrations\\Source\\BP_Members_Origin'               => $base_dir . '/src/source/bp-members.php',
	'HelpCenter_Intergrations\\Source\\AVIOG_Videos_Origin'               => $base_dir . '/src/source/aviog-videos.php',
	'HelpCenter_Intergrations\\Source\\LD_Lesson_Origin'               => $base_dir . '/src/source/sfwd-lessons.php',
	'HelpCenter_Intergrations\\Source\\LD_Courses_Origin'               => $base_dir . '/src/source/sfwd-courses.php',
	'HelpCenter_Intergrations\\Source\\BP_Groups_Origin'               => $base_dir . '/src/source/bp-groups.php',
	'HelpCenter_Intergrations\\Source\\CL_Podcasts_Origin'               => $base_dir . '/src/source/cl-podcasts.php',
);

spl_autoload_register(
	function ( $class ) use ( $classes ) {
		if ( isset( $classes[ $class ] ) ) {
			require_once $classes[ $class ];
		}
	}
);
