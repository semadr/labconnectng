<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Metric Row — row of metric tiles, any can be highlighted. */
class Metric_Row extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-metric-row'; }
	public function get_title() { return 'LC Metric Row'; }
	public function get_icon() { return 'eicon-gallery-justified'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Metrics' );
		$r = new \Elementor\Repeater();
		$this->c_text( 'value', 'Value', '1', [], $r );
		$this->c_text( 'label', 'Label', 'Label', [], $r );
		$this->c_switch( 'highlight', 'Highlight (mint)', '', [], $r );
		$this->c_repeater( 'items', 'Metrics', $r, [
			[ 'value' => '1', 'label' => 'Core message' ],
			[ 'value' => '3', 'label' => 'Key findings' ],
			[ 'value' => '1', 'label' => 'Visual hook', 'highlight' => 'yes' ],
		], '{{{ value }}} · {{{ label }}}' );
		$this->c_select( 'base', 'Tile style', [ 'white' => 'White', 'glass' => 'Glass (on dark)' ], 'white' );
		$this->lc_columns( 'cols', '.lc-metric-row', '' );
		$this->lc_slider( 'gap', 'Gap', '.lc-metric-row', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 60 );
		$this->end_controls_section();

		$this->lc_card_style( 'tile', 'Tiles', '.lc-metric:not(.lc-metric--mint)', [ 'align' => 'items' ] );
		$this->style_section( 'hl', 'Highlighted tile' );
		$this->lc_style_controls( 'hl', '.lc-metric--mint', [ 'color' => true, 'bg' => true, 'border' => true, 'shadow' => true, 'hover' => true ] );
		$this->end_controls_section();
		$this->lc_card_text_style( 'value', 'Value', '.lc-metric__value' );
		$this->lc_card_text_style( 'label', 'Label', '.lc-metric__label' );
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = array_map( function ( $i ) { return [ 'value' => $i['value'], 'label' => $i['label'], 'highlight' => R::yes( $i['highlight'] ) ]; }, $s['items'] );
		$this->out( R::metric_row( $items, $s['base'] ) );
	}
}
