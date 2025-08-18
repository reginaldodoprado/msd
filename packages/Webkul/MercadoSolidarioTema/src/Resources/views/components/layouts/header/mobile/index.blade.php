<!--
    This code needs to be refactored to reduce the amount of PHP in the Blade
    template as much as possible.
-->
@php
    $showCompare = (bool) core()->getConfigData('catalog.products.settings.compare_option');

    $showWishlist = (bool) core()->getConfigData('customer.settings.wishlist.wishlist_option');
@endphp

<div class="container-fluid d-lg-none py-3 shadow-ms bg-white">
    <div class="row align-items-center g-3">
        <!-- Left Navigation -->
        <div class="col-auto d-flex align-items-center gap-2">
            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.drawer.before') !!}

            <!-- Drawer -->
            <v-mobile-drawer></v-mobile-drawer>

            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.drawer.after') !!}

            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.logo.before') !!}

            <a
                href="{{ route('shop.home.index') }}"
                class="text-decoration-none"
                aria-label="@lang('shop::app.components.layouts.header.mobile.bagisto')"
            >
                <img
                    src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                    alt="{{ config('app.name') }}"
                    width="131"
                    height="29"
                    class="img-fluid"
                >
            </a>

            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.logo.after') !!}
        </div>

        <!-- Right Navigation -->
        <div class="col-auto ms-auto">
            <div class="d-flex align-items-center gap-3">
                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.compare.before') !!}

                @if($showCompare)
                    <a
                        href="{{ route('shop.compare.index') }}"
                        aria-label="@lang('shop::app.components.layouts.header.mobile.compare')"
                        class="text-decoration-none"
                    >
                        <i class="bi bi-arrow-left-right fs-4 text-ms-primary"></i>
                    </a>
                @endif

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.compare.after') !!}

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.mini_cart.before') !!}

                @if(core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                    @include('shop::checkout.cart.mini-cart')
                @endif

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.mini_cart.after') !!}

                <!-- For Large screens -->
                <div class="d-none d-md-block">
                    <div class="dropdown">
                        <button
                            class="btn btn-link text-decoration-none p-0"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="bi bi-person-circle fs-4 text-ms-primary"></i>
                        </button>

                        <!-- Guest Dropdown -->
                        @guest('customer')
                            <ul class="dropdown-menu dropdown-menu-end p-3 shadow-ms-lg border-0" style="min-width: 300px;">
                                <li>
                                    <div class="mb-3">
                                        <h6 class="dropdown-header text-ms-primary fw-bold">
                                            @lang('shop::app.components.layouts.header.mobile.welcome-guest')
                                        </h6>
                                        <p class="text-ms-muted small mb-0">
                                            @lang('shop::app.components.layouts.header.mobile.dropdown-text')
                                        </p>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.customers_action.before') !!}

                                    <div class="d-flex gap-2">
                                        {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.sign_in_button.before') !!}

                                        <a
                                            href="{{ route('shop.customer.session.create') }}"
                                            class="btn btn-ms-primary flex-fill"
                                        >
                                            @lang('shop::app.components.layouts.header.mobile.sign-in')
                                        </a>

                                        <a
                                            href="{{ route('shop.customers.register.index') }}"
                                            class="btn btn-ms-outline-primary flex-fill"
                                        >
                                            @lang('shop::app.components.layouts.header.mobile.sign-up')
                                        </a>

                                        {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.sign_in_button.after') !!}
                                    </div>

                                    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.customers_action.after') !!}
                                </li>
                            </ul>
                        @endguest

                        <!-- Customers Dropdown -->
                        @auth('customer')
                            <ul class="dropdown-menu dropdown-menu-end p-0 shadow-ms-lg border-0" style="min-width: 280px;">
                                <li>
                                    <div class="p-3 border-bottom">
                                        <h6 class="dropdown-header text-ms-primary fw-bold mb-1">
                                            @lang('shop::app.components.layouts.header.mobile.welcome')'
                                            {{ auth()->guard('customer')->user()->first_name }}
                                        </h6>
                                        <p class="text-ms-muted small mb-0">
                                            @lang('shop::app.components.layouts.header.mobile.dropdown-text')
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="py-2">
                                        {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.profile_dropdown.links.before') !!}

                                        <a
                                            class="dropdown-item py-2 px-3 text-decoration-none"
                                            href="{{ route('shop.customers.account.profile.index') }}"
                                        >
                                            <i class="bi bi-person me-2"></i>
                                            @lang('shop::app.components.layouts.header.mobile.profile')
                                        </a>

                                        <a
                                            class="dropdown-item py-2 px-3 text-decoration-none"
                                            href="{{ route('shop.customers.account.orders.index') }}"
                                        >
                                            <i class="bi bi-box me-2"></i>
                                            @lang('shop::app.components.layouts.header.mobile.orders')
                                        </a>

                                        @if ($showWishlist)
                                            <a
                                                class="dropdown-item py-2 px-3 text-decoration-none"
                                                href="{{ route('shop.customers.account.wishlist.index') }}"
                                            >
                                                <i class="bi bi-heart me-2"></i>
                                                @lang('shop::app.components.layouts.header.mobile.wishlist')
                                            </a>
                                        @endif

                                        <!--Customers logout-->
                                        @auth('customer')
                                            <x-shop::form
                                                method="DELETE"
                                                action="{{ route('shop.customer.session.destroy') }}"
                                                id="customerLogout"
                                            />

                                            <a
                                                class="dropdown-item py-2 px-3 text-decoration-none text-danger"
                                                href="{{ route('shop.customer.session.destroy') }}"
                                                onclick="event.preventDefault(); document.getElementById('customerLogout').submit();"
                                            >
                                                <i class="bi bi-box-arrow-right me-2"></i>
                                                @lang('shop::app.components.layouts.header.mobile.logout')
                                            </a>
                                        @endauth

                                        {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.profile_dropdown.links.after') !!}
                                    </div>
                                </li>
                            </ul>
                        @endauth
                    </div>
                </div>

                <!-- For Medium and small screen -->
                <div class="d-md-none">
                    @guest('customer')
                        <a
                            href="{{ route('shop.customer.session.create') }}"
                            aria-label="@lang('shop::app.components.layouts.header.mobile.account')"
                            class="text-decoration-none"
                        >
                            <i class="bi bi-person-circle fs-4 text-ms-primary"></i>
                        </a>
                    @endguest

                    <!-- Customers Dropdown -->
                    @auth('customer')
                        <a
                            href="{{ route('shop.customers.account.index') }}"
                            aria-label="@lang('shop::app.components.layouts.header.mobile.account')"
                            class="text-decoration-none"
                        >
                            <i class="bi bi-person-circle fs-4 text-ms-primary"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.search.before') !!}

    <!-- Search Catalog Form -->
    <div class="row mt-3">
        <div class="col-12">
            <form action="{{ route('shop.search.index') }}" class="d-flex align-items-center">
                <label
                    for="organic-search"
                    class="visually-hidden"
                >
                    @lang('shop::app.components.layouts.header.mobile.search')
                </label>

                <div class="input-group">
                    <span class="input-group-text bg-white border-ms-subtle">
                        <i class="bi bi-search text-ms-primary"></i>
                    </span>

                    <input
                        type="text"
                        class="form-control border-ms-subtle"
                        style="border-width: 2px;"
                        name="query"
                        value="{{ request('query') }}"
                        placeholder="@lang('shop::app.components.layouts.header.mobile.search-text')"
                        required
                    >

                    @if (core()->getConfigData('catalog.products.settings.image_search'))
                        @include('shop::search.images.index')
                    @endif
                </div>
            </form>
        </div>
    </div>

    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.search.after') !!}
</div>

@pushOnce('scripts')
    <script type="text/x-template" id="v-mobile-drawer-template">
        <button
            class="btn btn-link text-decoration-none p-0"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#mobileDrawer"
            aria-controls="mobileDrawer"
        >
            <i class="bi bi-list fs-3 text-ms-primary"></i>
        </button>

        <!-- Bootstrap Offcanvas -->
        <div 
            class="offcanvas offcanvas-start" 
            tabindex="-1" 
            id="mobileDrawer"
            aria-labelledby="mobileDrawerLabel"
        >
            <div class="offcanvas-header border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('shop.home.index') }}" class="text-decoration-none">
                        <img
                            src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                            alt="{{ config('app.name') }}"
                            width="131"
                            height="29"
                            class="img-fluid"
                        >
                    </a>
                </div>
                <button 
                    type="button" 
                    class="btn-close" 
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"
                ></button>
            </div>

            <div class="offcanvas-body p-0">
                <!-- Account Profile Hero Section -->
                <div class="border-bottom p-3">
                    <div class="d-flex align-items-center gap-3 p-2 rounded-3 border">
                        <div>
                            <img
                                src="{{ auth()->user()?->image_url ??  bagisto_asset('images/user-placeholder.png') }}"
                                class="rounded-circle"
                                width="60"
                                height="60"
                            >
                        </div>

                        @guest('customer')
                            <a
                                href="{{ route('shop.customer.session.create') }}"
                                class="text-decoration-none fw-medium text-dark"
                            >
                                @lang('shop::app.components.layouts.header.mobile.login')
                                <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        @endguest

                        @auth('customer')
                            <div class="d-flex flex-column justify-content-between gap-1">
                                <p class="fw-bold mb-0 fs-5">Olá! {{ auth()->user()?->first_name }}</p>
                                <p class="text-ms-muted small mb-0">{{ auth()->user()?->email }}</p>
                            </div>
                        @endauth
                    </div>
                </div>

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.drawer.categories.before') !!}

                <!-- Mobile category view -->
                <v-mobile-category ref="mobileCategory"></v-mobile-category>

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.drawer.categories.after') !!}
            </div>

            <div class="offcanvas-footer border-top p-3">
                <!-- Localization & Currency Section -->
                @if(core()->getCurrentChannel()->locales()->count() > 1 || core()->getCurrentChannel()->currencies()->count() > 1 )
                    <div class="row g-2">
                        <!-- Currency Switcher -->
                        <div class="col-6">
                            <div class="dropdown w-100">
                                <button
                                    class="btn btn-ms-outline-primary w-100 dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    {{ core()->getCurrentCurrency()->symbol . ' ' . core()->getCurrentCurrencyCode() }}
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <v-currency-switcher></v-currency-switcher>
                                </ul>
                            </div>
                        </div>

                        <!-- Locale Switcher -->
                        <div class="col-6">
                            <div class="dropdown w-100">
                                <button
                                    class="btn btn-ms-outline-primary w-100 dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    <img
                                        src="{{ ! empty(core()->getCurrentLocale()->logo_url)
                                                ? core()->getCurrentLocale()->logo_url
                                                : bagisto_asset('images/default-language.svg')
                                            }}"
                                        class="me-1"
                                        alt="Default locale"
                                        width="16"
                                        height="12"
                                    />
                                    {{ core()->getCurrentChannel()->locales()->orderBy('name')->where('code', app()->getLocale())->value('name') }}
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <v-locale-switcher></v-locale-switcher>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </script>

    <script
        type="text/x-template"
        id="v-mobile-category-template"
    >
        <!-- Wrapper with transition effects -->
        <div class="position-relative h-100 overflow-hidden">
            <!-- Sliding container -->
            <div
                class="d-flex h-100"
                :class="{
                    'translate-x-0': currentViewLevel !== 'third',
                    'translate-x-100': currentViewLevel === 'third'
                }"
                style="transition: transform 0.3s ease;"
            >
                <!-- First level view -->
                <div class="h-100 w-100 flex-shrink-0 overflow-auto px-3">
                    <div class="py-3">
                        <div
                            v-for="category in categories"
                            :key="category.id"
                            :class="{'mb-2': category.children && category.children.length}"
                        >
                            <div class="d-flex align-items-center justify-content-between py-2 hover-bg-ms-light rounded">
                                <a :href="category.url" class="text-decoration-none fw-medium text-dark">
                                    @{{ category.name }}
                                </a>
                            </div>

                            <!-- Second Level Categories -->
                            <div v-if="category.children && category.children.length" >
                                <div
                                    v-for="secondLevelCategory in category.children"
                                    :key="secondLevelCategory.id"
                                >
                                    <div
                                        class="d-flex align-items-center justify-content-between py-2 hover-bg-ms-light rounded cursor-pointer"
                                        @click="showThirdLevel(secondLevelCategory, category, $event)"
                                    >
                                        <a :href="secondLevelCategory.url" class="text-decoration-none small">
                                            @{{ secondLevelCategory.name }}
                                        </a>

                                        <i
                                            v-if="secondLevelCategory.children && secondLevelCategory.children.length"
                                            class="bi bi-chevron-right"
                                        ></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Third level view -->
                <div
                    class="h-100 w-100 flex-shrink-0"
                    v-if="currentViewLevel === 'third'"
                >
                    <div class="border-bottom px-3 py-3">
                        <button
                            @click="goBackToMainView"
                            class="btn btn-link text-decoration-none p-0 d-flex align-items-center"
                            aria-label="Go back"
                        >
                            <i class="bi bi-arrow-left me-2"></i>
                            <span class="fw-medium">
                                @lang('shop::app.components.layouts.header.mobile.back-button')
                            </span>
                        </button>
                    </div>

                    <!-- Third Level Content -->
                    <div class="px-3 py-3">
                        <div
                            v-for="thirdLevelCategory in currentSecondLevelCategory?.children"
                            :key="thirdLevelCategory.id"
                            class="mb-2"
                        >
                            <a
                                :href="thirdLevelCategory.url"
                                class="d-block py-2 text-decoration-none small hover-bg-ms-light rounded px-2"
                            >
                                @{{ thirdLevelCategory.name }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-mobile-category', {
            template: '#v-mobile-category-template',

            data() {
                return  {
                    categories: [],
                    currentViewLevel: 'main',
                    currentSecondLevelCategory: null,
                    currentParentCategory: null
                }
            },

            mounted() {
                this.getCategories();
            },

            methods: {
                getCategories() {
                    this.$axios.get("{{ route('shop.api.categories.tree') }}")
                        .then(response => {
                            this.categories = response.data.data;
                        })
                        .catch(error => {
                            console.log(error);
                        });
                },

                showThirdLevel(secondLevelCategory, parentCategory, event) {
                    if (secondLevelCategory.children && secondLevelCategory.children.length) {
                        this.currentSecondLevelCategory = secondLevelCategory;
                        this.currentParentCategory = parentCategory;
                        this.currentViewLevel = 'third';

                        if (event) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                    }
                },

                goBackToMainView() {
                    this.currentViewLevel = 'main';
                }
            },
        });

        app.component('v-mobile-drawer', {
            template: '#v-mobile-drawer-template',

            methods: {
                onDrawerClose() {
                    this.$refs.mobileCategory.currentViewLevel = 'main';
                }
            },
        });
    </script>
@endPushOnce

<style>
.hover-bg-ms-light:hover {
    background-color: #e9ecef !important;
}
.translate-x-0 {
    transform: translateX(0);
}
.translate-x-100 {
    transform: translateX(100%);
}
</style>
