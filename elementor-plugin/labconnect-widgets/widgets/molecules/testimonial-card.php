<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Testimonial Card — quote, rating, author. */
class Testimonial_Card extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-testimonial-card'; }
	public function get_title() { return 'LC Testimonial Card'; }
	public function get_icon() { return 'eicon-testimonial'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Testimonial' );
		$this->c_area( 'quote', 'Quote', 'Our adverts finally look like the standard of care we provide. Patients mention our posts before they even mention a referral.', [ 'rows' => 5 ] );
		$this->c_text( 'name', 'Name', 'Clinic Owner' );
		$this->c_text( 'role', 'Role', 'Health business client · Weekly Authority' );
		$this->c_text( 'initials', 'Initials', 'CO' );
		$this->c_media( 'image', 'Photo (optional)' );
		$this->c_text( 'badge', 'Badge (optional)', '' );
		$this->c_number( 'rating', 'Stars', 5, 0, 5 );
		$this->c_select( 'tone', 'Theme', [ 'light' => 'Light', 'dark' => 'Dark (purple)' ], 'light' );
		$this->end_controls_section();

		$this->lc_card_style( 'card', 'Card', '.lc-testimonial', [ 'hover' => true ] );
		$this->lc_pill_style( 'badge', 'Badge', '.lc-testimonial__meta .lc-pill' );
		$this->style_section( 'stars', 'Stars' );
		$this->lc_slider( 'stars_size', 'Size', '.lc-stars svg', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px' ], 40 );
		$this->lc_color( 'stars_color', 'Color', $this->sel( '.lc-stars' ) );
		$this->end_controls_section();
		$this->lc_card_text_style( 'quote', 'Quote', '.lc-testimonial__quote', '.lc-testimonial:hover .lc-testimonial__quote' );
		$this->style_section( 'avatar', 'Avatar' );
		$this->lc_slider( 'avatar_size', 'Size', '.lc-avatar', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px' ], 160 );
		$this->lc_style_controls( 'avatar', '.lc-avatar', [ 'typography' => true, 'color' => true, 'bg' => true, 'border' => true, 'radius' => true ] );
		$this->end_controls_section();
		$this->lc_card_text_style( 'name', 'Name', '.lc-testimonial__name' );
		$this->lc_card_text_style( 'role', 'Role', '.lc-testimonial__role' );
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::testimonial( [ 'quote' => $s['quote'], 'name' => $s['name'], 'role' => $s['role'], 'initials' => $s['initials'], 'image' => $this->media_url( $s['image'] ), 'tone' => $s['tone'], 'badge' => $s['badge'], 'rating' => $s['rating'] ] ) );
	}
}
