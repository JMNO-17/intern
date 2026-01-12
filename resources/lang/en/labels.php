<?php

return [
    'login'                 => [
        'title'             => 'Sign in to your account',
        'signin'             => 'Sigin in',
        'fields'            => [
            'email'         => 'Email',
            'password'      => 'Password',
        ],
    ],
    'role'                  => [
        'title'             => 'Roles',
        'title_singular'    => 'Role',
        'description'       => 'A list of all the roles in your account including their name.',
        'fields'            => [
            'id'            => 'ID',
            'name'          => 'Name',
        ],
    ],
    'permission'            => [
        'title'             => 'Permissions',
        'title_singular'    => 'Permission',
        'description'       => 'A list of all the permissions in your account including their name.',
        'fields'            => [
            'id'            => 'ID',
            'name'          => 'Name',
        ],
    ],
    'user'                  => [
        'title'             => 'Users',
        'title_singular'    => 'User',
        'description'       => 'A list of all the users in your account including their name, title, email and role.',
        'fields'            => [
            'id'            => 'ID',
            'profile_image' => 'Profile Image',
            'name'          => 'Name',
            'email'         => 'Email',
            'password'      => 'Password',
            'role'          => 'Role',
            'status'        => 'Status',
        ],
    ],
    'profile'               => [
        'fields'            => [
            'image'         => 'Profile Image',
            'name'          => 'Name',
            'email'         => 'Email',
            'new_password'  => 'New Password',
            'confirm_password' => 'Confirm Password',
        ],
    ],
    'setting'               => [
        'title'             => 'Settings',
        'title_singular'    => 'Setting',
        'description'       => 'A list of all the settings in your account including their name and value.',
        'seo_settings'      => 'SEO Settings',
        'seo'               => 'SEO (Search Engine Optimization)',
        'seo_description'   => 'helps your website appear higher in search engines like Google. It brings more visibility, more visitors, and more potential customers—without paying for ads.',

        'social_links'      => 'Social Links',
        'quick_links'       => 'Quick Links',
        'useful_links'      => 'Useful Links',

        'fields'            => [
            'id'            => 'ID',
            'name'          => 'Name',
            'value'         => 'Value',
            'favicon'       => 'Favicon',
            'site_logo'     => 'Site Logo',
            'site_name'     => 'Site Name',
            'phone'         => 'Phone',
            'email'         => 'Email',
            'facebook'      => 'Facebook',
            'linkedin'      => 'LinkedIn',
            'twitter'       => 'Twitter',
            'instragram'    => 'Instragram',
            'address'       => 'Address',
            'google_map'    => 'Google Map Embed Link',
            'site_description' => 'Site Description',
            'seo_title'     => 'SEO Title',
            'seo_content'   => 'SEO Content',
            'seo_keywords'  => 'SEO Keywords',
            'seo_enabled'   => 'Enable SEO',
            'default_bg_color' => 'Default Background Color',

            // quick links
            'quick_link_a'  => 'Quick Link A',
            'quick_link_b'  => 'Quick Link B',
            'quick_link_c'  => 'Quick Link C',
            'quick_link_d'  => 'Quick Link D',

            // userful links
            'useful_link_a' => 'Useful Link A',
            'useful_link_b' => 'Useful Link B',
            'useful_link_c' => 'Useful Link C',
            'useful_link_d' => 'Useful Link D',
        ],
    ],
    'menu'                  => [
        'title'             => 'Menus',
        'title_singular'    => 'Menu',
        'description'       => 'A list of all the menus in your account including their name, slug, status, and type.',
        'fields'            => [
            'id'            => 'ID',
            'name'          => 'Name',
            'slug'          => 'Slug',
            'status'        => 'Status',
            'type'          => 'Type',
        ],
    ],
    'section'               => [
        'title'             => 'Sections',
        'title_singular'    => 'Section',
        'description'       => 'A list of all the sections in your account including their name and menu.',
        'fields'            => [
            'id'            => 'ID',
            'name'          => 'Name',
            'menu_id'       => 'Menu',
        ],
    ],
    'bannerslider'          => [
        'title'             => 'Banner Sliders',
        'title_singular'    => 'Banner Slider',
        'description'       => 'A list of all the bannerslider in your account including their name and description.',
        'fields'            => [
            'id'            => 'ID',
            'section_id'    => 'Section',
            'banner_image'  => 'Banner Image',
            'name'          => 'Name',
            'description'   => 'Description'
        ],
    ],

    'category' => [
        'title'             => 'Categories',
        'title_singular'    => 'Category',
        'description'       => 'A list of all the categories in your account including their name and description.',
        'fields'            => [
            'id'            => 'ID',
            'section_id'    => 'Section',
            'name'          => 'Name',
            'description'   => 'Description',
            'category_image' => 'Category Image',
        ],
    ],

    'product'    => [
        'title'             => 'Products',
        'title_singular'    => 'Product',
        'description'       => 'A list of all the products in your account including their name and description.',
        'fields'            => [
            'id'            => 'ID',
            'category_id'   => 'Category',
            'name'          => 'Name',
            'slug'          => 'Slug',
            'description'   => 'Description',
            'price'         => 'Price',
            'status'        => 'Status',
            'product_image' => 'Product Image',
        ],
    ],

    'contentdescription'    => [
        'title'             => 'Content Descriptions',
        'title_singular'    => 'Content Description',
        'description'       => 'A list of all the content description in your account including their title and description.',
        'fields'            => [
            'id'            => 'ID',
            'section_id'    => 'Section',
            'title'         => 'Title',
            'slug'          => 'Slug',
            'description'   => 'Description',
            'featured_image' => 'Featured Image',
            'other_images' => 'Other Images',
        ]
    ],
    'sitemap'               => [
        'title'             => 'Site Maps',
        'title_singular'    => 'Site Map',
        'description'       => 'A list of all the site maps in your account including their name and description.',
    ],
    'dashboard'             => [
        'title'             => 'Dashboard',
        'content'           => 'Contents',
        'user_management'   => 'User Managements'
    ],
    'footer'                => [
        'others'            => 'Others',
        'products'          => 'Products',
        'social_media'      => 'Social Media',
        'developed_year'    => '2025',
        'all_rights_reserved' => 'All Rights Reserved',
    ]
];
