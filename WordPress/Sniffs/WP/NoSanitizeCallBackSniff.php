<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Check thatsanitization is done correctly in the customizer.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#code
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_WP_NoSanitizeCallbackSniff extends WordPress_AbstractMethodParameterSniff {

	/**
	 * The group name for this group of functions.
	 *
	 * @since 0.11.0
	 *
	 * @var string
	 */
	protected $group_name = 'sanitize_callback';

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
		'add_setting' => 'sanitize_callback',
	);


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

		if ( ! isset( $parameters[2] ) ) {
			return;
		}

		$sanitize_callback_key = false;
		$next_token = $parameters[2]['start'];
		while ( $next_token = $this->phpcsFile->findNext( array( T_CONSTANT_ENCAPSED_STRING ), ( $next_token + 1 ), $parameters[2]['end'], false, null, true ) ) {

			if ( $next_token > $parameters[2]['end'] ) {
				$sanitize_callback_key = false;
				break;
			}

			if ( strpos( $this->tokens[ $next_token ]['content'], 'sanitize_callback' ) !== false ) {
				$sanitize_callback_key = $next_token;
				break;
			}
		}

		if ( ! $sanitize_callback_key ) {
			$this->phpcsFile->addError( 'add_setting is missing the sanitize_callback parameter', $stackPtr, 'NoSanitizeCallbackFound' );
			return;
		}

		$sanitize_callback_value = $this->phpcsFile->findNext( array( T_WHITESPACE, T_DOUBLE_ARROW ), ( $sanitize_callback_key + 1 ), null, true, null, true );

		if ( ! $sanitize_callback_value ) {
			$this->phpcsFile->addError( 'there is no sanitize_callback defined', $stackPtr, 'NoSanitizeCallbackFound' );
		}

		if ( T_CONSTANT_ENCAPSED_STRING === $this->tokens[ $sanitize_callback_value ]['code'] ) {

			$value = $this->strip_quotes( $this->tokens[ $sanitize_callback_value ]['content'] );
			if ( empty( $value ) ) {
				$this->phpcsFile->addError( 'The sanitize_callback parameter cannot be an empty string.', $sanitize_callback_key, 'NoSanitizeCallbackFound' );
				return;
			}

			if ( isset( $this->sanitizingFunctions[ $value ] ) || isset( $this->unslashingSanitizingFunctions[ $value ] ) ) {
				return;
			}

			$this->phpcsFile->addWarning( 'The sanitize_callback parameter is not a know WordPress function. Check that %s is being used correctly.', $sanitize_callback_key, 'NoSanitizeCallbackFound', array( $value ) );
			return;
		}

		$this->phpcsFile->addWarning( 'The sanitize_callback parameter dynamic. Check that is used correctly.', $sanitize_callback_key, 'NoSanitizeCallbackFound' );
	}

}
