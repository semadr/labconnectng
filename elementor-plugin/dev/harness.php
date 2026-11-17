<?php
/**
 * Offline test harness: mocks just enough of WordPress + Elementor to
 * register every widget, validate its controls and render it with default settings.
 *   php elementor-plugin/dev/harness.php > /tmp/lcw.json
 */
error_reporting( E_ALL );
ini_set( 'display_errors', 'stderr' );
set_error_handler( function ( $no, $str, $file, $line ) { fwrite( STDERR, "PHP[$no] $str @ $file:$line\n" ); $GLOBALS['lcw_errors'][] = "$str @ " . basename( $file ) . ":$line"; return true; } );

define( 'ABSPATH', __DIR__ );
$GLOBALS['lcw_errors'] = [];
function esc_html( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8' ); }
function esc_attr( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8' ); }
function esc_url( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8' ); }
function wp_kses_post( $s ) { return (string) $s; }
function sanitize_title( $s ) { return trim( preg_replace( '/[^a-z0-9]+/', '-', strtolower( $s ) ), '-' ); }
function sanitize_html_class( $s ) { return preg_replace( '/[^A-Za-z0-9_-]/', '', $s ); }
function plugin_dir_path( $f ) { return dirname( $f ) . '/'; }
function plugin_dir_url( $f ) { return '../labconnect-widgets/'; }
function add_action( ...$a ) {}
function did_action( $a ) { return 1; }
function get_option( $k, $d = [] ) { return $d; }
function wp_json_encode( $v ) { return json_encode( $v ); }

$GLOBALS['lcw_controls'] = [];

class LCW_Recorder {
	public $controls = [];
	public $errors = [];
	public $selectors = [];
	public $in_section = false;
	public $in_tabs = false;
	public $in_tab = false;
	public function rec( $id, $args, $group = null ) {
		if ( isset( $this->controls[ $id ] ) ) { $this->errors[] = "duplicate control id: $id"; }
		if ( ! $this->in_section ) { $this->errors[] = "control outside section: $id"; }
		$this->controls[ $id ] = $args + [ '__group' => $group ];
		if ( ! empty( $args['selectors'] ) ) { foreach ( $args['selectors'] as $sel => $css ) { $this->selectors[] = [ $id, $sel, $css ]; } }
		if ( ! empty( $args['selector'] ) ) { $this->selectors[] = [ $id, $args['selector'], '(group)' ]; }
	}
}
}

namespace Elementor {
	class Controls_Manager {
		const TAB_CONTENT = 'content'; const TAB_STYLE = 'style'; const TEXT = 'text'; const TEXTAREA = 'textarea'; const WYSIWYG = 'wysiwyg';
		const NUMBER = 'number'; const SELECT = 'select'; const SWITCHER = 'switcher'; const URL = 'url'; const MEDIA = 'media'; const ICONS = 'icons';
		const CHOOSE = 'choose'; const SLIDER = 'slider'; const DIMENSIONS = 'dimensions'; const COLOR = 'color'; const HEADING = 'heading';
		const REPEATER = 'repeater'; const HIDDEN = 'hidden'; const RAW_HTML = 'raw_html'; const DIVIDER = 'divider'; const HOVER_ANIMATION = 'hover_animation';
	}
	class Group_Control_Typography { static function get_type() { return 'typography'; } }
	class Group_Control_Background { static function get_type() { return 'background'; } }
	class Group_Control_Border { static function get_type() { return 'border'; } }
	class Group_Control_Box_Shadow { static function get_type() { return 'box-shadow'; } }
	class Group_Control_Text_Shadow { static function get_type() { return 'text-shadow'; } }
	class Icons_Manager { static function render_icon( $i, $a = [] ) { echo '<i class="' . htmlspecialchars( $i['value'] ) . '" aria-hidden="true"></i>'; } }
	class Repeater {
		public $c = [];
		function add_control( $id, $args ) { if ( isset( $this->c[ $id ] ) ) { throw new \Exception( "dup repeater field $id" ); } $this->c[ $id ] = $args + [ 'name' => $id ]; }
		function add_responsive_control( $id, $args ) { $this->add_control( $id, $args ); }
		function get_controls() { return $this->c; }
	}
	abstract class Widget_Base {
		public $r;
		function lcw_boot() { $this->r = new \LCW_Recorder(); $this->register_controls(); if ( $this->r->in_section ) { $this->r->errors[] = 'unclosed section'; } }
		protected function register_controls() {}
		function start_controls_section( $id, $args ) { if ( $this->r->in_section ) { $this->r->errors[] = "nested section $id"; } $this->r->in_section = $id; if ( isset( $this->r->controls[ $id ] ) ) { $this->r->errors[] = "section id clashes: $id"; } $this->r->controls[ $id ] = [ 'type' => 'section', '__group' => null ] + $args; }
		function end_controls_section() { if ( $this->r->in_tabs ) { $this->r->errors[] = 'tabs not closed'; } $this->r->in_section = false; }
		function start_controls_tabs( $id ) { if ( $this->r->in_tabs ) { $this->r->errors[] = "nested tabs $id"; } $this->r->in_tabs = $id; }
		function end_controls_tabs() { $this->r->in_tabs = false; }
		function start_controls_tab( $id, $a ) { if ( ! $this->r->in_tabs ) { $this->r->errors[] = "tab outside tabs $id"; } if ( $this->r->in_tab ) { $this->r->errors[] = "tab not closed before $id"; } $this->r->in_tab = $id; if ( isset( $this->r->controls[ $id ] ) ) { $this->r->errors[] = "tab id clashes: $id"; } $this->r->controls[ $id ] = [ 'type' => 'tab', '__group' => null ]; }
		function end_controls_tab() { $this->r->in_tab = false; }
		function add_control( $id, $args ) {
			if ( empty( $args['type'] ) ) { $this->r->errors[] = "no type: $id"; }
			if ( 'repeater' === ( $args['type'] ?? '' ) ) {
				$tf = $args['title_field'] ?? '';
				preg_match_all( '/\{\{\{\s*([a-z0-9_]+)/', $tf, $m );
				foreach ( $m[1] as $f ) { if ( ! isset( $args['fields'][ $f ] ) ) { $this->r->errors[] = "repeater $id title_field uses missing $f"; } }
				foreach ( $args['default'] as $i => $row ) { foreach ( $row as $k => $v ) { if ( ! isset( $args['fields'][ $k ] ) ) { $this->r->errors[] = "repeater $id default row $i has unknown field $k"; } } }
			}
			$this->r->rec( $id, $args );
		}
		function add_responsive_control( $id, $args ) { $this->add_control( $id, $args ); foreach ( [ '_tablet', '_mobile' ] as $sfx ) { if ( isset( $this->r->controls[ $id . $sfx ] ) ) { $this->r->errors[] = "responsive clash $id$sfx"; } } }
		function add_group_control( $type, $args ) { $this->r->rec( $args['name'] . '__' . $type, $args, $type ); }
		function get_id() { return 'abc123'; }
		function get_settings_for_display() {
			$s = [];
			foreach ( $this->r->controls as $id => $c ) {
				if ( in_array( $c['type'] ?? '', [ 'section', 'tab', 'heading' ], true ) || $c['__group'] ) { continue; }
				$d = $c['default'] ?? '';
				if ( 'repeater' === $c['type'] ) {
					$rows = [];
					foreach ( $d as $row ) { foreach ( $c['fields'] as $fid => $f ) { if ( ! array_key_exists( $fid, $row ) ) { $row[ $fid ] = $f['default'] ?? ''; } } $row['_id'] = substr( md5( json_encode( $row ) ), 0, 7 ); $rows[] = $row; }
					$d = $rows;
				}
				$s[ $id ] = $d;
			}
			return $s;
		}
	}
}

namespace {
	$root = dirname( __DIR__ ) . '/labconnect-widgets/';
	require $root . 'labconnect-widgets.php';
	\LCW\Plugin::load_core();
	$out = [];
	foreach ( \LCW\Plugin::WIDGETS as $w ) {
		$file = $root . 'widgets/' . $w[0] . '.php';
		if ( ! file_exists( $file ) ) { $out[] = [ 'file' => $w[0], 'missing' => true ]; continue; }
		require_once $file;
		$cls = '\\LCW\\Widgets\\' . $w[1];
		$GLOBALS['lcw_errors'] = [];
		$wd = new $cls();
		$errors = [];
		try { $wd->lcw_boot(); } catch ( \Throwable $e ) { $errors[] = 'boot: ' . $e->getMessage() . ' @' . basename( $e->getFile() ) . ':' . $e->getLine(); }
		$html = '';
		if ( ! $errors ) {
			ob_start();
			try { $m = new \ReflectionMethod( $wd, 'render' ); $m->setAccessible( true ); $m->invoke( $wd ); } catch ( \Throwable $e ) { $errors[] = 'render: ' . $e->getMessage() . ' @' . basename( $e->getFile() ) . ':' . $e->getLine(); }
			$html = ob_get_clean();
		}
		// condition keys must exist
		foreach ( $wd->r->controls ?? [] as $id => $c ) {
			foreach ( ( $c['condition'] ?? [] ) as $k => $v ) { $k = rtrim( $k, '!' ); if ( ! isset( $wd->r->controls[ $k ] ) ) { $errors[] = "control $id condition on missing $k"; } }
		}
		$out[] = [
			'file' => $w[0], 'name' => $wd->get_name(), 'title' => $wd->get_title(), 'icon' => $wd->get_icon(), 'cats' => $wd->get_categories(),
			'controls' => count( $wd->r->controls ?? [] ), 'errors' => array_merge( $errors, $wd->r->errors ?? [], $GLOBALS['lcw_errors'] ),
			'selectors' => $wd->r->selectors ?? [], 'html' => $html,
		];
	}
	echo json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
}
