<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Stars — rating row. */
class Stars extends Base_Widget {
	public function get_name() { return 'lc-stars'; }
	public function get_title() { return 'LC Stars'; }
	public function get_icon() { return 'eicon-rating'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Stars' );
		$this->c_number( 'count', 'Number of stars', 5, 1, 10 );
		$this->lc_align( 'align', '&', 'text' );
		$this->end_controls_section();

		$this->style_section( 'stars', 'Stars' );
		$this->lc_slider( 'stars_size', 'Size', '.lc-stars svg', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 80 );
		$this->lc_slider( 'stars_gap', 'Spacing', '.lc-stars', 'gap: {{SIZE}}{{UNIT}};', [ 'px' ], 30 );
		$this->lc_color( 'stars_color', 'Color', $this->sel( '.lc-stars' ) );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::stars( $s['count'] ) );
	}
}
