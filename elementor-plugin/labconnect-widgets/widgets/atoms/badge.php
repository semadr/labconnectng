<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Badge / Pill — small rounded label with optional dot or icon. */
class Badge extends Base_Widget {
	public function get_name() { return 'lc-badge'; }
	public function get_title() { return 'LC Badge / Pill'; }
	public function get_icon() { return 'eicon-tags'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Badge' );
		$this->c_text( 'label', 'Label', 'R-VaaS is now live' );
		$this->c_select( 'variant', 'Style', self::PILL_VARIANTS, 'mint-soft' );
		$this->c_select( 'dot', 'Dot', [ 'none' => 'None', 'static' => 'Static', 'live' => 'Pulsing (live)' ], 'live' );
		$this->c_icon( 'icon', 'Icon', 'sparkles' );
		$this->c_switch( 'wide', 'Wide letter spacing' );
		$this->c_url( 'link', 'Link (optional)', '' );
		$this->lc_align( 'align', '&', 'text' );
		$this->end_controls_section();

		$this->style_section( 'pill', 'Badge' );
		$this->lc_style_controls( 'pill', '.lc-pill', [ 'typography' => true, 'padding' => true, 'border' => true, 'radius' => true, 'color' => true, 'bg' => true, 'shadow' => true, 'hover' => true ] );
		$this->lc_color( 'pill_dot', 'Dot color', $this->sel( '.lc-pill__dot' ), 'background-color' );
		$this->lc_slider( 'pill_dot_size', 'Dot size', '.lc-pill__dot', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px' ], 20 );
		$this->lc_icon_style_controls( 'pill_icon', '.lc-pill__icon' );
		$this->end_controls_section();
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$pill = R::pill( [ 'label' => $s['label'], 'variant' => $s['variant'], 'dot' => $s['dot'], 'icon' => $s['icon'], 'icon_custom' => $s['icon_custom'], 'wide' => R::yes( $s['wide'] ) ] );
		$link = R::link_attrs( $s['link'] );
		$this->out( $link ? '<a class="lc-pill-link"' . $link . '>' . $pill . '</a>' : $pill );
	}
}
