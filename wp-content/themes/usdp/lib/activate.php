<?php

/**
 * Prompt for required plugins
 */
require_once(dirname(__FILE__ ) . '/vendor/class-tgm-plugin-activation.php');

function _usdp_register_required_plugins() {
  $plugins = array(
    array(
      'name'     => 'Timber',
      'slug'     => 'timber-library',
      'required' => true
    ),
  );

  tgmpa($plugins, array());
}
add_action('tgmpa_register', '_usdp_register_required_plugins');

/**
 * Add URL rewrites on theme activation
 */
// function _usdp_asset_rewrites() {
//   function _usdp_add_asset_rewrites($content) {
//     global $wp_rewrite;
//     $new_asset_rewrites = array(
//       // 'assets/(.*)'  => THEME_PATH . '/assets/$1',
//       'plugins/(.*)' => RELATIVE_PLUGIN_PATH . '/$1',
//       'media/(.*)'   => RELATIVE_UPLOAD_PATH . '/$1'
//     );
//     $wp_rewrite->non_wp_rules = array_merge($wp_rewrite->non_wp_rules, $new_asset_rewrites);
//     return $content;
//   }

//   add_action('generate_rewrite_rules', '_usdp_add_asset_rewrites');
// }
// add_action('after_setup_theme', '_usdp_asset_rewrites');

/**
 * Create primary menu on theme activation
 */
function _usdp_create_primary_menu() {
  $menu_name = 'Primary Navigation';

  // Check if the menu exists
  $menu_exists = wp_get_nav_menu_object($menu_name);

  // If it doesn't exist, create it
  if (!$menu_exists) {
    $menu_id = wp_create_nav_menu($menu_name);
  }
}
add_action('after_setup_theme', '_usdp_create_primary_menu');

/**
 * Theme activation options
 */
if (is_admin() && isset($_GET['activated']) && 'themes.php' == $GLOBALS['pagenow']) {
  wp_redirect(admin_url('themes.php?page=theme_activation_options'));
  exit();
}

function _usdp_theme_activation_options_init() {
  register_setting(
    '_usdp_activation_options',
    '_usdp_theme_activation_options'
  );
}
add_action('admin_init', '_usdp_theme_activation_options_init');

function _usdp_add_theme_activation_options_page() {
  add_theme_page(
    __('Theme Activation', '_usdp'),
    __('Theme Activation', '_usdp'),
    'edit_theme_options',
    'theme_activation_options',
    '_usdp_render_theme_activation_options'
  );
}
add_action('admin_menu', '_usdp_add_theme_activation_options_page', 50);

