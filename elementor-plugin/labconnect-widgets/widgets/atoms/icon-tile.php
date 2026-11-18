<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Icon Tile — icon in a rounded square. */
class Icon_Tile extends Base_Widget {
	public function get_name() { return 'lc-icon-tile'; }
	public function get_title() { return 'LC Icon Tile'; }
	public function get_icon() { return 'eicon-icon-box'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Icon Tile' );
		$this->c_icon( 'icon', 'Icon', 'heart' );
		$this->c_select( 'tone', 'Colour preset', [ 'purple' => 'Purple', 'mint' => 'Mint', 'soft' => 'Soft lavender', 'white' => 'White' ], 'purple' );
		$this->c_select( 'size', 'Size preset', [ 'sm' => 'Small', 'md' => 'Medium', 'lg' => 'Large' ], 'md' );
		$this->c_url( 'link', 'Link (optional)', '' );
		$this->lc_align( 'align', '&', 'text' );
		$this->end_controls_section();

		$this->lc_icon_tile_style( 'tile', 'Tile', '.lc-icon-tile' );
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$tile = R::icon_tile( [ 'icon' => $s['icon'], 'icon_custom' => $s['icon_custom'], 'tone' => $s['tone'], 'size' => $s['size'] ] );
		$link = R::link_attrs( $s['link'] );
		$this->out( $link ? '<a class="lc-icon-tile-link"' . $link . '>' . $tile . '</a>' : $tile );
	}
}
