<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Price — amount + period. */
class Price extends Base_Widget {
	public function get_name() { return 'lc-price'; }
	public function get_title() { return 'LC Price'; }
	public function get_icon() { return 'eicon-price-list'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Price' );
		$this->c_text( 'amount', 'Amount', '₦45,000' );
		$this->c_text( 'period', 'Period', '/ week' );
		$this->c_switch( 'on_dark', 'On dark background' );
		$this->lc_align( 'align', '.lc-price', 'flex' );
		$this->end_controls_section();

		$this->style_section( 'price', 'Price' );
		$this->lc_slider( 'price_gap', 'Space amount → period', '.lc-price', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 40 );
		$this->lc_style_controls( 'amount', '.lc-price__amount', [ 'heading' => 'Amount', 'typography' => true, 'text_shadow' => true, 'color' => true ] );
		$this->lc_style_controls( 'period', '.lc-price__period', [ 'heading' => 'Period', 'typography' => true, 'color' => true ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::price( $s['amount'], $s['period'], R::yes( $s['on_dark'] ) ) );
	}
}
