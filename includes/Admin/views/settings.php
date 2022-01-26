<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Gumpress', 'uilib-gumpress');?></h1>
    <br>
    <form action="" style="max-width: 660px;" method="post">
        <table class="form-table">
            <tbody>
                <tr>
                    <th>Gumroad access token [<a href="https://help.gumroad.com/article/280-create-application-api#Generatinganaccessto" title="Generating an access token" target="_blank">?</a>]</th>
                    <td>
                        <input type="text" value="<?php echo esc_attr(get_option('gumroad_http_token')); ?>" placeholder="Gumroad token" name="gumroad-http-token" id="gumroad-http-token" class="regular-text">
                    </td>
                    <td>
                        <?php wp_nonce_field('gumroad-http-token');?>
                        <?php submit_button(__( 'Save', 'uilib-gumpress'), 'primary', 'save_gumroad_http_token', false );?>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <h2 class="title">Sync Products</h2>
    <p><?php echo __('Import all of your products from Gumroad.', 'uilib-gumpress') ?></p>
    <br>
    <a href="<?php echo admin_url('admin.php?page=uilib-gumpress&action=sync'); ?>" class="page-title-action"><?php _e('Sync Products', 'uilib-gumpress');?></a>
</div>