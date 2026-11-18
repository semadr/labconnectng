<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Pricing Card — package with features; selecting it updates the Final CTA WhatsApp message. */
class Pricing_Card extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-pricing-card'; }
	public function get_title() { return 'LC Pricing Card'; }
	public function get_icon() { return 'eicon-price-table'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Package' );
		$this->c_text( 'badge', 'Badge', 'Most popular' );
		$this->c_text( 'name', 'Name', 'Weekly Authority' );
		$this->c_text( 'amount', 'Price', '₦45,000' );
		$this->c_text( 'period', 'Period', '/ week' );
		$this->c_area( 'description', 'Description', 'Stay visible every week — without chasing a designer or missing a post.' );
		$r = new \Elementor\Repeater();
		$this->c_text( 'text', 'Feature', 'Feature', [], $r );
		$this->c_repeater( 'features', 'Features', $r, [
			[ 'text' => '10 designs every week' ],
			[ 'text' => 'Social + WhatsApp-ready formats' ],
			[ 'text' => 'Consistent brand styling' ],
			[ 'text' => 'Priority turnaround' ],
		], '{{{ text }}}' );
		$this->c_select( 'theme', 'Theme', [ 'clinic' => 'Clinic (purple)', 'rvaas' => 'R-VaaS (mint)' ], 'clinic' );
		$this->c_switch( 'featured', 'Featured (highlighted card)', 'yes' );
		$this->end_controls_section();

		$this->content_section( 'action', 'Button' );
		$this->c_select( 'action_type', 'When clicked', [ 'select' => 'Select package (updates Final CTA)', 'whatsapp' => 'Open WhatsApp chat', 'link' => 'Go to link' ], 'select' );
		$this->c_text( 'cta_label', 'Button label', 'Choose this package' );
		$this->c_text( 'cta_selected_label', 'Selected label', 'Selected — start with this package', [ 'condition' => [ 'action_type' => 'select' ] ] );
		$this->c_text( 'group', 'Selection group', 'clinic', [ 'description' => 'Cards with the same group are picked one at a time. Use "clinic" or "rvaas".', 'condition' => [ 'action_type' => 'select' ] ] );
		$this->c_text( 'pkg_id', 'Package key (optional)', '', [ 'condition' => [ 'action_type' => 'select' ] ] );
		$this->c_switch( 'selected', 'Selected by default', 'yes', [ 'condition' => [ 'action_type' => 'select' ] ] );
		$this->c_area( 'wa_message', 'WhatsApp message', "Hello LabConnect, I'd like to start with the {package} package ({price}).", [ 'description' => 'Placeholders: {package} {price} {amount} {period}', 'condition' => [ 'action_type' => 'whatsapp' ] ] );
		$this->c_text( 'wa_number', 'WhatsApp number (optional)', '', [ 'description' => 'Leave empty to use Settings → LabConnect Widgets.', 'condition' => [ 'action_type' => 'whatsapp' ] ] );
		$this->c_url( 'link', 'Link', '#contact', [ 'condition' => [ 'action_type' => 'link' ] ] );
		$this->end_controls_section();

		$this->lc_card_style( 'card', 'Card', '.lc-pricing-card', [ 'align' => false, 'selected_selector' => '.lc-pricing-card.is-selected' ] );
		$this->style_section( 'outline', 'Selected outline' );
		$this->lc_color( 'outline_color', 'Outline color', $this->sel( '.lc-pricing-card.is-selected' ), 'outline-color' );
		$this->lc_slider( 'outline_w', 'Outline width', '.lc-pricing-card.is-selected', 'outline-width: {{SIZE}}{{UNIT}};', [ 'px' ], 10 );
		$this->lc_slider( 'outline_off', 'Outline offset', '.lc-pricing-card.is-selected', 'outline-offset: {{SIZE}}{{UNIT}};', [ 'px' ], 20 );
		$this->end_controls_section();
		$this->lc_pill_style( 'badge', 'Badge', '.lc-pricing-card__badge' );
		$this->lc_card_text_style( 'name', 'Name', '.lc-heading', '.lc-pricing-card:hover .lc-heading' );
		$this->style_section( 'price', 'Price' );
		$this->lc_style_controls( 'amount', '.lc-price__amount', [ 'heading' => 'Amount', 'typography' => true, 'color' => true ] );
		$this->lc_style_controls( 'period', '.lc-price__period', [ 'heading' => 'Period', 'typography' => true, 'color' => true ] );
		$this->end_controls_section();
		$this->lc_card_text_style( 'desc', 'Description', '.lc-text', '.lc-pricing-card:hover .lc-text' );
		$this->style_section( 'feat', 'Features' );
		$this->lc_slider( 'feat_gap', 'Space between rows', '.lc-pricing-card__features', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 60 );
		$this->lc_style_controls( 'feat', '.lc-check', [ 'typography' => true, 'color' => true ] );
		$this->lc_slider( 'feat_icon', 'Icon size', '.lc-check__icon', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px' ], 40 );
		$this->lc_color( 'feat_icon_color', 'Icon color', $this->sel( '.lc-check__icon' ) );
		$this->lc_color( 'feat_icon_bg', 'Icon background', $this->sel( '.lc-check__icon' ), 'background-color' );
		$this->end_controls_section();
		$this->lc_button_style( 'btn', 'Button', '.lc-pricing-card__button', [ 'selected_selector' => '.lc-pricing-card.is-selected .lc-pricing-card__button' ] );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::pricing_card( [
			'id'                 => $s['pkg_id'],
			'group'              => $s['group'],
			'badge'              => $s['badge'],
			'name'               => $s['name'],
			'amount'             => $s['amount'],
			'period'             => $s['period'],
			'description'        => $s['description'],
			'features'           => array_map( function ( $f ) { return $f['text']; }, $s['features'] ),
			'cta_label'          => $s['cta_label'],
			'cta_selected_label' => $s['cta_selected_label'],
			'theme'              => $s['theme'],
			'featured'           => R::yes( $s['featured'] ),
			'selected'           => R::yes( $s['selected'] ),
			'action'             => $s['action_type'],
			'link'               => $s['link'],
			'wa_message'         => $s['wa_message'],
			'wa_number'          => $s['wa_number'],
		] ) );
	}
}
