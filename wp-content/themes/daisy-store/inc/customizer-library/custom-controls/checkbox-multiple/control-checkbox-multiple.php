<?php
function daisy_store_load_checkbox_multiple_controls() {
/**
 * Multiple checkbox customize control class.
 *
 * @access public
 */
class Daisy_Store_Customize_Control_Checkbox_Multiple extends WP_Customize_Control {

    /**
     * The type of customize control being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'multiple-checkbox';

    /**
     * Enqueue scripts/styles.
     *
     * @access public
     * @return void
     */
    public function enqueue() {
    }

    /**
     * Displays the control content.
     *
     * @access public
     * @return void
     */
    public function render_content() {

        if ( empty( $this->choices ) )
            return; ?>

        <?php if ( !empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif; ?>

        <?php if ( !empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo $this->description; ?></span>
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
add_action( 'customize_register', 'daisy_store_load_checkbox_multiple_controls', 0 );