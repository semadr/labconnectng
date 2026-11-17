<?php
namespace LCW;

use Elementor\Controls_Manager as CM;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base for every LabConnect widget.
 * - Output is wrapped in <div class="lc-w"> (scope for labconnect.css).
 * - Style selectors are built with sel(): "{{WRAPPER}} .lc-w <selector>".
 * - lc_style() adds a full style panel for one element (typography, size, spacing,
 *   border, radius, colours/background/shadow with Normal / Hover / Selected tabs).
 */
abstract class Base_Widget extends \Elementor\Widget_Base {

	/** atoms | molecules | sections */
	protected $lc_group = 'atoms';

	const BTN_VARIANTS = [
		'primary' => 'Purple (primary)',
		'accent'  => 'Mint (accent)',
		'outline' => 'Outline',
		'light'   => 'White',
		'ghost'   => 'Text link',
	];
	const BTN_SIZES = [ 'sm' => 'Small', 'md' => 'Medium', 'lg' => 'Large' ];
	const PILL_VARIANTS = [
		'outline'   => 'Outline',
		'dark'      => 'Purple',
		'mint'      => 'Mint',
		'mint-soft' => 'Mint soft',
		'glass'     => 'Glass (on dark)',
		'chip'      => 'Chip (no caps)',
	];
	const HEADING_LEVELS = [ 'hero' => 'Hero (largest)', 'h2' => 'Section title', 'h3' => 'Sub-title', 'h4' => 'Card title' ];
	const HTML_TAGS = [ '' => 'Auto', 'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6', 'p' => 'p', 'div' => 'div', 'span' => 'span' ];

	const STYLE_DEFAULTS = [
		'heading'           => null,
		'condition'         => [],
		'typography'        => false,
		'text_shadow'       => false,
		'color'             => false,
		'color_prop'        => 'color',
		'color_label'       => 'Text color',
		'bg'                => false,
		'bg_types'          => [ 'classic', 'gradient' ],
		'border'            => false,
		'radius'            => false,
		'shadow'            => false,
		'padding'           => false,
		'margin'            => false,
		'width'             => false,
		'height'            => false,
		'min_height'        => false,
		'max_width'         => false,
		'gap'               => false,
		'gap_selector'      => null,
		'hover'             => false,
		'hover_selector'    => null,
		'selected_selector' => null,
		'lift'              => false,
		'transition'        => false,
	];

	public function get_categories() {
		return [ 'lc-' . $this->lc_group ];
	}

	public function get_keywords() {
		return [ 'labconnect', 'lc', $this->lc_group ];
	}

	public function get_style_depends() {
		return [ 'lcw-fonts', 'lcw-styles', 'lcw-compat' ];
	}

	public function get_script_depends() {
		return [ 'lcw-frontend' ];
	}

	protected function out( $html ) {
		echo '<div class="lc-w">' . $html . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts in R.
	}

	/* =========================================================
	 * Selectors
	 * ======================================================= */

	/** "a, b" -> "{{WRAPPER}} .lc-w a, {{WRAPPER}} .lc-w b". Use "&" for the .lc-w wrapper itself. */
	protected function sel( $selector, $suffix = '' ) {
		$parts = array_map( 'trim', explode( ',', $selector ) );
		$out   = [];
		foreach ( $parts as $p ) {
			$out[] = ( '&' === $p || '' === $p ) ? '{{WRAPPER}} .lc-w' . $suffix : '{{WRAPPER}} .lc-w ' . $p . $suffix;
		}
		return implode( ', ', $out );
	}

	/* =========================================================
	 * Content control shorthands ($t = $this or a Repeater)
	 * ======================================================= */

	protected function t( $t ) {
		return $t ? $t : $this;
	}

	protected function c_text( $id, $label, $default = '', array $x = [], $t = null ) {
		$this->t( $t )->add_control( $id, [ 'label' => $label, 'type' => CM::TEXT, 'default' => $default, 'label_block' => true, 'dynamic' => [ 'active' => true ] ] + $x );
	}

	protected function c_area( $id, $label, $default = '', array $x = [], $t = null ) {
		$this->t( $t )->add_control( $id, [ 'label' => $label, 'type' => CM::TEXTAREA, 'default' => $default, 'rows' => 3, 'dynamic' => [ 'active' => true ] ] + $x );
	}

