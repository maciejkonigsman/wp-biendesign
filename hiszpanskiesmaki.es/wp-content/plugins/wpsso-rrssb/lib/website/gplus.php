<?php
/*
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Copyright 2014-2017 Jean-Sebastien Morisset (https://surniaulula.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WpssoRrssbSubmenuWebsiteGplus' ) ) {

	class WpssoRrssbSubmenuWebsiteGplus {

		public function __construct( &$plugin ) {
			$this->p =& $plugin;
			$this->p->util->add_plugin_filters( $this, array(
				'rrssb_website_gplus_rows' => 3,	// $table_rows, $form, $submenu
			) );
		}

		public function filter_rrssb_website_gplus_rows( $table_rows, $form, $submenu ) {

			$table_rows[] = $form->get_th_html( _x( 'Show Button in', 'option label', 'wpsso-rrssb' ) ).
			'<td>'.$submenu->show_on_checkboxes( 'gp' ).'</td>';

			$table_rows[] = $form->get_th_html( _x( 'Preferred Order', 'option label', 'wpsso-rrssb' ) ).
			'<td>'.$form->get_select( 'gp_order', range( 1, count( $submenu->website ) ) ).'</td>';

			if ( $this->p->avail['*']['vary_ua'] ) {
				$table_rows[] = '<tr class="hide_in_basic">'.
				$form->get_th_html( _x( 'Allow for Platform', 'option label', 'wpsso-rrssb' ) ).
				'<td>'.$form->get_select( 'gp_platform', $this->p->cf['sharing']['platform'] ).'</td>';
			}

			$table_rows[] = '<tr class="hide_in_basic">'.
			'<td colspan="2">'.$form->get_textarea( 'gp_rrssb_html', 'average code' ).'</td>';

			return $table_rows;
		}
	}
}

if ( ! class_exists( 'WpssoRrssbWebsiteGplus' ) ) {

	class WpssoRrssbWebsiteGplus {

		private static $cf = array(
			'opt' => array(				// options
				'defaults' => array(
					'gp_order' => 3,
					'gp_on_content' => 1,
					'gp_on_excerpt' => 0,
					'gp_on_sidebar' => 0,
					'gp_on_admin_edit' => 1,
					'gp_platform' => 'any',
					'gp_rrssb_html' => '<li class="rrssb-googleplus">
	<a href="https://plus.google.com/share?url=%%sharing_url%%" class="popup">
		<span class="rrssb-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28">
				<path d="M14.703 15.854l-1.22-.948c-.37-.308-.88-.715-.88-1.46 0-.747.51-1.222.95-1.662 1.42-1.12 2.84-2.31 2.84-4.817 0-2.58-1.62-3.937-2.4-4.58h2.098l2.203-1.384h-6.67c-1.83 0-4.467.433-6.398 2.027C3.768 4.287 3.06 6.018 3.06 7.576c0 2.634 2.02 5.328 5.603 5.328.34 0 .71-.033 1.083-.068-.167.408-.336.748-.336 1.324 0 1.04.55 1.685 1.01 2.297-1.523.104-4.37.273-6.466 1.562-1.998 1.187-2.605 2.915-2.605 4.136 0 2.512 2.357 4.84 7.288 4.84 5.822 0 8.904-3.223 8.904-6.41.008-2.327-1.36-3.49-2.83-4.73h-.01zM10.27 11.95c-2.913 0-4.232-3.764-4.232-6.036 0-.884.168-1.797.744-2.51.543-.68 1.49-1.12 2.372-1.12 2.807 0 4.256 3.797 4.256 6.24 0 .613-.067 1.695-.845 2.48-.537.55-1.438.947-2.295.95v-.003zm.032 13.66c-3.62 0-5.957-1.733-5.957-4.143 0-2.408 2.165-3.223 2.91-3.492 1.422-.48 3.25-.545 3.556-.545.34 0 .52 0 .767.034 2.574 1.838 3.706 2.757 3.706 4.48-.002 2.072-1.736 3.664-4.982 3.648l.002.017zM23.254 11.89V8.52H21.57v3.37H18.2v1.714h3.367v3.4h1.684v-3.4h3.4V11.89" />
			</svg>
		</span>
		<span class="rrssb-text">google+</span>
	</a>
</li><!-- .rrssb-googleplus -->',
				),
			),
		);

		protected $p;

		public function __construct( &$plugin ) {
			$this->p =& $plugin;
			$this->p->util->add_plugin_filters( $this, array( 'get_defaults' => 1 ) );
		}

		public function filter_get_defaults( $def_opts ) {
			return array_merge( $def_opts, self::$cf['opt']['defaults'] );
		}

		public function get_html( array $atts, array $opts, array $mod ) {
			if ( $this->p->debug->enabled )
				$this->p->debug->mark();

			return $this->p->util->replace_inline_vars( '<!-- Google+ Button -->'.
				$this->p->options['gp_rrssb_html'], $mod, $atts );
		}
	}
}

?>
