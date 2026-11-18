<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Track Card — selectable audience card (Health Businesses / Researchers). */
class Track_Card extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-track-card'; }
	public function get_title() { return 'LC Track Card'; }
	public function get_icon() { return 'eicon-select'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Track' );
		$this->c_icon( 'icon', 'Icon', 'heart' );
		$this->c_text( 'title', 'Title', 'For Health Businesses' );
		$this->c_text( 'badge', 'Badge (optional)', '' );
		$this->c_area( 'description', 'Description', 'Adverts that give labs, pharmacies, clinics and hospitals the status they have earned.' );
		$this->c_text( 'link_label', 'Link label', 'Explore clinic designs' );
		$this->c_text( 'target', 'Scroll to (anchor or URL)', '#clinics' );
		$this->c_select( 'theme', 'Theme', [ 'purple' => 'Purple (clinics)', 'mint' => 'Mint (researchers)' ], 'purple' );
		$this->c_heading( 'sel_hd', 'Selection' );
		$this->c_switch( 'selectable', 'Selectable (shares choice with Pricing Cards + Final CTA)', 'yes' );
		$this->c_text( 'track_id', 'Track key', 'clinic', [ 'description' => 'Use "clinic" or "rvaas" to match the Pricing Card group.', 'condition' => [ 'selectable' => 'yes' ] ] );
		$this->c_switch( 'selected', 'Selected by default', 'yes', [ 'condition' => [ 'selectable' => 'yes' ] ] );
		$this->c_text( 'select_label', '"Select" label', 'Select', [ 'condition' => [ 'selectable' => 'yes' ] ] );
		$this->c_text( 'selected_label', '"Selected" label', 'Selected', [ 'condition' => [ 'selectable' => 'yes' ] ] );
		$this->end_controls_section();

		$this->lc_card_style( 'card', 'Card', '.lc-track-card', [ 'align' => false, 'selected_selector' => '.lc-track-card.is-selected' ] );
		$this->lc_icon_tile_style( 'tile', 'Icon tile', '.lc-icon-tile', '.lc-track-card:hover .lc-icon-tile' );
		$this->lc_pill_style( 'state', '"Select" pill', '.lc-track-card__state--off', [ 'selectable' => 'yes' ] );
		$this->lc_pill_style( 'state_on', '"Selected" pill', '.lc-track-card__state--on', [ 'selectable' => 'yes' ] );
		$this->lc_card_text_style( 'title', 'Title', '.lc-heading', '.lc-track-card:hover .lc-heading' );
		$this->lc_pill_style( 'badge', 'Badge', '.lc-track-card__title .lc-pill' );
		$this->lc_card_text_style( 'desc', 'Description', '.lc-text', '.lc-track-card:hover .lc-text' );
		$this->style_section( 'link', 'Link' );
		$this->lc_style_controls( 'link', '.lc-track-card__link', [ 'typography' => true, 'gap' => true, 'margin' => true, 'color' => true, 'hover' => true, 'hover_selector' => '.lc-track-card:hover .lc-track-card__link' ] );
		$this->lc_slider( 'link_icon', 'Arrow size', '.lc-track-card__link svg', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px' ], 40 );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::track_card( [
			'id'             => $s['track_id'],
			'icon'           => $s['icon'],
			'icon_custom'    => $s['icon_custom'],
			'title'          => $s['title'],
			'badge'          => $s['badge'],
			'description'    => $s['description'],
			'link_label'     => $s['link_label'],
			'target'         => $s['target'],
			'theme'          => $s['theme'],
			'selectable'     => R::yes( $s['selectable'] ),
			'selected'       => R::yes( $s['selected'] ),
			'select_label'   => $s['select_label'],
			'selected_label' => $s['selected_label'],
		] ) );
	}
}
