<div class="wrap">
    <h1><?php _e( 'Add New Postmeta', '' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <!-- <tr class="row-meta-id">
                    <th scope="row">
                        <label for="meta_id"><?php //_e( 'Meta Id', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="meta_id" id="meta_id" class="regular-text" placeholder="<?php //echo esc_attr( '', '' ); ?>" value="" />
                    </td>
                </tr> -->
                <tr class="row-post-id">
                    <th scope="row">
                        <label for="post_id"><?php _e( 'Post Id', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="post_id" id="post_id" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" />
                    </td>
                </tr>
                <tr class="row-meta-key">
                    <th scope="row">
                        <label for="meta_key"><?php _e( 'Meta Key', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="meta_key" id="meta_key" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" />
                    </td>
                </tr>
                <tr class="row-meta-value">
                    <th scope="row">
                        <label for="meta_value"><?php _e( 'Meta Value', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="meta_value" id="meta_value" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Add New Postmeta', '' ), 'primary', 'Post_Submit_Option' ); ?>

    </form>
</div>