function _usdp_render_theme_activation_options() {
  ?>
  <div class="wrap">
    <h2><?php __('Theme Activation', '_usdp'); ?></h2>
    <?php if (strpos(wp_get_referer(), 'page=theme_activation_options') !== false): ?>
    <div class="updated"><p>Settings updated successfully!</p></div>
    <?php endif; ?>
    <form method="post" action="options.php">
      <?php settings_fields('_usdp_activation_options'); ?>
      <table class="form-table">
        <!-- Create Static Front Page -->
        <?php if (current_user_can('publish_pages') && current_user_can('edit_theme_options') && current_user_can('manage_options')): ?>
        <tr valign="top"><th scope="row"><?php _e('Create static front page?', '_usdp'); ?></th>
          <td>
            <fieldset>
              <legend class="screen-reader-text"><span><?php _e('Create static front page?', '_usdp'); ?></span></legend>
              <select name="_usdp_theme_activation_options[create_front_page]" id="create_front_page">
                <option selected="selected" value="true"><?php echo _e('Yes', '_usdp'); ?></option>
                <option value="false"><?php echo _e('No', '_usdp'); ?></option>
              </select>
              <p class="description"><?php printf(__('Creates a "Home" page and sets it as the static front page', '_usdp')); ?></p>
            </fieldset>
          </td>
        </tr>
        <?php endif; ?>

        <!-- Disable Comments -->
        <?php if (current_user_can('manage_options')): ?>
        <tr valign="top"><th scope="row"><?php _e('Disable comments?', '_usdp'); ?></th>
          <td>
            <fieldset>
              <legend class="screen-reader-text"><span><?php _e('Disable comments?', '_usdp'); ?></span></legend>
              <select name="_usdp_theme_activation_options[disable_comments]" id="disable_comments">
                <option selected="selected" value="true"><?php echo _e('Yes', '_usdp'); ?></option>
                <option value="false"><?php echo _e('No', '_usdp'); ?></option>
              </select>
              <p class="description"><?php printf(__('Disables all comments and pingbacks', '_usdp')); ?></p>
            </fieldset>
          </td>
        </tr>
        <?php endif; ?>

        <!-- Change Permalink Structure -->
        <?php if (current_user_can('manage_options')): ?>
        <tr valign="top"><th scope="row"><?php _e('Change permalink structure?', '_usdp'); ?></th>
          <td>
            <fieldset>
              <legend class="screen-reader-text"><span><?php _e('Update permalink structure?', '_usdp'); ?></span></legend>
              <select name="_usdp_theme_activation_options[change_permalink_structure]" id="change_permalink_structure">
                <option selected="selected" value="true"><?php echo _e('Yes', '_usdp'); ?></option>
                <option value="false"><?php echo _e('No', '_usdp'); ?></option>
              </select>
              <p class="description"><?php printf(__('Change permalink structure to /&#37;postname&#37;/', '_usdp')); ?></p>
            </fieldset>
          </td>
        </tr>
        <?php endif; ?>

        <!-- Flatten Uploads Directory -->
        <?php if (current_user_can('manage_options')): ?>
        <tr valign="top"><th scope="row"><?php _e('Flatten uploads directory?', '_usdp'); ?></th>
          <td>
            <fieldset>
              <legend class="screen-reader-text"><span><?php _e('Flatten uploads directory?', '_usdp'); ?></span></legend>
              <select name="_usdp_theme_activation_options[flatten_uploads]" id="flatten_uploads">
                <option selected="selected" value="true"><?php echo _e('Yes', '_usdp'); ?></option>
                <option value="false"><?php echo _e('No', '_usdp'); ?></option>
              </select>
              <p class="description"><?php printf(__('Disables default WordPress sorting of uploads into year and month directories', '_usdp')); ?></p>
            </fieldset>
          </td>
        </tr>
        <?php endif; ?>

        <!-- Remove Default Plugins -->
        <?php if (current_user_can('delete_plugins')): ?>
        <tr valign="top"><th scope="row"><?php _e('Remove default plugins?', '_usdp'); ?></th>
          <td>
            <fieldset>
              <legend class="screen-reader-text"><span><?php _e('Remove default plugins?', '_usdp'); ?></span></legend>
              <select name="_usdp_theme_activation_options[remove_default_plugins]" id="remove_default_plugins">
                <option selected="selected" value="true"><?php echo _e('Yes', '_usdp'); ?></option>
                <option value="false"><?php echo _e('No', '_usdp'); ?></option>
              </select>
              <p class="description"><?php printf(__('Removes the default plugins included in the WordPress installation (Hello Dolly and Akismet)', '_usdp')); ?></p>
            </fieldset>
          </td>
        </tr>
        <?php endif; ?>

        <!-- Remove Default Content -->
        <?php if (current_user_can('delete_posts') && current_user_can('delete_pages') && current_user_can('edit_comment')): ?>
        <tr valign="top"><th scope="row"><?php _e('Remove default content?', '_usdp'); ?></th>
          <td>
            <fieldset>
              <legend class="screen-reader-text"><span><?php _e('Remove default content?', '_usdp'); ?></span></legend>
              <select name="_usdp_theme_activation_options[remove_default_content]" id="remove_default_content">
                <option selected="selected" value="true"><?php echo _e('Yes', '_usdp'); ?></option>
                <option value="false"><?php echo _e('No', '_usdp'); ?></option>
              </select>
              <p class="description"><?php printf(__('Removes the default WordPress content (i.e. sample post, page, and comment)', '_usdp')); ?></p>
            </fieldset>
          </td>
        </tr>
        <?php endif; ?>

        <!-- Remove Default Theme -->
        <?php if (current_user_can('delete_themes')): ?>
        <tr valign="top"><th scope="row"><?php _e('Remove default themes?', '_usdp'); ?></th>
          <td>
            <fieldset>
              <legend class="screen-reader-text"><span><?php _e('Remove default themes?', '_usdp'); ?></span></legend>
              <select name="_usdp_theme_activation_options[remove_default_themes]" id="remove_default_themes">
                <option selected="selected" value="true"><?php echo _e('Yes', '_usdp'); ?></option>
                <option value="false"><?php echo _e('No', '_usdp'); ?></option>
              </select>
              <p class="description">
                <?php printf(__('Removes the default WordPress themes', '_usdp')); ?>
                <?php $default_themes = _usdp_get_default_themes(); ?>
                <?php if (count($default_themes) > 0): ?>
                <?php echo ' (' . join(', ', array_map(function($theme) { return $theme->get('Name'); }, $default_themes)) . ')'; ?>
                <?php endif; ?>
              </p>
            </fieldset>
          </td>
        </tr>
        <?php endif; ?>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
  <?php
}

