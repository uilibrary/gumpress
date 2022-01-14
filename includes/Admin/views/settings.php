<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Gumpress', 'uilib-gumpress');?></h1>
    <br>
    <br>
    <form action="" style="max-width: 380px;" method="post">
        <table class="form-table">
            <tbody>
                <tr class="row">
                    <td>
                        <input type="text" value="<?php echo esc_attr(get_option('gumroad_http_token')); ?>" placeholder="Gumroad api key" name="gumroad-http-token" id="gumroad-http-token" class="regular-text">
                    </td>
                    <td>
                        <?php wp_nonce_field('gumroad-http-token');?>
                        <?php submit_button(__('Save', 'uilib-gumpress'), 'primary', 'save_gumroad_http_token');?>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <br>
    <br>

    <h2 class="wp-heading-inline">Sync products</h2>
    <a href="<?php echo admin_url('admin.php?page=uilib-gumpress&action=sync'); ?>" class="page-title-action"><?php _e('Sync Products', 'uilib-gumpress');?></a>
</div>