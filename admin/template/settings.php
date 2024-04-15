<div class="wrap">
        <h2><?php esc_html_e( 'Multi Step Checkout Settings', 'multi-step-checkout-pmpro' ); ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'ets_msc_settings_group' ); ?>
            <?php do_settings_sections( 'ets_msc_settings_group' ); ?>
            <div class="form-field">
                <label for="ets_msc_step_bg_color"><?php esc_html_e( 'Step Background Color', 'multi-step-checkout-pmpro' ); ?></label>
                <input type="text" name="ets_msc_step_bg_color" value="<?php echo esc_attr( get_option( 'ets_msc_step_bg_color', '#f0f0f0' ) ); ?>" class="wp-color-picker">
            </div>
            <div class="form-field">
                <label for="ets_msc_step_border_color"><?php esc_html_e( 'Step Border Color', 'multi-step-checkout-pmpro' ); ?></label>
                <input type="text" name="ets_msc_step_border_color" value="<?php echo esc_attr( get_option( 'ets_msc_step_border_color', '#cccccc' ) ); ?>" class="wp-color-picker">
            </div>
            <div class="form-field">
                <label for="ets_msc_step_active_bg_color"><?php esc_html_e( 'Active Step Background Color', 'multi-step-checkout-pmpro' ); ?></label>
                <input type="text" name="ets_msc_step_active_bg_color" value="<?php echo esc_attr( get_option( 'ets_msc_step_active_bg_color', '#194305' ) ); ?>" class="wp-color-picker">
            </div>
            <div class="form-field">
                <label for="ets_msc_step_active_color"><?php esc_html_e( 'Active Step Text Color', 'multi-step-checkout-pmpro' ); ?></label>
                <input type="text" name="ets_msc_step_active_color" value="<?php echo esc_attr( get_option( 'ets_msc_step_active_color', '#ffffff' ) ); ?>" class="wp-color-picker">
            </div>
            <?php submit_button( __( 'Save Settings', 'multi-step-checkout-pmpro' ), 'primary', 'submit', true ); ?>
        </form>
</div>
