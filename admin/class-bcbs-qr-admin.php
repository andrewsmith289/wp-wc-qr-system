<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https:///
 * @since      1.0.0
 *
 * @package    Bcbs_Qr
 * @subpackage Bcbs_Qr/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bcbs_Qr
 * @subpackage Bcbs_Qr/admin
 * @author     *********** <webmaster@***********>
 */
class Bcbs_Qr_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bcbs_Qr_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bcbs_Qr_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bcbs-qr-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bcbs_Qr_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bcbs_Qr_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bcbs-qr-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Register the 'qr' endpoint to the root
     */
    function add_qr_endpoints() {
        add_rewrite_endpoint( 'qr', EP_ROOT );

    }

    /**
     * Intercepts and builds a QR bulk print page
     */
    function qr_template_redirect() {
        if ( $_SERVER['REQUEST_URI'] && 'qr' === explode( '/', $_SERVER['REQUEST_URI'] )[1] ) {
            if ( ! current_user_can( 'manage_woocommerce' ) ) {
                echo 'Sorry, you\'re not authorized to view this page. <br /> <a href="/">Better find a way out of here</a>';
                die();
            }

            if ( ! get_query_var( 'qr_data', '' ) ) {
                echo 'Missing parameters. Please provide at least qr_data.';
                exit;
            }

            $data = utf8_encode( get_query_var( 'qr_data' ) );
            $size = get_query_var( 'qr_size', 225 );
            $count = get_query_var( 'qr_count', 1 );
            $margin = 2;
            $uri = "https://chart.googleapis.com/chart?chs={$size}x{$size}&cht=qr&chld=L|{$margin}&chl={$data}&choe=UTF-8";

            // include custom template
            include 'partials/print-wrapper.php';

            //render qr page
            echo "<div class='qr-batch'><div class='qr-page'><div class='qr-row'>";
            for ( $i = 1; $i <= $count; $i++ ) {
                echo "<img src='{$uri}' alt='{$data}' />";
                if ( ( $i % 3 ) == 0 ) {
                    echo "<div class='clearfix'></div></div>"; // /qr-row
                    if ( ( $i % 12 ) == 0 ) {
                        echo "<div class='clearfix'></div></div><div class='qr-page'><div class='qr-row'>"; //new page
                    } else {
                        echo "<div class='qr-row'>";
                    }
                }
            }
            echo "</div>"; // /qr_batch

            exit;
        }

    }

    /**
     * Register data query vars
     * @param $vars
     * @return array
     */
    function custom_query_vars_filter($vars) {
        $vars[] = 'qr_data';
        $vars[] .= 'qr_size';
        $vars[] .= 'qr_count';

        return $vars;
    }

    /**
     * Register the QR Print custom data tab in the product page backend
     * @param $product_data_tabs
     * @return mixed
     */
    function add_qr_print_product_data_tab( $product_data_tabs ) {
        $product_data_tabs['qr-print'] = array(
            'label' => __( 'QR Print', 'redacted' ),
            'target' => 'qr_print_product_data',
        );
        return $product_data_tabs;
    }

    /**
     * Add the QR Print data fields to a new WC panel
     */
    function add_qr_print_product_data_fields() {
        global $post;
        $product = wc_get_product( $post->ID );


        ?>
        <div id="qr_print_product_data" class="panel woocommerce_options_panel">

            <?php
                //if ( $product->is_type( 'simple' ) ) {
                    woocommerce_wp_hidden_input(array(
                        'id' => '_qr_data',
                        'value' => 'p' . $product->get_id(),
                    ));

                    if ( $product->is_type( 'variable' ) ) {
                        woocommerce_wp_hidden_input(array(
                            'id' => '_qr_is_variable',
                            'value' => true,
                        ));

                        $options = array();

                        /** @var $product WC_Product_Variable */
                        $children = $product->get_children();
                        foreach ( $children as $child_id ) {
                            $prod = wc_get_product( $child_id );
                            //$title = $prod->get_title();
                            $price = strval( $prod->get_price() );
                            $stock_status = $prod->get_stock_status();
                            $stock = $prod->get_stock_quantity();

                            $attrs_text = '';
                            $attrs = $prod->get_attributes();
                            foreach ( $attrs as $key => $value ) {
                                $name = esc_attr( $key );
                                $value = esc_attr( $value );
                                $attrs_text .= "{$name}: {$value}, ";
                            }
                            $attrs_text = substr( trim( $attrs_text ), 0, -1);

                            $options += array(
                                "{$child_id}" => "[{$attrs_text}] : {$stock_status} - {$stock} avail. @ \${$price}"
                            );

                        }

                        woocommerce_wp_select( array(
                            'id' => '_qr_print_var_id',
                            //'style' => 'width: 5em',
                            'wrapper_class' => '',
                            'label' => __('Product Variation', 'redacted'),
                            'options' => $options,
                            'default' => '1'
                        ));
                    }

                    woocommerce_wp_text_input( array(
                        'id' => '_qr_print_qty',
                        'style' => 'width: 5em',
                        'wrapper_class' => '',
                        'label' => __('Quantity', 'redacted'),
                        'default' => '1',
                        'value' => '1'
                    ));

                    woocommerce_wp_text_input(array(
                        'id' => '_qr_print_size',
                        'style' => 'width: 5em',
                        'wrapper_class' => '',
                        'label' => __('Width (px)', 'redacted'),
                        'default' => '225',
                        'value' => '225',
                    ));

                    submit_button(
                        'Print QR Code(s)',
                        'primary',
                        'do-qr-print'
                    );
               // }
            ?>
        </div>
        <?php
    }

}
