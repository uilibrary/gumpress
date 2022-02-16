<div class="wrap">
    <h1 class="wp-heading-inline"><strong><?php _e('Gumpress', 'uilib-gumpress');?></strong></h1>
    <br>
    <form action="" style="max-width: 660px;" method="post">
        <table class="form-table">
            <tbody>
                <tr>
                    <th>Gumroad Access Token* [<a href="https://help.gumroad.com/article/280-create-application-api" title="Generating an access token" target="_blank">?</a>]</th>
                    <td>
                        <input type="text" value="<?php echo esc_attr(get_option('gumroad_http_token')); ?>" placeholder="Gumroad token" name="gumroad-http-token" id="gumroad-http-token" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th><h4>Override settings</h4></th>
                    <td>Override seettings will only work when you've already imported Gumroad products.</td>
                </tr>
                <tr>
                    <th><label for="gp-reset-title">Override Product Titles</label></th>
                    <td>
                        <input type="checkbox" <?php checked(1, get_option('gp_reset_title'));?> name="gp-reset-title" id="gp-reset-title">
                        <p class="description">This will reset your existing product's titles</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="gp-reset-description">Override Product Descriptions</label></th>
                    <td>
                        <input type="checkbox" <?php checked(1, get_option('gp_reset_description'));?> name="gp-reset-description" id="gp-reset-description">
                        <p class="description">This will reset your existing product's description</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <?php wp_nonce_field('gumroad-http-token');?>
            <?php submit_button(__( 'Save Changes', 'uilib-gumpress'), 'button', 'save_gumroad_http_token', false );?>
        </p>
    </form>
    <h2 class="title"><strong>Sync Products</strong></h2>
    <p><?php echo __('Import all of your products from Gumroad.', 'uilib-gumpress') ?></p>
    <a href="<?php echo admin_url('admin.php?page=uilib-gumpress&action=sync'); ?>" class="button button-primary button-large"><?php _e('Sync Products', 'uilib-gumpress');?></a>
</div>