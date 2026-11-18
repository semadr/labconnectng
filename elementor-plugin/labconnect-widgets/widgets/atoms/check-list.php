<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Check List — feature rows with tick or circle icons. */
class Check_List extends Base_Widget {
	public function get_name() { return 'lc-check-list'; }
	public function get_title() { return 'LC Check List'; }
	public function get_icon() { return 'eicon-bullet-list'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Items' );
		$r = new \Elementor\Repeater();
		$this->c_text( 'label', 'Text', 'Feature', [], $r );
		$this->c_repeater( 'items', 'Items', $r, [
			[ 'label' => '3 custom advert designs' ],
			[ 'label' => '48-hour delivery' ],
			[ 'label' => '1 revision round' ],
			[ 'label' => 'Ready for WhatsApp + social' ],
		], '{{{ label }}}' );
		$this->c_select( 'variant', 'Icon style', [ 'tick' => 'Tick', 'circle' => 'Tick in circle' ], 'tick' );
		$this->c_icon( 'icon', 'Icon', 'check' );
		$this->c_select( 'tone', 'Colour preset', [ 'purple' => 'Purple', 'mint' => 'Mint' ], 'purple' );
		$this->c_switch( 'on_dark', 'On dark background' );
		$this->end_controls_section();

		$this->style_section( 'list', 'List' );
		$this->lc_slider( 'list_gap', 'Space between rows', '.lc-check-list', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 80 );
		$this->lc_slider( 'list_col_gap', 'Space icon → text', '.lc-check', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 40 );
		$this->lc_style_controls( 'item', '.lc-check', [ 'typography' => true, 'color' => true, 'heading' => 'Text' ] );
		$this->end_controls_section();

		$this->style_section( 'icon', 'Icon' );
		$this->lc_slider( 'icon_size', 'Size', '.lc-check__icon', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 60 );
		$this->lc_style_controls( 'icon', '.lc-check__icon', [ 'color' => true, 'color_label' => 'Icon color', 'bg' => true, 'bg_types' => [ 'classic' ], 'padding' => true, 'radius' => true, 'border' => true ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$items = array_map( function ( $i ) { return $i['label']; }, $s['items'] );
		$this->out( R::check_list( $items, [ 'variant' => $s['variant'], 'tone' => $s['tone'], 'on_dark' => R::yes( $s['on_dark'] ), 'icon' => $s['icon'], 'icon_custom' => $s['icon_custom'] ] ) );
	}
}
