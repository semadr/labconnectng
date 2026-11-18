<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Trust Row — small icon + label promises. */
class Trust_Row extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-trust-row'; }
	public function get_title() { return 'LC Trust Row'; }
	public function get_icon() { return 'eicon-check-circle'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Items' );
		$r = new \Elementor\Repeater();
		$this->c_icon( 'icon', 'Icon', 'badge-check', [], $r );
		$this->c_text( 'label', 'Label', 'Promise', [], $r );
		$this->c_repeater( 'items', 'Items', $r, [
			[ 'icon' => 'badge-check', 'label' => 'Clear packages' ],
			[ 'icon' => 'calendar', 'label' => 'Fast turnaround' ],
			[ 'icon' => 'zap', 'label' => 'Designed to be shared' ],
		], '{{{ label }}}' );
		$this->c_switch( 'on_dark', 'On dark background' );
		$this->lc_align( 'align', '.lc-trust-row', 'flex' );
		$this->end_controls_section();

		$this->style_section( 'row', 'Items' );
		$this->lc_slider( 'row_gap', 'Space between items', '.lc-trust-row', 'column-gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 80 );
		$this->lc_slider( 'row_vgap', 'Space between lines', '.lc-trust-row', 'row-gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 60 );
		$this->lc_style_controls( 'item', '.lc-trust-row__item', [ 'typography' => true, 'color' => true, 'gap' => true, 'padding' => true, 'bg' => true, 'border' => true, 'radius' => true ] );
		$this->lc_icon_style_controls( 'icon', '.lc-trust-row__item svg, .lc-trust-row__item .lc-icon-custom' );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = array_map( function ( $i ) { return [ 'icon' => $i['icon'], 'icon_custom' => $i['icon_custom'], 'label' => $i['label'] ]; }, $s['items'] );
		$this->out( R::trust_row( $items, 'start', R::yes( $s['on_dark'] ) ) );
	}
}
