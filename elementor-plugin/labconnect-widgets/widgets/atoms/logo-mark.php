<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Logo Mark — the bridge icon drawn as SVG (bullet, badge, divider). */
class Logo_Mark extends Base_Widget {
	public function get_name() { return 'lc-logo-mark'; }
	public function get_title() { return 'LC Logo Mark'; }
	public function get_icon() { return 'eicon-favorite'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Logo Mark' );
		$this->c_switch( 'on_dark', 'On dark background' );
		$this->lc_align( 'align', '&', 'text' );
		$this->end_controls_section();

		$this->style_section( 'mark', 'Logo Mark' );
		$this->lc_slider( 'mark_size', 'Size', '.lc-logomark', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 400 );
		$this->lc_color( 'mark_node', 'Node color', $this->sel( '.lc-logomark__node' ), 'fill' );
		$this->lc_color( 'mark_line', 'Lines + ring color', $this->sel( '.lc-logomark__link, .lc-logomark__ring' ), 'stroke' );
		$this->lc_color( 'mark_hub', 'Hub color', $this->sel( '.lc-logomark__hub' ), 'fill' );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::logomark( R::yes( $s['on_dark'] ) ) );
	}
}
