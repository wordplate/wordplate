<?php

/*
 * This file is part of WordPlate.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Remove menu items depending on user role.
 *
 * @return void
 */
add_action('admin_head', function () {
    $items = [
        'comments',
        'dashboard',
        'links',
        'media',
    ];

    // Hide for none administrators.
    if (!current_user_can('manage_options')) {
        $items = array_merge($items, [
            'appearance',
            'plugins',
            'settings',
            'tools',
        ]);
    }

    $elements = implode(', #menu-', $items);

    echo sprintf('<style> #menu-%s { display: none !important; } </style>', $elements);
});

/**
 * Remove links from admin toolbar.
 *
 * @param mixed $menu
 *
 * @return void
 */
add_action('admin_bar_menu', function ($menu) {
    $items = [
        'comments',
        'wp-logo',
        'edit',
        'appearance',
        'view',
        'new-content',
        'updates',
        'search',
    ];

    foreach ($items as $item) {
        $menu->remove_node($item);
    }
}, 999);

/**
 * Add custom footer text.
 *
 * @return string|null
 */
add_filter('admin_footer_text', function () {
    return 'Thank you for creating with WordPress.';
});

/**
 * Cleanup dashboard widgets.
 *
 * @return void
 */
add_action('wp_dashboard_setup', function () {
    global $wp_meta_boxes;

    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
});

/**
 * Hide help panel tab.
 *
 * @return void
 */
add_action('admin_head', function () {
    $screen = get_current_screen();
    $screen->remove_help_tabs();
});

/**
 * Hide screen options tab.
 *
 * @return bool
 */
add_filter('screen_options_show_screen', function () {
    return false;
});