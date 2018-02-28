<?php
// Prevent direct script access
if ( !defined('ABSPATH') )
    die ( 'No direct script access allowed' );
?>
<?php
if ( ! class_exists( 'G1_Socials_Admin' ) ):

class G1_Socials_Admin {

    /**
     * The object instance
     *
     * @var G1_Socials_Admin
     */
    private static $instance;

    /**
     * Return the only existing instance of the object
     *
     * @return G1_Socials_Admin
     */
    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new G1_Socials_Admin();
        }

        return self::$instance;
    }

    private function __construct() {
        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'add_admin_page' ) );

        // Load css/js resources
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    public function admin_init() {
    register_setting( G1_Socials()->get_option_name(), G1_Socials()->get_option_name() );
}

    public function add_admin_page() {
        add_options_page(
            esc_html__( 'G1 Socials', 'g1_socials' ),
            esc_html__( 'G1 Socials', 'g1_socials' ),
            'manage_options',
            $this->get_page(),
            array( $this, 'render_admin_page' )
        );
    }

    public function get_page () {
        return 'g1_socials_options';
    }

    public function capture_admin_page() {
        $this->register_translation_strings();

        ob_start();
            include( 'tpl_admin.php');
        $out = ob_get_clean();

        return $out;
    }

    public function register_translation_strings () {
        if ( !function_exists( 'icl_t' ) ) {
            return;
        }

        $icons = get_option( G1_Socials()->get_option_name(), array() );

        foreach ( $icons as $name => $data ) {
            icl_register_string('G1 Socials', $name . ' ' . esc_html__( 'label', 'g1_socials' ), $data['label'] );
            icl_register_string('G1 Socials', $name . ' ' . esc_html__( 'caption', 'g1_socials' ), $data['caption'] );
        }
    }

    public function render_admin_page() {
        echo $this->capture_admin_page();
    }

    public function capture_item( $name ) {
        $value = $this->get_item_value($name);
        $base_option_name = sprintf('%s[%s]', G1_Socials()->get_option_name(), $name);

        ob_start();
        include( 'tpl_admin_item.php');
        $out = ob_get_clean();

        return $out;
    }

    public function render_item( $name ) {
        echo $this->capture_item( $name );
    }

    public function get_item_value ( $name ) {
        $options = get_option(G1_Socials()->get_option_name());
        $value = !empty($options[$name]) ? $options[$name]: array();

        $default_value = array(
            'label'     => '',
            'caption'   => '',
            'link'      => '',
        );

        return wp_parse_args( $value, $default_value );
    }

    public function enqueue_styles( $hook ) {
        $url = trailingslashit( $this->get_plugin_object()->get_plugin_dir_url() );

        if ( 'post-new.php' === $hook || 'post.php' == $hook ) {
            wp_enqueue_style( 'g1-socials-shortcode', $url . 'css/g1-socials-shortcode.css', array(), $this->get_plugin_object()->get_version(), 'screen' );
        }

        wp_enqueue_style( 'g1-socials-admin',   $url . 'css/admin.css', array(), $this->get_plugin_object()->get_version(), 'screen' );
        wp_enqueue_style( 'font-awesome',       $url . 'css/font-awesome/css/font-awesome.min.css' );
    }

    public function enqueue_scripts( $hook ) {
        if ( 'settings_page_g1_socials_options' == $hook ) {
            wp_enqueue_script('jquery-ui-sortable');
        }
    }

    private function get_plugin_object () {
        return G1_Socials();
    }
}
endif;

function G1_Socials_Admin() {
    return G1_Socials_Admin::get_instance();
}
// Fire in the hole :)
G1_Socials_Admin();