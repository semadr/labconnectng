<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Section Header — badge + heading + description. */
class Section_Header extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-section-header'; }
	public function get_title() { return 'LC Section Header'; }
	public function get_icon() { return 'eicon-header'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Section Header' );
		$this->c_section_header( 'sh', [
			'badge'       => 'Section A · For Health Businesses',
			'title'       => 'Medical Advert Designs for Health Businesses',
			'highlight'   => 'Health Businesses',
			'description' => 'Labs, pharmacies, clinics and hospitals that have been ignored online get status on social media and on their website.',
		] );
		$this->c_select( 'sh_level', 'Title size', self::HEADING_LEVELS, 'h2' );
		$this->c_select( 'sh_tag', 'Title HTML tag', self::HTML_TAGS, '' );
		$this->end_controls_section();

		$this->lc_section_header_style( 'sh' );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::section_header( [ 'level' => $s['sh_level'], 'tag' => $s['sh_tag'] ] + $this->section_header_args( $s, 'sh' ) ) );
	}
}
