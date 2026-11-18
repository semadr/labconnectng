<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Process Step — numbered timeline item. */
class Process_Step extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-process-step'; }
	public function get_title() { return 'LC Process Step'; }
	public function get_icon() { return 'eicon-time-line'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Step' );
		$this->c_text( 'number', 'Number', '01' );
		$this->c_text( 'title', 'Title', 'Submit Your Paper' );
		$this->c_area( 'description', 'Description', 'Share your manuscript, key findings and figures. No design work needed from you.' );
		$this->c_switch( 'line', 'Show connector line', 'yes' );
		$this->c_switch( 'last', 'Fade the line (last step)', '', [ 'condition' => [ 'line' => 'yes' ] ] );
		$this->end_controls_section();

		$this->style_section( 'box', 'Step' );
		$this->lc_style_controls( 'box', '.lc-process-step', [ 'gap' => true, 'padding' => true, 'bg' => true, 'border' => true, 'radius' => true, 'shadow' => true, 'hover' => true ] );
		$this->end_controls_section();
		$this->style_section( 'num', 'Number' );
		$this->lc_slider( 'num_size', 'Circle size', '.lc-step-num', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px' ], 200 );
		$this->lc_style_controls( 'num', '.lc-step-num', [ 'typography' => true, 'border' => true, 'radius' => true, 'color' => true, 'bg' => true, 'shadow' => true, 'hover' => true, 'hover_selector' => '.lc-process-step:hover .lc-step-num' ] );
		$this->end_controls_section();
		$this->style_section( 'line', 'Connector line', [ 'line' => 'yes' ] );
		$this->lc_slider( 'line_h', 'Thickness', '.lc-process-step__line', 'height: {{SIZE}}{{UNIT}};', [ 'px' ], 12 );
		$this->lc_slider( 'line_gap', 'Space from number', '.lc-process-step__head', 'gap: {{SIZE}}{{UNIT}};', [ 'px' ], 60 );
		$this->add_group_control( \Elementor\Group_Control_Background::get_type(), [ 'name' => 'line_bg', 'types' => [ 'classic', 'gradient' ], 'selector' => $this->sel( '.lc-process-step__line' ) ] );
		$this->end_controls_section();
		$this->lc_card_text_style( 'title', 'Title', '.lc-heading', '.lc-process-step:hover .lc-heading' );
		$this->lc_card_text_style( 'desc', 'Description', '.lc-text', '.lc-process-step:hover .lc-text' );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::process_step( [ 'number' => $s['number'], 'title' => $s['title'], 'description' => $s['description'], 'line' => R::yes( $s['line'] ), 'last' => R::yes( $s['last'] ) ] ) );
	}
}
