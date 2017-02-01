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
class WordPress_Sniffs_WP_DeprecatedHooksSniff extends WordPress_AbstractFunctionParameterSniff {

	/**
	 * The group name for this group of functions.
	 *
	 * @since 0.11.0
	 *
	 * @var string
	 */
	protected $group_name = 'wp_deprecated_hooks';

	/**
	 * Minimum WordPress version.
	 *
	 * This variable allows changing the minimum supported WP version used by
	 * this sniff by setting a property in a custom ruleset xml file.
	 * Last updated: WordPress 4.7
	 *
	 * Example usage:
	 * <rule ref="WordPress.WP.DeprecatedParameters">
	 *  <properties>
	 *   <property name="minimum_supported_version" value="4.4"/>
	 *  </properties>
	 * </rule>
	 *
	 * @since 0.11.0
	 *
	 * @var string WordPress version.
	 */
	public $minimum_supported_version = 4.4;

	/**
	 * Array of function, argument, and replacement function for deprecated argument.
	 *
	 * @since 0.11.0
	 *
	 * @var array Multi-dimentional array with parameter details.
	 *
	 *               @type string Function name. {
	 *                   @type int target Parameter positions. {
	 *                       @type string|boolean|null  Default value.
	 *                       @type int The WordPress version when deprecated.
	 *                   }
	 *               }
	 */
	protected $target_functions = array(

		'add_filter' => array(
			'blog_details' => array(
				'version' => '4.7',
				'alt'     => 'site_details',
			),
			'rest_enabled' => array(
				'version' => '4.7',
				'alt'     => 'rest_authentication_errors',
			),
		),
		'add_action' => array(),

	); // End $target_functions.

	/**
	 * Process the parameters of a matched function.
	 *
	 * @since 0.11.0
	 *
	 * @param int    $stackPtr        The position of the current token in the stack.
	 * @param array  $group_name      The name of the group which was matched.
	 * @param string $matched_content The token content (function name) which was matched.
	 * @param array  $parameters      Array with information about the parameters.
	 *
	 * @return void
	 */
	public function process_parameters( $stackPtr, $group_name, $matched_content, $parameters ) {

		if ( ! isset( $parameters[1] ) ) {
			return;
		}

		$matched_parameter = $this->strip_quotes( $parameters[1]['raw'] );

		if ( ! isset( $this->target_functions[ $matched_content ][ $matched_parameter ] ) ) {
			return;
		}

		$message = 'The hook [%s] has been deprecated since WordPress version %s.';
		$data    = array(
			$matched_parameter,
			$this->target_functions[ $matched_content ][ $matched_parameter ]['version'],
		);

		if ( ! empty( $this->target_functions[ $matched_content ][ $matched_parameter ]['alt'] ) ) {
			$message .= ' Use "%s" instead.';
			$data[]   = $this->target_functions[ $matched_content ][ $matched_parameter ]['alt'];
		}

		$is_error = version_compare( $this->target_functions[ $matched_content ][ $matched_parameter ]['version'], $this->minimum_supported_version, '<' );

		$this->addMessage( $message, $stackPtr, $is_error, $matched_content . 'Found', $data, 0 );
	} // End process_parameters().

}
