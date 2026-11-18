<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Logo — full LabConnect logo image. */
class Logo extends Base_Widget {
	public function get_name() { return 'lc-logo'; }
	public function get_title() { return 'LC Logo'; }
	public function get_icon() { return 'eicon-site-logo'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Logo' );
		$this->c_media( 'image', 'Logo image', [ 'description' => 'Leave empty to use the bundled LabConnect logo.' ] );
		$this->c_text( 'alt', 'Alt text', 'LabConnect — Build the bridge' );
		$this->c_url( 'link', 'Link', '#top' );
		$this->lc_align( 'align', '&', 'text' );
		$this->end_controls_section();

		$this->style_section( 'logo', 'Logo' );
		$this->lc_slider( 'logo_h', 'Height', '.lc-logo img', 'height: {{SIZE}}{{UNIT}}; width: auto;', [ 'px', 'em' ], 300 );
		$this->lc_style_controls( 'logo', '.lc-logo', [ 'padding' => true, 'border' => true, 'radius' => true, 'bg' => true, 'shadow' => true, 'hover' => true ] );
		$this->add_control( 'logo_opacity', [ 'label' => 'Hover opacity', 'type' => CM::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ], 'selectors' => [ $this->sel( '.lc-logo:hover img' ) => 'opacity: {{SIZE}};' ] ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::logo( [ 'src' => $this->media_url( $s['image'] ), 'alt' => $s['alt'], 'link' => $s['link'] ] ) );
	}
}
