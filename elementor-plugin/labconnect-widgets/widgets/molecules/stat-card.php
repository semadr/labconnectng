<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Stat Card — big number + label. */
class Stat_Card extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-stat-card'; }
	public function get_title() { return 'LC Stat Card'; }
	public function get_icon() { return 'eicon-counter'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Stat' );
		$this->c_text( 'value', 'Value', '200+' );
		$this->c_text( 'label', 'Label', 'Facilities supported' );
		$this->end_controls_section();

		$this->lc_card_style( 'card', 'Card', '.lc-stat', [ 'align' => 'text', 'gap' => false ] );
		$this->lc_card_text_style( 'value', 'Value', '.lc-stat__value', '.lc-stat:hover .lc-stat__value' );
		$this->lc_card_text_style( 'label', 'Label', '.lc-stat__label', '.lc-stat:hover .lc-stat__label' );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::stat( $s['value'], $s['label'] ) );
	}
}
