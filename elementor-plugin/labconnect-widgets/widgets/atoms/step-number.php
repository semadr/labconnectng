<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Step Number — "01" as a circle or a big serif numeral. */
class Step_Number extends Base_Widget {
	public function get_name() { return 'lc-step-number'; }
	public function get_title() { return 'LC Step Number'; }
	public function get_icon() { return 'eicon-number-field'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Step Number' );
		$this->c_text( 'value', 'Number', '01' );
		$this->c_select( 'variant', 'Style', [ 'circle' => 'Circle', 'big' => 'Big numeral' ], 'circle' );
		$this->lc_align( 'align', '&', 'text' );
		$this->end_controls_section();

		$this->style_section( 'num', 'Number' );
		$this->lc_slider( 'num_size', 'Circle size', '.lc-step-num', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 300, [ 'condition' => [ 'variant' => 'circle' ] ] );
		$this->lc_style_controls( 'num', '.lc-step-num', [ 'typography' => true, 'text_shadow' => true, 'border' => true, 'radius' => true, 'color' => true, 'bg' => true, 'shadow' => true ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::step_number( $s['value'], $s['variant'] ) );
	}
}
