<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Button Group — several buttons side by side. Each button can have its own colours. */
class Button_Group extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-button-group'; }
	public function get_title() { return 'LC Button Group'; }
	public function get_icon() { return 'eicon-dual-button'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Buttons' );
		$r = new \Elementor\Repeater();
		$this->c_button( 'b', [ 'label' => 'Button' ], $r );
		$this->c_item_colors( $r, 'This button only' );
		$this->c_repeater( 'buttons', 'Buttons', $r, [
			[ 'b_label' => 'I run a Health Business', 'b_link' => [ 'url' => '#clinics' ], 'b_variant' => 'primary', 'b_size' => 'lg' ],
			[ 'b_label' => 'I am a Researcher → R-VaaS', 'b_link' => [ 'url' => '#rvaas' ], 'b_variant' => 'outline', 'b_size' => 'lg' ],
		], '{{{ b_label }}}' );
		$this->lc_align( 'align', '.lc-btn-group', 'flex', 'Alignment', true );
		$this->c_switch( 'stack', 'Stack on mobile', '', [ 'selectors' => [ '(mobile){{WRAPPER}} .lc-w .lc-btn-group' => 'flex-direction: column; align-items: stretch;' ] ] );
		$this->lc_slider( 'gap', 'Gap', '.lc-btn-group', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 60 );
		$this->end_controls_section();

		$this->lc_button_style( 'btn', 'All buttons', '.lc-btn' );
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$btns = [];
		foreach ( $s['buttons'] as $b ) {
			$btns[] = $this->button_args( $b, 'b', [ 'class' => 'elementor-repeater-item-' . $b['_id'] ] );
		}
		$this->out( R::button_group( $btns ) );
	}
}
