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
        'name' => 'Orders',
        'id' => 'orders',
        'icon' => 'mdi mdi-shape',
        'active' => Route::is('admin.orders.*'),
        'children' => [
            [
                'name' => 'All Orders',
                'route' => 'admin.orders.index',
                'permission' => App\Models\Order::LIST,
                'active' => Route::is('admin.orders.index') && !request()->has('status') && !request()->has('cancel_request'),
            ],
            [
                'name' => 'Placed',
                'route' => 'admin.orders.index',
                'query' => '?status=placed',
                'permission' => App\Models\Order::LIST,
                'active' => Route::is('admin.orders.index') && request()->get('status') === 'placed',
            ],
            [
                'name' => 'Approved',
                'route' => 'admin.orders.index',
                'query' => '?status=approved',
                'permission' => App\Models\Order::LIST,
                'active' => Route::is('admin.orders.index') && request()->get('status') === 'approved',
            ],
            [
                'name' => 'Shipped',
                'route' => 'admin.orders.index',
                'query' => '?status=shipped',
                'permission' => App\Models\Order::LIST,
                'active' => Route::is('admin.orders.index') && request()->get('status') === 'shipped',
            ],
            [
                'name' => 'Delivered',
                'route' => 'admin.orders.index',
                'query' => '?status=delivered',
                'permission' => App\Models\Order::LIST,
                'active' => Route::is('admin.orders.index') && request()->get('status') === 'delivered',
            ],
            [
                'name' => 'Cancelled',
                'route' => 'admin.orders.index',
                'query' => '?status=cancelled',
                'permission' => App\Models\Order::LIST,
                'active' => Route::is('admin.orders.index') && request()->get('status') === 'cancelled',
            ],
            [
                'name' => 'Cancel Request' . (getTotalCancelRequestCount() ? "<span class='pro-badge'>" . getTotalCancelRequestCount() . "</span>" : ''),
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
        'name' => 'Subcategories',
        'route' => 'admin.subcategory.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Subcategory::LIST,
        'active' => Route::is('admin.subcategory.*'),
    ],
    [
        'type' => 'link',
        'name' => 'Sub Subcategories',
        'route' => 'admin.subsub-category.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\SubsubCategory::LIST,
        'active' => Route::is('admin.subsub-category.*'),
    ],
    [
        'type' => 'link',
        'name' => 'Deals',
        'route' => 'admin.deals.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Deal::LIST,
        'active' => Route::is('admin.deals.*'),
    ],
    [
        'type' => 'link',
        'name' => 'Brands',
        'route' => 'admin.brand.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Brand::LIST,
        'active' => Route::is('admin.brand.*'),
    ],
    [
        'type' => 'link',
        'name' => 'Products',
        'route' => 'admin.products.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Product::LIST,
        'active' => Route::is('admin.products.*'),
    ],
    [
        'type' => 'link',
        'name' => 'Promos',
        'route' => 'admin.promo.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Campaign::LIST,
        'active' => Route::is('admin.promo.*'),
    ],
    [
        'type' => 'link',
        'name' => 'Campaigns',
        'route' => 'admin.campaign.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Promo::LIST,
        'active' => Route::is('admin.campaign.*'),
    ],
    [
        'type' => 'link',
        'name' => 'Delivery Schedules',
        'route' => 'admin.delivery-schedule.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\DeliverySchedule::LIST,
        'active' => Route::is('admin.delivery.*'),
    ],
    [
        'type' => 'link',
        'name' => 'Tags',
        'route' => 'admin.tags.index',
        'icon' => 'mdi mdi-shape',
        'permission' => App\Models\Tag::LIST,
        'active' => Route::is('admin.tags.*'),
    ],
    [
        'type' => 'link',
        'name' => 'Pages',
        'route' => 'admin.pages.index',
        'icon' => 'mdi mdi-format-page-break',
        'permission' => App\Models\CmsPage::LIST,
        'active' => Route::is('admin.page.*'),
    ],
    // [
    //     'type' => 'link',
    //     'name' => 'FAQs',
    //     'route' => 'admin.faq.index',
    //     'icon' => 'mdi mdi-frequently-asked-questions',
    //     'permission' => App\Models\Faq::LIST,
    //     'active' => Route::is('admin.faq.*'),
    // ],
    [
        'type' => 'link',
        'name' => 'User searches',
        'route' => 'admin.user-searches.index',
        'icon' => 'mdi mdi-search-web',
        'permission' => App\Models\Transaction::LIST,
        'active' => Route::is('admin.user-searches.*'),
    ],
    // [
    //     'type' => 'link',
    //     'name' => 'Subscribers',
    //     'route' => 'admin.subscriber.index',
    //     'icon' => 'mdi mdi-shape',
    //     'permission' => App\Models\Subscriber::LIST,
    //     'active' => Route::is('admin.subscriber.*'),
    // ],
    [
        'type' => 'link',
        'name' => 'News Letters',
        'route' => 'admin.newsletter.index',
        'icon' => 'mdi mdi-newspaper',
        'permission' => App\Models\NewsLetter::LIST,
        'active' => Route::is('admin.newsletter.*'),
    ],
    [
        'type' => 'link',
        'name' => 'Feature Highlight',
        'route' => 'admin.feature-highlights.index',
        'icon' => 'mdi mdi-newspaper',
        'permission' => App\Models\FeatureHighlight::LIST,
        'active' => Route::is('admin.feature-highlight.index*'),
    ],
    [
        'type' => 'dropdown',
        'name' => 'Banners',
        'id' => 'banners',
        'icon' => 'mdi mdi-image-area',
        'active' => Route::is('admin.banner.*'),
        'children' => [
            [
                'name' => 'Fixed',
                'route' => 'admin.banner.fixedBanners',
                'permission' => App\Models\Banner::LIST,
                'active' => Route::is('admin.banner.fixedBanners'),
            ],
            [
                'name' => 'Slider',
                'route' => 'admin.banner.index',
                'permission' => App\Models\Banner::LIST,
                'active' => Route::is('admin.banner.index') && !request()->has('type'),
            ],
            [
                'name' => 'Popup',
                'route' => 'admin.banner.index',
                'query' => '?type=popup',
                'permission' => App\Models\Banner::LIST,
                'active' => Route::is('admin.banner.index') && request()->get('type') === 'popup',
            ],
        ],
    ],
    [
        'type' => 'dropdown',
        'name' => 'Reports',
        'id' => 'reports',
        'icon' => 'mdi mdi-chart-line',
        'active' => Route::is('admin.reports.*'),
        'children' => [
            [
                'name' => 'Sales',
                'route' => 'admin.reports.sales.index',
                'permission' => App\Models\Settings::REPORTS_LIST,
                'active' => Route::is('admin.reports.sales.index'),
            ],
            [
                'name' => 'Transactions',
                'route' => 'admin.reports.transactions.index',
                'permission' => App\Models\Settings::REPORTS_LIST,
                'active' => Route::is('admin.reports.transactions.index'),
            ],
        ],
    ],
    [
        'type' => 'dropdown',
        'name' => 'Settings',
        'id' => 'settings',
        'icon' => 'mdi mdi-cog',
        'active' => Route::is('admin.settings.*'),
        'children' => [
            [
                'name' => 'Site Settings',
                'route' => 'admin.settings.site',
                'active' => Route::is('admin.settings.site'),
            ],
            [
                'name' => 'Payment Gateways',
                'route' => 'admin.settings.payment-gateway.stripe',
                'permission' => App\Models\Settings::STRIPE_SETTINGS,
                'active' => Route::is('admin.settings.payment-gateway.stripe'),
            ],
            [
                'name' => 'Email Template',
                'route' => 'admin.settings.email-template.reset-password',
                'active' => Route::is('admin.settings.email-template.reset-password'),
            ],
        ],
    ],
    [
        'type' => 'dropdown',
        'name' => 'Administration',
        'id' => 'administration',
        'icon' => 'mdi mdi-account-key',
        'active' => Route::is('admin.role.*') || Route::is('admin.users.*'),
        'condition' => auth()->user()->can('Role Management') || auth()->user()->can('User Management'),
        'children' => [
            [
                'name' => 'Role Manager',
                'route' => 'admin.role.index',
                'permission' => 'Role Management',
                'active' => Route::is('admin.role.*'),
            ],
            [
                'name' => 'Users',
                'route' => 'admin.users.index',
                'permission' => 'User Management',
                'active' => Route::is('admin.users.index') && !request()->has('type'),
            ],
            [
                'name' => 'Customers',
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