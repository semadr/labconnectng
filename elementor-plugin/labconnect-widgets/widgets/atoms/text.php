<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Text / Quote — body, lead or small paragraph, or a serif pull-quote. */
class Text extends Base_Widget {
	public function get_name() { return 'lc-text'; }
	public function get_title() { return 'LC Text / Quote'; }
	public function get_icon() { return 'eicon-text'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Text' );
		$this->c_area( 'text', 'Text', 'Too many excellent health businesses are ignored online. LabConnect NG turns your care, credibility and offers into adverts people notice, trust and act on.', [ 'rows' => 5, 'description' => 'Basic HTML allowed (<strong>, <em>, <a>, <br>).' ] );
		$this->c_select( 'style', 'Type', [ 'text' => 'Paragraph', 'quote' => 'Pull-quote (serif, mint)' ], 'text' );
		$this->c_select( 'size', 'Size preset', [ 'body' => 'Body', 'lead' => 'Lead (larger)', 'small' => 'Small' ], 'lead', [ 'condition' => [ 'style' => 'text' ] ] );
		$this->c_switch( 'on_dark', 'On dark background', '', [ 'condition' => [ 'style' => 'text' ] ] );
		$this->end_controls_section();

		$this->lc_text_style( 'text', 'Text', '.lc-text, .lc-quote' );
		$this->style_section( 'link', 'Links inside text' );
		$this->lc_style_controls( 'link', '.lc-text a, .lc-quote a', [ 'color' => true, 'hover' => true, 'typography' => true ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::text( [ 'text' => $s['text'], 'style' => $s['style'], 'size' => $s['size'], 'on_dark' => R::yes( $s['on_dark'] ) ] ) );
	}
}
