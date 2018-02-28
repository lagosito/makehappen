<div class="wrap">
    <?php do_action( 'g1_plugin_before_admin_page' ); ?>
    <?php do_action( 'g1_socials_before_admin_page' ); ?>


    <h2><?php esc_html_e( 'G1 Socials', 'g1_socials' ); ?></h2>
    <form action="options.php" method="post">

        <?php settings_fields(G1_Socials()->get_option_name()); ?>

        <table id="g1-social-icons" class="g1-social-icons-table">
            <thead>
                <tr>
                    <th colspan="2"><?php esc_html_e( 'Name', 'g1_socials' ); ?></th>
                    <th><?php esc_html_e( 'Label', 'g1_socials' ); ?></th>
                    <th><?php esc_html_e( 'Caption', 'g1_socials' ); ?></th>
                    <th><?php esc_html_e( 'Link', 'g1_socials' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ( G1_Socials()->get_items() as $g1_name => $g1_data ) {
                        G1_Socials_Admin()->render_item( $g1_name );
                    }
                ?>
            </tbody>
        </table>

        <p class="g1-social-icons-form-actions">
            <input class="button button-primary" name="Submit" type="submit" value="<?php esc_attr_e('Save Changes', 'g1_socials'); ?>" />
        </p>
    </form>

    <?php do_action( 'g1_socials_before_admin_page' ); ?>
    <?php do_action( 'g1_plugin_after_admin_page' ); ?>
</div>

<script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            $( '#g1-social-icons tbody' ).sortable();

            $( '#g1-social-icons tbody tr' ).each(function () {
                var $this = $(this);

                $this.mouseover(function () {
                    $this.addClass('g1-hover');
                });

                $this.mouseout(function () {
                    $this.removeClass('g1-hover');
                });
            });
        });
    })(jQuery);
</script>

