<?php
/*
 * @see https://make.wordpress.org/core/2015/07/02/deprecating-php4-style-constructors-in-wordpress-4-3/
 */
// All will give an ERROR.
// 4.3
WP_Widget::WP_Widget();
parent::WP_Widget();
$this->WP_Widget();

// 4.2
WP_Widget_Factory::WP_Widget_Factory();
parent::WP_Widget_Factory();
$this->WP_Widget_Factory();

// These examples are OK as they not methods.
$this->WP_Widget_Factory;
function WP_Widget_Factory() {

}
