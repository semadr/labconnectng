<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Button — label, link, style, size, icon. */
class Button extends Base_Widget {
	public function get_name() { return 'lc-button'; }
	public function get_title() { return 'LC Button'; }
	public function get_icon() { return 'eicon-button'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Button' );
		$this->c_button( 'btn', [ 'label' => 'Start Your Project', 'link' => '#contact', 'icon' => 'arrow-right' ] );
		$this->c_switch( 'btn_block', 'Full width' );
		$this->lc_align( 'align', '&', 'text' );
		$this->end_controls_section();

		$this->lc_button_style( 'btn', 'Button', '.lc-btn' );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::button( $this->button_args( $s, 'btn', [ 'block' => R::yes( $s['btn_block'] ) ] ) ) );
	}
}
