<?php

return [

    'colors' => [
        'blue' => 'Blue', 'orange' => 'Orange', 'mint' => 'Mint (Green)',
        'yellow' => 'Yellow', 'purple' => 'Purple', 'coral' => 'Coral', 'sky' => 'Sky Blue',
    ],
    'badge_colors'     => ['orange' => 'Orange', 'mint' => 'Mint', 'sky' => 'Sky Blue', 'blue' => 'Blue'],
    'highlight_colors' => ['yellow' => 'Yellow', 'mint' => 'Mint', 'sky' => 'Sky Blue', 'orange' => 'Orange'],
    'ratings'          => [5 => '5 stars', 4 => '4 stars', 3 => '3 stars', 2 => '2 stars', 1 => '1 star'],

    /*
    |--------------------------------------------------------------------------
    | List-type content (many rows each)
    |--------------------------------------------------------------------------
    */
    'types' => [

        'sliders' => [
            'model'       => \App\Models\HomeSlider::class,
            'title'       => 'Hero Slides',
            'singular'    => 'Slide',
            'description' => 'Main hero banner carousel at the top of the home page.',
            'icon'        => 'fa-picture-o',
            'tone'        => 'wi-blue',
            'image_dir'   => 'home/sliders',
            'columns'     => [
                ['label' => 'Image',     'field' => 'image', 'type' => 'image'],
                ['label' => 'Heading',   'field' => 'title_line1'],
                ['label' => 'Dot Label', 'field' => 'nav_label'],
            ],
            'fields' => [
                ['name' => 'image', 'label' => 'Slide Image', 'type' => 'image', 'required' => true,
                    'hint' => 'Recommended 1920 × 520 px. JPG / PNG / WebP, max 4 MB.'],
                ['name' => 'image_alt', 'label' => 'Image Alt Text', 'type' => 'text', 'rules' => 'nullable|max:255'],
                ['name' => 'badge_text', 'label' => 'Badge Text', 'type' => 'text', 'rules' => 'nullable|max:255', 'half' => true],
                ['name' => 'badge_icon', 'label' => 'Badge Icon', 'type' => 'text', 'rules' => 'nullable|max:100', 'half' => true,
                    'hint' => 'FontAwesome class, e.g. fa-sparkles'],
                ['name' => 'badge_color', 'label' => 'Badge Color', 'type' => 'select', 'options' => 'badge_colors', 'default' => 'orange', 'rules' => 'required'],
                ['name' => 'title_line1', 'label' => 'Heading Line 1', 'type' => 'text', 'rules' => 'required|max:255', 'half' => true],
                ['name' => 'title_line2', 'label' => 'Heading Line 2 (highlighted)', 'type' => 'text', 'rules' => 'nullable|max:255', 'half' => true],
                ['name' => 'highlight_color', 'label' => 'Highlight Color', 'type' => 'select', 'options' => 'highlight_colors', 'default' => 'yellow', 'rules' => 'required'],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rules' => 'nullable|max:1000'],
                ['name' => 'btn1_text', 'label' => 'Button 1 Text', 'type' => 'text', 'rules' => 'nullable|max:100', 'half' => true],
                ['name' => 'btn1_link', 'label' => 'Button 1 Link', 'type' => 'text', 'rules' => 'nullable|max:255', 'half' => true,
                    'hint' => 'e.g. shop?category=toys or a full URL'],
                ['name' => 'btn2_text', 'label' => 'Button 2 Text', 'type' => 'text', 'rules' => 'nullable|max:100', 'half' => true],
                ['name' => 'btn2_link', 'label' => 'Button 2 Link', 'type' => 'text', 'rules' => 'nullable|max:255', 'half' => true],
                ['name' => 'nav_label', 'label' => 'Dot Label', 'type' => 'text', 'rules' => 'nullable|max:40',
                    'hint' => 'Short label on the slider dot, e.g. TOYS'],
            ],
        ],

        'usps' => [
            'model'       => \App\Models\HomeUsp::class,
            'title'       => 'Trust Strip',
            'singular'    => 'Trust Item',
            'description' => 'The 4 badges right below the hero (safe products, delivery, payments, returns).',
            'icon'        => 'fa-shield',
            'tone'        => 'wi-green',
            'columns'     => [
                ['label' => 'Icon',     'field' => 'icon'],
                ['label' => 'Title',    'field' => 'title'],
                ['label' => 'Subtitle', 'field' => 'subtitle'],
                ['label' => 'Color',    'field' => 'color'],
            ],
            'fields' => [
                ['name' => 'icon', 'label' => 'Icon', 'type' => 'text', 'rules' => 'required|max:100', 'hint' => 'FontAwesome class, e.g. fa-shield-halved'],
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'rules' => 'required|max:255'],
                ['name' => 'subtitle', 'label' => 'Subtitle', 'type' => 'text', 'rules' => 'nullable|max:255'],
                ['name' => 'color', 'label' => 'Color', 'type' => 'select', 'options' => 'colors', 'default' => 'blue', 'rules' => 'required'],
            ],
        ],

        'interests' => [
            'model'       => \App\Models\HomeInterest::class,
            'title'       => 'Shop By Interest',
            'singular'    => 'Interest Card',
            'description' => '"What are they into?" cards. Each links to a category or a custom link.',
            'icon'        => 'fa-heart-o',
            'tone'        => 'wi-purple',
            'columns'     => [
                ['label' => 'Icon',     'field' => 'icon'],
                ['label' => 'Title',    'field' => 'title'],
                ['label' => 'Subtitle', 'field' => 'subtitle'],
                ['label' => 'Links To', 'field' => 'link_label'],
            ],
            'fields' => [
                ['name' => 'icon', 'label' => 'Icon', 'type' => 'text', 'rules' => 'required|max:100', 'hint' => 'FontAwesome class, e.g. fa-cubes'],
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'rules' => 'required|max:255', 'half' => true],
                ['name' => 'subtitle', 'label' => 'Subtitle', 'type' => 'text', 'rules' => 'nullable|max:255', 'half' => true],
                ['name' => 'color', 'label' => 'Color', 'type' => 'select', 'options' => 'colors', 'default' => 'orange', 'rules' => 'required'],
                ['name' => 'category_id', 'label' => 'Link To Category', 'type' => 'category'],
                ['name' => 'custom_link', 'label' => 'Custom Link', 'type' => 'text', 'rules' => 'nullable|max:255',
                    'hint' => 'Only used when no category is selected.'],
            ],
        ],

        'features' => [
            'model'       => \App\Models\HomeFeature::class,
            'title'       => 'Why Families Love Us',
            'singular'    => 'Feature',
            'description' => 'The trust-building cards in the "Why families love us" section.',
            'icon'        => 'fa-check-circle-o',
            'tone'        => 'wi-amber',
            'columns'     => [
                ['label' => 'Icon',        'field' => 'icon'],
                ['label' => 'Title',       'field' => 'title'],
                ['label' => 'Description', 'field' => 'description'],
            ],
            'fields' => [
                ['name' => 'icon', 'label' => 'Icon', 'type' => 'text', 'rules' => 'required|max:100', 'hint' => 'FontAwesome class, e.g. fa-award'],
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'rules' => 'required|max:255'],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rules' => 'nullable|max:500'],
                ['name' => 'color', 'label' => 'Color', 'type' => 'select', 'options' => 'colors', 'default' => 'blue', 'rules' => 'required'],
            ],
        ],

        'testimonials' => [
            'model'       => \App\Models\HomeTestimonial::class,
            'title'       => 'Testimonials',
            'singular'    => 'Testimonial',
            'description' => 'Customer reviews shown in the "What parents are saying" slider.',
            'icon'        => 'fa-comments-o',
            'tone'        => 'wi-accent',
            'columns'     => [
                ['label' => 'Customer', 'field' => 'customer_name'],
                ['label' => 'Location / Role', 'field' => 'customer_title'],
                ['label' => 'Product', 'field' => 'product_tag'],
                ['label' => 'Rating', 'field' => 'rating'],
            ],
            'fields' => [
                ['name' => 'customer_name', 'label' => 'Customer Name', 'type' => 'text', 'rules' => 'required|max:255', 'half' => true],
                ['name' => 'customer_title', 'label' => 'Role / Location', 'type' => 'text', 'rules' => 'nullable|max:255', 'half' => true,
                    'hint' => 'e.g. Parent of 2, Bengaluru'],
                ['name' => 'review', 'label' => 'Review', 'type' => 'textarea', 'rules' => 'required|max:1000'],
                ['name' => 'rating', 'label' => 'Rating', 'type' => 'select', 'options' => 'ratings', 'default' => 5, 'rules' => 'required'],
                ['name' => 'product_tag', 'label' => 'Product Tag', 'type' => 'text', 'rules' => 'nullable|max:255', 'half' => true],
                ['name' => 'tag_icon', 'label' => 'Tag Icon', 'type' => 'text', 'rules' => 'nullable|max:100', 'half' => true,
                    'hint' => 'FontAwesome class, e.g. fa-futbol'],
                ['name' => 'color', 'label' => 'Card Color', 'type' => 'select', 'options' => 'colors', 'default' => 'yellow', 'rules' => 'required'],
                ['name' => 'is_verified', 'label' => 'Verified Buyer', 'type' => 'switch', 'default' => true],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Section headings + promo banner (one fixed row per section)
    |--------------------------------------------------------------------------
    */
    'section_fields' => [
        'badge_text'      => ['label' => 'Badge Text', 'type' => 'text', 'rules' => 'nullable|max:255'],
        'badge_icon'      => ['label' => 'Badge Icon', 'type' => 'text', 'rules' => 'nullable|max:100', 'hint' => 'FontAwesome class, e.g. fa-sparkles'],
        'title'           => ['label' => 'Heading', 'type' => 'text', 'rules' => 'required|max:255'],
        'title_highlight' => ['label' => 'Heading Line 2 (highlighted)', 'type' => 'text', 'rules' => 'nullable|max:255'],
        'subtitle'        => ['label' => 'Sub Text', 'type' => 'textarea', 'rules' => 'nullable|max:1000'],
        'button_text'     => ['label' => 'Button Text', 'type' => 'text', 'rules' => 'nullable|max:100'],
        'button_link'     => ['label' => 'Button Link', 'type' => 'text', 'rules' => 'nullable|max:255', 'hint' => 'e.g. shop or a full URL'],
        'extra_rating'    => ['label' => 'Rating Badge', 'type' => 'text', 'rules' => 'nullable|max:30', 'hint' => 'e.g. 4.9/5'],
        'extra_reviews'   => ['label' => 'Reviews Count Text', 'type' => 'text', 'rules' => 'nullable|max:60', 'hint' => 'e.g. (1,200+ Reviews)'],
    ],

    'sections' => [

        'categories' => [
            'title'       => 'Categories Section',
            'description' => '"What do they love?" heading above the category cards.',
            'fields'      => ['badge_text', 'badge_icon', 'title', 'subtitle'],
            'defaults'    => [
                'badge_text' => 'DISCOVER PLAYTIME', 'badge_icon' => 'fa-sparkles',
                'title' => 'WHAT DO THEY LOVE?',
                'subtitle' => 'Explore fun, games and activities for every kind of kid.',
            ],
        ],

        'trending' => [
            'title'       => 'Trending Products Section',
            'description' => 'Heading and bottom button of the New Arrivals / Best Sellers / Trending tabs.',
            'fields'      => ['badge_text', 'title', 'subtitle', 'button_text', 'button_link'],
            'defaults'    => [
                'badge_text' => 'HOTTEST PICKS', 'title' => "THEY'RE LOVING THESE",
                'subtitle' => 'Popular picks for playtime and family smiles.',
                'button_text' => 'DISCOVER ALL PRODUCTS', 'button_link' => 'shop',
            ],
        ],

        'favourites' => [
            'title'       => 'Our Current Favourites Section',
            'description' => 'Heading above the two handpicked products.',
            'fields'      => ['badge_text', 'title', 'subtitle'],
            'defaults'    => [
                'badge_text' => 'HANDPICKED STANDOUTS', 'title' => 'OUR CURRENT FAVOURITES',
                'subtitle' => 'Two timeless play sets designed for endless creativity and hours of smiles.',
            ],
        ],

        'interests' => [
            'title'       => 'Shop By Interest Section',
            'description' => '"What are they into?" heading above the interest cards.',
            'fields'      => ['badge_text', 'title', 'subtitle'],
            'defaults'    => [
                'badge_text' => 'PASSION & HOBBIES', 'title' => 'WHAT ARE THEY INTO?',
                'subtitle' => 'Follow their curiosity with curated interest-based collections.',
            ],
        ],

        'promo_banner' => [
            'title'       => 'Promotional Banner',
            'description' => 'The big "More play. More memories." banner.',
            'fields'      => ['badge_text', 'title', 'title_highlight', 'subtitle', 'button_text', 'button_link'],
            'defaults'    => [
                'badge_text' => 'SEASON OF ADVENTURE', 'title' => 'MORE PLAY.', 'title_highlight' => 'MORE MEMORIES.',
                'subtitle' => 'Discover something exciting for their next adventure. From backyard championships to living room board game triumphs.',
                'button_text' => 'SHOP NOW →', 'button_link' => 'shop',
            ],
        ],

        'why_us' => [
            'title'       => 'Why Families Love Us Section',
            'description' => 'Heading above the feature cards.',
            'fields'      => ['badge_text', 'title', 'subtitle'],
            'defaults'    => [
                'badge_text' => 'OUR COMMITMENT', 'title' => 'WHY FAMILIES LOVE US',
                'subtitle' => 'Crafting wholesome play experiences with trusted quality and honest care.',
            ],
        ],

        'testimonials' => [
            'title'       => 'Testimonials Section',
            'description' => 'Heading and the rating badge above the testimonial slider.',
            'fields'      => ['badge_text', 'badge_icon', 'title', 'subtitle', 'extra_rating', 'extra_reviews'],
            'defaults'    => [
                'badge_text' => 'HAPPY FAMILIES', 'badge_icon' => 'fa-face-smile',
                'title' => 'WHAT PARENTS ARE SAYING',
                'subtitle' => 'Real feedback from families and educators who made playtime memorable.',
                'extra' => ['rating' => '4.9/5', 'reviews' => '(1,200+ Reviews)'],
            ],
        ],
    ],
];