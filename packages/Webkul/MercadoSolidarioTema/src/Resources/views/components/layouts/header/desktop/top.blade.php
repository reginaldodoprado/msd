{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.before') !!}

<v-topbar>
    <!-- Shimmer Effect -->
    <div class="container-fluid border-bottom">
        <div class="row align-items-center">
            <!-- Currencies -->
            <div class="col-auto d-flex align-items-center gap-2 py-2">
                <div class="placeholder-glow">
                    <span class="placeholder col-2 rounded"></span>
                    <span class="placeholder col-1 rounded ms-1"></span>
                </div>
            </div>

            <!-- Offers -->
            <div class="col d-flex justify-content-center">
                <div class="placeholder-glow">
                    <span class="placeholder col-8 rounded py-2"></span>
                </div>
            </div>

            <!-- Locales -->
            <div class="col-auto d-flex align-items-center gap-2 py-2">
                <div class="placeholder-glow">
                    <span class="placeholder col-1 rounded"></span>
                    <span class="placeholder col-3 rounded ms-1"></span>
                    <span class="placeholder col-1 rounded ms-1"></span>
                </div>
            </div>
        </div>
    </div>
</v-topbar>

{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-topbar-template"
    >
        <div class="container-fluid border-bottom bg-ms-light">
            <div class="row align-items-center">
                {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.currency_switcher.before') !!}

                <!-- Currency Switcher -->
                <div class="col-auto">
                    <div class="dropdown">
                        <button
                            class="btn btn-link text-decoration-none dropdown-toggle py-2"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            @click="currencyToggler = ! currencyToggler"
                        >
                            <span class="fw-medium text-ms-primary">
                                {{ core()->getCurrentCurrency()->symbol . ' ' . core()->getCurrentCurrencyCode() }}
                            </span>
                        </button>

                        <ul class="dropdown-menu border-0 shadow-ms">
                            <v-currency-switcher></v-currency-switcher>
                        </ul>
                    </div>
                </div>

                {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.currency_switcher.after') !!}

                <!-- Offers -->
                <div class="col text-center">
                    <p class="mb-0 py-2 small fw-medium text-ms-muted">
                        {{ core()->getConfigData('general.content.header_offer.title') }}
                        
                        <a 
                            href="{{ core()->getConfigData('general.content.header_offer.redirection_link') }}" 
                            class="text-decoration-none text-ms-primary fw-bold"
                            role="button"
                        >
                            {{ core()->getConfigData('general.content.header_offer.redirection_title') }}
                        </a>
                    </p>
                </div>

                {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.locale_switcher.before') !!}

                <!-- Locales Switcher -->
                <div class="col-auto">
                    <div class="dropdown">
                        <button
                            class="btn btn-link text-decoration-none dropdown-toggle py-2"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            @click="localeToggler = ! localeToggler"
                        >
                            <div class="d-flex align-items-center gap-2">
                                <img
                                    src="{{ ! empty(core()->getCurrentLocale()->logo_url)
                                            ? core()->getCurrentLocale()->logo_url
                                            : bagisto_asset('images/default-language.svg')
                                        }}"
                                    class="img-fluid"
                                    alt="@lang('shop::app.components.layouts.header.desktop.top.default-locale')"
                                    width="24"
                                    height="16"
                                />
                                
                                <span class="fw-medium text-ms-primary">
                                    {{ core()->getCurrentChannel()->locales()->orderBy('name')->where('code', app()->getLocale())->value('name') }}
                                </span>
                            </div>
                        </button>
                    
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-ms">
                            <v-locale-switcher></v-locale-switcher>
                        </ul>
                    </div>
                </div>

                {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.locale_switcher.after') !!}
            </div>
        </div>
    </script>

    <script
        type="text/x-template"
        id="v-currency-switcher-template"
    >
        <div class="py-2">
            <li
                v-for="currency in currencies"
                :key="currency.code"
            >
                <button
                    class="dropdown-item py-2 px-3"
                    :class="{'active bg-ms-primary text-white': currency.code == '{{ core()->getCurrentCurrencyCode() }}'}"
                    @click="change(currency)"
                >
                    @{{ currency.symbol + ' ' + currency.code }}
                </button>
            </li>
        </div>
    </script>

    <script
        type="text/x-template"
        id="v-locale-switcher-template"
    >
        <div class="py-2">
            <li
                v-for="locale in locales"
                :key="locale.code"
            >
                <button
                    class="dropdown-item py-2 px-3 d-flex align-items-center gap-2"
                    :class="{'active bg-ms-primary text-white': locale.code == '{{ app()->getLocale() }}'}"
                    @click="change(locale)"
                >
                    <img
                        :src="locale.logo_url || '{{ bagisto_asset('images/default-language.svg') }}'"
                        width="24"
                        height="16"
                        class="img-fluid"
                    />
                    @{{ locale.name }}
                </button>
            </li>
        </div>
    </script>

    <script type="module">
        app.component('v-topbar', {
            template: '#v-topbar-template',

            data() {
                return {
                    localeToggler: false,
                    currencyToggler: false,
                };
            },
        });

        app.component('v-currency-switcher', {
            template: '#v-currency-switcher-template',

            data() {
                return {
                    currencies: @json(core()->getCurrentChannel()->currencies),
                };
            },

            methods: {
                change(currency) {
                    let url = new URL(window.location.href);
                    url.searchParams.set('currency', currency.code);
                    window.location.href = url.href;
                }
            }
        });

        app.component('v-locale-switcher', {
            template: '#v-locale-switcher-template',

            data() {
                return {
                    locales: @json(core()->getCurrentChannel()->locales()->orderBy('name')->get()),
                };
            },

            methods: {
                change(locale) {
                    let url = new URL(window.location.href);
                    url.searchParams.set('locale', locale.code);
                    window.location.href = url.href;
                }
            }
        });
    </script>
@endPushOnce