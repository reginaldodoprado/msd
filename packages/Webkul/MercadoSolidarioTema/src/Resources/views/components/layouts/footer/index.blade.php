{!! view_render_event('bagisto.shop.layout.footer.before') !!}

<!--
    The category repository is injected directly here because there is no way
    to retrieve it from the view composer, as this is an anonymous component.
-->
@inject('themeCustomizationRepository', 'Webkul\Theme\Repositories\ThemeCustomizationRepository')

<!--
    This code needs to be refactored to reduce the amount of PHP in the Blade
    template as much as possible.
-->
@php
    $channel = core()->getCurrentChannel();

    $customization = $themeCustomizationRepository->findOneWhere([
        'type'       => 'footer_links',
        'status'     => 1,
        'theme_code' => $channel->theme,
        'channel_id' => $channel->id,
    ]);
@endphp

<footer class="mt-5 bg-gradient-ms-subtle">
    <div class="container-fluid py-5">
        <div class="row g-4">
            <!-- For Desktop View -->
            <div class="col-lg-8 d-none d-lg-block">
                <div class="row g-4">
                    @if ($customization?->options)
                        @foreach ($customization->options as $footerLinkSection)
                            <div class="col-md-3">
                                <ul class="list-unstyled">
                                    @php
                                        usort($footerLinkSection, function ($a, $b) {
                                            return $a['sort_order'] - $b['sort_order'];
                                        });
                                    @endphp

                                    @foreach ($footerLinkSection as $link)
                                        <li class="mb-2">
                                            <a 
                                                href="{{ $link['url'] }}" 
                                                class="text-decoration-none text-ms-muted hover-text-ms-primary transition-ms"
                                            >
                                                {{ $link['title'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- For Mobile view -->
            <div class="col-12 d-lg-none">
                <div class="accordion" id="footerAccordion">
                    <div class="accordion-item border-0 bg-transparent">
                        <h2 class="accordion-header">
                            <button 
                                class="accordion-button collapsed bg-ms-primary text-white fw-bold rounded-3" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#footerCollapse" 
                                aria-expanded="false" 
                                aria-controls="footerCollapse"
                            >
                                @lang('shop::app.components.layouts.footer.footer-content')
                            </button>
                        </h2>
                        <div 
                            id="footerCollapse" 
                            class="accordion-collapse collapse" 
                            data-bs-parent="#footerAccordion"
                        >
                            <div class="accordion-body">
                                <div class="row g-3">
                                    @if ($customization?->options)
                                        @foreach ($customization->options as $footerLinkSection)
                                            <div class="col-6">
                                                <ul class="list-unstyled">
                                                    @php
                                                        usort($footerLinkSection, function ($a, $b) {
                                                            return $a['sort_order'] - $b['sort_order'];
                                                        });
                                                    @endphp

                                                    @foreach ($footerLinkSection as $link)
                                                        <li class="mb-2">
                                                            <a
                                                                href="{{ $link['url'] }}"
                                                                class="text-decoration-none text-ms-muted small fw-medium hover-text-ms-primary transition-ms"
                                                            >
                                                                {{ $link['title'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {!! view_render_event('bagisto.shop.layout.footer.newsletter_subscription.before') !!}

            <!-- News Letter subscription -->
            @if (core()->getConfigData('customer.settings.newsletter.subscription'))
                <div class="col-lg-4">
                    <div class="text-center text-lg-start">
                        <h2 
                            class="display-6 fst-italic fw-bold text-ms-primary mb-2"
                            role="heading"
                            aria-level="2"
                        >
                            @lang('shop::app.components.layouts.footer.newsletter-text')
                        </h2>

                        <p class="text-ms-muted small mb-3">
                            @lang('shop::app.components.layouts.footer.subscribe-stay-touch')
                        </p>

                        <div class="d-flex justify-content-center justify-content-lg-start">
                            <x-shop::form
                                :action="route('shop.subscription.store')"
                                class="w-100"
                            >
                                <div class="input-group">
                                    <x-shop::form.control-group.control
                                        type="email"
                                        class="form-control border-ms-subtle bg-white"
                                        style="border-width: 2px;"
                                        name="email"
                                        rules="required|email"
                                        label="Email"
                                        :aria-label="trans('shop::app.components.layouts.footer.email')"
                                        placeholder="email@example.com"
                                    />

                                    <button
                                        type="submit"
                                        class="btn btn-ms-primary px-4 fw-medium"
                                    >
                                        @lang('shop::app.components.layouts.footer.subscribe')
                                    </button>
                                </div>

                                <x-shop::form.control-group.error control-name="email" />
                            </x-shop::form>
                        </div>
                    </div>
                </div>
            @endif

            {!! view_render_event('bagisto.shop.layout.footer.newsletter_subscription.after') !!}
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="bg-gradient-ms-subtle border-top border-ms-primary">
        <div class="container-fluid py-3">
            <div class="row align-items-center">
                <div class="col-12 text-center">
                    {!! view_render_event('bagisto.shop.layout.footer.footer_text.before') !!}

                    <p class="text-white small mb-0">
                        Mercado Solidário - Todos os direitos reservados
                    </p>

                    {!! view_render_event('bagisto.shop.layout.footer.footer_text.after') !!}
                </div>
            </div>
        </div>
    </div>
</footer>

{!! view_render_event('bagisto.shop.layout.footer.after') !!}
