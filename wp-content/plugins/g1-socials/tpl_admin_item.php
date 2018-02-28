<tr>
    <td>
        <span class="g1-socials-item-icon g1-socials-item-icon-<?php echo sanitize_html_class( $name ); ?>" title="<?php esc_attr( $name ); ?>"></span>
    </td>
    <td>
        <?php echo esc_html( $name ); ?>
    </td>
    <td>
        <input type="text" name="<?php echo esc_attr( $base_option_name.'[label]' ); ?>" value="<?php echo esc_attr( $value['label'] ) ?>" placeholder="<?php esc_attr_e( 'label&hellip;', 'g1_socials' ); ?>" />
    </td>
    <td>
        <input type="text" name="<?php echo esc_attr( $base_option_name.'[caption]' ); ?>" value="<?php echo esc_attr( $value['caption'] ) ?>" placeholder="<?php esc_attr_e( 'caption&hellip;', 'g1_socials' ); ?>" />
    </td>
    <td>
        <input type="text" name="<?php echo esc_attr( $base_option_name.'[link]' ); ?>" value="<?php echo esc_attr( $value['link'] ) ?>" placeholder="<?php echo esc_attr_e( 'link&hellip;', 'g1_socials' ); ?>" />
    </td>
</tr>