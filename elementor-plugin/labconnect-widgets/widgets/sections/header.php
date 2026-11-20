<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Header — logo + nav menu + CTA button, with mobile drawer. */
class Section_Site_Header extends Base_Widget {
	protected $lc_group = 'sections';
	public function get_name() { return 'lc-site-header'; }
	public function get_title() { return 'LC Header'; }
	public function get_icon() { return 'eicon-header'; }

	protected function register_controls() {
		$this->content_section( 'content', 'Header' );
		$this->c_media( 'logo', 'Logo image', [ 'description' => 'Empty = bundled LabConnect logo.' ] );
		$this->c_url( 'logo_link', 'Logo link', '#top' );
		$r = new \Elementor\Repeater();
		$this->c_text( 'label', 'Label', 'Link', [], $r );
		$this->c_url( 'link', 'Link', '#', [], $r );
		$this->c_text( 'accent', 'Accent text (optional)', '', [], $r );
		$this->c_repeater( 'links', 'Menu links', $r, Nav_Menu::default_links(), '{{{ label }}}' );
		$this->end_controls_section();

		$this->content_section( 'cta', 'Button' );
		$this->c_switch( 'show_cta', 'Show button', 'yes' );
		$this->c_button( 'cta', [ 'label' => 'Start Your Project', 'link' => '#contact', 'icon' => 'arrow-right', 'size' => 'sm' ] );
		$this->add_control( 'sticky_note', [ 'type' => CM::RAW_HTML, 'raw' => 'To keep the header pinned while scrolling, turn on Sticky for the container that holds this widget (Advanced → Motion Effects).', 'separator' => 'before' ] );
		$this->end_controls_section();

		$this->style_section( 'bar', 'Bar' );
		$this->lc_slider( 'bar_h', 'Height', '.lc-header__inner', 'min-height: {{SIZE}}{{UNIT}};', [ 'px' ], 200 );
		$this->lc_slider( 'bar_inner', 'Inner max width', '.lc-header > .lc-container', 'max-width: {{SIZE}}{{UNIT}};', [ 'px', '%' ], 1800 );
		$this->lc_style_controls( 'bar', '.lc-header', [ 'padding' => true, 'border' => true, 'bg' => true, 'shadow' => true ] );
		$this->add_control( 'bar_blur', [ 'label' => 'Background blur', 'type' => CM::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ], 'selectors' => [ $this->sel( '.lc-header' ) => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);' ] ] );
		$this->end_controls_section();

		$this->style_section( 'logo', 'Logo' );
		$this->lc_slider( 'logo_h', 'Height', '.lc-logo img', 'height: {{SIZE}}{{UNIT}};', [ 'px' ], 160 );
		$this->end_controls_section();

		$this->style_section( 'nav', 'Menu links' );
		$this->lc_slider( 'nav_gap', 'Spacing', '.lc-header__nav .lc-nav', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 100 );
		$this->lc_style_controls( 'nav', '.lc-nav__link', [ 'typography' => true, 'padding' => true, 'color' => true, 'hover' => true ] );
		$this->lc_color( 'nav_accent', 'Accent text color', $this->sel( '.lc-nav__accent' ) );
		$this->end_controls_section();

		$this->lc_button_style( 'btn', 'Button', '.lc-header .lc-btn', [ 'condition' => [ 'show_cta' => 'yes' ] ] );

		$this->style_section( 'mob', 'Mobile menu' );
		$this->lc_style_controls( 'tog', '.lc-header__toggle', [ 'heading' => 'Menu button', 'width' => true, 'height' => true, 'border' => true, 'radius' => true, 'color' => true, 'bg' => true ] );
		$this->lc_style_controls( 'drawer', '.lc-header__drawer', [ 'heading' => 'Drawer', 'padding' => true, 'bg' => true, 'border' => true ] );
		$this->lc_color( 'drawer_div', 'Drawer divider color', $this->sel( '.lc-header__drawer .lc-nav__link' ), 'border-bottom-color' );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$links = $s['links'];
		$btn   = R::yes( $s['show_cta'] ) ? $this->button_args( $s, 'cta' ) : null;
		$out   = '<header class="lc-header"><div class="lc-container lc-header__inner">';
		$out  .= R::logo( [ 'src' => $this->media_url( $s['logo'] ), 'link' => $s['logo_link'] ] );
		$out  .= '<div class="lc-header__nav">' . R::nav( $links ) . '</div>';
		$out  .= $btn ? R::button( [ 'class' => 'lc-header__cta' ] + $btn ) : '<span></span>';
		$out  .= '<button type="button" class="lc-header__toggle" aria-expanded="false" aria-label="Open menu">'
			. \LCW\Icons::svg( 'menu', 'lc-header__icon-open' ) . \LCW\Icons::svg( 'x', 'lc-header__icon-close' ) . '</button></div>';
		$out  .= '<div class="lc-header__drawer" hidden>' . R::nav( $links, 'vertical' ) . ( $btn ? R::button( [ 'size' => 'md', 'block' => true ] + $btn ) : '' ) . '</div>';
		$this->out( $out . '</header>' );
	}
}
