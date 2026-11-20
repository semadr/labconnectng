<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Track Selector — "Choose your track" box with selectable Track Cards. */
class Section_Track_Selector extends Base_Widget {
	use \LCW\Track_Parts;
	protected $lc_group = 'sections';
	public function get_name() { return 'lc-track-selector'; }
	public function get_title() { return 'LC Track Selector'; }
	public function get_icon() { return 'eicon-select'; }

	protected function register_controls() {
		$this->register_track_content();
		$this->register_track_style();
	}

	protected function render() {
		$this->out( $this->render_tracks( $this->get_settings_for_display() ) );
	}
}