	protected function c_select( $id, $label, array $options, $default, array $x = [], $t = null ) {
		$this->t( $t )->add_control( $id, [ 'label' => $label, 'type' => CM::SELECT, 'options' => $options, 'default' => $default ] + $x );
	}

	protected function c_switch( $id, $label, $default = '', array $x = [], $t = null ) {
		$this->t( $t )->add_control( $id, [ 'label' => $label, 'type' => CM::SWITCHER, 'return_value' => 'yes', 'default' => $default ] + $x );
	}

	protected function c_url( $id, $label = 'Link', $default = '#', array $x = [], $t = null ) {
		$this->t( $t )->add_control( $id, [ 'label' => $label, 'type' => CM::URL, 'default' => [ 'url' => $default ], 'dynamic' => [ 'active' => true ] ] + $x );
	}

	protected function c_number( $id, $label, $default, $min = 0, $max = 100, $step = 1, array $x = [], $t = null ) {
		$this->t( $t )->add_control( $id, [ 'label' => $label, 'type' => CM::NUMBER, 'default' => $default, 'min' => $min, 'max' => $max, 'step' => $step ] + $x );
	}

	protected function c_media( $id, $label, array $x = [], $t = null ) {
		$this->t( $t )->add_control( $id, [ 'label' => $label, 'type' => CM::MEDIA, 'default' => [ 'url' => '' ], 'dynamic' => [ 'active' => true ] ] + $x );
	}

	protected function c_heading( $id, $label ) {
		$this->add_control( $id, [ 'label' => $label, 'type' => CM::HEADING, 'separator' => 'before' ] );
	}

	protected function c_repeater( $id, $label, Repeater $r, array $default, $title_field ) {
		$this->add_control( $id, [ 'label' => $label, 'type' => CM::REPEATER, 'fields' => $r->get_controls(), 'default' => $default, 'title_field' => $title_field ] );
	}

	/** LC icon set + "Custom" (Elementor icon library). */
	protected function c_icon( $id, $label = 'Icon', $default = 'none', array $x = [], $t = null ) {
		$opts = [ 'none' => '— None —' ] + Icons::options() + [ 'custom' => 'Custom (icon library)…' ];
		$this->t( $t )->add_control( $id, [ 'label' => $label, 'type' => CM::SELECT, 'options' => $opts, 'default' => $default ] + $x );
		$cond = isset( $x['condition'] ) ? $x['condition'] : [];
		$this->t( $t )->add_control( $id . '_custom', [ 'label' => $label . ' (library)', 'type' => CM::ICONS, 'default' => [ 'value' => 'fas fa-star', 'library' => 'fa-solid' ], 'condition' => [ $id => 'custom' ] + $cond ] );
	}

	/** Grouped button content controls, prefixed. */
	protected function c_button( $p, array $d = [], $t = null ) {
		$d += [ 'label' => 'Start Your Project', 'link' => '#contact', 'variant' => 'primary', 'size' => 'md', 'icon' => 'none', 'icon_pos' => 'after' ];
		$this->c_text( $p . '_label', 'Label', $d['label'], [], $t );
		$this->c_url( $p . '_link', 'Link', $d['link'], [], $t );
		$this->c_select( $p . '_variant', 'Style', self::BTN_VARIANTS, $d['variant'], [], $t );
		$this->c_select( $p . '_size', 'Size', self::BTN_SIZES, $d['size'], [], $t );
		$this->c_icon( $p . '_icon', 'Icon', $d['icon'], [], $t );
		$this->c_select( $p . '_icon_pos', 'Icon position', [ 'before' => 'Before', 'after' => 'After' ], $d['icon_pos'], [ 'condition' => [ $p . '_icon!' => 'none' ] ], $t );
	}

	protected function button_args( array $s, $p, array $extra = [] ) {
		$v = function ( $k, $def = '' ) use ( $s, $p ) {
			return isset( $s[ $p . '_' . $k ] ) ? $s[ $p . '_' . $k ] : $def;
		};
		return $extra + [
			'label'       => $v( 'label' ),
			'link'        => $v( 'link' ),
			'variant'     => $v( 'variant', 'primary' ),
			'size'        => $v( 'size', 'md' ),
			'icon'        => $v( 'icon', 'none' ),
			'icon_custom' => $v( 'icon_custom', null ),
			'icon_pos'    => $v( 'icon_pos', 'after' ),
		];
	}

