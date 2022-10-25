<?php
/**
 * Sanitization for textarea field
 */
function th_shop_mania_sanitize_textarea( $input ){
    global $allowedposttags;
    $output = wp_kses( $input, $allowedposttags );
    return $output;
}
function th_shop_mania_sanitize_text( $string ) {
    return wp_kses_post( balanceTags( $string ) );
}
function th_shop_mania_sanitize_textarea_html( $input ) {
    $output = esc_html( $input );
    return $output;
}
function th_shop_mania_sanitize_font_weight( $input ) {

      $valid = array(
        'normal',
        'bold',
        '100',
        '200',
        '300',
        '400',
        '500',
        '600',
        '700',
        '800',
        '900',
      );

      if ( in_array( $input, $valid ) ) {
        return $input;
      } else {
        return 'normal';
      }
    }
/**
 * Returns a sanitized filepath if it has a valid extension.
 */
function th_shop_mania_sanitize_upload( $upload ) {
    $return = '';
    $fype = wp_check_filetype( $upload );
    if ( $fype["ext"] ) {
        $return = esc_url_raw( $upload );
    }
    return $return;
}
/**
 * Checkbox sanitization callback
 *
 */
function th_shop_mania_sanitize_checkbox( $checked ) {
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Select sanitization callback
 */
function th_shop_mania_sanitize_select( $input='', $setting='' ) {
    // Ensure input is a slug.
  $input = sanitize_key( $input );

  // Get list of choices from the control associated with the setting.
  $choices = $setting->manager->get_control( $setting->id );
  if (is_object($choices)) {
    $choices = $choices->choices;
  }
  // If the input is a valid key, return it; otherwise, return the default.
  if (is_array($choices)) {
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
  }
  
}


/**
 * Color sanitization callback
 *
 * @since 1.2.1
 */
function th_shop_mania_sanitize_color( $color ){
    if ( empty( $color ) || is_array( $color ) ){
        return '';
    }

    // If string does not start with 'rgba', then treat as hex.
    // sanitize the hex color and finally convert hex to rgba
    if ( false === strpos( $color, 'rgba' ) ) {
        return sanitize_hex_color( $color );
    }

    // By now we know the string is formatted as an rgba color so we need to further sanitize it.
    $color = str_replace( ' ', '', $color );
    sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

    return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
}

// Multiple Checkbox Show
function th_shop_mania_checkbox_explode( $values ){
    $multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;
    return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}
// Multiple Checkbox Show
function th_shop_mania_sanitize_number( $val, $setting ){

            $input_attrs = $setting->manager->get_control( $setting->id )->input_attrs;

            if ( isset( $input_attrs ) ) {

                $input_attrs['min']  = isset( $input_attrs['min'] ) ? $input_attrs['min'] : 0;
                $input_attrs['step'] = isset( $input_attrs['step'] ) ? $input_attrs['step'] : 1;

                if ( isset( $input_attrs['max'] ) && $val > $input_attrs['max'] ) {
                    $val = $input_attrs['max'];
                } elseif ( $val < $input_attrs['min'] ) {
                    $val = $input_attrs['min'];
                }

                        $dv = $val / $input_attrs['step'];

                        $dv = round( $dv );

                        $val = $dv * $input_attrs['step'];

                    $val = number_format( (float) $val, 2, '.', '' );
                if ( $val == (int) $val ) {
                    $val = (int) $val;
                }
            }

            return is_numeric( $val ) ? $val : 0;
        }
// radio
function th_shop_mania_sanitize_radio( $input='', $setting='' ){

  // Ensure input is a slug.
  $input = sanitize_key( $input );

  // Get list of choices from the control associated with the setting.
  $choices = $setting->manager->get_control( $setting->id );
  if (is_object($choices)) {
    $choices = $choices->choices;
  }
  // If the input is a valid key, return it; otherwise, return the default.
  if (is_array($choices)) {
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
  }
}
// MULTI-CHOICE
function sanitize_multi_choices( $input, $setting ){

      // Get list of choices from the control
      // associated with the setting.
      $choices    = $setting->manager->get_control( $setting->id )->choices;
      $input_keys = $input;

      foreach ( $input_keys as $key => $value ){
        if ( ! array_key_exists( $value, $choices ) ){
          unset( $input[ $key ] );
        }
      }

      // If the input is a valid key, return it;
      // otherwise, return the default.
      return ( is_array( $input ) ? $input : $setting->default );
    }
//Repeater Control
/**
 * Sanitize repeater control.
 *
 * @param object $value Control output.
 *
 * @return object
 */
function th_shop_mania_repeater_sanitize( $value ) {
    $value_decoded = json_decode( $value, true );

    if ( ! empty( $value_decoded ) ) {
        foreach ( $value_decoded as $boxk => $box ) {
            foreach ( $box as $key => $value ) {

                $value_decoded[ $boxk ][ $key ] = wp_kses_post( force_balance_tags( $value ) );

            }
        }

        return json_encode( $value_decoded );
    }

    return $value;
}
/**
 * Default color picker palettes
 */
if ( ! function_exists( 'th_shop_mania_default_color_palettes' ) ){
    function th_shop_mania_default_color_palettes() {
    $palettes = array(
            '#000000',
            '#ffffff',
            '#dd3333',
            '#dd9933',
            '#eeee22',
            '#81d742',
            '#1e73be',
            '#8224e3',
        );
        // Apply filters and return
        return apply_filters( 'th_shop_mania_default_color_palettes', $palettes );

    }

}
// th_shop_mania_Customizer_Sanitizes
if ( ! class_exists( 'th_shop_mania_Customizer_Sanitizes' ) ){
    /**
     * Customizer Sanitizes Initial setup
     */
    class th_shop_mania_Customizer_Sanitizes{

        /**
         * Instance
         *
         * @access private
         * @var object
         */
        private static $instance;

        /**
         * Initiator
         */
        public static function get_instance(){
            if ( ! isset( self::$instance ) ){
                self::$instance = new self;
            }
            return self::$instance;
        }
        /**
         * Constructor
         */
        public function __construct() { }
        /**
         * Sanitize responsive  Spacing
         *
         * @param  number $val Customizer setting input number.
         * @return number        Return number.
         * @since  1.2.1
         */
        static public function th_shop_mania_sanitize_responsive_spacing( $val ) {

            $spacing = array(
                'desktop'      => array(
                    'top'    => '',
                    'right'  => '',
                    'bottom' => '',
                    'left'   => '',
                ),
                'tablet'       => array(
                    'top'    => '',
                    'right'  => '',
                    'bottom' => '',
                    'left'   => '',
                ),
                'mobile'       => array(
                    'top'    => '',
                    'right'  => '',
                    'bottom' => '',
                    'left'   => '',
                ),
                'desktop-unit' => 'px',
                'tablet-unit'  => 'px',
                'mobile-unit'  => 'px',
            );

            if ( isset( $val['desktop'] ) ) {
                $spacing['desktop'] = array_map(
                    function ( $value ) {
                            return ( is_numeric( $value ) && $value >= 0 ) ? $value : '';
                    }, $val['desktop']
                );

                $spacing['tablet'] = array_map(
                    function ( $value ) {
                            return ( is_numeric( $value ) && $value >= 0 ) ? $value : '';
                    }, $val['tablet']
                );

                $spacing['mobile'] = array_map(
                    function ( $value ) {
                            return ( is_numeric( $value ) && $value >= 0 ) ? $value : '';
                    }, $val['mobile']
                );

                if ( isset( $val['desktop-unit'] ) ) {
                    $spacing['desktop-unit'] = $val['desktop-unit'];
                }

                if ( isset( $val['tablet-unit'] ) ) {
                    $spacing['tablet-unit'] = $val['tablet-unit'];
                }

                if ( isset( $val['mobile-unit'] ) ) {
                    $spacing['mobile-unit'] = $val['mobile-unit'];
                }

                return $spacing;

            } else {
                foreach ( $val as $key => $value ) {
                    $val[ $key ] = is_numeric( $val[ $key ] ) ? $val[ $key ] : '';
                }
                return $val;
            }

        }

    }

}
th_shop_mania_Customizer_Sanitizes::get_instance();
/**
 * Multiple checkbox customize control class.
 *
 * @since  1.0.0
 * @access public
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
class th_shop_mania_Customize_Control_Checkbox_Multiple extends WP_Customize_Control{
    /**
     * The type of customize control being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'checkbox-multiple';

    /**
     * Enqueue scripts/styles.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function enqueue() {
       
    }

    /**
     * Displays the control content.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function render_content() {

        if ( empty( $this->choices ) ){
            return;   }
            ?>
      

        <?php if ( !empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif; ?>
        <?php if ( !empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
        <?php endif; ?>
        <?php $multi_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>
        <ul>
            <?php foreach ( $this->choices as $value => $label ) : ?>

                <li>
                    <label>
                        <input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> /> 
                        <?php echo esc_html( $label ); ?>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
        <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
    <?php }
}
}

function th_shop_mania_customize_function_register( $wp_customize ){
  /**
 *widget-redirect
 *
 */
class th_shop_mania_Widegt_Redirect extends WP_Customize_Control {
    /**
     * Control id
     *
     * @var string $id Control id.
     */
    public $id = '';

    /**
     * Button class.
     *
     * @var mixed|string
     */
    public $button_class = '';

    /**
     * Icon class.
     *
     * @var mixed|string
     */
    public $icon_class = '';

    /**
     * Button text.
     *
     * @var mixed|string
     */
    public $button_text = '';

    /**
     * 
     *
     * @param WP_Customize_Manager $manager Customizer manager.
     * @param string               $id Control id.
     * @param array                $args Argument.
     */
    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );
        $this->id = $id;
        if ( ! empty( $args['button_class'] ) ) {
            $this->button_class = $args['button_class'];
        }
        if ( ! empty( $args['icon_class'] ) ) {
            $this->icon_class = $args['icon_class'];
        }
        if ( ! empty( $args['button_text'] ) ) {
            $this->button_text = $args['button_text'];
        }
    }

    /**
     * Render content for the control.
     *
     */
    public function render_content() {
        if ( ! empty( $this->button_text ) ) {
            echo '<button type="button" class="button menu-shortcut ' . esc_attr( $this->button_class ) . '" tabindex="0">';
            if ( ! empty( $this->button_class ) ) {
                echo '<span class="dashicons dashicons-admin-generic" style="margin-right: 10px;margin-top:3px;
    color:#999;"></span>';
            }
                echo esc_html( $this->button_text );
            echo '</button>';
        }
    }
}
  // divider
    class th_shop_mania_Misc_Control extends WP_Customize_Control{
    public $description = '';
    public $url = '';
    public $label = '';
    public $title = '';
    public function render_content() {
        switch ( $this->type ) {
            default:

            case 'heading':
                echo '<span class="customize-control-title">'.esc_html($this->title).'</span>';
                break;
            case 'custom_message' :
                echo '<p class="description">' .esc_html($this->description). '</p>';
                break;
            case 'pro-text' :
                echo '<span class="view-pro">' .esc_html($this->label). '</span><span class="pro-desc">' .esc_html($this->description). '</span>';
                break;
            case'pro-link':
                echo sprintf(
                            '<a href="%1$s" target="_blank">'.esc_html($this->label).'</a>',
                            esc_url( $this->url )
                        );
            break;
            case 'doc-link':
                echo sprintf(
                            '<p class="opn-doc-link"> %1$s  <a href="%2$s" target="_blank">%3$s</a></p>',
                            esc_html( $this->description ),
                            esc_url( $this->url ),
                            esc_html__('Doc', 'th-shop-mania' )
                        );
            break;
            case 'hr' :
                echo '<hr />';
            break;
        }
     }   
}
  // Register customizer setting
