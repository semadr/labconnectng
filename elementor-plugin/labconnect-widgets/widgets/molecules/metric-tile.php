<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Metric Tile — e.g. "1 · Core message". */
class Metric_Tile extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-metric-tile'; }
	public function get_title() { return 'LC Metric Tile'; }
	public function get_icon() { return 'eicon-info-box'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Metric' );
		$this->c_text( 'value', 'Value', '3' );
		$this->c_text( 'label', 'Label', 'Key findings' );
		$this->c_select( 'variant', 'Style', [ 'white' => 'White', 'glass' => 'Glass (on dark)', 'mint' => 'Mint (highlight)' ], 'mint' );
		$this->end_controls_section();

		$this->lc_card_style( 'tile', 'Tile', '.lc-metric', [ 'align' => 'items' ] );
		$this->style_section( 'tile_text', 'Tile text' );
		$this->lc_style_controls( 'tile_text', '.lc-metric', [ 'color' => true, 'color_label' => 'Text color', 'hover' => true ] );
		$this->end_controls_section();
		$this->lc_card_text_style( 'value', 'Value', '.lc-metric__value' );
		$this->lc_card_text_style( 'label', 'Label', '.lc-metric__label' );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::metric( $s['value'], $s['label'], $s['variant'] ) );
	}
}
