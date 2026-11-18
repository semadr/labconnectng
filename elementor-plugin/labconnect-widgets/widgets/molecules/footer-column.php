<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Footer Column — title + link list. */
class Footer_Column extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-footer-column'; }
	public function get_title() { return 'LC Footer Column'; }
	public function get_icon() { return 'eicon-editor-list-ul'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Column' );
		$this->c_text( 'title', 'Title', 'Health Businesses' );
		$r = new \Elementor\Repeater();
		$this->c_text( 'label', 'Label', 'Link', [], $r );
		$this->c_url( 'link', 'Link', '#', [], $r );
		$this->c_repeater( 'links', 'Links', $r, array_map( function ( $l ) { return [ 'label' => $l, 'link' => [ 'url' => '#clinics' ] ]; }, [ 'Social Media Adverts', 'Website Banners', 'WhatsApp Status Packs', 'Promo Flyers' ] ), '{{{ label }}}' );
		$this->end_controls_section();

		$this->style_section( 'col', 'Column' );
		$this->lc_align( 'col_align', '.lc-footer-col', 'items' );
		$this->lc_slider( 'col_gap', 'Space below title', '.lc-footer-col', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 60 );
		$this->lc_slider( 'list_gap', 'Space between links', '.lc-footer-col__list', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 40 );
		$this->end_controls_section();
		$this->lc_card_text_style( 'title', 'Title', '.lc-footer-col__title' );
		$this->style_section( 'link', 'Links' );
		$this->lc_style_controls( 'link', '.lc-footer-col__list a', [ 'typography' => true, 'color' => true, 'hover' => true ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::footer_col( $s['title'], $s['links'] ) );
	}
}
