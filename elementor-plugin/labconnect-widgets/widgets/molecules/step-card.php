<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Step Card — big numeral card for "How it works". */
class Step_Card extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-step-card'; }
	public function get_title() { return 'LC Step Card'; }
	public function get_icon() { return 'eicon-number-field'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Step' );
		$this->c_text( 'number', 'Number', '01' );
		$this->c_text( 'title', 'Title', 'Share your brief' );
		$this->c_area( 'description', 'Description', 'Tell us your service, paper, offer or goal — plus any brand colours, photos or key messages.' );
		$this->c_switch( 'mark', 'Show logo mark', 'yes' );
		$this->end_controls_section();

		$this->lc_card_style( 'card', 'Card', '.lc-step-card' );
		$this->lc_card_text_style( 'num', 'Number', '.lc-step-num', '.lc-step-card:hover .lc-step-num' );
		$this->style_section( 'mark', 'Logo mark', [ 'mark' => 'yes' ] );
		$this->lc_slider( 'mark_size', 'Size', '.lc-logomark', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px' ], 120 );
		$this->lc_color( 'mark_hub', 'Hub color', $this->sel( '.lc-logomark__hub' ), 'fill' );
		$this->lc_color( 'mark_node', 'Node color', $this->sel( '.lc-logomark__node' ), 'fill' );
		$this->lc_color( 'mark_line', 'Lines color', $this->sel( '.lc-logomark__link, .lc-logomark__ring' ), 'stroke' );
		$this->end_controls_section();
		$this->lc_card_text_style( 'title', 'Title', '.lc-heading', '.lc-step-card:hover .lc-heading' );
		$this->lc_card_text_style( 'desc', 'Description', '.lc-text', '.lc-step-card:hover .lc-text' );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::step_card( [ 'number' => $s['number'], 'title' => $s['title'], 'description' => $s['description'], 'mark' => R::yes( $s['mark'] ) ] ) );
	}
}