function _usdp_get_default_themes() {
  return array_filter(wp_get_themes(), function($theme) {
    return $theme->get('Author') === 'the WordPress team';
  });
}

function _usdp_update_activation_options() {
  // Determine if action should be executed on every request or only when form submitted
  $submitted = strpos(wp_get_referer(), 'page=theme_activation_options') !== false;

  // Option actions by key
  $actions = array(
    // Create static front page
    'create_front_page' => array(
      'every_request' => false,
      'action' => function() {
        $page_title = 'Home';

        // Verify page does not already exist
        foreach (get_pages() as $i => $page) {
          if ($page->post_title == $page_title) return;
        }

        // Create page
        if (current_user_can('publish_pages')) {
          $page_id = wp_insert_post(array(
            'post_title' => $page_title,
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page'
          ));
        }

        // Create menu item
        if (current_user_can('edit_theme_options')) {
          wp_update_nav_menu_item('primary-navigation', 0);
        }

        // Update front page setting
        if (current_user_can('manage_options')) {
          update_option('show_on_front', 'page');
          update_option('page_on_front', $page_id);
        }
      }
    ),

    // Disable comments
    'disable_comments' => array(
      'every_request' => false,
      'action' => function() {
        if (!current_user_can('manage_options')) return;

        update_option('default_comment_status', 'closed');
        update_option('default_ping_status', 'closed');
      }
    ),

    // Set permalink structure to /%postname%/
    'change_permalink_structure' => array(
      'every_request' => false,
      'action' => function() {
        if (!current_user_can('manage_options')) return;

        if (get_option('permalink_structure') !== '/%postname%/') {
          global $wp_rewrite;
          $wp_rewrite->set_permalink_structure('/%postname%/');
          flush_rewrite_rules();
        }
      }
    ),

    // Disable uploads being split into year and month directories
    'flatten_uploads' => array(
      'every_request' => false,
      'action' => function() {
        if (!current_user_can('manage_options')) return;

        update_option('uploads_use_yearmonth_folders', 0);
      }
    ),

    // Remove default plugins ("Hello Dolly" and "Akismet")
    'remove_default_plugins' => array(
      'every_request' => false,
      'action' => function() {
        if (!current_user_can('delete_plugins')) return;

        $default_plugins = array(
          'hello.php',
          'akismet/akismet.php'
        );

        // Deactivate
        deactivate_plugins($default_plugins);

        // Remove
        delete_plugins($default_plugins);
      }
    ),

    // Remove default post, page, and comment
    'remove_default_content' => array(
      'every_request' => false,
      'action' => function() {
        global $wpdb;

        // Delete default post
        if (current_user_can('delete_posts')) {
          $default_post_slug = sanitize_title(_x('hello-world', 'Default post slug'));
          $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->posts WHERE post_name = %s", $default_post_slug));
        }

        // Delete default comment
        if (current_user_can('edit_comment')) {
          $first_comment_author = __('Mr WordPress');
          $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->comments WHERE comment_author = %s", $first_comment_author));
        }

        // Delete default page
        if (current_user_can('delete_pages')) {
          $default_page_slug = __('sample-page');
          $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->posts WHERE post_name = %s", $default_page_slug));
        }
      }
    ),

    'remove_default_themes' => array(
      'every_request' => false,
      'action' => function() {
        if (!current_user_can('delete_themes')) return;

        $default_themes = _usdp_get_default_themes();

        foreach ($default_themes as $i => $default_theme) {
          delete_theme($default_theme->get_stylesheet());
        }
      }
    )
  );

  // Iterate over form to update settings
  $options = get_option('_usdp_theme_activation_options');
  if (!is_array($options)) $options = array();
  array_walk($options, function(&$val, $option) use ($actions, $submitted) {
    if ($val === 'true' && ($actions[$option]['every_request'] || $submitted)) {
      $actions[$option]['action']();
    }
  });
}
add_action('admin_init', '_usdp_update_activation_options');

function _usdp_unregister_options() {
  delete_option('_usdp_theme_activation_options');
}
add_action('switch_theme', '_usdp_unregister_options');