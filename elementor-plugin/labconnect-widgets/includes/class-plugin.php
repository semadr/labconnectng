<?php
namespace LCW;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Boots the plugin: categories, assets, settings page and widget registration.
 */
final class Plugin {

	const OPTION = 'lcw_settings';

	/** Every widget: [ folder/file (no .php), class name ]. Order = order in the Elementor panel. */
	const WIDGETS = [
		// Atoms.
		[ 'atoms/button', 'Button' ],
		[ 'atoms/badge', 'Badge' ],
		[ 'atoms/eyebrow', 'Eyebrow' ],
		[ 'atoms/heading', 'Heading' ],
		[ 'atoms/text', 'Text' ],
		[ 'atoms/icon-tile', 'Icon_Tile' ],
		[ 'atoms/logo', 'Logo' ],
		[ 'atoms/logo-mark', 'Logo_Mark' ],
		[ 'atoms/check-list', 'Check_List' ],
		[ 'atoms/price', 'Price' ],
		[ 'atoms/stars', 'Stars' ],
		[ 'atoms/avatar', 'Avatar' ],
		[ 'atoms/step-number', 'Step_Number' ],
		[ 'atoms/dot-grid', 'Dot_Grid' ],
		// Molecules.
		[ 'molecules/section-header', 'Section_Header' ],
		[ 'molecules/stat-card', 'Stat_Card' ],
		[ 'molecules/stat-group', 'Stat_Group' ],
		[ 'molecules/metric-tile', 'Metric_Tile' ],
		[ 'molecules/metric-row', 'Metric_Row' ],
		[ 'molecules/button-group', 'Button_Group' ],
		[ 'molecules/trust-row', 'Trust_Row' ],
		[ 'molecules/service-card', 'Service_Card' ],
		[ 'molecules/track-card', 'Track_Card' ],
		[ 'molecules/pricing-card', 'Pricing_Card' ],
		[ 'molecules/process-step', 'Process_Step' ],
		[ 'molecules/step-card', 'Step_Card' ],
		[ 'molecules/testimonial-card', 'Testimonial_Card' ],
		[ 'molecules/work-card', 'Work_Card' ],
		[ 'molecules/campaign-card', 'Campaign_Card' ],
		[ 'molecules/floating-note', 'Floating_Note' ],
		[ 'molecules/marquee', 'Marquee' ],
		[ 'molecules/nav-menu', 'Nav_Menu' ],
		[ 'molecules/footer-column', 'Footer_Column' ],
		// Sections.
		[ 'sections/header', 'Section_Site_Header' ],
		[ 'sections/hero', 'Section_Hero' ],
		[ 'sections/track-selector', 'Section_Track_Selector' ],
		[ 'sections/services-grid', 'Section_Services_Grid' ],
		[ 'sections/pricing-grid', 'Section_Pricing_Grid' ],
		[ 'sections/rvaas-intro', 'Section_Rvaas_Intro' ],
		[ 'sections/rvaas-process', 'Section_Rvaas_Process' ],
		[ 'sections/portfolio', 'Section_Portfolio' ],
		[ 'sections/how-it-works', 'Section_How_It_Works' ],
		[ 'sections/testimonials', 'Section_Testimonials' ],
		[ 'sections/final-cta', 'Section_Final_Cta' ],
		[ 'sections/footer', 'Section_Site_Footer' ],
	];

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'admin_menu', [ $this, 'settings_page' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );

		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'missing_elementor_notice' ] );
			return;
		}

		add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ], 5 );
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'register_assets' ] );
		add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_all' ] );
	}

	/* ---------------- settings ---------------- */

	public static function setting( $key, $default = '' ) {
		$opts = get_option( self::OPTION, [] );
		$defaults = [
			'whatsapp'   => '2349025997196',
			'load_fonts' => 'yes',
		];
		$value = isset( $opts[ $key ] ) ? $opts[ $key ] : ( isset( $defaults[ $key ] ) ? $defaults[ $key ] : $default );
		return $value;
	}

	public static function whatsapp_number( $override = '' ) {
		$n = '' !== trim( (string) $override ) ? $override : self::setting( 'whatsapp' );
		return preg_replace( '/\D/', '', (string) $n );
	}

	public static function whatsapp_link( $message, $override = '' ) {
		$n = self::whatsapp_number( $override );
		return ( $n ? 'https://wa.me/' . $n : 'https://wa.me/' ) . '?text=' . rawurlencode( $message );
	}

	public function register_settings() {
		register_setting(
			'lcw',
			self::OPTION,
			[
				'sanitize_callback' => function ( $in ) {
					return [
						'whatsapp'   => preg_replace( '/\D/', '', isset( $in['whatsapp'] ) ? $in['whatsapp'] : '' ),
						'load_fonts' => empty( $in['load_fonts'] ) ? 'no' : 'yes',
					];
				},
			]
		);
	}

	public function settings_page() {
		add_options_page( 'LabConnect Widgets', 'LabConnect Widgets', 'manage_options', 'lcw', [ $this, 'render_settings' ] );
	}

	public function render_settings() {
		?>
		<div class="wrap">
			<h1>LabConnect Widgets</h1>
			<form method="post" action="options.php">
				<?php settings_fields( 'lcw' ); ?>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="lcw-wa">WhatsApp business number</label></th>
						<td>
							<input id="lcw-wa" class="regular-text" name="<?php echo esc_attr( self::OPTION ); ?>[whatsapp]" value="<?php echo esc_attr( self::setting( 'whatsapp' ) ); ?>" />
							<p class="description">International format, digits only (e.g. 2349025997196). Used by Pricing Cards and the Final CTA unless a widget sets its own number.</p>
						</td>
					</tr>
					<tr>
						<th scope="row">Brand fonts</th>
						<td><label><input type="checkbox" name="<?php echo esc_attr( self::OPTION ); ?>[load_fonts]" value="yes" <?php checked( self::setting( 'load_fonts' ), 'yes' ); ?> /> Load Fraunces + Manrope from Google Fonts</label></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	public function missing_elementor_notice() {
		echo '<div class="notice notice-warning"><p><strong>LabConnect Widgets</strong> needs the Elementor plugin. Install and activate Elementor to use the widgets.</p></div>';
	}

	/* ---------------- elementor ---------------- */

	public function register_categories( $elements_manager ) {
		$elements_manager->add_category( 'lc-sections', [ 'title' => 'LabConnect · Sections', 'icon' => 'eicon-section' ] );
		$elements_manager->add_category( 'lc-molecules', [ 'title' => 'LabConnect · Cards & Groups', 'icon' => 'eicon-inner-section' ] );
		$elements_manager->add_category( 'lc-atoms', [ 'title' => 'LabConnect · Basics', 'icon' => 'eicon-elementor-circle' ] );
	}

	public static function load_core() {
		require_once LCW_PATH . 'includes/class-icons.php';
		require_once LCW_PATH . 'includes/class-render.php';
		require_once LCW_PATH . 'includes/class-base-widget.php';
		require_once LCW_PATH . 'includes/trait-track-parts.php';
	}

	public function register_widgets( $widgets_manager ) {
		self::load_core();
		foreach ( self::WIDGETS as $w ) {
			require_once LCW_PATH . 'widgets/' . $w[0] . '.php';
			$class = '\\LCW\\Widgets\\' . $w[1];
			$widgets_manager->register( new $class() );
		}
	}

	public function register_assets() {
		if ( wp_style_is( 'lcw-styles', 'registered' ) ) {
			return;
		}
		$fonts = 'yes' === self::setting( 'load_fonts' )
			? 'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700;9..144,900&family=Manrope:wght@400;500;600;700;800&display=swap'
			: false;
		wp_register_style( 'lcw-fonts', $fonts, [], null );
		wp_register_style( 'lcw-styles', LCW_URL . 'assets/css/labconnect.css', [ 'lcw-fonts' ], LCW_VERSION );
		wp_register_style( 'lcw-compat', LCW_URL . 'assets/css/compat.css', [ 'lcw-styles' ], LCW_VERSION );
		wp_register_script( 'lcw-frontend', LCW_URL . 'assets/js/lc-widgets.js', [], LCW_VERSION, true );
		wp_add_inline_script( 'lcw-frontend', 'window.LCW_CONFIG = ' . wp_json_encode( [ 'whatsapp' => self::whatsapp_number() ] ) . ';', 'before' );
	}

	public function enqueue_all() {
		$this->register_assets();
		wp_enqueue_style( 'lcw-compat' );
		wp_enqueue_script( 'lcw-frontend' );
	}
}
