<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** LC Nav Menu — horizontal or vertical link list. */
class Nav_Menu extends Base_Widget {
	protected $lc_group = 'molecules';
	public function get_name() { return 'lc-nav-menu'; }
	public function get_title() { return 'LC Nav Menu'; }
	public function get_icon() { return 'eicon-nav-menu'; }

	public static function default_links() {
		return [
			[ 'label' => 'For Clinics', 'link' => [ 'url' => '#clinics' ] ],
			[ 'label' => 'For Researchers', 'link' => [ 'url' => '#rvaas' ], 'accent' => '(R-VaaS)' ],
			[ 'label' => 'Packages', 'link' => [ 'url' => '#packages' ] ],
			[ 'label' => 'Work', 'link' => [ 'url' => '#work' ] ],
			[ 'label' => 'Contact', 'link' => [ 'url' => '#contact' ] ],
		];
	}

	protected function register_controls() {
		$this->content_section( 'content', 'Links' );
		$r = new \Elementor\Repeater();
		$this->c_text( 'label', 'Label', 'Link', [], $r );
		$this->c_url( 'link', 'Link', '#', [], $r );
		$this->c_text( 'accent', 'Accent text (optional)', '', [], $r );
		$this->c_repeater( 'links', 'Links', $r, self::default_links(), '{{{ label }}}' );
		$this->c_select( 'orientation', 'Layout', [ 'horizontal' => 'Horizontal', 'vertical' => 'Vertical (list)' ], 'horizontal' );
		$this->lc_align( 'align', '.lc-nav', 'flex' );
		$this->end_controls_section();

		$this->style_section( 'links', 'Links' );
		$this->lc_slider( 'links_gap', 'Spacing', '.lc-nav', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 100 );
		$this->lc_style_controls( 'link', '.lc-nav__link', [ 'typography' => true, 'padding' => true, 'radius' => true, 'color' => true, 'bg' => true, 'hover' => true ] );
		$this->lc_color( 'accent_color', 'Accent text color', $this->sel( '.lc-nav__accent' ) );
		$this->lc_color( 'divider', 'Divider color (vertical)', $this->sel( '.lc-nav--vertical .lc-nav__link' ), 'border-bottom-color' );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$this->out( R::nav( $s['links'], $s['orientation'] ) );
	}
}
