@php
$sidebarItems = [
    [
        'type' => 'link',
        'name' => 'Dashboard',
        'route' => 'admin.dashboard.index',
        'icon' => 'mdi mdi-view-dashboard',
        'permission' => 'dashboard',
        'active' => Route::is('admin.dashboard.index'),
    ],
    [
        'type' => 'dropdown',
        'name' => __('app.orders'),
        'id' => 'orders',
        'icon' => 'mdi mdi-shape',
        'active' => Route::is('admin.orders.*'),
        'children' => [
            [
                'name' => __('app.all_orders'),
                'route' => 'admin.orders.index',
                'permission' => App\Models\Order::LIST,
                'active' => Route::is('admin.orders.index') && !request()->has('status') && !request()->has('cancel_request'),
            ],
            [
                'name' => __('app.placed'),
                'route' => 'admin.orders.index',
                'query' => '?status=placed',
                'permission' => App\Models\Order::LIST,
                'active' => Route::is('admin.orders.index') && request()->get('status') === 'placed',
            ],
            [
                'name' => __('app.approved'),
                'route' => 'admin.orders.index',
                'query' => '?status=approved',
                'permission' => App\Models\Order::LIST,
                'active' => Route::is('admin.orders.index') && request()->get('status') === 'approved',
            ],
            [
                'name' => __('app.shipped'),
                'route' => 'admin.orders.index',
                'query' => '?status=shipped',
                'permission' => App\Models\Order::LIST,
                'active' => Route::is('admin.orders.index') && request()->get('status') === 'shipped',
            ],
            [
                'name' => __('app.delivered'),
                'route' => 'admin.orders.index',
                'query' => '?status=delivered',
                'permission' => App\Models\Order::LIST,
                'active' => Route::is('admin.orders.index') && request()->get('status') === 'delivered',
            ],
            [
                'name' => __('app.cancelled'),
                'route' => 'admin.orders.index',
                'query' => '?status=cancelled',
                'permission' => App\Models\Order::LIST,
                'active' => Route::is('admin.orders.index') && request()->get('status') === 'cancelled',
            ],
            [
                'name' => __('app.cancel_request') . (getTotalCancelRequestCount() ? "<span class='pro-badge'>" . getTotalCancelRequestCount() . "</span>" : ''),
                'route' => 'admin.orders.index',
                'query' => '?cancel_request=true',
                'permission' => App\Models\Order::CANCEL_REQUEST_APPROVE,
                'active' => Route::is('admin.orders.index') && request()->get('cancel_request') === 'true',
            ],
        ],
    ],
    [
        'type' => 'link',
        'name' => 'Categories',
        'route' => 'admin.category.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Category::LIST,
        'active' => Route::is('admin.category.*'),
    ],
    [
        'type' => 'link',
        'name' => __('app.subcategories'),
        'route' => 'admin.subcategory.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Subcategory::LIST,
        'active' => Route::is('admin.subcategory.*'),
    ],
    [
        'type' => 'link',
        'name' => __('app.subsubcategories'),
        'route' => 'admin.subsub-category.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\SubsubCategory::LIST,
        'active' => Route::is('admin.subsub-category.*'),
    ],
    [
        'type' => 'link',
        'name' => __('app.deals'),
        'route' => 'admin.deals.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Deal::LIST,
        'active' => Route::is('admin.deals.*'),
    ],
    [
        'type' => 'link',
        'name' => __('app.brands'),
        'route' => 'admin.brand.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Brand::LIST,
        'active' => Route::is('admin.brand.*'),
    ],
    [
        'type' => 'link',
        'name' => __('app.products'),
        'route' => 'admin.products.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Product::LIST,
        'active' => Route::is('admin.products.*'),
    ],
    [
        'type' => 'link',
        'name' => __('app.promos'),
        'route' => 'admin.promo.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Campaign::LIST,
        'active' => Route::is('admin.promo.*'),
    ],
    [
        'type' => 'link',
        'name' => __('app.campaigns'),
        'route' => 'admin.campaign.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Promo::LIST,
        'active' => Route::is('admin.campaign.*'),
    ],
    [
        'type' => 'link',
        'name' => __('app.delivery_schedules'),
        'route' => 'admin.delivery-schedule.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\DeliverySchedule::LIST,
        'active' => Route::is('admin.delivery.*'),
    ],
    [
        'type' => 'link',
        'name' => __('app.tags'),
        'route' => 'admin.tags.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Tag::LIST,
        'active' => Route::is('admin.tags.*'),
    ],
    [
        'type' => 'link',
        'name' => __('app.pages'),
        'route' => 'admin.pages.index',
        'icon' => 'mdi mdi-format-page-break',
        'permission' => App\Models\CmsPage::LIST,
        'active' => Route::is('admin.page.*'),
    ],
    // [
    //     'type' => 'link',
    //     'name' => __('app.faqs'),
    //     'route' => 'admin.faq.index',
    //     'icon' => 'mdi mdi-frequently-asked-questions',
    //     'permission' => App\Models\Faq::LIST,
    //     'active' => Route::is('admin.faq.*'),
    // ],
    [
        'type' => 'link',
        'name' => __('app.user_searches'),
        'route' => 'admin.user-searches.index',
        'icon' => 'mdi mdi-search-web',
        'permission' => App\Models\Transaction::LIST,
        'active' => Route::is('admin.user-searches.*'),
    ],
    // [
    //     'type' => 'link',
    //     'name' => __('app.subscribers'),
    //     'route' => 'admin.subscriber.index',
    //     'icon' => 'mdi mdi-shape',
    //     'permission' => App\Models\Subscriber::LIST,
    //     'active' => Route::is('admin.subscriber.*'),
    // ],
    [
        'type' => 'link',
        'name' => __('app.news_letters'),
        'route' => 'admin.newsletter.index',
        'icon' => 'mdi mdi-newspaper',
        'permission' => App\Models\NewsLetter::LIST,
        'active' => Route::is('admin.newsletter.*'),
    ],
    [
        'type' => 'link',
        'name' => __('app.feature_highlight'),
        'route' => 'admin.feature-highlights.index',
        'icon' => 'mdi mdi-newspaper',
        'permission' => App\Models\FeatureHighlight::LIST,
        'active' => Route::is('admin.feature-highlight.index*'),
    ],
    [
        'type' => 'dropdown',
        'name' => __('app.banners'),
        'id' => 'banners',
        'icon' => 'mdi mdi-image-area',
        'active' => Route::is('admin.banner.*'),
        'children' => [
            [
                'name' => __('app.fixed'),
                'route' => 'admin.banner.fixedBanners',
                'permission' => App\Models\Banner::LIST,
                'active' => Route::is('admin.banner.fixedBanners'),
            ],
            [
                'name' => __('app.slider'),
                'route' => 'admin.banner.index',
                'permission' => App\Models\Banner::LIST,
                'active' => Route::is('admin.banner.index') && !request()->has('type'),
            ],
            [
                'name' => __('app.popup'),
                'route' => 'admin.banner.index',
                'query' => '?type=popup',
                'permission' => App\Models\Banner::LIST,
                'active' => Route::is('admin.banner.index') && request()->get('type') === 'popup',
            ],
        ],
    ],
    [
        'type' => 'dropdown',
        'name' => __('app.reports'),
        'id' => 'reports',
        'icon' => 'mdi mdi-chart-line',
        'active' => Route::is('admin.reports.*'),
        'children' => [
            [
                'name' => __('app.sales'),
                'route' => 'admin.reports.sales.index',
                'permission' => App\Models\Settings::REPORTS_LIST,
                'active' => Route::is('admin.reports.sales.index'),
            ],
            [
                'name' => __('app.transactions'),
                'route' => 'admin.reports.transactions.index',
                'permission' => App\Models\Settings::REPORTS_LIST,
                'active' => Route::is('admin.reports.transactions.index'),
            ],
        ],
    ],
    [
        'type' => 'dropdown',
        'name' => __('app.settings'),
        'id' => 'settings',
        'icon' => 'mdi mdi-cog',
        'active' => Route::is('admin.settings.*'),
        'children' => [
            [
                'name' => __('app.site_settings'),
                'route' => 'admin.settings.site',
                'active' => Route::is('admin.settings.site'),
            ],
            [
                'name' => __('app.payment_gateways'),
                'route' => 'admin.settings.payment-gateway.stripe',
                'permission' => App\Models\Settings::STRIPE_SETTINGS,
                'active' => Route::is('admin.settings.payment-gateway.stripe'),
            ],
            [
                'name' => __('app.email_template'),
                'route' => 'admin.settings.email-template.reset-password',
                'active' => Route::is('admin.settings.email-template.reset-password'),
            ],
        ],
    ],
    [
        'type' => 'dropdown',
        'name' => __('app.administration'),
        'id' => 'administration',
        'icon' => 'mdi mdi-account-key',
        'active' => Route::is('admin.role.*') || Route::is('admin.users.*'),
        'condition' => auth()->user()->can('Role Management') || auth()->user()->can('User Management'),
        'children' => [
            [
                'name' => __('app.role_manager'),
                'route' => 'admin.role.index',
                'permission' => 'Role Management',
                'active' => Route::is('admin.role.*'),
            ],
            [
                'name' => __('app.users'),
                'route' => 'admin.users.index',
                'permission' => 'User Management',
                'active' => Route::is('admin.users.index') && !request()->has('type'),
            ],
            [
                'name' => __('app.customers'),
                'route' => 'admin.users.index',
                'query' => '?type=customers',
                'permission' => 'User Management',
                'active' => Route::is('admin.users.index') && request()->get('type') === 'customers',
            ],
        ],
    ],
];
@endphp

