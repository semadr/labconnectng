<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Work Card — portfolio tile (advert, graphical abstract, carousel, poster). */
class Work_Card extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-work-card'; }
	public function get_title() { return 'LC Work Card'; }
	public function get_icon() { return 'eicon-image-box'; }

	const THEMES = [ 'purple' => 'Purple', 'lavender' => 'Lavender', 'night' => 'Night', 'mint' => 'Mint', 'white' => 'White' ];
	const KINDS  = [ 'advert' => 'Advert (bottom strip)', 'abstract' => 'Graphical abstract (metrics)', 'carousel' => 'Carousel (dots)', 'poster' => 'Poster (footer line)' ];

	protected function register_controls() {
		$this->content_section( 'content', 'Work' );
		$this->c_select( 'kind', 'Layout', self::KINDS, 'advert' );
		$this->c_select( 'theme', 'Theme', self::THEMES, 'purple' );
		$this->c_media( 'image', 'Image (optional)' );
		$this->c_text( 'tag', 'Tag', 'Clinic advert' );
		$this->c_select( 'tag_variant', 'Tag style', self::PILL_VARIANTS, 'glass' );
		$this->c_area( 'title', 'Title', 'Free Health Screening Weekend', [ 'rows' => 2 ] );
		$this->c_area( 'body', 'Body', 'Blood pressure · Blood sugar · General consultation' );
		$this->c_text( 'strip_label', 'Strip label', 'Book your slot', [ 'condition' => [ 'kind' => 'advert' ] ] );
		$this->c_text( 'strip_note', 'Strip note (empty = logo mark)', 'Limited spaces →', [ 'condition' => [ 'kind' => 'advert' ] ] );
		$r = new \Elementor\Repeater();
		$this->c_text( 'value', 'Value', '1', [], $r );
		$this->c_text( 'label', 'Label', 'Label', [], $r );
		$this->c_switch( 'highlight', 'Highlight', '', [], $r );
		$this->add_control( 'metrics', [
			'label' => 'Metrics', 'type' => CM::REPEATER, 'fields' => $r->get_controls(), 'title_field' => '{{{ value }}} · {{{ label }}}', 'condition' => [ 'kind' => 'abstract' ],
			'default' => [ [ 'value' => '1', 'label' => 'Core question' ], [ 'value' => '3', 'label' => 'Key findings' ], [ 'value' => '→', 'label' => 'Clear takeaway', 'highlight' => 'yes' ] ],
		] );
		$this->c_text( 'footer_label', 'Footer label', 'Ready for print + LinkedIn', [ 'condition' => [ 'kind' => 'poster' ] ] );
		$this->end_controls_section();

		$this->lc_card_style( 'card', 'Card', '.lc-work-card', [ 'align' => false ] );
		$this->lc_pill_style( 'tag', 'Tag', '.lc-work-card > div > .lc-pill' );
		$this->lc_card_text_style( 'title', 'Title', '.lc-work-card__title', '.lc-work-card:hover .lc-work-card__title' );
		$this->lc_card_text_style( 'body', 'Body', '.lc-work-card__body', '.lc-work-card:hover .lc-work-card__body' );
		$this->style_section( 'strip', 'Bottom strip', [ 'kind' => 'advert' ] );
		$this->lc_style_controls( 'strip', '.lc-work-card__strip', [ 'typography' => true, 'padding' => true, 'color' => true, 'bg' => true, 'border' => true ] );
		$this->lc_color( 'strip_note_color', 'Note color', $this->sel( '.lc-work-card__strip-note' ) );
		$this->end_controls_section();
		$this->style_section( 'metrics', 'Metrics', [ 'kind' => 'abstract' ] );
		$this->lc_style_controls( 'metric', '.lc-metric', [ 'color' => true, 'bg' => true, 'radius' => true, 'padding' => true ] );
		$this->lc_style_controls( 'metric_hl', '.lc-metric--mint', [ 'heading' => 'Highlighted', 'color' => true, 'bg' => true ] );
		$this->end_controls_section();
		$this->style_section( 'dots', 'Carousel dots', [ 'kind' => 'carousel' ] );
		$this->lc_color( 'dots_color', 'Dot color', $this->sel( '.lc-work-card__dots span' ), 'background-color' );
		$this->lc_color( 'dots_active', 'Active dot color', $this->sel( '.lc-work-card__dots span:first-child' ), 'background-color' );
		$this->end_controls_section();
		$this->style_section( 'footer', 'Footer line', [ 'kind' => 'poster' ] );
		$this->lc_style_controls( 'footer', '.lc-work-card__footer', [ 'typography' => true, 'color' => true ] );
		$this->end_controls_section();
		$this->style_section( 'img', 'Image', [ 'image[url]!' => '' ] );
		$this->lc_slider( 'img_h', 'Height', '.lc-work-card__image', 'height: {{SIZE}}{{UNIT}}; aspect-ratio: auto;', [ 'px' ], 600 );
		$this->lc_dimensions( 'img_radius', 'Radius', '.lc-work-card__image', 'border-radius' );
		$this->end_controls_section();
	}

	protected function render() {
		$s       = $this->get_settings_for_display();
		$metrics = array_map( function ( $m ) { return [ 'value' => $m['value'], 'label' => $m['label'], 'highlight' => R::yes( $m['highlight'] ) ]; }, (array) $s['metrics'] );
		$this->out( R::work_card( [
			'kind' => $s['kind'], 'theme' => $s['theme'], 'tag' => $s['tag'], 'tag_variant' => $s['tag_variant'], 'title' => $s['title'], 'body' => $s['body'],
			'strip_label' => $s['strip_label'], 'strip_note' => $s['strip_note'], 'metrics' => $metrics, 'footer_label' => $s['footer_label'], 'image' => $this->media_url( $s['image'] ),
		] ) );
	}
}
