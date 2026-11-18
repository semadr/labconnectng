<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Marquee — scrolling ticker bar. */
class Marquee extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-marquee'; }
	public function get_title() { return 'LC Marquee'; }
	public function get_icon() { return 'eicon-slider-push'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Ticker' );
		$r = new \Elementor\Repeater();
		$this->c_text( 'text', 'Text', 'Item', [], $r );
		$this->c_repeater( 'items', 'Items', $r, array_map( function ( $t ) { return [ 'text' => $t ]; }, [ 'Clinics', 'Pharmacies', 'Labs', 'Hospitals', 'Researchers', 'Graphical abstracts', 'Social campaigns' ] ), '{{{ text }}}' );
		$this->c_number( 'speed', 'Loop duration (seconds)', 32, 5, 200 );
		$this->c_switch( 'reverse', 'Scroll left → right' );
		$this->c_switch( 'pause', 'Pause on hover', 'yes' );
		$this->c_switch( 'no_fade', 'Remove edge fade', '', [ 'selectors' => [ '{{WRAPPER}} .lc-w .lc-marquee' => '-webkit-mask-image: none; mask-image: none;' ] ] );
		$this->end_controls_section();

		$this->style_section( 'bar', 'Bar' );
		$this->lc_style_controls( 'bar', '.lc-marquee', [ 'padding' => true, 'border' => true, 'radius' => true, 'bg' => true, 'shadow' => true ] );
		$this->end_controls_section();
		$this->style_section( 'item', 'Items' );
		$this->lc_slider( 'item_gap', 'Spacing', '.lc-marquee__group', 'gap: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 120 );
		$this->lc_style_controls( 'item', '.lc-marquee__item', [ 'typography' => true, 'color' => true, 'hover' => true ] );
		$this->add_control( 'sep_hd', [ 'label' => 'Separator', 'type' => CM::HEADING, 'separator' => 'before' ] );
		$this->lc_slider( 'sep_size', 'Size', '.lc-marquee__sep', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px' ], 30 );
		$this->lc_color( 'sep_color', 'Color', $this->sel( '.lc-marquee__sep' ), 'background-color' );
		$this->lc_dimensions( 'sep_radius', 'Radius', '.lc-marquee__sep', 'border-radius' );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = array_map( function ( $i ) { return $i['text']; }, $s['items'] );
		$this->out( R::marquee( $items, $s['speed'], R::yes( $s['reverse'] ), R::yes( $s['pause'] ) ) );
	}
}
