<?php
namespace LCW;

use Elementor\Controls_Manager as CM;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Track selector controls + render, shared by the Hero and Track Selector section widgets.
 */
trait Track_Parts {

	protected function register_track_content( array $condition = [] ) {
		$this->content_section( 'tracks', 'Track selector', $condition );
		$this->c_text( 'tr_eyebrow', 'Eyebrow', 'Choose your track' );
		$this->c_text( 'tr_title', 'Title', 'Two services. One clear starting point.' );
		$this->c_area( 'tr_description', 'Description', 'Pick the path that fits you. Each track has its own rhythm, deliverables and pricing.' );
		$r = new \Elementor\Repeater();
		$this->c_text( 'track_id', 'Track key', 'clinic', [ 'description' => '"clinic" or "rvaas" — links to Pricing Cards of the same group.' ], $r );
		$this->c_icon( 'icon', 'Icon', 'heart', [], $r );
		$this->c_text( 'title', 'Title', 'Track', [], $r );
		$this->c_text( 'badge', 'Badge', '', [], $r );
		$this->c_area( 'description', 'Description', '', [], $r );
		$this->c_text( 'link_label', 'Link label', 'Explore', [], $r );
		$this->c_text( 'target', 'Scroll to', '#clinics', [], $r );
		$this->c_select( 'theme', 'Theme', [ 'purple' => 'Purple', 'mint' => 'Mint' ], 'purple', [], $r );
		$this->c_switch( 'selected', 'Selected by default', '', [], $r );
		$this->c_repeater( 'tr_items', 'Tracks', $r, [
			[ 'track_id' => 'clinic', 'icon' => 'heart', 'title' => 'For Health Businesses', 'description' => 'Adverts that give labs, pharmacies, clinics and hospitals the status they have earned.', 'link_label' => 'Explore clinic designs', 'target' => '#clinics', 'theme' => 'purple', 'selected' => 'yes' ],
			[ 'track_id' => 'rvaas', 'icon' => 'flask', 'title' => 'For Researchers', 'badge' => 'R-VaaS', 'description' => 'Turn papers into visuals people understand, share and cite — through a repeatable process.', 'link_label' => 'Explore R-VaaS', 'target' => '#rvaas', 'theme' => 'mint' ],
		], '{{{ title }}}' );
		$this->lc_columns( 'tr_cols', '.lc-tracks__grid', '', 4 );
		$this->end_controls_section();
	}

	protected function register_track_style( array $condition = [] ) {
		$this->style_section( 'tr_box', 'Track selector · Box', $condition );
		$this->lc_style_controls( 'tr_box', '.lc-tracks', [ 'margin' => true, 'padding' => true, 'border' => true, 'radius' => true, 'bg' => true, 'shadow' => true ] );
		$this->lc_slider( 'tr_grid_gap', 'Gap between cards', '.lc-tracks__grid', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 80 );
		$this->lc_style_controls( 'tr_eb', '.lc-tracks__head .lc-eyebrow', [ 'heading' => 'Eyebrow', 'typography' => true, 'color' => true ] );
		$this->lc_style_controls( 'tr_tt', '.lc-tracks__head .lc-heading', [ 'heading' => 'Title', 'typography' => true, 'color' => true ] );
		$this->lc_style_controls( 'tr_ds', '.lc-tracks__head .lc-text', [ 'heading' => 'Description', 'typography' => true, 'color' => true ] );
		$this->end_controls_section();
		$this->lc_card_style( 'tr_card', 'Track selector · Cards', '.lc-track-card', [ 'align' => false, 'selected_selector' => '.lc-track-card.is-selected', 'condition' => $condition ] );
		$this->style_section( 'tr_ct', 'Track selector · Card text', $condition );
		$this->lc_style_controls( 'tr_ct_title', '.lc-track-card .lc-heading', [ 'heading' => 'Title', 'typography' => true, 'color' => true ] );
		$this->lc_style_controls( 'tr_ct_desc', '.lc-track-card .lc-text', [ 'heading' => 'Description', 'typography' => true, 'color' => true ] );
		$this->lc_style_controls( 'tr_ct_link', '.lc-track-card__link', [ 'heading' => 'Link', 'typography' => true, 'color' => true, 'hover' => true, 'hover_selector' => '.lc-track-card:hover .lc-track-card__link' ] );
		$this->lc_style_controls( 'tr_ct_tile', '.lc-track-card .lc-icon-tile', [ 'heading' => 'Icon tile', 'color' => true, 'color_label' => 'Icon color', 'bg' => true, 'bg_types' => [ 'classic' ], 'radius' => true ] );
		$this->end_controls_section();
	}

	protected function render_tracks( array $s ) {
		$out  = '<div class="lc-tracks"><div class="lc-tracks__head"><div class="lc-stack" style="--lc-stack-gap: 0.5rem">';
		$out .= R::eyebrow( [ 'label' => $s['tr_eyebrow'] ] ) . R::heading( [ 'text' => $s['tr_title'], 'level' => 'h3' ] ) . '</div>';
		$out .= R::text( [ 'text' => $s['tr_description'], 'size' => 'small' ] ) . '</div><div class="lc-tracks__grid">';
		foreach ( $s['tr_items'] as $t ) {
			$out .= R::track_card( [
				'id' => $t['track_id'], 'icon' => $t['icon'], 'icon_custom' => $t['icon_custom'], 'title' => $t['title'], 'badge' => $t['badge'],
				'description' => $t['description'], 'link_label' => $t['link_label'], 'target' => $t['target'], 'theme' => $t['theme'], 'selected' => R::yes( $t['selected'] ),
			] );
		}
		return $out . '</div></div>';
	}
}
