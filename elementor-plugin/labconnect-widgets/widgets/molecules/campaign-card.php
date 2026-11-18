<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Campaign Card — the featured advert mockup from the hero. */
class Campaign_Card extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-campaign-card'; }
	public function get_title() { return 'LC Campaign Card'; }
	public function get_icon() { return 'eicon-call-to-action'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Campaign' );
		$this->c_text( 'tag', 'Tag', 'Featured campaign' );
		$this->c_text( 'eyebrow', 'Eyebrow', 'Your health, our priority' );
		$this->c_icon( 'eyebrow_icon', 'Eyebrow icon', 'stethoscope' );
		$this->c_area( 'title', 'Title', 'Care that feels close. Service you can trust.', [ 'rows' => 2 ] );
		$this->c_area( 'body', 'Body', 'Same-week appointments · Experienced care team · A clinic that listens first.' );
		$this->c_text( 'cta_label', 'CTA label', 'Book a visit today' );
		$this->c_text( 'cta_sub', 'CTA sub-text', 'Your health cannot wait.' );
		$this->c_url( 'link', 'CTA link', '#clinics' );
		$this->c_switch( 'glow', 'Show mint glow', 'yes', [ 'selectors' => [], 'return_value' => 'yes' ] );
		$this->end_controls_section();

		$this->style_section( 'card', 'Card' );
		$this->lc_style_controls( 'card', '.lc-campaign', [ 'gap' => true, 'padding' => true, 'border' => true, 'radius' => true, 'color' => true, 'bg' => true, 'shadow' => true, 'hover' => true, 'lift' => true ] );
		$this->lc_color( 'glow_color', 'Glow color', $this->sel( '.lc-campaign::after' ), 'background' );
		$this->end_controls_section();
		$this->lc_pill_style( 'tag', 'Tag', '.lc-campaign__top .lc-pill' );
		$this->style_section( 'mark', 'Logo badge' );
		$this->lc_slider( 'mark_size', 'Size', '.lc-campaign__mark', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px' ], 120 );
		$this->lc_color( 'mark_bg', 'Background', $this->sel( '.lc-campaign__mark' ), 'background-color' );
		$this->end_controls_section();
		$this->style_section( 'eyebrow', 'Eyebrow' );
		$this->lc_style_controls( 'eyebrow', '.lc-eyebrow', [ 'typography' => true, 'color' => true ] );
		$this->lc_icon_style_controls( 'eyebrow_icon', '.lc-eyebrow__icon' );
		$this->end_controls_section();
		$this->lc_card_text_style( 'title', 'Title', '.lc-campaign__title' );
		$this->lc_card_text_style( 'body', 'Body', '.lc-text' );
		$this->style_section( 'cta', 'CTA box' );
		$this->lc_style_controls( 'cta', '.lc-campaign__cta', [ 'padding' => true, 'margin' => true, 'border' => true, 'radius' => true, 'color' => true, 'bg' => true, 'shadow' => true, 'hover' => true ] );
		$this->lc_style_controls( 'cta_label', '.lc-campaign__cta-label', [ 'heading' => 'Label', 'typography' => true, 'color' => true ] );
		$this->lc_style_controls( 'cta_sub', '.lc-campaign__cta-sub', [ 'heading' => 'Sub-text', 'typography' => true, 'color' => true ] );
		$this->end_controls_section();
		$this->style_section( 'arrow', 'CTA arrow' );
		$this->lc_slider( 'arrow_size', 'Circle size', '.lc-campaign__arrow', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px' ], 120 );
		$this->lc_style_controls( 'arrow', '.lc-campaign__arrow', [ 'color' => true, 'color_label' => 'Arrow color', 'bg' => true, 'hover' => true, 'hover_selector' => '.lc-campaign__cta:hover .lc-campaign__arrow' ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$html = R::campaign( [ 'tag' => $s['tag'], 'eyebrow' => $s['eyebrow'], 'eyebrow_icon' => $s['eyebrow_icon'], 'eyebrow_icon_custom' => $s['eyebrow_icon_custom'], 'title' => $s['title'], 'body' => $s['body'], 'cta_label' => $s['cta_label'], 'cta_sub' => $s['cta_sub'], 'link' => $s['link'] ] );
		if ( ! R::yes( $s['glow'] ) ) {
			$html = str_replace( 'class="lc-campaign"', 'class="lc-campaign lc-campaign--no-glow"', $html );
		}
		$this->out( $html );
	}
}