	/** Heading text + highlight controls, prefixed. */
	protected function c_heading_text( $p, array $d = [], $with_level = true ) {
		$d += [ 'text' => 'Heading', 'highlight' => '', 'tone' => 'purple', 'level' => 'h2', 'tag' => '' ];
		$this->c_area( $p . '_text', 'Title', $d['text'], [ 'rows' => 2 ] );
		$this->c_area( $p . '_highlight', 'Highlight words', $d['highlight'], [ 'rows' => 2, 'description' => 'Words or phrases from the title to colour. One per line.' ] );
		$this->c_select( $p . '_hl_tone', 'Highlight colour', [ 'purple' => 'Purple', 'mint' => 'Mint' ], $d['tone'] );
		if ( $with_level ) {
			$this->c_select( $p . '_level', 'Size preset', self::HEADING_LEVELS, $d['level'] );
			$this->c_select( $p . '_tag', 'HTML tag', self::HTML_TAGS, $d['tag'] );
		}
	}

	/** Media control value -> URL. */
	protected function media_url( $v ) {
		return is_array( $v ) && ! empty( $v['url'] ) ? $v['url'] : '';
	}

	/** Splits a textarea into non-empty lines. */
	protected function lines( $v ) {
		return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $v ) ), 'strlen' ) );
	}

	/* =========================================================
	 * Style helpers
	 * ======================================================= */

	protected function style_section( $id, $label, array $condition = [] ) {
		$args = [ 'label' => $label, 'tab' => CM::TAB_STYLE ];
		if ( $condition ) {
			$args['condition'] = $condition;
		}
		$this->start_controls_section( $id . '_style', $args );
	}

	protected function content_section( $id, $label, array $condition = [] ) {
		$args = [ 'label' => $label, 'tab' => CM::TAB_CONTENT ];
		if ( $condition ) {
			$args['condition'] = $condition;
		}
		$this->start_controls_section( $id, $args );
	}

	/** Alignment control. mode: text | flex | items | self | block */
	protected function lc_align( $id, $selector, $mode = 'text', $label = 'Alignment', $justify = false ) {
		$opts = [
			'left'   => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
			'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
			'right'  => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
		];
		if ( $justify ) {
			$opts['justify'] = [ 'title' => 'Full width', 'icon' => 'eicon-text-align-justify' ];
		}
		$dict = [
			'text'  => [ 'left' => 'text-align: left;', 'center' => 'text-align: center;', 'right' => 'text-align: right;', 'justify' => 'text-align: justify;' ],
			'flex'  => [ 'left' => 'justify-content: flex-start;', 'center' => 'justify-content: center;', 'right' => 'justify-content: flex-end;', 'justify' => 'justify-content: space-between;' ],
			'items' => [ 'left' => 'justify-items: start; text-align: left;', 'center' => 'justify-items: center; text-align: center;', 'right' => 'justify-items: end; text-align: right;', 'justify' => 'justify-items: stretch;' ],
			'self'  => [ 'left' => 'margin-right: auto; margin-left: 0;', 'center' => 'margin-left: auto; margin-right: auto;', 'right' => 'margin-left: auto; margin-right: 0;', 'justify' => 'width: 100%;' ],
		];
		$this->add_responsive_control( $id, [
			'label'                => $label,
			'type'                 => CM::CHOOSE,
			'options'              => $opts,
			'toggle'               => true,
			'selectors_dictionary' => $dict[ $mode ],
			'selectors'            => [ $this->sel( $selector ) => '{{VALUE}}' ],
		] );
	}

	protected function lc_slider( $id, $label, $selector, $css, array $units = [ 'px', 'em', 'rem', '%' ], $max = 1000, array $x = [] ) {
		$range = [];
		foreach ( $units as $u ) {
			$range[ $u ] = in_array( $u, [ '%', 'vw', 'vh' ], true ) ? [ 'min' => 0, 'max' => 100 ] : ( in_array( $u, [ 'em', 'rem' ], true ) ? [ 'min' => 0, 'max' => 20, 'step' => 0.1 ] : [ 'min' => 0, 'max' => $max ] );
		}
		$this->add_responsive_control( $id, [
			'label'      => $label,
			'type'       => CM::SLIDER,
			'size_units' => $units,
			'range'      => $range,
			'selectors'  => [ $this->sel( $selector ) => $css ],
		] + $x );
	}

	protected function lc_dimensions( $id, $label, $selector, $prop ) {
		$this->add_responsive_control( $id, [
			'label'      => $label,
			'type'       => CM::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'selectors'  => [ $this->sel( $selector ) => $prop . ': {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
	}

	protected function lc_color( $id, $label, $selector, $prop = 'color' ) {
		$this->add_control( $id, [ 'label' => $label, 'type' => CM::COLOR, 'selectors' => [ $selector => $prop . ': {{VALUE}};' ] ] );
	}

	/** Full style panel (own section) for one element. */
	protected function lc_style( $id, $label, $selector, array $o = [] ) {
		$o += self::STYLE_DEFAULTS;
		$this->style_section( $id, $label, $o['condition'] );
		$this->lc_style_controls( $id, $selector, $o );
		$this->end_controls_section();
	}

	/** Same controls without opening a section (stack several elements in one panel). */
	protected function lc_style_controls( $id, $selector, array $o = [] ) {
		$o   += self::STYLE_DEFAULTS;
		$sel  = $this->sel( $selector );
		$hsel = null !== $o['hover_selector'] ? $this->sel( $o['hover_selector'] ) : $this->sel( $selector, ':hover' );

		if ( $o['heading'] ) {
			$this->add_control( $id . '_hd', [ 'label' => $o['heading'], 'type' => CM::HEADING, 'separator' => 'before' ] );
		}
		if ( $o['typography'] ) {
			$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => $id . '_typo', 'selector' => $sel ] );
		}
		if ( $o['text_shadow'] ) {
			$this->add_group_control( Group_Control_Text_Shadow::get_type(), [ 'name' => $id . '_tshadow', 'selector' => $sel ] );
		}
		if ( $o['width'] ) {
			$this->lc_slider( $id . '_width', 'Width', $selector, 'width: {{SIZE}}{{UNIT}};', [ 'px', '%', 'em', 'vw' ] );
		}
		if ( $o['height'] ) {
			$this->lc_slider( $id . '_height', 'Height', $selector, 'height: {{SIZE}}{{UNIT}};', [ 'px', 'em', 'vh' ] );
		}
		if ( $o['min_height'] ) {
			$this->lc_slider( $id . '_min_height', 'Min height', $selector, 'min-height: {{SIZE}}{{UNIT}};', [ 'px', 'em', 'vh' ] );
		}
		if ( $o['max_width'] ) {
			$this->lc_slider( $id . '_max_width', 'Max width', $selector, 'max-width: {{SIZE}}{{UNIT}};', [ 'px', '%', 'em', 'vw' ], 1600 );
		}
		if ( $o['gap'] ) {
			$this->lc_slider( $id . '_gap', 'Spacing between items', null !== $o['gap_selector'] ? $o['gap_selector'] : $selector, 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em', 'rem' ], 120 );
		}
		if ( $o['padding'] ) {
			$this->lc_dimensions( $id . '_padding', 'Padding', $selector, 'padding' );
		}
		if ( $o['margin'] ) {
			$this->lc_dimensions( $id . '_margin', 'Margin', $selector, 'margin' );
		}
		if ( $o['border'] ) {
			$this->add_group_control( Group_Control_Border::get_type(), [ 'name' => $id . '_border', 'selector' => $sel, 'separator' => 'before' ] );
		}
		if ( $o['radius'] ) {
			$this->lc_dimensions( $id . '_radius', 'Border radius', $selector, 'border-radius' );
		}

		$states = [ 'normal' => [ 'Normal', $sel ] ];
		if ( $o['hover'] ) {
			$states['hover'] = [ 'Hover', $hsel ];
		}
		if ( $o['selected_selector'] ) {
			$states['selected'] = [ 'Selected', $this->sel( $o['selected_selector'] ) ];
		}
		$has_paint = $o['color'] || $o['bg'] || $o['shadow'] || ( $o['border'] && count( $states ) > 1 );
		if ( ! $has_paint ) {
			return;
		}
		$tabs = count( $states ) > 1;
		if ( $tabs ) {
			$this->start_controls_tabs( $id . '_tabs' );
		}
		foreach ( $states as $state => $info ) {
			list( $tab_label, $s ) = $info;
			$k = 'normal' === $state ? $id : $id . '_' . $state;
			if ( $tabs ) {
				$this->start_controls_tab( $k . '_tab', [ 'label' => $tab_label ] );
			}
			if ( $o['color'] ) {
				$this->lc_color( $k . '_color', $o['color_label'], $s, $o['color_prop'] );
			}
			if ( $o['bg'] ) {
				$this->add_group_control( Group_Control_Background::get_type(), [ 'name' => $k . '_bg', 'types' => $o['bg_types'], 'selector' => $s ] );
			}
			if ( $o['border'] && 'normal' !== $state ) {
				$this->lc_color( $k . '_border_color', 'Border color', $s, 'border-color' );
			}
			if ( $o['shadow'] ) {
				$this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => $k . '_shadow', 'selector' => $s ] );
			}
			if ( 'hover' === $state && $o['lift'] ) {
				$this->add_control( $k . '_lift', [
					'label'      => 'Move up on hover',
					'type'       => CM::SLIDER,
					'size_units' => [ 'px' ],
					'range'      => [ 'px' => [ 'min' => -20, 'max' => 20 ] ],
					'selectors'  => [ $s => 'transform: translateY(calc({{SIZE}}px * -1));' ],
				] );
			}
			if ( 'hover' === $state && $o['transition'] ) {
				$this->add_control( $id . '_transition', [
					'label'     => 'Transition (s)',
					'type'      => CM::SLIDER,
					'range'     => [ 'px' => [ 'min' => 0, 'max' => 2, 'step' => 0.05 ] ],
					'selectors' => [ $sel => 'transition-duration: {{SIZE}}s;' ],
				] );
			}
			if ( $tabs ) {
				$this->end_controls_tab();
			}
		}
		if ( $tabs ) {
			$this->end_controls_tabs();
		}
	}

	/** Icon size + colour for an icon element (LC svg or library icon). */
	protected function lc_icon_style_controls( $id, $selector, $label = 'Icon', $hover_selector = null ) {
		$this->add_control( $id . '_hd', [ 'label' => $label, 'type' => CM::HEADING, 'separator' => 'before' ] );
		$this->lc_slider( $id . '_size', 'Icon size', $selector, 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 120 );
		if ( $hover_selector ) {
			$this->start_controls_tabs( $id . '_tabs' );
			$this->start_controls_tab( $id . '_n', [ 'label' => 'Normal' ] );
			$this->lc_color( $id . '_color', 'Icon color', $this->sel( $selector ) );
			$this->end_controls_tab();
			$this->start_controls_tab( $id . '_h', [ 'label' => 'Hover' ] );
			$this->lc_color( $id . '_hcolor', 'Icon color', $this->sel( $hover_selector ) );
			$this->end_controls_tab();
			$this->end_controls_tabs();
		} else {
			$this->lc_color( $id . '_color', 'Icon color', $this->sel( $selector ) );
		}
	}

	/* ---------- composite style panels reused across widgets ---------- */

	/** Button: typography, size, padding, border, radius, Normal/Hover(/Selected) colours, icon. */
	protected function lc_button_style( $id, $label, $selector, array $x = [] ) {
		$x += [ 'condition' => [], 'selected_selector' => null ];
		$this->style_section( $id, $label, $x['condition'] );
		$this->lc_style_controls( $id, $selector, [
			'typography'        => true,
			'width'             => true,
			'min_height'        => true,
			'padding'           => true,
			'border'            => true,
			'radius'            => true,
			'color'             => true,
			'bg'                => true,
			'shadow'            => true,
			'hover'             => true,
			'lift'              => true,
			'transition'        => true,
			'selected_selector' => $x['selected_selector'],
		] );
		$this->lc_slider( $id . '_icon_gap', 'Icon spacing', $selector, 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 40 );
		$this->lc_slider( $id . '_icon_size', 'Icon size', $selector . ' .lc-btn__icon', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 60 );
		$this->end_controls_section();
	}

	/** Badge / pill look. */
	protected function lc_pill_style( $id, $label, $selector, array $condition = [] ) {
		$this->style_section( $id, $label, $condition );
		$this->lc_style_controls( $id, $selector, [ 'typography' => true, 'padding' => true, 'border' => true, 'radius' => true, 'color' => true, 'bg' => true, 'shadow' => true ] );
		$this->lc_color( $id . '_dot', 'Dot color', $this->sel( $selector . ' .lc-pill__dot' ), 'background-color' );
		$this->lc_slider( $id . '_icon', 'Icon size', $selector . ' .lc-pill__icon', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 40 );
		$this->end_controls_section();
	}

	/** Heading look (typography, colours, highlight, shadow). */
	protected function lc_heading_style( $id, $label, $selector, array $x = [] ) {
		$x += [ 'condition' => [], 'align' => true, 'spacing' => false ];
		$this->style_section( $id, $label, $x['condition'] );
		if ( $x['align'] ) {
			$this->lc_align( $id . '_align', $selector, 'text' );
		}
		$this->lc_style_controls( $id, $selector, [ 'typography' => true, 'text_shadow' => true, 'color' => true, 'max_width' => true, 'margin' => $x['spacing'] ] );
		$this->add_control( $id . '_hl_hd', [ 'label' => 'Highlighted words', 'type' => CM::HEADING, 'separator' => 'before' ] );
		$this->lc_color( $id . '_hl_color', 'Highlight color', $this->sel( $selector . ' .lc-hl' ) );
		$this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => $id . '_hl_typo', 'selector' => $this->sel( $selector . ' .lc-hl' ) ] );
		$this->add_group_control( Group_Control_Background::get_type(), [ 'name' => $id . '_hl_bg', 'types' => [ 'classic', 'gradient' ], 'selector' => $this->sel( $selector . ' .lc-hl' ) ] );
		$this->end_controls_section();
	}

	/** Plain text look. */
	protected function lc_text_style( $id, $label, $selector, array $x = [] ) {
		$x += [ 'condition' => [], 'align' => true ];
		$this->style_section( $id, $label, $x['condition'] );
		if ( $x['align'] ) {
			$this->lc_align( $id . '_align', $selector, 'text' );
		}
		$this->lc_style_controls( $id, $selector, [ 'typography' => true, 'color' => true, 'max_width' => true, 'margin' => true ] );
		$this->end_controls_section();
	}

	/** Card box: alignment, padding, border, radius, bg/shadow normal + hover (+ selected). */
	protected function lc_card_style( $id, $label, $selector, array $x = [] ) {
		$x += [ 'condition' => [], 'hover' => true, 'selected_selector' => null, 'align' => 'items', 'min_height' => true, 'gap' => true ];
		$this->style_section( $id, $label, $x['condition'] );
		if ( $x['align'] ) {
			$this->lc_align( $id . '_align', $selector, $x['align'] );
		}
		$this->lc_style_controls( $id, $selector, [
			'min_height'        => $x['min_height'],
			'gap'               => $x['gap'],
			'padding'           => true,
			'border'            => true,
			'radius'            => true,
			'bg'                => true,
			'shadow'            => true,
			'hover'             => $x['hover'],
			'lift'              => $x['hover'],
			'transition'        => $x['hover'],
			'selected_selector' => $x['selected_selector'],
		] );
		$this->end_controls_section();
	}

	/** Icon tile box (size, icon size, bg, colour, radius, border, shadow). Hover follows the parent card if given. */
	protected function lc_icon_tile_style( $id, $label, $selector, $hover_selector = null, array $condition = [] ) {
		$this->style_section( $id, $label, $condition );
		$this->lc_slider( $id . '_box', 'Box size', $selector, 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 200 );
		$this->lc_slider( $id . '_icon', 'Icon size', $selector . ' svg, ' . $selector . ' .lc-icon-custom', 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};', [ 'px', 'em' ], 120 );
		$this->lc_style_controls( $id, $selector, [
			'border'         => true,
			'radius'         => true,
			'color'          => true,
			'color_label'    => 'Icon color',
			'bg'             => true,
			'shadow'         => true,
			'hover'          => true,
			'hover_selector' => $hover_selector,
		] );
		$this->end_controls_section();
	}

	/** Section shell: anchor, background, padding, inner width. */
	protected function lc_section_shell_controls( $anchor ) {
		$this->c_text( 'section_anchor', 'Section ID (anchor)', $anchor, [ 'description' => 'Used by menu links, e.g. #' . $anchor ] );
		$this->c_switch( 'section_container', 'Inner container (max width + side padding)', 'yes' );
	}

	protected function lc_section_shell_style( $selector = '.lc-section' ) {
		$this->style_section( 'shell', 'Section' );
		$this->lc_style_controls( 'shell', $selector, [ 'padding' => true, 'margin' => true, 'border' => true, 'radius' => true, 'bg' => true, 'shadow' => true ] );
		$this->lc_slider( 'shell_inner', 'Inner max width', $selector . ' > .lc-container', 'max-width: {{SIZE}}{{UNIT}};', [ 'px', '%', 'vw' ], 1800 );
		$this->lc_dimensions( 'shell_inner_pad', 'Inner side padding', $selector . ' > .lc-container', 'padding' );
		$this->end_controls_section();
	}

	protected function section_open( array $s, $classes, $tag = 'section' ) {
		$id   = isset( $s['section_anchor'] ) ? sanitize_html_class( $s['section_anchor'] ) : '';
		$flat = isset( $s['section_container'] ) && 'yes' !== $s['section_container'];
		return '<' . $tag . ' class="' . esc_attr( R::cx( $classes, $flat ? 'lc-section--flush' : '' ) ) . '"' . ( $id ? ' id="' . esc_attr( $id ) . '"' : '' ) . '><div class="lc-container">';
	}

	protected function section_close( $tag = 'section' ) {
		return '</div></' . $tag . '>';
	}

	/** Section header content + style helpers (badge / title / description). */
	protected function c_section_header( $p, array $d ) {
		$d += [ 'badge' => '', 'badge_variant' => 'dark', 'title' => '', 'highlight' => '', 'tone' => 'purple', 'description' => '', 'align' => 'split' ];
		$this->c_text( $p . '_badge', 'Badge', $d['badge'] );
		$this->c_select( $p . '_badge_variant', 'Badge style', self::PILL_VARIANTS, $d['badge_variant'] );
		$this->c_heading_text( $p, [ 'text' => $d['title'], 'highlight' => $d['highlight'], 'tone' => $d['tone'] ], false );
		$this->c_area( $p . '_description', 'Description', $d['description'] );
		$this->c_select( $p . '_align', 'Layout', [ 'split' => 'Split (title left, text right)', 'left' => 'Stacked left', 'center' => 'Centered' ], $d['align'] );
	}

	protected function section_header_args( array $s, $p ) {
		return [
			'badge'          => $s[ $p . '_badge' ],
			'badge_variant'  => $s[ $p . '_badge_variant' ],
			'title'          => $s[ $p . '_text' ],
			'highlight'      => $s[ $p . '_highlight' ],
			'highlight_tone' => $s[ $p . '_hl_tone' ],
			'description'    => $s[ $p . '_description' ],
			'align'          => $s[ $p . '_align' ],
		];
	}

	protected function lc_section_header_style( $p, $root = '.lc-section-header' ) {
		$this->style_section( $p . '_box', 'Header block' );
		$this->lc_slider( $p . '_box_gap', 'Space below header', $root, 'margin-bottom: {{SIZE}}{{UNIT}};', [ 'px', 'em', 'rem' ], 200 );
		$this->lc_slider( $p . '_box_inner_gap', 'Space between parts', $root . ', ' . $root . ' .lc-section-header__main', 'gap: {{SIZE}}{{UNIT}};', [ 'px', 'em', 'rem' ], 100 );
		$this->end_controls_section();
		$this->lc_pill_style( $p . '_badge', 'Header · Badge', $root . ' .lc-pill' );
		$this->lc_heading_style( $p . '_title', 'Header · Title', $root . ' .lc-heading' );
		$this->lc_text_style( $p . '_desc', 'Header · Description', $root . ' .lc-text' );
	}
}
