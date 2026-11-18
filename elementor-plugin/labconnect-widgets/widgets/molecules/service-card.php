<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Service Card — icon tile + title + text. */
class Service_Card extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-service-card'; }
	public function get_title() { return 'LC Service Card'; }
	public function get_icon() { return 'eicon-icon-box'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Service' );
		$this->c_icon( 'icon', 'Icon', 'megaphone' );
		$this->c_select( 'icon_tone', 'Icon colour preset', [ 'purple' => 'Purple', 'mint' => 'Mint', 'soft' => 'Soft lavender', 'white' => 'White' ], 'purple' );
		$this->c_text( 'title', 'Title', 'Social Media Adverts' );
		$this->c_area( 'description', 'Description', 'Scroll-stopping designs that make your services easy to trust and easy to choose.' );
		$this->c_url( 'link', 'Link (whole card, optional)', '' );
		$this->end_controls_section();

		$this->lc_card_style( 'card', 'Card', '.lc-service-card' );
		$this->lc_icon_tile_style( 'tile', 'Icon tile', '.lc-icon-tile', '.lc-service-card:hover .lc-icon-tile' );
		$this->lc_card_text_style( 'title', 'Title', '.lc-heading', '.lc-service-card:hover .lc-heading' );
		$this->lc_card_text_style( 'desc', 'Description', '.lc-text', '.lc-service-card:hover .lc-text' );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::service_card( [ 'icon' => $s['icon'], 'icon_custom' => $s['icon_custom'], 'icon_tone' => $s['icon_tone'], 'title' => $s['title'], 'description' => $s['description'], 'link' => $s['link'] ] ) );
	}
}
