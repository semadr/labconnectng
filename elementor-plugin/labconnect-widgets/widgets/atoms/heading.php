<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Heading — serif display heading with highlight words. */
class Heading extends Base_Widget {
	public function get_name() { return 'lc-heading'; }
	public function get_title() { return 'LC Heading'; }
	public function get_icon() { return 'eicon-heading'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Heading' );
		$this->c_heading_text( 'h', [ 'text' => 'Your Clinic Saves Lives. Your Adverts Should Show It.', 'highlight' => 'Your Adverts Should Show It.', 'level' => 'h2' ] );
		$this->c_select( 'tone', 'Colour preset', [ 'ink' => 'Ink (default)', 'purple' => 'Purple', 'on-dark' => 'On dark background' ], 'ink' );
		$this->c_url( 'link', 'Link (optional)', '' );
		$this->end_controls_section();

		$this->lc_heading_style( 'h', 'Heading', '.lc-heading' );
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$html = R::heading( [ 'text' => $s['h_text'], 'highlight' => $s['h_highlight'], 'highlight_tone' => $s['h_hl_tone'], 'level' => $s['h_level'], 'tag' => $s['h_tag'], 'tone' => $s['tone'] ] );
		$link = R::link_attrs( $s['link'] );
		$this->out( $link ? '<a class="lc-heading-link"' . $link . '>' . $html . '</a>' : $html );
	}
}
