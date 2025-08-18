{!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.before') !!}

<div class="container-fluid bg-gradient-ms-subtle border-bottom">
    <div class="row align-items-center min-vh-78">
        <!-- Left Navigation Section -->
        <div class="col-lg-6 d-flex align-items-center gap-4">
            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.logo.before') !!}

            <a
                href="{{ route('shop.home.index') }}"
                aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.bagisto')"
                class="text-decoration-none"
            >
                <img
                    src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                    width="131"
                    height="29"
                    alt="{{ config('app.name') }}"
                    class="img-fluid shadow-ms"
                >
            </a>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.logo.after') !!}

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.category.before') !!}

            <v-desktop-category>
                <div class="d-flex align-items-center gap-3">
                    <div class="placeholder-glow">
                        <span class="placeholder col-3 rounded"></span>
                        <span class="placeholder col-3 rounded ms-2"></span>
                        <span class="placeholder col-3 rounded ms-2"></span>
                    </div>
                </div>
            </v-desktop-category>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.category.after') !!}
        </div>

        <!-- Right Navigation Section -->
        <div class="col-lg-6 d-flex align-items-center justify-content-end gap-4">

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.search_bar.before') !!}

            <!-- Search Bar Container -->
            <div class="position-relative flex-grow-1" style="max-width: 400px;">
                <form
                    action="{{ route('shop.search.index') }}"
                    class="d-flex align-items-center"
                    role="search"
                >
                    <label
                        for="organic-search"
                        class="visually-hidden"
                    >
                        @lang('shop::app.components.layouts.header.desktop.bottom.search')
                    </label>

                    <div class="position-absolute top-50 start-0 translate-middle-y ms-3 text-ms-primary">
                        <i class="bi bi-search fs-5"></i>
                    </div>

                    <input
                        type="text"
                        name="query"
                        value="{{ request('query') }}"
                        class="form-control ps-5 pe-3 py-2 border-ms-subtle bg-white"
                        style="border-width: 2px;"
                        minlength="{{ core()->getConfigData('catalog.products.search.min_query_length') }}"
                        maxlength="{{ core()->getConfigData('catalog.products.search.max_query_length') }}"
                        placeholder="@lang('shop::app.components.layouts.header.desktop.bottom.search-text')"
                        aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.search-text')"
                        aria-required="true"
                        pattern="[^\\]+"
                        required
                    >

                    <button
                        type="submit"
                        class="visually-hidden"
                        aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.submit')"
                    >
                    </button>

                    @if (core()->getConfigData('catalog.products.settings.image_search'))
                        @include('shop::search.images.index')
                    @endif
                </form>
            </div>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.search_bar.after') !!}

            <!-- Right Navigation Links -->
            <div class="d-flex align-items-center gap-3">

                {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.compare.before') !!}

                <!-- Compare -->
                @if(core()->getConfigData('catalog.products.settings.compare_option'))
                    <a
                        href="{{ route('shop.compare.index') }}"
                        aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.compare')"
                        class="text-decoration-none"
                    >
                        <i class="bi bi-arrow-left-right fs-4 text-ms-primary hover-scale"></i>
                    </a>
                @endif

                {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.compare.after') !!}

                {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.mini_cart.before') !!}

                <!-- Mini cart -->
                @if(core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                    @include('shop::checkout.cart.mini-cart')
                @endif

                {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.mini_cart.after') !!}

                {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile.before') !!}

                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <button
                        class="btn btn-link text-decoration-none p-0"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        <i class="bi bi-person-circle fs-4 text-ms-primary hover-scale"></i>
                    </button>

                    <!-- Guest Dropdown -->
                    @guest('customer')
                        <ul class="dropdown-menu dropdown-menu-end p-3 shadow-ms-lg border-0" style="min-width: 300px;">
                            <li>
                                <div class="mb-3">
                                    <h6 class="dropdown-header text-ms-primary fw-bold">
                                        @lang('shop::app.components.layouts.header.desktop.bottom.welcome-guest')
                                    </h6>
                                    <p class="text-ms-muted small mb-0">
                                        @lang('shop::app.components.layouts.header.desktop.bottom.dropdown-text')
                                    </p>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.customers_action.before') !!}

                                <div class="d-flex gap-2">
                                    {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.sign_in_button.before') !!}

                                    <a
                                        href="{{ route('shop.customer.session.create') }}"
                                        class="btn btn-ms-primary flex-fill"
                                    >
                                        @lang('shop::app.components.layouts.header.desktop.bottom.sign-in')
                                    </a>

                                    <a
                                        href="{{ route('shop.customers.register.index') }}"
                                        class="btn btn-ms-outline-primary flex-fill"
                                    >
                                        @lang('shop::app.components.layouts.header.desktop.bottom.sign-up')
                                    </a>

                                    {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.sign_up_button.after') !!}
                                </div>

                                {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.customers_action.after') !!}
                            </li>
                        </ul>
                    @endguest

                    <!-- Customers Dropdown -->
                    @auth('customer')
                        <ul class="dropdown-menu dropdown-menu-end p-0 shadow-ms-lg border-0" style="min-width: 280px;">
                            <li>
                                <div class="p-3 border-bottom">
                                    <h6 class="dropdown-header text-ms-primary fw-bold mb-1">
                                        @lang('shop::app.components.layouts.header.desktop.bottom.welcome')'
                                        {{ auth()->guard('customer')->user()->first_name }}
                                    </h6>
                                    <p class="text-ms-muted small mb-0">
                                        @lang('shop::app.components.layouts.header.desktop.bottom.dropdown-text')
                                    </p>
                                </div>
                            </li>
                            <li>
                                <div class="py-2">
                                    {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile_dropdown.links.before') !!}

                                    <a
                                        class="dropdown-item py-2 px-3 text-decoration-none"
                                        href="{{ route('shop.customers.account.profile.index') }}"
                                    >
                                        <i class="bi bi-person me-2"></i>
                                        @lang('shop::app.components.layouts.header.desktop.bottom.profile')
                                    </a>

                                    <a
                                        class="dropdown-item py-2 px-3 text-decoration-none"
                                        href="{{ route('shop.customers.account.orders.index') }}"
                                    >
                                        <i class="bi bi-box me-2"></i>
                                        @lang('shop::app.components.layouts.header.desktop.bottom.orders')
                                    </a>

                                    @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                                        <a
                                            class="dropdown-item py-2 px-3 text-decoration-none"
                                            href="{{ route('shop.customers.account.wishlist.index') }}"
                                        >
                                            <i class="bi bi-heart me-2"></i>
                                            @lang('shop::app.components.layouts.header.desktop.bottom.wishlist')
                                        </a>
                                    @endif

                                    <!-- Customers logout-->
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
                                            @lang('shop::app.components.layouts.header.desktop.bottom.logout')
                                        </a>
                                    @endauth

                                    {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile_dropdown.links.after') !!}
                                </div>
                            </li>
                        </ul>
                    @endauth
                </div>

                {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile.after') !!}
            </div>
        </div>
    </div>
</div>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-desktop-category-template"
    >
        <!-- Loading State -->
        <div
            class="d-flex align-items-center gap-3"
            v-if="isLoading"
        >
            <div class="placeholder-glow">
                <span class="placeholder col-3 rounded"></span>
                <span class="placeholder col-3 rounded ms-2"></span>
                <span class="placeholder col-3 rounded ms-2"></span>
            </div>
        </div>

        <!-- Default category layout -->
        <div
            class="d-flex align-items-center"
            v-else-if="'{{ core()->getConfigData('general.design.categories.category_view') }}' !== 'sidebar'"
        >
            <div
                class="nav-item dropdown position-relative"
                v-for="category in categories"
            >
                <a
                    :href="category.url"
                    class="nav-link text-dark text-decoration-none px-3 py-2 fw-medium text-uppercase"
                    :class="{'active': false}"
                >
                    @{{ category.name }}
                </a>

                <div
                    class="dropdown-menu dropdown-menu-start border-0 shadow-lg p-4"
                    style="min-width: 600px; max-height: 580px; overflow-y: auto;"
                    v-if="category.children && category.children.length"
                >
                    <div class="row g-4">
                        <div
                            class="col-6"
                            v-for="pairCategoryChildren in pairCategoryChildren(category)"
                        >
                            <template v-for="secondLevelCategory in pairCategoryChildren">
                                <h6 class="fw-bold text-success mb-2">
                                    <a :href="secondLevelCategory.url" class="text-decoration-none">
                                        @{{ secondLevelCategory.name }}
                                    </a>
                                </h6>

                                <ul
                                    class="list-unstyled mb-3"
                                    v-if="secondLevelCategory.children && secondLevelCategory.length"
                                >
                                    <li
                                        class="mb-1"
                                        v-for="thirdLevelCategory in secondLevelCategory.children"
                                    >
                                        <a 
                                            :href="thirdLevelCategory.url"
                                            class="text-decoration-none text-muted small"
                                        >
                                            @{{ thirdLevelCategory.name }}
                                        </a>
                                    </li>
                                </ul>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar category layout -->
        <div v-else>
            <!-- Categories Navigation -->
            <div class="d-flex align-items-center">
                <!-- "All" button for opening the category drawer -->
                <button
                    class="btn btn-link text-decoration-none px-3 py-2 fw-medium text-uppercase"
                    @click="toggleCategoryDrawer"
                >
                    <i class="bi bi-list me-1"></i>
                    @lang('shop::app.components.layouts.header.desktop.bottom.all')
                </button>

                <!-- Show only first 4 categories in main navigation -->
                <div
                    class="nav-item dropdown position-relative"
                    v-for="category in categories.slice(0, 4)"
                >
                    <a
                        :href="category.url"
                        class="nav-link text-dark text-decoration-none px-3 py-2 fw-medium text-uppercase"
                    >
                        @{{ category.name }}
                    </a>

                    <!-- Dropdown for each category -->
                    <div
                        class="dropdown-menu dropdown-menu-start border-0 shadow-lg p-4"
                        style="min-width: 600px; max-height: 580px; overflow-y: auto;"
                        v-if="category.children && category.children.length"
                    >
                        <div class="row g-4">
                            <div
                                class="col-6"
                                v-for="pairCategoryChildren in pairCategoryChildren(category)"
                            >
                                <template v-for="secondLevelCategory in pairCategoryChildren">
                                    <h6 class="fw-bold text-success mb-2">
                                        <a :href="secondLevelCategory.url" class="text-decoration-none">
                                            @{{ secondLevelCategory.name }}
                                        </a>
                                    </h6>

                                    <ul
                                        class="list-unstyled mb-3"
                                        v-if="secondLevelCategory.children && secondLevelCategory.children.length"
                                    >
                                        <li
                                            class="mb-1"
                                            v-for="thirdLevelCategory in secondLevelCategory.children"
                                        >
                                            <a 
                                                :href="thirdLevelCategory.url"
                                                class="text-decoration-none text-muted small"
                                            >
                                                @{{ thirdLevelCategory.name }}
                                            </a>
                                        </li>
                                    </ul>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap Offcanvas Integration -->
            <div 
                class="offcanvas offcanvas-start" 
                tabindex="-1" 
                id="categoryOffcanvas"
                :class="{'show': isDrawerActive}"
                @click.self="onDrawerClose"
            >
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title fw-bold text-success">
                        @lang('shop::app.components.layouts.header.desktop.bottom.categories')
                    </h5>
                    <button 
                        type="button" 
                        class="btn-close" 
                        @click="onDrawerClose"
                    ></button>
                </div>
                <div class="offcanvas-body p-0">
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
                            <div class="h-100 w-100 flex-shrink-0 overflow-auto">
                                <div class="py-3">
                                    <div
                                        v-for="category in categories"
                                        :key="category.id"
                                        :class="{'mb-2': category.children && category.children.length}"
                                    >
                                        <div class="d-flex align-items-center justify-content-between px-3 py-2 hover-bg-light rounded">
                                            <a
                                                :href="category.url"
                                                class="text-decoration-none fw-medium text-dark"
                                            >
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
                                                    class="d-flex align-items-center justify-content-between px-4 py-2 hover-bg-light rounded cursor-pointer"
                                                    @click="showThirdLevel(secondLevelCategory, category, $event)"
                                                >
                                                    <a
                                                        :href="secondLevelCategory.url"
                                                        class="text-decoration-none small"
                                                    >
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
                                            @lang('shop::app.components.layouts.header.desktop.bottom.back-button')
                                        </span>
                                    </button>
                                </div>

                                <!-- Third Level Content -->
                                <div class="py-3">
                                    <div
                                        v-for="thirdLevelCategory in currentSecondLevelCategory?.children"
                                        :key="thirdLevelCategory.id"
                                        class="mb-2"
                                    >
                                        <a
                                            :href="thirdLevelCategory.url"
                                            class="d-block px-4 py-2 text-decoration-none small hover-bg-light rounded"
                                        >
                                            @{{ thirdLevelCategory.name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-desktop-category', {
            template: '#v-desktop-category-template',

            data() {
                return {
                    isLoading: true,
                    categories: [],
                    isDrawerActive: false,
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
                            this.isLoading = false;
                            this.categories = response.data.data;
                        })
                        .catch(error => {
                            console.log(error);
                        });
                },

                pairCategoryChildren(category) {
                    if (! category.children) return [];

                    return category.children.reduce((result, value, index, array) => {
                        if (index % 2 === 0) {
                            result.push(array.slice(index, index + 2));
                        }
                        return result;
                    }, []);
                },

                toggleCategoryDrawer() {
                    this.isDrawerActive = !this.isDrawerActive;
                    if (this.isDrawerActive) {
                        this.currentViewLevel = 'main';
                        // Show Bootstrap offcanvas
                        const offcanvas = new bootstrap.Offcanvas(document.getElementById('categoryOffcanvas'));
                        offcanvas.show();
                    }
                },

                onDrawerToggle(event) {
                    this.isDrawerActive = event.isActive;
                },

                onDrawerClose(event) {
                    this.isDrawerActive = false;
                    // Hide Bootstrap offcanvas
                    const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('categoryOffcanvas'));
                    if (offcanvas) {
                        offcanvas.hide();
                    }
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
    </script>
@endPushOnce

<style>
.hover-scale {
    transition: transform 0.3s ease;
}
.hover-scale:hover {
    transform: scale(1.1);
}
.hover-bg-light:hover {
    background-color: rgba(0,0,0,0.05) !important;
}
.translate-x-0 {
    transform: translateX(0);
}
.translate-x-100 {
    transform: translateX(100%);
}
.min-vh-78 {
    min-height: 78px;
}
</style>

{!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.after') !!}
