<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Eyebrow — small uppercase kicker above headings. */
class Eyebrow extends Base_Widget {
	public function get_name() { return 'lc-eyebrow'; }
	public function get_title() { return 'LC Eyebrow'; }
	public function get_icon() { return 'eicon-t-letter'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Eyebrow' );
		$this->c_text( 'label', 'Label', 'Choose your track' );
		$this->c_select( 'tone', 'Colour preset', [ 'purple' => 'Purple', 'mint' => 'Mint', 'on-dark' => 'On dark background' ], 'purple' );
		$this->c_icon( 'icon', 'Icon', 'none' );
		$this->lc_align( 'align', '&', 'text' );
		$this->end_controls_section();

		$this->style_section( 'eyebrow', 'Eyebrow' );
		$this->lc_style_controls( 'eyebrow', '.lc-eyebrow', [ 'typography' => true, 'color' => true, 'gap' => true, 'padding' => true, 'bg' => true, 'border' => true, 'radius' => true ] );
		$this->lc_icon_style_controls( 'eyebrow_icon', '.lc-eyebrow__icon' );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::eyebrow( [ 'label' => $s['label'], 'tone' => $s['tone'], 'icon' => $s['icon'], 'icon_custom' => $s['icon_custom'] ] ) );
	}
}
