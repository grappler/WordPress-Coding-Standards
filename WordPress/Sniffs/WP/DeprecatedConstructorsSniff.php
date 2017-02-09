<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Check for usage of deprecated hooks.
 *
 * This sniff will throw an error when usage of deprecated hook is
 * detected if the hook was deprecated before the minimum supported
 * WP version; a warning otherwise.
 * By default, it is set to presume that a project will support the current
 * WP version and up to three releases before.
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.11.0
 */
 class WordPress_Sniffs_WP_DeprecatedConstructorsSniff extends WordPress_AbstractMethodRestrictionsSniff {

 	/**
 	 * Groups of functions to restrict.
 	 *
 	 * Example: groups => array(
 	 * 	'lambda' => array(
 	 * 		'type'      => 'error' | 'warning',
 	 * 		'message'   => 'Use anonymous functions instead please!',
 	 * 		'functions' => array( 'file_get_contents', 'create_function' ),
 	 * 	)
 	 * )
 	 *
 	 * @return array
 	 */
 	public function getGroups() {
 		return array(
 			'wp_widget' => array(
 				'type'      => 'warning',
 				'message'   => 'WP_Widget::%s() is deprecated since WordPress version 4.3. Use WP_Widget::__construct() instead.',
 				'functions' => array(
 					'WP_Widget',
 				),
 			),

 			'wp_widget_factory' => array(
 				'type'      => 'warning',
 				'message'   => 'WP_Widget_Factory::%s() deprecated since WordPress version 4.2. Use the WP_Widget_Factory::__construct() instead.',
 				'functions' => array(
 					'WP_Widget_Factory',
 				),
 			),

 		);
 	} // end getGroups()

 } // end class
