<?php
/**
 * Unit test class for WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Unit test class for the DeprecatedConstructors sniff.
 *
 * @package WPCS\WordPressCodingStandards
 * @since   0.11.0
 */
class WordPress_Tests_WP_DeprecatedConstructorsUnitTest extends AbstractSniffUnitTest {

	/**
	 * Returns the lines where errors should occur.
	 *
	 * @return array <int line number> => <int number of errors>
	 */
	public function getErrorList() {
		return array();
	}

	/**
	 * Returns the lines where warnings should occur.
	 *
	 * @return array <int line number> => <int number of warnings>
	 */
	public function getWarningList() {
		return array(
			7  => 1,
			8  => 1,
			9  => 1,
			12 => 1,
			13 => 1,
			14 => 1,
		);
	}

} // End class.
