<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Stat Group — row of stat cards. */
class Stat_Group extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-stat-group'; }
	public function get_title() { return 'LC Stat Group'; }
	public function get_icon() { return 'eicon-number-field'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Stats' );
		$r = new \Elementor\Repeater();
		$this->c_text( 'value', 'Value', '100+', [], $r );
		$this->c_text( 'label', 'Label', 'Label', [], $r );
		$this->c_repeater( 'items', 'Stats', $r, [
			[ 'value' => '200+', 'label' => 'Facilities supported' ],
			[ 'value' => '100+', 'label' => 'Papers visualized' ],
			[ 'value' => '48 hrs', 'label' => 'Fast first delivery' ],
		], '{{{ value }}} · {{{ label }}}' );
		$this->lc_columns( 'cols', '.lc-stat-group', '' );
		$this->lc_slider( 'gap', 'Gap', '.lc-stat-group', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 80 );
		$this->end_controls_section();

		$this->lc_card_style( 'card', 'Cards', '.lc-stat', [ 'align' => 'text', 'gap' => false ] );
		$this->lc_card_text_style( 'value', 'Value', '.lc-stat__value', '.lc-stat:hover .lc-stat__value' );
		$this->lc_card_text_style( 'label', 'Label', '.lc-stat__label', '.lc-stat:hover .lc-stat__label' );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::stat_group( $s['items'] ) );
	}
}
