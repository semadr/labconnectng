<?php
namespace LCW;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Markup builders — the PHP twin of src/components/lc (atoms → molecules).
 * Every method returns an HTML string so widgets can compose them freely.
 * Keep class names identical to the React components.
 */
class R {

	/* ================= helpers ================= */

	public static function cx( ...$parts ) {
		return implode( ' ', array_filter( $parts, function ( $p ) {
			return false !== $p && null !== $p && '' !== $p;
		} ) );
	}

	public static function e( $s ) {
		return esc_html( (string) $s );
	}

	public static function a( $s ) {
		return esc_attr( (string) $s );
	}

	public static function yes( $v ) {
		return 'yes' === $v || true === $v;
	}

	/** Builds data-* / aria-* attributes from an array. */
	public static function attrs( array $attrs ) {
		$out = '';
		foreach ( $attrs as $k => $v ) {
			if ( null === $v || false === $v ) {
				continue;
			}
			$out .= ' ' . $k . '="' . esc_attr( (string) $v ) . '"';
		}
		return $out;
	}

	/** href / target / rel from an Elementor URL value or a plain string. */
	public static function link_attrs( $link, $external = false ) {
		if ( is_array( $link ) ) {
			$url      = isset( $link['url'] ) ? $link['url'] : '';
			$external = ! empty( $link['is_external'] );
			$nofollow = ! empty( $link['nofollow'] );
		} else {
			$url      = (string) $link;
			$nofollow = false;
		}
		if ( '' === $url ) {
			return '';
		}
		$out = ' href="' . esc_url( $url ) . '"';
		$rel = [];
		if ( $external ) {
			$out  .= ' target="_blank"';
			$rel[] = 'noopener';
			$rel[] = 'noreferrer';
		}
		if ( $nofollow ) {
			$rel[] = 'nofollow';
		}
		if ( $rel ) {
			$out .= ' rel="' . implode( ' ', $rel ) . '"';
		}
		return $out;
	}

	/** LC icon by name, or an Elementor icon-library value when $name === 'custom'. */
	public static function icon( $name, $class = '', $custom = null, $stroke = 2 ) {
		if ( ! $name || 'none' === $name ) {
			return '';
		}
		if ( 'custom' === $name ) {
			if ( empty( $custom['value'] ) || ! class_exists( '\Elementor\Icons_Manager' ) ) {
				return '';
			}
			ob_start();
			\Elementor\Icons_Manager::render_icon( $custom, [ 'aria-hidden' => 'true' ] );
			return '<span class="' . self::a( self::cx( 'lc-icon-custom', $class ) ) . '" aria-hidden="true">' . ob_get_clean() . '</span>';
		}
		return Icons::svg( $name, $class, $stroke );
	}

