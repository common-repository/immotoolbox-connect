<?php
/**
 * Created by PhpStorm.
 * User: BenjaminMermoz
 * Date: 09/10/2018
 * Time: 16:13
 */
?>
<div class="wrap">
    <h1><?php _e('ITB Connect API Settings', 'itbconnect'); ?></h1>

    <form id="itbconnect-admin-form" method="post">
        <p>
			<?php _e('You can get your API settings from your <b>Integrations</b> page on ImmoToolBox.', 'itbconnect'); ?>
        </p>
        <p>
            <?php printf(__('Documentation can be found on the <a href="%s" target="_blank">plugin page</a>.', 'itbconnect'), ITBCONNECT_PLUGIN_URL); ?>
        </p>
        <p>
            <?php _e('Plugin version :', 'itbconnect'); ?> <?=ITBCONNECT_VERSION;?>
        </p>

        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="itbconnect_private_key"><?php _e( 'Private key', 'itbconnect' ); ?></label>
                </th>
                <td>
                    <input name="itbconnect_private_key"
                           id="itbconnect_private_key"
                           class="regular-text"
                           type="text"
                           required="required"
                           minlength="32"
                           value="<?php echo (isset($data['private_key'])) ? $data['private_key'] : ''; ?>"/>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="itbconnect_google_maps_api_key"><?php _e( 'Google Maps key', 'itbconnect' ); ?></label>
                </th>
                <td>
                    <input name="itbconnect_google_maps_api_key"
                           id="itbconnect_google_maps_api_key"
                           class="regular-text"
                           type="text"
                           value="<?php echo (isset($data['google_maps_api_key'])) ? $data['google_maps_api_key'] : ''; ?>"/>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="itbconnect_include_bootstrap_js"><?php _e( 'Include Bootstrap', 'itbconnect' ); ?></label>
                </th>
                <td>
                    <select name="itbconnect_include_bootstrap_js"
                           id="itbconnect_include_bootstrap_js"
                            class="regular-text"
                          >
                        <option value="0"><?php _e( 'Javascript', 'itbconnect' ); ?> : <?php _e('No'); ?></option>
                        <option value="1" <?=isset($data['include_bootstrap_js'])&&$data['include_bootstrap_js']?"selected":""; ?>><?php _e( 'Javascript', 'itbconnect' ); ?> : <?php _e('Yes'); ?></option>
                    </select><br />
                    <select name="itbconnect_include_bootstrap_css"
                           id="itbconnect_include_bootstrap_css"
                            class="regular-text"
                          >
                        <option value="0"><?php _e( 'CSS', 'itbconnect' ); ?> : <?php _e('No'); ?></option>
                        <option value="1" <?=isset($data['include_bootstrap_css'])&&$data['include_bootstrap_css']?"selected":""; ?>><?php _e( 'CSS', 'itbconnect' ); ?> : <?php _e('Yes'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="itbconnect_property_page_id">Property template page</label>
                </th>
                <td>
                    <select id="itbconnect_property_page_id" name="itbconnect_property_page_id" class="regular-text">
                        <option value="">-</option>
						<?php
						if( $pages = get_pages() ){
							echo '<optgroup label="'.__('Detected pages', 'itbconnect').'">';
							foreach( $pages as $page ){
							    if (false!==strpos($page->post_content, '[itb_property')) {
								    echo '<option value="' . $page->ID . '" ' . selected( $page->ID, $data['property_page_id'] ) . '>' . $page->post_title . '</option>';
							    }
							}
							echo '</optgroup>';
							echo '<optgroup label="'.__('Other pages', 'itbconnect').'">';
							foreach( $pages as $page ){
								if (false===strpos($page->post_content, '[itb_property')) {
									echo '<option value="' . $page->ID . '" ' . selected( $page->ID, $data['property_page_id'] ) . '>' . $page->post_title . '</option>';
								}
							}
							echo '</optgroup>';
						}
						?>
                    </select>
                    <p class="description" id="tagline-description"><?php _e( 'The WordPress page used to display a property', 'itbconnect' ); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="itbconnect_searchresults_page_id">Search results page</label>
                </th>
                <td>
                    <select id="itbconnect_searchresults_page_id" name="itbconnect_searchresults_page_id" class="regular-text">
                        <option value="">-</option>

						<?php
						if( $pages = get_pages() ){
						    echo '<optgroup label="'.__('Detected pages', 'itbconnect').'">';
							foreach( $pages as $page ) {
								if ( false !== strpos( $page->post_content, '[itb_searchresults' ) ) {
									echo '<option value="' . $page->ID . '" ' . selected( $page->ID, $data['searchresults_page_id'] ) . '>' . $page->post_title . '</option>';
								}
							}
							echo '</optgroup>';
							echo '<optgroup label="'.__('Other pages', 'itbconnect').'">';
							foreach( $pages as $page ) {
								if ( false === strpos( $page->post_content, '[itb_searchresults' ) ) {
									echo '<option value="' . $page->ID . '" ' . selected( $page->ID, $data['searchresults_page_id'] ) . '>' . $page->post_title . '</option>';
								}
							}
							echo '</optgroup>';
						}
						?>
                    </select>
                    <p class="description" id="tagline-description"><?php _e( 'The WordPress page used to display search results', 'itbconnect' ); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="itbconnect_basket_page_id">Client properties selection page</label>
                </th>
                <td>
                    <select id="itbconnect_basket_page_id" name="itbconnect_basket_page_id" class="regular-text">
                        <option value="">-</option>

						<?php
						if( $pages = get_pages() ){
						    echo '<optgroup label="'.__('Detected pages', 'itbconnect').'">';
							foreach( $pages as $page ) {
								if ( false !== strpos( $page->post_content, '[itb_selection' ) ) {
									echo '<option value="' . $page->ID . '" ' . selected( $page->ID, $data['basket_page_id'] ) . '>' . $page->post_title . '</option>';
								}
							}
							echo '</optgroup>';
							echo '<optgroup label="'.__('Other pages', 'itbconnect').'">';
							foreach( $pages as $page ) {
								if ( false === strpos( $page->post_content, '[itb_selection' ) ) {
									echo '<option value="' . $page->ID . '" ' . selected( $page->ID, $data['basket_page_id'] ) . '>' . $page->post_title . '</option>';
								}
							}
							echo '</optgroup>';
						}
						?>
                    </select>
                    <p class="description" id="tagline-description"><?php _e( 'The WordPress page used to display client selection', 'itbconnect' ); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="itbconnect_include_bootstrap_js"><?php _e( 'Check SSL certificate', 'itbconnect' ); ?></label>
                </th>
                <td>
                    <select name="itbconnect_nocheck_ssl"
                            id="itbconnect_nocheck_ssl"
                            class="regular-text"
                    >
                        <option value="0"><?php _e( 'Check SSL', 'itbconnect' ); ?> : <?php _e('Yes'); ?></option>
                        <option value="1" <?=isset($data['nocheck_ssl'])&&$data['nocheck_ssl']?"selected":""; ?>><?php _e( 'Check SSL', 'itbconnect' ); ?> : <?php _e('No'); ?></option>
                    </select>
                    <p class="description" id="tagline-description"><?php _e( 'You can set this option to "No" if the connection to ImmoToolBox fails (can happen on old server)' ); ?></p>
                </td>
            </tr>
			<?php if (!empty($data['private_key'])) { ?>
				<?php if (!$connect_response) { ?>
                    <tr>
                        <td colspan="2">
                            <p class="notice notice-error">
								<?php _e( 'An error happened while trying to connect to ImmoToolBox. Please double check the API Private key.', 'itbconnect' ); ?>
                            </p>
                        </td>
                    </tr>
				<?php } else { ?>
                    <tr>
                        <td colspan="2">
                            <p class="notice notice-success">
								<?php _e( 'The connection to ImmoToolBox is established!', 'itbconnect' ); ?><br />
								<?php _e( 'Properties available :', 'itbconnect' ); ?> <?=(int)$connect_response->{"hydra:totalItems"}; ?>
                            </p>
                        </td>
                    </tr>
				<?php } ?>
			<?php } else { ?>
                <tr>
                    <td colspan="2">
                        <p class="notice notice-info">
                            <?php _e( 'Please fill up your API keys to see the widget options.', 'itbconnect' ); ?>
                        </p>
                    </td>
                </tr>
			<?php } ?>
            </tbody>
        </table>
        <button class="button button-primary" id="itbconnect-admin-save" type="submit"><?php _e( 'Save' ); ?></button>
    </form>
</div>