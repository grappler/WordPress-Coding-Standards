<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Restricts usage of some functions.
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.11.0
 */
abstract class WordPress_AbstractMethodRestrictionsSniff extends WordPress_AbstractFunctionRestrictionsSniff {

	/**
	 * Verify is the current token is a function call.
	 *
	 * @since 0.11.0 Split out from the `process()` method.
	 *
	 * @param int $stackPtr The position of the current token in the stack.
	 *
	 * @return bool
	 */
	public function is_targetted_token( $stackPtr ) {

		if ( T_STRING === $this->tokens[ $stackPtr ]['code'] && isset( $this->tokens[ ( $stackPtr - 1 ) ] ) ) {

			$maybe_method = $this->phpcsFile->findPrevious( array( T_DOUBLE_COLON, T_OBJECT_OPERATOR ), ( $stackPtr - 1 ), null, false, null, true );

			// Check if it looks like a method.
			if ( ! $maybe_method ) {
				return false;
			}

			$bracket = $this->phpcsFile->findNext( PHP_CodeSniffer_Tokens::$emptyTokens, ( $stackPtr + 1 ), null, true, null, true );

			// Check that it is a method and not a property.
			if ( T_OPEN_PARENTHESIS !== $this->tokens[ $bracket ]['code'] ) {
				return false;
			}

			return true;
		}

		return false;

	} // End is_targetted_token().

} // End class.