<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="{{ route('admin.dashboard.index') }}" class="d-block" style="height: 50px;">
            <img style="width: 100%; height: 100%; object-fit: contain;" src="{{ asset(getSetting(App\Models\Settings::PRIMARY_LOGO)) }}" alt="{{ App\Models\Settings::SITE_TITLE }}" />
        </a>
    </div>
    
    <!-- Search Input -->
    <div class="header-search d-none d-md-flex" style="padding: 15px; padding-top: 0;">
        <form action="#">
            <input type="search" id="sidebar-search-input" placeholder="Search...">
            <button type="button"><i class="lni lni-search-alt"></i></button>
            {{-- <button type="button" class="clear-search" onclick="$('#sidebar-search-input').val('').trigger('keyup');"><i class="lni lni-close"></i></button> --}}
        </form>
    </div>

    <nav class="sidebar-nav">
        <ul>
            @foreach ($sidebarItems as $item)
                @if (!isset($item['condition']) || $item['condition'])
                    @if ($item['type'] === 'link')
                        <x-sidebar-nav-link
                            :active="$item['active']"
                            :link="route($item['route'])"
                            :icon="$item['icon']"
                            :permissionCheck="$item['permission']"
                        >
                            {{ $item['name'] }}
                        </x-sidebar-nav-link>
                    @elseif ($item['type'] === 'dropdown')
                        <li class="nav-item nav-item-has-children {{ $item['active'] ? 'active' : '' }}">
                            <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#{{ $item['id'] }}"
                                aria-controls="{{ $item['id'] }}" aria-expanded="{{ $item['active'] ? 'true' : 'false' }}"
                                aria-label="Toggle navigation">
                                <span class="icon">
                                    <span class="{{ $item['icon'] }}"></span>
                                </span>
                                <span class="text">{{ $item['name'] }}</span>
                            </a>
                            <ul id="{{ $item['id'] }}" class="collapse dropdown-nav {{ $item['active'] ? 'show' : '' }}" data-parent=".nav-item-has-children">
                                @foreach ($item['children'] as $child)
                                    @if (!isset($child['permission']) || checkUserPermission($child['permission']) || auth()->user()->can($child['permission']))
                                        <li class="nav-item {{ $child['active'] ? 'active' : '' }}">
                                            <a href="{{ route($child['route']) . ($child['query'] ?? '') }}">{{ $child['name'] }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            @endforeach
        </ul>
    </nav>
</aside>
<div class="overlay"></div>
<script>
$(document).ready(function() {
    $('#sidebar-search-input').on('input', function() {
        var searchText = $(this).val().toLowerCase();
        
        // Show all items initially
        $('.sidebar-nav ul li').show();
        
        if (searchText.length > 0) {
            // Hide all items first
            $('.sidebar-nav ul li').hide();
            
            // Show parent items that match
            $('.sidebar-nav > ul > li').each(function() {
                var parentText = $(this).find('.text').text().toLowerCase();
                if (parentText.includes(searchText)) {
                    $(this).show();
                    // Show all children if parent matches
                    $(this).find('ul.dropdown-nav li').show();
                } else {
                    // Check children for matches
                    var hasMatchingChild = false;
                    $(this).find('ul.dropdown-nav li').each(function() {
                        var childText = $(this).text().toLowerCase();
                        if (childText.includes(searchText)) {
                            $(this).show();
                            hasMatchingChild = true;
                        }
                    });
                    // Show parent if any child matches
                    if (hasMatchingChild) {
                        $(this).show();
                        // Expand dropdown
                        $(this).find('ul.dropdown-nav').addClass('show');
                        $(this).find('a[data-bs-toggle="collapse"]').attr('aria-expanded', 'true');
                    }
                }
            });
        } else {
            // Reset dropdown states when search is cleared
            $('.sidebar-nav ul.dropdown-nav').removeClass('show');
            $('.sidebar-nav a[data-bs-toggle="collapse"]').attr('aria-expanded', 'false');
            // Restore active dropdowns
            $('.sidebar-nav li.active').each(function() {
                $(this).find('ul.dropdown-nav').addClass('show');
                $(this).find('a[data-bs-toggle="collapse"]').attr('aria-expanded', 'true');
            });
        }
    });
});
</script>