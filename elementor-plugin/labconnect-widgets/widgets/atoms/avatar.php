<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Avatar — initials circle (or photo). */
class Avatar extends Base_Widget {
	public function get_name() { return 'lc-avatar'; }
	public function get_title() { return 'LC Avatar'; }
	public function get_icon() { return 'eicon-person'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Avatar' );
		$this->c_text( 'initials', 'Initials', 'CO' );
		$this->c_media( 'image', 'Photo (optional)' );
		$this->c_select( 'tone', 'Colour preset', [ 'purple' => 'Purple', 'mint' => 'Mint' ], 'purple' );
		$this->lc_align( 'align', '&', 'text' );
		$this->end_controls_section();

		$this->style_section( 'avatar', 'Avatar' );
		$this->lc_slider( 'avatar_size', 'Size', '.lc-avatar', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 300 );
		$this->lc_style_controls( 'avatar', '.lc-avatar', [ 'typography' => true, 'border' => true, 'radius' => true, 'color' => true, 'bg' => true, 'shadow' => true ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::avatar( $s['initials'], $s['tone'], $this->media_url( $s['image'] ) ) );
	}
}
