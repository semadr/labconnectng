<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Services Grid — section header + service cards. */
class Section_Services_Grid extends Base_Widget {
	protected $lc_group = 'sections';
	public function get_name() { return 'lc-services-grid'; }
	public function get_title() { return 'LC Services Grid'; }
	public function get_icon() { return 'eicon-gallery-grid'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Header' );
		$this->lc_section_shell_controls( 'clinics' );
		$this->c_section_header( 'sh', [
			'badge'       => 'Section A · For Health Businesses',
			'title'       => 'Medical Advert Designs for Health Businesses',
			'highlight'   => 'Health Businesses',
			'description' => "Labs, pharmacies, clinics and hospitals that have been ignored online get status on social media and on their website. We make your expertise visible — and your next patient's decision easier.",
		] );
		$this->end_controls_section();

		$this->content_section( 'items_sec', 'Services' );
		$r = new \Elementor\Repeater();
		$this->c_icon( 'icon', 'Icon', 'megaphone', [], $r );
		$this->c_text( 'title', 'Title', 'Service', [], $r );
		$this->c_area( 'description', 'Description', '', [], $r );
		$this->c_url( 'link', 'Link (optional)', '', [], $r );
		$this->c_repeater( 'items', 'Services', $r, [
			[ 'icon' => 'megaphone', 'title' => 'Social Media Adverts', 'description' => 'Scroll-stopping designs that make your services easy to trust and easy to choose.' ],
			[ 'icon' => 'monitor', 'title' => 'Website Banners', 'description' => 'Clean, credible banners that turn a quick visit into an enquiry or booking.' ],
			[ 'icon' => 'share', 'title' => 'WhatsApp Status Packs', 'description' => 'Daily-ready visuals sized for status, so your community sees you again and again.' ],
			[ 'icon' => 'pen', 'title' => 'Promo Flyers', 'description' => 'Offers, screenings, openings and health campaigns — designed to be shared.' ],
		], '{{{ title }}}' );
		$this->lc_columns( 'cols', '.lc-grid', '' );
		$this->lc_slider( 'gap', 'Gap', '.lc-grid', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 80 );
		$this->end_controls_section();

		$this->lc_section_shell_style();
		$this->lc_section_header_style( 'sh' );
		$this->lc_card_style( 'card', 'Cards', '.lc-service-card' );
		$this->lc_icon_tile_style( 'tile', 'Card · Icon tile', '.lc-service-card .lc-icon-tile', '.lc-service-card:hover .lc-icon-tile' );
		$this->lc_card_text_style( 'title', 'Card · Title', '.lc-service-card .lc-heading', '.lc-service-card:hover .lc-heading' );
		$this->lc_card_text_style( 'desc', 'Card · Description', '.lc-service-card .lc-text', '.lc-service-card:hover .lc-text' );
	}

	protected function render() {
		$s   = $this->get_settings_for_display();
		$out = $this->section_open( $s, 'lc-section' ) . R::section_header( $this->section_header_args( $s, 'sh' ) ) . '<div class="lc-grid lc-grid--4">';
		foreach ( $s['items'] as $i ) {
			$out .= R::service_card( [ 'icon' => $i['icon'], 'icon_custom' => $i['icon_custom'], 'title' => $i['title'], 'description' => $i['description'], 'link' => $i['link'] ] );
		}
		$this->out( $out . '</div>' . $this->section_close() );
	}
}