$wp_customize->register_panel_type( 'Th_Shop_Mania_WP_Customize_Panel' );
$wp_customize->register_section_type( 'Th_Shop_Mania_WP_Customize_Section' );
$wp_customize->register_section_type( 'th_shop_mania_WP_Customize_Control_Radio_Image' );
$wp_customize->register_section_type( 'Th_Shop_Mania_WP_Customizer_Range_Value_Control' );
// $wp_customize->register_section_type( 'amaz_store_Customize_Custom_Background_Control' );
// $wp_customize->register_section_type( 'amaz_store_Customizer_Buttonset_Control' );
$wp_customize->register_section_type( 'th_shop_mania_Toggle_Control' );
}
add_action('customize_register','th_shop_mania_customize_function_register');
function th_shop_mania_customizer_script_registers(){
  wp_enqueue_script( 'open_customizer_script', TH_SHOP_MANIA_THEME_URI .'customizer/extend-customizer/extend-js/extend-customizer.js', array("jquery"), '', true );  
}
add_action('customize_controls_enqueue_scripts', 'th_shop_mania_customizer_script_registers' );

// style
function th_shop_mania_customizer_style_registers(){
    
  wp_enqueue_style('th_shop_mania_customizer_styles', TH_SHOP_MANIA_THEME_URI .'customizer/extend-customizer/extend-css/extend-customizer.css');
  wp_enqueue_style('th_shop_mania_customizer_custom_styles', TH_SHOP_MANIA_THEME_URI .'customizer/customizer.css');
}
add_action('customize_controls_print_styles', 'th_shop_mania_customizer_style_registers');

/**
 * Used by hook: 'customize_preview_init'
 * 
 * @see add_action('customize_preview_init',$func)
 */
function th_shop_mania_customizer_live_preview(){
wp_enqueue_script( 'th_shop_mania_live_customizer', get_template_directory_uri().'/customizer/js/live-customizer.js', array("jquery"),'', true );  
}
add_action('customize_preview_init','th_shop_mania_customizer_live_preview');