	/** Splits text into plain / highlighted spans. $words: one phrase per line (or "|" separated). */
	public static function highlight( $text, $words, $tone = 'purple' ) {
		$list = is_array( $words ) ? $words : preg_split( '/[\r\n|]+/', (string) $words );
		$list = array_values( array_filter( array_map( 'trim', $list ), 'strlen' ) );
		$text = (string) $text;
		if ( ! $list ) {
			return '<span>' . self::e( $text ) . '</span>';
		}
		$re    = '/(' . implode( '|', array_map( function ( $w ) {
			return preg_quote( $w, '/' );
		}, $list ) ) . ')/u';
		$parts = preg_split( $re, $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
		$cls   = self::cx( 'lc-hl', 'mint' === $tone ? 'lc-hl--mint' : '' );
		$out   = '';
		foreach ( $parts as $p ) {
			$out .= in_array( $p, $list, true )
				? '<span class="' . $cls . '">' . self::e( $p ) . '</span>'
				: '<span>' . self::e( $p ) . '</span>';
		}
		return $out;
	}

	/* ================= atoms ================= */

	public static function button( array $a ) {
		$a += [
			'label'    => '',
			'link'     => '',
			'external' => false,
			'variant'  => 'primary',
			'size'     => 'md',
			'icon'     => '',
			'icon_custom' => null,
			'icon_pos' => 'after',
			'block'    => false,
			'class'    => '',
			'attrs'    => [],
			'label_html' => null,
			'hover_anim' => '',
		];
		$cls = self::cx(
			'lc-btn',
			'lc-btn--' . $a['variant'],
			'md' !== $a['size'] ? 'lc-btn--' . $a['size'] : '',
			$a['block'] ? 'lc-btn--block' : '',
			$a['hover_anim'] ? 'elementor-animation-' . $a['hover_anim'] : '',
			$a['class']
		);
		$before = 'before' === $a['icon_pos'] ? self::icon( $a['icon'], 'lc-btn__icon', $a['icon_custom'] ) : '';
		$after  = 'before' !== $a['icon_pos'] ? self::icon( $a['icon'], 'lc-btn__icon lc-btn__icon--trail', $a['icon_custom'] ) : '';
		$label  = null !== $a['label_html'] ? $a['label_html'] : '<span class="lc-btn__label">' . self::e( $a['label'] ) . '</span>';
		$inner  = $before . $label . $after;
		$link   = self::link_attrs( $a['link'], $a['external'] );
		if ( '' === $link ) {
			$link = ' href="#" role="button"';
		}
		return '<a class="' . self::a( $cls ) . '"' . $link . self::attrs( $a['attrs'] ) . '>' . $inner . '</a>';
	}

	public static function pill( array $a ) {
		$a += [ 'label' => '', 'variant' => 'outline', 'dot' => '', 'icon' => '', 'icon_custom' => null, 'wide' => false, 'class' => '' ];
		$dot = '';
		if ( $a['dot'] && 'none' !== $a['dot'] ) {
			$dot = '<span class="' . self::cx( 'lc-pill__dot', 'live' === $a['dot'] ? 'lc-pill__dot--live' : '' ) . '"></span>';
		}
		return '<span class="' . self::a( self::cx( 'lc-pill', 'lc-pill--' . $a['variant'], $a['wide'] ? 'lc-pill--wide' : '', $a['class'] ) ) . '">'
			. $dot . self::icon( $a['icon'], 'lc-pill__icon', $a['icon_custom'] ) . '<span class="lc-pill__label">' . self::e( $a['label'] ) . '</span></span>';
	}

	public static function eyebrow( array $a ) {
		$a += [ 'label' => '', 'tone' => 'purple', 'icon' => '', 'icon_custom' => null ];
		return '<span class="' . self::cx( 'lc-eyebrow', 'purple' !== $a['tone'] ? 'lc-eyebrow--' . $a['tone'] : '' ) . '">'
			. self::icon( $a['icon'], 'lc-eyebrow__icon', $a['icon_custom'] ) . self::e( $a['label'] ) . '</span>';
	}

	public static function heading( array $a ) {
		$a += [ 'text' => '', 'highlight' => '', 'highlight_tone' => 'purple', 'level' => 'h2', 'tag' => '', 'tone' => 'ink', 'class' => '' ];
		$default_tags = [ 'hero' => 'h1', 'h2' => 'h2', 'h3' => 'h3', 'h4' => 'h3' ];
		$tag = $a['tag'] ? $a['tag'] : ( isset( $default_tags[ $a['level'] ] ) ? $default_tags[ $a['level'] ] : 'h2' );
		$tag = in_array( $tag, [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'span' ], true ) ? $tag : 'h2';
		$cls = self::cx( 'lc-heading', 'lc-heading--' . $a['level'], 'ink' !== $a['tone'] ? 'lc-heading--' . $a['tone'] : '', $a['class'] );
		return '<' . $tag . ' class="' . self::a( $cls ) . '">' . self::highlight( $a['text'], $a['highlight'], $a['highlight_tone'] ) . '</' . $tag . '>';
	}

	public static function text( array $a ) {
		$a += [ 'text' => '', 'size' => 'body', 'on_dark' => false, 'class' => '', 'style' => 'text' ];
		if ( 'quote' === $a['style'] ) {
			return '<p class="' . self::a( self::cx( 'lc-quote', $a['class'] ) ) . '">' . wp_kses_post( $a['text'] ) . '</p>';
		}
		$cls = self::cx( 'lc-text', 'body' !== $a['size'] ? 'lc-text--' . $a['size'] : '', $a['on_dark'] ? 'lc-text--on-dark' : '', $a['class'] );
		return '<p class="' . self::a( $cls ) . '">' . wp_kses_post( $a['text'] ) . '</p>';
	}

	public static function icon_tile( array $a ) {
		$a += [ 'icon' => 'heart', 'icon_custom' => null, 'tone' => 'purple', 'size' => 'md', 'class' => '' ];
		$cls = self::cx( 'lc-icon-tile', 'purple' !== $a['tone'] ? 'lc-icon-tile--' . $a['tone'] : '', 'md' !== $a['size'] ? 'lc-icon-tile--' . $a['size'] : '', $a['class'] );
		return '<span class="' . self::a( $cls ) . '" aria-hidden="true">' . self::icon( $a['icon'], '', $a['icon_custom'] ) . '</span>';
	}

	public static function logomark( $on_dark = false, $class = '' ) {
		return '<svg viewBox="0 0 64 64" class="' . self::a( self::cx( 'lc-logomark', $on_dark ? 'lc-logomark--on-dark' : '', $class ) ) . '" aria-hidden="true">'
			. '<line x1="20" y1="18" x2="36" y2="36" class="lc-logomark__link" stroke-width="5" stroke-linecap="round"></line>'
			. '<line x1="16" y1="50" x2="36" y2="42" class="lc-logomark__link" stroke-width="5" stroke-linecap="round"></line>'
			. '<circle cx="18" cy="16" r="8" class="lc-logomark__node"></circle>'
			. '<circle cx="14" cy="50" r="6" class="lc-logomark__ring" stroke-width="5"></circle>'
			. '<circle cx="42" cy="38" r="12" class="lc-logomark__hub"></circle>'
			. '</svg>';
	}

	public static function default_logo_url() {
		return LCW_URL . 'assets/img/labconnect-logo.png';
	}

	public static function logo( array $a ) {
		$a += [ 'link' => '#top', 'src' => '', 'alt' => 'LabConnect — Build the bridge' ];
		$src  = $a['src'] ? $a['src'] : self::default_logo_url();
		$link = self::link_attrs( $a['link'] );
		$img  = '<img src="' . esc_url( $src ) . '" alt="' . self::a( $a['alt'] ) . '" width="164" height="34" />';
		return $link ? '<a class="lc-logo"' . $link . ' aria-label="LabConnect home">' . $img . '</a>' : '<span class="lc-logo">' . $img . '</span>';
	}

	public static function check( array $a ) {
		$a += [ 'label' => '', 'variant' => 'tick', 'tone' => 'purple', 'on_dark' => false, 'icon' => 'check', 'icon_custom' => null ];
		$cls = self::cx( 'lc-check', 'circle' === $a['variant'] ? 'lc-check--circle' : '', 'mint' === $a['tone'] ? 'lc-check--mint' : '', $a['on_dark'] ? 'lc-check--on-dark' : '' );
		return '<li class="' . $cls . '">' . self::icon( $a['icon'], 'lc-check__icon', $a['icon_custom'], 3 ) . '<span class="lc-check__label">' . self::e( $a['label'] ) . '</span></li>';
	}

	public static function check_list( array $items, array $a = [], $class = 'lc-check-list' ) {
		$out = '<ul class="' . self::a( $class ) . '">';
		foreach ( $items as $label ) {
			$out .= self::check( [ 'label' => $label ] + $a );
		}
		return $out . '</ul>';
	}

	public static function stars( $count = 5 ) {
		$count = max( 0, min( 10, (int) $count ) );
		return '<span class="lc-stars" role="img" aria-label="' . $count . ' out of 5 stars">' . str_repeat( Icons::svg( 'star' ), $count ) . '</span>';
	}

	public static function avatar( $initials, $tone = 'purple', $image = '' ) {
		$cls = self::cx( 'lc-avatar', 'mint' === $tone ? 'lc-avatar--mint' : '' );
		if ( $image ) {
			return '<span class="' . $cls . ' lc-avatar--img"><img src="' . esc_url( $image ) . '" alt="" /></span>';
		}
		return '<span class="' . $cls . '">' . self::e( $initials ) . '</span>';
	}

	public static function step_number( $value, $variant = 'circle' ) {
		return '<span class="lc-step-num lc-step-num--' . self::a( $variant ) . '">' . self::e( $value ) . '</span>';
	}

	public static function price( $amount, $period = '', $on_dark = false ) {
		return '<div class="' . self::cx( 'lc-price', $on_dark ? 'lc-price--on-dark' : '' ) . '"><span class="lc-price__amount">' . self::e( $amount ) . '</span>'
			. ( '' !== (string) $period ? '<span class="lc-price__period">' . self::e( $period ) . '</span>' : '' ) . '</div>';
	}

	public static function dots( $class = '' ) {
		return '<span class="' . self::a( self::cx( 'lc-dots', $class ) ) . '" aria-hidden="true"></span>';
	}

	/* ================= molecules ================= */

	public static function section_header( array $a ) {
		$a += [ 'badge' => '', 'badge_variant' => 'dark', 'title' => '', 'highlight' => '', 'highlight_tone' => 'purple', 'description' => '', 'align' => 'split', 'level' => 'h2', 'tag' => '', 'tone' => 'ink', 'class' => '' ];
		$out  = '<header class="' . self::a( self::cx( 'lc-section-header', 'lc-section-header--' . $a['align'], $a['class'] ) ) . '"><div class="lc-section-header__main">';
		$out .= $a['badge'] ? self::pill( [ 'label' => $a['badge'], 'variant' => $a['badge_variant'], 'dot' => 'static', 'wide' => true ] ) : '';
		$out .= self::heading( [ 'text' => $a['title'], 'highlight' => $a['highlight'], 'highlight_tone' => $a['highlight_tone'], 'level' => $a['level'], 'tag' => $a['tag'], 'tone' => $a['tone'] ] );
		$out .= '</div>';
		$out .= $a['description'] ? self::text( [ 'text' => $a['description'], 'size' => 'lead' ] ) : '';
		return $out . '</header>';
	}

	public static function stat( $value, $label ) {
		return '<div class="lc-stat"><div class="lc-stat__value">' . self::e( $value ) . '</div><div class="lc-stat__label">' . self::e( $label ) . '</div></div>';
	}

	public static function stat_group( array $items ) {
		$out = '<div class="lc-stat-group">';
		foreach ( $items as $s ) {
			$out .= self::stat( $s['value'], $s['label'] );
		}
		return $out . '</div>';
	}

	public static function metric( $value, $label, $variant = 'white' ) {
		return '<div class="' . self::cx( 'lc-metric', 'white' !== $variant ? 'lc-metric--' . $variant : '' ) . '"><span class="lc-metric__value">' . self::e( $value ) . '</span><span class="lc-metric__label">' . self::e( $label ) . '</span></div>';
	}

	public static function metric_row( array $items, $base = 'white' ) {
		$out = '<div class="lc-metric-row">';
		foreach ( $items as $m ) {
			$out .= self::metric( $m['value'], $m['label'], ! empty( $m['highlight'] ) ? 'mint' : $base );
		}
		return $out . '</div>';
	}

	public static function button_group( array $buttons, $align = 'start' ) {
		$out = '<div class="' . self::cx( 'lc-btn-group', 'center' === $align ? 'lc-btn-group--center' : '' ) . '">';
		foreach ( $buttons as $b ) {
			$out .= self::button( $b );
		}
		return $out . '</div>';
	}

	public static function trust_row( array $items, $align = 'start', $on_dark = false ) {
		$out = '<ul class="' . self::cx( 'lc-trust-row', 'center' === $align ? 'lc-trust-row--center' : '', $on_dark ? 'lc-trust-row--on-dark' : '' ) . '">';
		foreach ( $items as $t ) {
			$out .= '<li class="lc-trust-row__item">' . self::icon( $t['icon'], '', isset( $t['icon_custom'] ) ? $t['icon_custom'] : null ) . self::e( $t['label'] ) . '</li>';
		}
		return $out . '</ul>';
	}

	public static function service_card( array $a ) {
		$a += [ 'icon' => 'megaphone', 'icon_custom' => null, 'icon_tone' => 'purple', 'title' => '', 'description' => '', 'link' => '' ];
		$tag  = self::link_attrs( $a['link'] ) ? 'a' : 'article';
		$link = 'a' === $tag ? self::link_attrs( $a['link'] ) : '';
		return '<' . $tag . ' class="lc-card lc-card--hover lc-service-card"' . $link . '>'
			. self::icon_tile( [ 'icon' => $a['icon'], 'icon_custom' => $a['icon_custom'], 'tone' => $a['icon_tone'] ] )
			. self::heading( [ 'text' => $a['title'], 'level' => 'h4', 'class' => 'lc-service-card__title' ] )
			. self::text( [ 'text' => $a['description'], 'size' => 'small' ] )
			. '</' . $tag . '>';
	}

	public static function track_card( array $a ) {
		$a += [ 'id' => 'clinic', 'icon' => 'heart', 'icon_custom' => null, 'title' => '', 'badge' => '', 'description' => '', 'link_label' => '', 'target' => '#clinics', 'theme' => 'purple', 'selected' => false, 'selectable' => true, 'select_label' => 'Select', 'selected_label' => 'Selected' ];
		$mint  = 'mint' === $a['theme'];
		$attrs = [ 'href' => $a['target'] ? $a['target'] : '#' ];
		if ( $a['selectable'] ) {
			$attrs += [ 'role' => 'button', 'aria-pressed' => $a['selected'] ? 'true' : 'false', 'data-lc-track' => $a['id'], 'data-lc-target' => $a['target'] ];
		}
		$out  = '<a class="' . self::cx( 'lc-card lc-track-card', $mint ? 'lc-track-card--mint' : '', $a['selected'] ? 'is-selected' : '' ) . '"' . self::attrs( $attrs ) . '>';
		$out .= '<div class="lc-track-card__top">' . self::icon_tile( [ 'icon' => $a['icon'], 'icon_custom' => $a['icon_custom'], 'tone' => $mint ? 'mint' : 'purple' ] );
		if ( $a['selectable'] ) {
			$out .= self::pill( [ 'label' => $a['select_label'], 'variant' => 'outline', 'class' => 'lc-track-card__state lc-track-card__state--off' ] );
			$out .= self::pill( [ 'label' => $a['selected_label'], 'variant' => $mint ? 'mint' : 'dark', 'dot' => 'static', 'class' => 'lc-track-card__state lc-track-card__state--on' ] );
		}
		$out .= '</div><div class="lc-track-card__title">' . self::heading( [ 'text' => $a['title'], 'level' => 'h4', 'tag' => 'p' ] );
		$out .= $a['badge'] ? self::pill( [ 'label' => $a['badge'], 'variant' => 'mint' ] ) : '';
		$out .= '</div>' . self::text( [ 'text' => $a['description'], 'size' => 'small' ] );
		$out .= '<span class="lc-track-card__link">' . self::e( $a['link_label'] ) . ' ' . Icons::svg( 'arrow-right' ) . '</span>';
		return $out . '</a>';
	}

	/**
	 * Pricing card. action: select (updates Final CTA) | whatsapp (opens chat) | link.
	 */
	public static function pricing_card( array $a ) {
		$a += [
			'id' => '', 'group' => 'clinic', 'badge' => '', 'name' => '', 'amount' => '', 'period' => '', 'description' => '', 'features' => [],
			'cta_label' => 'Choose this package', 'cta_selected_label' => 'Selected — start with this package',
			'theme' => 'clinic', 'featured' => false, 'selected' => false, 'action' => 'select', 'link' => '', 'wa_message' => '', 'wa_number' => '',
		];
		$rvaas    = 'rvaas' === $a['theme'];
		$dark     = $a['featured'] && ! $rvaas;
		$badge_v  = $a['featured'] ? 'mint' : ( $rvaas ? 'mint-soft' : 'outline' );
		$v_off    = $rvaas ? 'accent' : 'primary';
		$v_on     = $dark ? 'accent' : ( $rvaas ? 'primary' : 'accent' );
		$selected = 'select' === $a['action'] && $a['selected'];
		$id       = $a['id'] ? $a['id'] : sanitize_title( $a['name'] );

		$out  = '<article class="' . self::cx( 'lc-card lc-pricing-card', $rvaas ? 'lc-pricing-card--mint' : '', $a['featured'] ? 'lc-pricing-card--featured' : '', $selected ? 'is-selected' : '' ) . '"'
			. self::attrs( [ 'data-lc-package' => $id, 'data-lc-group' => $a['group'], 'data-lc-name' => $a['name'], 'data-lc-amount' => $a['amount'], 'data-lc-period' => $a['period'] ] ) . '>';
		$out .= $a['badge'] ? self::pill( [ 'label' => $a['badge'], 'variant' => $badge_v, 'class' => 'lc-pricing-card__badge', 'icon' => $a['featured'] ? 'sparkles' : '' ] ) : '';
		$out .= self::heading( [ 'text' => $a['name'], 'level' => 'h4' ] );
		$out .= self::price( $a['amount'], $a['period'], $dark );
		$out .= self::text( [ 'text' => $a['description'], 'size' => 'small' ] );
		$out .= self::check_list( $a['features'], [ 'variant' => $rvaas ? 'circle' : 'tick', 'tone' => $dark ? 'mint' : 'purple', 'on_dark' => $dark ], 'lc-pricing-card__features' );
		$out .= '<div class="lc-pricing-card__cta">';
		if ( 'select' === $a['action'] ) {
			$out .= self::button( [
				'variant'    => $selected ? $v_on : $v_off,
				'block'      => true,
				'icon'       => 'badge-check',
				'icon_pos'   => 'before',
				'label_html' => '<span class="lc-btn__label lc-sel-off">' . self::e( $a['cta_label'] ) . '</span><span class="lc-btn__label lc-sel-on">' . self::e( $a['cta_selected_label'] ) . '</span>',
				'class'      => 'lc-pricing-card__button',
				'attrs'      => [ 'data-lc-select' => '1', 'aria-pressed' => $selected ? 'true' : 'false', 'data-lc-variant-on' => $v_on, 'data-lc-variant-off' => $v_off ],
			] );
			$out  = str_replace( 'class="lc-btn__icon"', 'class="lc-btn__icon lc-pricing-card__sel-icon"', $out );
		} elseif ( 'whatsapp' === $a['action'] ) {
			$msg  = strtr( $a['wa_message'], [ '{package}' => $a['name'], '{price}' => trim( $a['amount'] . ' ' . $a['period'] ), '{amount}' => $a['amount'], '{period}' => $a['period'] ] );
			$out .= self::button( [ 'label' => $a['cta_label'], 'variant' => $v_off, 'block' => true, 'link' => Plugin::whatsapp_link( $msg, $a['wa_number'] ), 'external' => true, 'class' => 'lc-pricing-card__button' ] );
		} else {
			$out .= self::button( [ 'label' => $a['cta_label'], 'variant' => $v_off, 'block' => true, 'link' => $a['link'], 'class' => 'lc-pricing-card__button' ] );
		}
		return $out . '</div></article>';
	}

	public static function process_step( array $a ) {
		$a += [ 'number' => '01', 'title' => '', 'description' => '', 'last' => false, 'line' => true ];
		return '<div class="' . self::cx( 'lc-process-step', $a['last'] ? 'lc-process-step--last' : '' ) . '"><div class="lc-process-step__head">'
			. self::step_number( $a['number'], 'circle' ) . ( $a['line'] ? '<span class="lc-process-step__line" aria-hidden="true"></span>' : '' ) . '</div>'
			. self::heading( [ 'text' => $a['title'], 'level' => 'h4' ] ) . self::text( [ 'text' => $a['description'], 'size' => 'small' ] ) . '</div>';
	}

	public static function step_card( array $a ) {
		$a += [ 'number' => '01', 'title' => '', 'description' => '', 'mark' => true ];
		return '<article class="lc-card lc-card--hover lc-step-card"><div class="lc-step-card__top">' . self::step_number( $a['number'], 'big' ) . ( $a['mark'] ? self::logomark() : '' ) . '</div>'
			. self::heading( [ 'text' => $a['title'], 'level' => 'h4' ] ) . self::text( [ 'text' => $a['description'], 'size' => 'small' ] ) . '</article>';
	}

	public static function testimonial( array $a ) {
		$a += [ 'quote' => '', 'name' => '', 'role' => '', 'initials' => '', 'image' => '', 'tone' => 'light', 'badge' => '', 'rating' => 5 ];
		$dark = 'dark' === $a['tone'];
		$out  = '<figure class="' . self::cx( 'lc-card lc-testimonial', $dark ? 'lc-testimonial--dark' : '' ) . '"><div class="lc-testimonial__meta">';
		$out .= $a['badge'] ? self::pill( [ 'label' => $a['badge'], 'variant' => 'mint' ] ) : '';
		$out .= (int) $a['rating'] > 0 ? self::stars( $a['rating'] ) : '';
		$out .= '</div><blockquote class="lc-testimonial__quote">“' . self::e( $a['quote'] ) . '”</blockquote>';
		$out .= '<figcaption class="lc-testimonial__author">' . self::avatar( $a['initials'], $dark ? 'mint' : 'purple', $a['image'] )
			. '<div><div class="lc-testimonial__name">' . self::e( $a['name'] ) . '</div><div class="lc-testimonial__role">' . self::e( $a['role'] ) . '</div></div></figcaption>';
		return $out . '</figure>';
	}

	public static function work_card( array $a ) {
		$a += [ 'kind' => 'advert', 'theme' => 'purple', 'tag' => '', 'tag_variant' => 'mint', 'title' => '', 'body' => '', 'strip_label' => '', 'strip_note' => '', 'metrics' => [], 'footer_label' => '', 'image' => '' ];
		$on_dark = in_array( $a['theme'], [ 'purple', 'night' ], true );
		$out     = '<article class="lc-card lc-card--hover lc-work-card lc-work-card--' . self::a( $a['theme'] ) . '">';
		$out    .= $a['image'] ? '<img class="lc-work-card__image" src="' . esc_url( $a['image'] ) . '" alt="" />' : '';
		$out    .= '<div>' . self::pill( [ 'label' => $a['tag'], 'variant' => $a['tag_variant'] ] ) . '</div>';
		$out    .= '<h3 class="lc-work-card__title">' . self::e( $a['title'] ) . '</h3>';
		if ( 'abstract' === $a['kind'] && $a['metrics'] ) {
			$out .= self::metric_row( $a['metrics'] );
		}
		$out .= $a['body'] ? '<p class="lc-work-card__body">' . self::e( $a['body'] ) . '</p>' : '';
		if ( 'advert' === $a['kind'] && $a['strip_label'] ) {
			$out .= '<div class="lc-work-card__strip"><span>' . self::e( $a['strip_label'] ) . '</span>'
				. ( $a['strip_note'] ? '<span class="lc-work-card__strip-note">' . self::e( $a['strip_note'] ) . '</span>' : self::logomark() ) . '</div>';
		}
		if ( 'carousel' === $a['kind'] ) {
			$out .= '<div class="lc-work-card__dots" aria-hidden="true"><span></span> <span></span> <span></span> <span></span> <span></span></div>';
		}
		if ( 'poster' === $a['kind'] && $a['footer_label'] ) {
			$out .= '<div class="lc-work-card__footer">' . self::logomark( $on_dark ) . ' ' . self::e( $a['footer_label'] ) . '</div>';
		}
		return $out . '</article>';
	}

	public static function campaign( array $a ) {
		$a += [ 'tag' => '', 'eyebrow' => '', 'eyebrow_icon' => 'stethoscope', 'eyebrow_icon_custom' => null, 'title' => '', 'body' => '', 'cta_label' => '', 'cta_sub' => '', 'link' => '#clinics' ];
		$link = self::link_attrs( $a['link'] );
		return '<article class="lc-campaign"><div class="lc-campaign__top">' . self::pill( [ 'label' => $a['tag'], 'variant' => 'glass', 'wide' => true ] )
			. '<span class="lc-campaign__mark">' . self::logomark() . '</span></div>'
			. self::eyebrow( [ 'label' => $a['eyebrow'], 'icon' => $a['eyebrow_icon'], 'icon_custom' => $a['eyebrow_icon_custom'], 'tone' => 'on-dark' ] )
			. '<h3 class="lc-campaign__title">' . self::e( $a['title'] ) . '</h3>'
			. self::text( [ 'text' => $a['body'], 'size' => 'small', 'on_dark' => true ] )
			. '<a class="lc-campaign__cta"' . ( $link ? $link : ' href="#"' ) . '><span><span class="lc-campaign__cta-label">' . self::e( $a['cta_label'] ) . '</span><br /><span class="lc-campaign__cta-sub">' . self::e( $a['cta_sub'] ) . '</span></span>'
			. '<span class="lc-campaign__arrow">' . Icons::svg( 'arrow-up-right' ) . '</span></a></article>';
	}

	public static function float_note( array $a ) {
		$a += [ 'icon' => 'flask', 'icon_custom' => null, 'title' => '', 'subtitle' => '', 'class' => '' ];
		return '<div class="' . self::a( self::cx( 'lc-float-note', $a['class'] ) ) . '"><span class="lc-icon-tile lc-icon-tile--soft lc-icon-tile--sm">' . self::logomark() . '</span>'
			. '<div><div class="lc-float-note__title">' . self::icon( $a['icon'], '', $a['icon_custom'] ) . self::e( $a['title'] ) . '</div><div class="lc-float-note__sub">' . self::e( $a['subtitle'] ) . '</div></div></div>';
	}

	public static function marquee( array $items, $speed = 32, $reverse = false, $pause = true ) {
		$group = function ( $hidden ) use ( $items ) {
			$g = '<div class="lc-marquee__group"' . ( $hidden ? ' aria-hidden="true"' : '' ) . '>';
			foreach ( $items as $it ) {
				$g .= '<span class="lc-marquee__item">' . self::e( $it ) . '</span><span class="lc-marquee__sep"></span>';
			}
			return $g . '</div>';
		};
		return '<div class="' . self::cx( 'lc-marquee', $reverse ? 'lc-marquee--reverse' : '', $pause ? '' : 'lc-marquee--no-pause' ) . '" style="--lc-marquee-speed: ' . (float) $speed . 's"><div class="lc-marquee__track">'
			. $group( false ) . $group( true ) . '</div></div>';
	}

	public static function nav( array $links, $orientation = 'horizontal' ) {
		$out = '<nav class="' . self::cx( 'lc-nav', 'vertical' === $orientation ? 'lc-nav--vertical' : '' ) . '" aria-label="Main">';
		foreach ( $links as $l ) {
			$out .= '<a class="lc-nav__link"' . self::link_attrs( $l['link'] ) . '>' . self::e( $l['label'] )
				. ( ! empty( $l['accent'] ) ? '<span class="lc-nav__accent"> ' . self::e( $l['accent'] ) . '</span>' : '' ) . '</a>';
		}
		return $out . '</nav>';
	}

	public static function footer_col( $title, array $links ) {
		$out = '<div class="lc-footer-col"><p class="lc-footer-col__title">' . self::e( $title ) . '</p><ul class="lc-footer-col__list">';
		foreach ( $links as $l ) {
			$out .= '<li><a' . self::link_attrs( $l['link'] ) . '>' . self::e( $l['label'] ) . '</a></li>';
		}
		return $out . '</ul></div>';
	}
}
