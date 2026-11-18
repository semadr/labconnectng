<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Dot Grid — decorative dotted square. */
class Dot_Grid extends Base_Widget {
	public function get_name() { return 'lc-dot-grid'; }
	public function get_title() { return 'LC Dot Grid'; }
	public function get_icon() { return 'eicon-apps'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Dot Grid' );
		$this->add_control( 'note', [ 'type' => CM::RAW_HTML, 'raw' => 'Decorative pattern. Use Advanced → Position: Absolute to float it behind other widgets.' ] );
		$this->lc_align( 'align', '.lc-dots', 'self' );
		$this->end_controls_section();

		$this->style_section( 'dots', 'Dots' );
		$this->lc_slider( 'dots_w', 'Width', '.lc-dots', 'width: {{SIZE}}{{UNIT}};', [ 'px', '%' ], 800 );
		$this->lc_slider( 'dots_h', 'Height', '.lc-dots', 'height: {{SIZE}}{{UNIT}};', [ 'px' ], 800 );
		$this->lc_slider( 'dots_gap', 'Dot spacing', '.lc-dots', '--lc-dots-gap: {{SIZE}}{{UNIT}};', [ 'px' ], 60 );
		$this->lc_slider( 'dots_size', 'Dot size', '.lc-dots', '--lc-dots-size: {{SIZE}}{{UNIT}};', [ 'px' ], 10 );
		$this->lc_color( 'dots_color', 'Dot color', $this->sel( '.lc-dots' ), '--lc-dots-color' );
		$this->add_control( 'dots_opacity', [ 'label' => 'Opacity', 'type' => CM::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ], 'selectors' => [ $this->sel( '.lc-dots' ) => 'opacity: {{SIZE}};' ] ] );
		$this->end_controls_section();
	}

	protected function render() {
		$this->out( R::dots( 'lc-dots--static' ) );
	}
}
