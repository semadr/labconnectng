<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Floating Note — small info card that can float. */
class Floating_Note extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-floating-note'; }
	public function get_title() { return 'LC Floating Note'; }
	public function get_icon() { return 'eicon-alert'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Note' );
		$this->c_icon( 'icon', 'Icon', 'flask' );
		$this->c_text( 'title', 'Title', 'R-VaaS · Research Visibility' );
		$this->c_text( 'subtitle', 'Subtitle', 'One paper. One story. Designed to be shared.' );
		$this->c_switch( 'animate', 'Gentle float animation', 'yes' );
		$this->end_controls_section();

		$this->style_section( 'box', 'Box' );
		$this->lc_style_controls( 'box', '.lc-float-note', [ 'max_width' => true, 'gap' => true, 'padding' => true, 'border' => true, 'radius' => true, 'bg' => true, 'shadow' => true, 'hover' => true ] );
		$this->end_controls_section();
		$this->style_section( 'mark', 'Logo tile' );
		$this->lc_slider( 'mark_size', 'Size', '.lc-icon-tile', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px' ], 120 );
		$this->lc_color( 'mark_bg', 'Background', $this->sel( '.lc-icon-tile' ), 'background-color' );
		$this->lc_dimensions( 'mark_radius', 'Radius', '.lc-icon-tile', 'border-radius' );
		$this->end_controls_section();
		$this->style_section( 'title', 'Title' );
		$this->lc_style_controls( 'title', '.lc-float-note__title', [ 'typography' => true, 'color' => true ] );
		$this->lc_icon_style_controls( 'icon', '.lc-float-note__title svg, .lc-float-note__title .lc-icon-custom' );
		$this->end_controls_section();
		$this->lc_card_text_style( 'sub', 'Subtitle', '.lc-float-note__sub' );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::float_note( [ 'icon' => $s['icon'], 'icon_custom' => $s['icon_custom'], 'title' => $s['title'], 'subtitle' => $s['subtitle'], 'class' => R::yes( $s['animate'] ) ? 'lc-float-note--animated' : '' ] ) );
	}
}
