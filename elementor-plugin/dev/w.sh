# helper: w <file>  — writes the standard widget file header then stdin
w() { cat > "$1" <<'HDR'
<?php
namespace LCW\Widgets;

use Elementor\Controls_Manager as CM;
use LCW\Base_Widget;
use LCW\R;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

HDR
cat >> "$1"; }
