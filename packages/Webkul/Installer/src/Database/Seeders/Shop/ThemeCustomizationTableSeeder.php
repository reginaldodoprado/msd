<?php

namespace Webkul\Installer\Database\Seeders\Shop;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ThemeCustomizationTableSeeder extends Seeder
{
    /**
     * Base path for the images.
     */
    const BASE_PATH = 'packages/Webkul/Installer/src/Resources/assets/images/seeders/theme/';

    /**
     * Seed the application's database.
     *
     * @param  array  $parameters
     * @return void
     */
    public function run($parameters = [])
    {
        DB::table('theme_customizations')->delete();

        DB::table('theme_customization_translations')->delete();

        $now = Carbon::now();

        $defaultLocale = $parameters['default_locale'] ?? config('app.locale');

        $appUrl = config('app.url');

        DB::table('theme_customizations')
            ->insert([
                [
                    'id'         => 1,
                    'type'       => 'image_carousel',
                    'name'       => trans('installer::app.seeders.shop.theme-customizations.image-carousel.name', [], $defaultLocale),
                    'sort_order' => 1,
                    'status'     => 0,
                    'channel_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 2,
                    'type'       => 'static_content',
                    'name'       => trans('installer::app.seeders.shop.theme-customizations.offer-information.name', [], $defaultLocale),
                    'sort_order' => 2,
                    'status'     => 0,
                    'channel_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 3,
                    'type'       => 'category_carousel',
                    'name'       => trans('installer::app.seeders.shop.theme-customizations.categories-collections.name', [], $defaultLocale),
                    'sort_order' => 3,
                    'status'     => 0,
                    'channel_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 4,
                    'type'       => 'product_carousel',
                    'name'       => trans('installer::app.seeders.shop.theme-customizations.new-products.name', [], $defaultLocale),
                    'sort_order' => 4,
                    'status'     => 0,
                    'channel_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 5,
                    'type'       => 'static_content',
                    'name'       => trans('installer::app.seeders.shop.theme-customizations.top-collections.name', [], $defaultLocale),
                    'sort_order' => 5,
                    'status'     => 0,
                    'channel_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 6,
                    'type'       => 'static_content',
                    'name'       => trans('installer::app.seeders.shop.theme-customizations.bold-collections.name', [], $defaultLocale),
                    'sort_order' => 6,
                    'status'     => 0,
                    'channel_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 7,
                    'type'       => 'product_carousel',
                    'name'       => trans('installer::app.seeders.shop.theme-customizations.featured-collections.name', [], $defaultLocale),
                    'sort_order' => 7,
                    'status'     => 0,
                    'channel_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 8,
                    'type'       => 'static_content',
                    'name'       => trans('installer::app.seeders.shop.theme-customizations.game-container.name', [], $defaultLocale),
                    'sort_order' => 8,
                    'status'     => 0,
                    'channel_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 9,
                    'type'       => 'product_carousel',
                    'name'       => trans('installer::app.seeders.shop.theme-customizations.all-products.name', [], $defaultLocale),
                    'sort_order' => 9,
                    'status'     => 0,
                    'channel_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 10,
                    'type'       => 'static_content',
                    'name'       => trans('installer::app.seeders.shop.theme-customizations.bold-collections.name', [], $defaultLocale),
                    'sort_order' => 10,
                    'status'     => 0,
                    'channel_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 11,
                    'type'       => 'footer_links',
                    'name'       => trans('installer::app.seeders.shop.theme-customizations.footer-links.name', [], $defaultLocale),
                    'sort_order' => 11,
                    'status'     => 0,
                    'channel_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 12,
                    'type'       => 'services_content',
                    'name'       => trans('installer::app.seeders.shop.theme-customizations.services-content.name', [], $defaultLocale),
                    'sort_order' => 12,
                    'status'     => 0,
                    'channel_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 13,
                    'type'       => 'static_content',
                    'name'       => 'Banner Missão Solidária',
                    'sort_order' => 13,
                    'status'     => 1,
                    'channel_id' => 1,
                    'theme_code' => 'mercado-solidario-tema',
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 14,
                    'type'       => 'static_content',
                    'name'       => 'Nossos Valores',
                    'sort_order' => 14,
                    'status'     => 1,
                    'channel_id' => 1,
                    'theme_code' => 'mercado-solidario-tema',
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 15,
                    'type'       => 'static_content',
                    'name'       => 'Como Funciona',
                    'sort_order' => 15,
                    'status'     => 1,
                    'channel_id' => 1,
                    'theme_code' => 'mercado-solidario-tema',
                    'created_at' => $now,
                    'updated_at' => $now,
                ], [
                    'id'         => 16,
                    'type'       => 'static_content',
                    'name'       => 'Sobre o Projeto',
                    'sort_order' => 16,
                    'status'     => 1,
                    'channel_id' => 1,
                    'theme_code' => 'mercado-solidario-tema',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);

        $locales = $parameters['allowed_locales'] ?? [$defaultLocale];

        foreach ($locales as $locale) {
            DB::table('theme_customization_translations')
                ->insert([
                    /**
                     * Customizations for current locale
                     */
                    [
                        'theme_customization_id' => 1,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'images' => [
                                [
                                    'title' => trans('installer::app.seeders.shop.theme-customizations.image-carousel.sliders.title', [], $locale),
                                    'link'  => '',
                                    'image' => $this->storeFileIfExists('theme/1', 'sliders/'.$locale.'/1.webp', 'sliders/en/1.webp'),
                                ], [
                                    'title' => trans('installer::app.seeders.shop.theme-customizations.image-carousel.sliders.title', [], $locale),
                                    'link'  => '',
                                    'image' => $this->storeFileIfExists('theme/1', 'sliders/'.$locale.'/2.webp', 'sliders/en/2.webp'),
                                ], [
                                    'title' => trans('installer::app.seeders.shop.theme-customizations.image-carousel.sliders.title', [], $locale),
                                    'link'  => '',
                                    'image' => $this->storeFileIfExists('theme/1', 'sliders/'.$locale.'/3.webp', 'sliders/en/3.webp'),
                                ], [
                                    'title' => trans('installer::app.seeders.shop.theme-customizations.image-carousel.sliders.title', [], $locale),
                                    'link'  => '',
                                    'image' => $this->storeFileIfExists('theme/1', 'sliders/'.$locale.'/4.webp', 'sliders/en/4.webp'),
                                ],
                            ],
                        ]),
                    ], [
                        'theme_customization_id' => 2,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'html' => '<div class="home-offer"><h1>'.trans('installer::app.seeders.shop.theme-customizations.offer-information.content.title', [], $locale).'</h1></div>',
                            'css'  => '.home-offer h1 {display: block;font-weight: 500;text-align: center;font-size: 22px;font-family: DM Serif Display;background-color: #E8EDFE;padding-top: 20px;padding-bottom: 20px;}@media (max-width:768px){.home-offer h1 {font-size:18px;padding-top: 10px;padding-bottom: 10px;}@media (max-width:525px) {.home-offer h1 {font-size:14px;padding-top: 6px;padding-bottom: 6px;}}',
                        ]),
                    ], [
                        'theme_customization_id' => 3,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'filters' => [
                                'parent_id'  => 1,
                                'sort'       => 'asc',
                                'limit'      => 10,
                            ],
                        ]),
                    ], [
                        'theme_customization_id' => 4,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'title'   => trans('installer::app.seeders.shop.theme-customizations.new-products.options.title', [], $locale),
                            'filters' => [
                                'new'   => 1,
                                'sort'  => 'name-asc',
                                'limit' => 12,
                            ],
                        ]),
                    ], [
                        'theme_customization_id' => 5,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'html' => '<div class="top-collection-container"><div class="top-collection-header"><h2>'.trans('installer::app.seeders.shop.theme-customizations.top-collections.content.title', [], $locale).'</h2></div><div class="top-collection-grid container"><div class="top-collection-card"><img src="" data-src="'.$this->storeFileIfExists('theme/5', 'static/'.$locale.'/1.webp', 'static/en/1.webp').'" class="lazy" width="396" height="396" alt="'.trans('installer::app.seeders.shop.theme-customizations.top-collections.content.title', [], $locale).'"><h3>'.trans('installer::app.seeders.shop.theme-customizations.top-collections.content.sub-title-1', [], $locale).'</h3></div><div class="top-collection-card"><img src="" data-src="'.$this->storeFileIfExists('theme/5', 'static/'.$locale.'/2.webp', 'static/en/2.webp').'" class="lazy" width="396" height="396" alt="'.trans('installer::app.seeders.shop.theme-customizations.top-collections.content.title', [], $locale).'"><h3>'.trans('installer::app.seeders.shop.theme-customizations.top-collections.content.sub-title-2', [], $locale).'</h3></div><div class="top-collection-card"><img src="" data-src="'.$this->storeFileIfExists('theme/5', 'static/'.$locale.'/3.webp', 'static/en/3.webp').'" class="lazy" width="396" height="396" alt="'.trans('installer::app.seeders.shop.theme-customizations.top-collections.content.title', [], $locale).'"><h3>'.trans('installer::app.seeders.shop.theme-customizations.top-collections.content.sub-title-3', [], $locale).'</h3></div><div class="top-collection-card"><img src="" data-src="'.$this->storeFileIfExists('theme/5', 'static/'.$locale.'/4.webp', 'static/en/4.webp').'" class="lazy" width="396" height="396" alt="'.trans('installer::app.seeders.shop.theme-customizations.top-collections.content.title', [], $locale).'"><h3>'.trans('installer::app.seeders.shop.theme-customizations.top-collections.content.sub-title-4', [], $locale).'</h3></div><div class="top-collection-card"><img src="" data-src="'.$this->storeFileIfExists('theme/5', 'static/'.$locale.'/5.webp', 'static/en/5.webp').'" class="lazy" width="396" height="396" alt="'.trans('installer::app.seeders.shop.theme-customizations.top-collections.content.title', [], $locale).'"><h3>'.trans('installer::app.seeders.shop.theme-customizations.top-collections.content.sub-title-5', [], $locale).'</h3></div><div class="top-collection-card"><img src="" data-src="'.$this->storeFileIfExists('theme/5', 'static/'.$locale.'/6.webp', 'static/en/6.webp').'" class="lazy" width="396" height="396" alt="'.trans('installer::app.seeders.shop.theme-customizations.top-collections.content.title', [], $locale).'"><h3>'.trans('installer::app.seeders.shop.theme-customizations.top-collections.content.sub-title-6', [], $locale).'</h3></div></div></div>',

                            'css'  => '.top-collection-container {overflow: hidden;}.top-collection-header {padding-left: 15px;padding-right: 15px;text-align: center;font-size: 70px;line-height: 90px;color: #060C3B;margin-top: 80px;}.top-collection-header h2 {max-width: 595px;margin-left: auto;margin-right: auto;font-family: DM Serif Display;}.top-collection-grid {display: flex;flex-wrap: wrap;gap: 32px;justify-content: center;margin-top: 60px;width: 100%;margin-right: auto;margin-left: auto;padding-right: 90px;padding-left: 90px;}.top-collection-card {position: relative;background: #f9fafb;overflow:hidden;border-radius:20px;}.top-collection-card img {border-radius: 16px;max-width: 100%;text-indent:-9999px;transition: transform 300ms ease;transform: scale(1);}.top-collection-card:hover img {transform: scale(1.05);transition: all 300ms ease;}.top-collection-card h3 {color: #060C3B;font-size: 30px;font-family: DM Serif Display;transform: translateX(-50%);width: max-content;left: 50%;bottom: 30px;position: absolute;margin: 0;font-weight: inherit;}@media not all and (min-width: 525px) {.top-collection-header {margin-top: 28px;font-size: 20px;line-height: 1.5;}.top-collection-grid {gap: 10px}}@media not all and (min-width: 768px) {.top-collection-header {margin-top: 30px;font-size: 28px;line-height: 3;}.top-collection-header h2 {line-height:2; margin-bottom:20px;} .top-collection-grid {gap: 14px}} @media not all and (min-width: 1024px) {.top-collection-grid {padding-left: 30px;padding-right: 30px;}}@media (max-width: 768px) {.top-collection-grid { row-gap:15px; column-gap:0px;justify-content: space-between;margin-top: 0px;} .top-collection-card{width:48%} .top-collection-card img {width:100%;} .top-collection-card h3 {font-size:24px; bottom: 16px;}}@media (max-width:520px) { .top-collection-grid{padding-left: 15px;padding-right: 15px;} .top-collection-card h3 {font-size:18px; bottom: 10px;}}',
                        ]),
                    ], [
                        'theme_customization_id' => 6,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'html' => '<div class="section-gap bold-collections container"> <div class="inline-col-wrapper"> <div class="inline-col-image-wrapper"> <img src="" data-src="'.$this->storeFileIfExists('theme/6', 'static/'.$locale.'/7.webp', 'static/en/7.webp').'" class="lazy" width="632" height="510" alt="'.trans('installer::app.seeders.shop.theme-customizations.bold-collections.content.title', [], $locale).'"> </div> <div class="inline-col-content-wrapper"> <h2 class="inline-col-title"> '.trans('installer::app.seeders.shop.theme-customizations.bold-collections.content.title', [], $locale).' </h2> <p class="inline-col-description">'.trans('installer::app.seeders.shop.theme-customizations.bold-collections.content.description', [], $locale).'</p> <button class="primary-button max-md:rounded-lg max-md:px-4 max-md:py-2.5 max-md:text-sm">'.trans('installer::app.seeders.shop.theme-customizations.bold-collections.content.btn-title', [], $locale).'</button> </div> </div> </div>',

                            'css'  => '.section-gap{margin-top:80px}.direction-ltr{direction:ltr}.direction-rtl{direction:rtl}.inline-col-wrapper{display:grid;grid-template-columns:auto 1fr;grid-gap:60px;align-items:center}.inline-col-wrapper .inline-col-image-wrapper{overflow:hidden}.inline-col-wrapper .inline-col-image-wrapper img{max-width:100%;height:auto;border-radius:16px;text-indent:-9999px}.inline-col-wrapper .inline-col-content-wrapper{display:flex;flex-wrap:wrap;gap:20px;max-width:464px}.inline-col-wrapper .inline-col-content-wrapper .inline-col-title{max-width:442px;font-size:60px;font-weight:400;color:#060c3b;line-height:70px;font-family:DM Serif Display;margin:0}.inline-col-wrapper .inline-col-content-wrapper .inline-col-description{margin:0;font-size:18px;color:#6e6e6e;font-family:Poppins}@media (max-width:991px){.inline-col-wrapper{grid-template-columns:1fr;grid-gap:16px}.inline-col-wrapper .inline-col-content-wrapper{gap:10px}} @media (max-width:768px){.inline-col-wrapper .inline-col-image-wrapper img {width:100%;} .inline-col-wrapper .inline-col-content-wrapper .inline-col-title{font-size:28px !important;line-height:normal !important}} @media (max-width:525px){.inline-col-wrapper .inline-col-content-wrapper .inline-col-title{font-size:20px !important;} .inline-col-description{font-size:16px} .inline-col-wrapper{grid-gap:10px}}',
                        ]),
                    ], [
                        'theme_customization_id' => 7,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'title'   => trans('installer::app.seeders.shop.theme-customizations.featured-collections.options.title', [], $locale),
                            'filters' => [
                                'featured' => 1,
                                'sort'     => 'name-desc',
                                'limit'    => 12,
                            ],
                        ]),
                    ], [
                        'theme_customization_id' => 8,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'html' => '<div class="section-game"><div class="section-title"> <h2>'.trans('installer::app.seeders.shop.theme-customizations.game-container.content.title', [], $locale).'</h2> </div> <div class="section-gap container"> <div class="collection-card-wrapper"> <div class="single-collection-card"> <img src="" data-src="'.$this->storeFileIfExists('theme/8', 'static/'.$locale.'/8.webp', 'static/en/8.webp').'" class="lazy" width="615" height="600" alt="'.trans('installer::app.seeders.shop.theme-customizations.game-container.content.title', [], $locale).'"> <h3 class="overlay-text">'.trans('installer::app.seeders.shop.theme-customizations.game-container.content.sub-title-1', [], $locale).'</h3> </div> <div class="single-collection-card"> <img src="" data-src="'.$this->storeFileIfExists('theme/8', 'static/'.$locale.'/9.webp', 'static/en/9.webp').'" class="lazy" width="615" height="600" alt="'.trans('installer::app.seeders.shop.theme-customizations.game-container.content.title', [], $locale).'"> <h3 class="overlay-text"> '.trans('installer::app.seeders.shop.theme-customizations.game-container.content.sub-title-2', [], $locale).' </h3> </div> </div> </div> </div>',

                            'css'  => '.section-game {overflow: hidden;}.section-title,.section-title h2{font-weight:400;font-family:DM Serif Display}.section-title{margin-top:80px;padding-left:15px;padding-right:15px;text-align:center;line-height:90px}.section-title h2{font-size:70px;color:#060c3b;max-width:595px;margin:auto}.collection-card-wrapper{display:flex;flex-wrap:wrap;justify-content:center;gap:30px}.collection-card-wrapper .single-collection-card{position:relative}.collection-card-wrapper .single-collection-card img{border-radius:16px;background-color:#f5f5f5;max-width:100%;height:auto;text-indent:-9999px}.collection-card-wrapper .single-collection-card .overlay-text{font-size:50px;font-weight:400;max-width:234px;font-style:italic;color:#060c3b;font-family:DM Serif Display;position:absolute;bottom:30px;left:30px;margin:0}@media (max-width:1024px){.section-title{padding:0 30px}}@media (max-width:991px){.collection-card-wrapper{flex-wrap:wrap}}@media (max-width:768px) {.collection-card-wrapper .single-collection-card .overlay-text{font-size:32px; bottom:20px}.section-title{margin-top:32px}.section-title h2{font-size:28px;line-height:normal}} @media (max-width:525px){.collection-card-wrapper .single-collection-card .overlay-text{font-size:18px; bottom:10px} .section-title{margin-top:28px}.section-title h2{font-size:20px;} .collection-card-wrapper{gap:10px; 15px; row-gap:15px; column-gap:0px;justify-content: space-between;margin-top: 15px;} .collection-card-wrapper .single-collection-card {width:48%;}}',
                        ]),
                    ], [
                        'theme_customization_id' => 9,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'title'   => trans('installer::app.seeders.shop.theme-customizations.all-products.options.title', [], $locale),
                            'filters' => [
                                'sort'  => 'name-desc',
                                'limit' => 12,
                            ],
                        ]),
                    ], [
                        'theme_customization_id' => 10,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'html' => '<div class="section-gap bold-collections container"> <div class="inline-col-wrapper direction-rtl"> <div class="inline-col-image-wrapper"> <img src="" data-src="'.$this->storeFileIfExists('theme/10', 'static/'.$locale.'/10.webp', 'static/en/10.webp').'" class="lazy" width="632" height="510" alt="'.trans('installer::app.seeders.shop.theme-customizations.bold-collections.content.title', [], $locale).'"> </div> <div class="inline-col-content-wrapper direction-ltr"> <h2 class="inline-col-title"> '.trans('installer::app.seeders.shop.theme-customizations.bold-collections.content.title', [], $locale).' </h2> <p class="inline-col-description">'.trans('installer::app.seeders.shop.theme-customizations.bold-collections.content.description', [], $locale).'</p> <button class="primary-button max-md:rounded-lg max-md:px-4 max-md:py-2.5 max-md:text-sm">'.trans('installer::app.seeders.shop.theme-customizations.bold-collections.content.btn-title', [], $locale).'</button> </div> </div> </div>',

                            'css'  => '.section-gap{margin-top:80px}.direction-ltr{direction:ltr}.direction-rtl{direction:rtl}.inline-col-wrapper{display:grid;grid-template-columns:auto 1fr;grid-gap:60px;align-items:center}.inline-col-wrapper .inline-col-image-wrapper{overflow:hidden}.inline-col-wrapper .inline-col-image-wrapper img{max-width:100%;height:auto;border-radius:16px;text-indent:-9999px}.inline-col-wrapper .inline-col-content-wrapper{display:flex;flex-wrap:wrap;gap:20px;max-width:464px}.inline-col-wrapper .inline-col-content-wrapper .inline-col-title{max-width:442px;font-size:60px;font-weight:400;color:#060c3b;line-height:70px;font-family:DM Serif Display;margin:0}.inline-col-wrapper .inline-col-content-wrapper .inline-col-description{margin:0;font-size:18px;color:#6e6e6e;font-family:Poppins}@media (max-width:991px){.inline-col-wrapper{grid-template-columns:1fr;grid-gap:16px}.inline-col-wrapper .inline-col-content-wrapper{gap:10px}}@media (max-width:768px) {.inline-col-wrapper .inline-col-image-wrapper img {max-width:100%;}.inline-col-wrapper .inline-col-content-wrapper{max-width:100%;justify-content:center; text-align:center} .section-gap{padding:0 30px; gap:20px;margin-top:24px} .bold-collections{margin-top:32px;}} @media (max-width:525px){.inline-col-wrapper .inline-col-content-wrapper{gap:10px} .inline-col-wrapper .inline-col-content-wrapper .inline-col-title{font-size:20px;line-height:normal} .section-gap{padding:0 15px; gap:15px;margin-top:10px} .bold-collections{margin-top:28px;}  .inline-col-description{font-size:16px !important} .inline-col-wrapper{grid-gap:15px}',
                        ]),
                    ], [
                        'theme_customization_id' => 11,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'column_1' => [
                                [
                                    'url'        => $appUrl.'/page/about-us',
                                    'title'      => trans('installer::app.seeders.shop.theme-customizations.footer-links.options.about-us', [], $locale),
                                    'sort_order' => 1,
                                ], [
                                    'url'        => $appUrl.'/contact-us',
                                    'title'      => trans('installer::app.seeders.shop.theme-customizations.footer-links.options.contact-us', [], $locale),
                                    'sort_order' => 2,
                                ], [
                                    'url'        => $appUrl.'/page/customer-service',
                                    'title'      => trans('installer::app.seeders.shop.theme-customizations.footer-links.options.customer-service', [], $locale),
                                    'sort_order' => 3,
                                ], [
                                    'url'        => $appUrl.'/page/whats-new',
                                    'title'      => trans('installer::app.seeders.shop.theme-customizations.footer-links.options.whats-new', [], $locale),
                                    'sort_order' => 4,
                                ], [
                                    'url'        => $appUrl.'/page/terms-of-use',
                                    'title'      => trans('installer::app.seeders.shop.theme-customizations.footer-links.options.terms-of-use', [], $locale),
                                    'sort_order' => 5,
                                ], [
                                    'url'        => $appUrl.'/page/terms-conditions',
                                    'title'      => trans('installer::app.seeders.shop.theme-customizations.footer-links.options.terms-conditions', [], $locale),
                                    'sort_order' => 6,
                                ],
                            ],

                            'column_2' => [
                                [
                                    'url'        => $appUrl.'/page/privacy-policy',
                                    'title'      => trans('installer::app.seeders.shop.theme-customizations.footer-links.options.privacy-policy', [], $locale),
                                    'sort_order' => 1,
                                ], [
                                    'url'        => $appUrl.'/page/payment-policy',
                                    'title'      => trans('installer::app.seeders.shop.theme-customizations.footer-links.options.payment-policy', [], $locale),
                                    'sort_order' => 2,
                                ], [
                                    'url'        => $appUrl.'/page/shipping-policy',
                                    'title'      => trans('installer::app.seeders.shop.theme-customizations.footer-links.options.shipping-policy', [], $locale),
                                    'sort_order' => 3,
                                ], [
                                    'url'        => $appUrl.'/page/refund-policy',
                                    'title'      => trans('installer::app.seeders.shop.theme-customizations.footer-links.options.refund-policy', [], $locale),
                                    'sort_order' => 4,
                                ], [
                                    'url'        => $appUrl.'/page/return-policy',
                                    'title'      => trans('installer::app.seeders.shop.theme-customizations.footer-links.options.return-policy', [], $locale),
                                    'sort_order' => 5,
                                ],
                            ],
                        ]),
                    ], [
                        'theme_customization_id' => 12,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'services' => [
                                [
                                    'title'         => trans('installer::app.seeders.shop.theme-customizations.services-content.title.free-shipping', [], $locale),
                                    'description'   => trans('installer::app.seeders.shop.theme-customizations.services-content.description.free-shipping-info', [], $locale),
                                    'service_icon'  => 'icon-truck',
                                ], [
                                    'title'         => trans('installer::app.seeders.shop.theme-customizations.services-content.title.product-replace', [], $locale),
                                    'description'   => trans('installer::app.seeders.shop.theme-customizations.services-content.description.product-replace-info', [], $locale),
                                    'service_icon'  => 'icon-product',
                                ], [
                                    'title'         => trans('installer::app.seeders.shop.theme-customizations.services-content.title.emi-available', [], $locale),
                                    'description'   => trans('installer::app.seeders.shop.theme-customizations.services-content.description.emi-available-info', [], $locale),
                                    'service_icon'  => 'icon-dollar-sign',
                                ], [
                                    'title'         => trans('installer::app.seeders.shop.theme-customizations.services-content.title.time-support', [], $locale),
                                    'description'   => trans('installer::app.seeders.shop.theme-customizations.services-content.description.time-support-info', [], $locale),
                                    'service_icon'  => 'icon-support',
                                ],
                            ],
                        ]),
                    ], [
                        'theme_customization_id' => 13,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'html' => '<section class="mercado-solidario-hero">\r\n    <div class="hero-content">\r\n        <div class="hero-icon">\r\n            <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor">\r\n                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"\/>\r\n            <\/svg>\r\n        <\/div>\r\n        <h1 class="hero-title">Mercado Solidário<\/h1>\r\n        <p class="hero-subtitle">Projeto de Caridade da Igreja<\/p>\r\n        <p class="hero-description">Transformando vidas através da solidariedade cristã. Cada compra ajuda famílias em necessidade.<\/p>\r\n        <div class="hero-stats">\r\n            <div class="stat-item">\r\n                <span class="stat-number">500+<\/span>\r\n                <span class="stat-label">Famílias Ajudadas<\/span>\r\n            <\/div>\r\n          \r\n            <div class="stat-item">\r\n                <span class="stat-number">3<\/span>\r\n                <span class="stat-label">Anos de Missão<\/span>\r\n            <\/div>\r\n        <\/div>\r\n    <\/div>\r\n<\/section>',
                            'css'  => '.mercado-solidario-hero {\r\n    background: linear-gradient(135deg, rgba(245, 158, 11, 0.8) 0%, #15616f 100%);\r\n    color: white;\r\n    padding: 4rem 2rem;\r\n    text-align: center;\r\n    position: relative;\r\n    overflow: hidden;\r\n}\r\n.mercado-solidario-hero::before {\r\n    content:\'\';\r\n    position: absolute;\r\n    top: 0;\r\n    left: 0;\r\n    right: 0;\r\n    bottom: 0;\r\n    background: url(\'data:image\/svg+xml,<svg xmlns="http:\/\/www.w3.org\/2000\/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.08)"\/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.08)"\/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.08)"\/><\/svg>\');\r\n    opacity: 0.2;\r\n}\r\n.hero-content {\r\n    position: relative;\r\n    z-index: 2;\r\n    max-width: 1200px;\r\n    margin: 0 auto;\r\n}\r\n.hero-icon {\r\n    margin-bottom: 2rem;\r\n}\r\n.hero-icon svg {\r\n    color: rgba(255, 255, 255, 0.9);\r\n    animation: pulse-solidario 2s infinite;\r\n}\r\n.hero-title {\r\n    font-size: 3.5rem;\r\n    font-weight: 800;\r\n    margin-bottom: 1rem;\r\n    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);\r\n}\r\n.hero-subtitle {\r\n    font-size: 1.5rem;\r\n    margin-bottom: 1.5rem;\r\n    opacity: 0.9;\r\n    font-weight: 600;\r\n}\r\n.hero-description {\r\n    font-size: 1.25rem;\r\n    max-width: 800px;\r\n    margin: 0 auto 3rem;\r\n    line-height: 1.6;\r\n    opacity: 0.95;\r\n}\r\n.hero-stats {\r\n    display: flex;\r\n    justify-content: center;\r\n    gap: 3rem;\r\n    flex-wrap: wrap;\r\n}\r\n.stat-item {\r\n    display: flex;\r\n    flex-direction: column;\r\n    align-items: center;\r\n    gap: 0.5rem;\r\n}\r\n.stat-number {\r\n    font-size: 2.5rem;\r\n    font-weight: 800;\r\n    color: #fbbf24;\r\n}\r\n.stat-label {\r\n    font-size: 0.9rem;\r\n    opacity: 0.9;\r\n    text-transform: uppercase;\r\n    letter-spacing: 0.5px;\r\n}\r\n@keyframes pulse-solidario {\r\n    0%, 100% {\r\n        transform: scale(1);\r\n    }\r\n    50% {\r\n        transform: scale(1.05);\r\n    }\r\n}\r\n@media (max-width: 768px) {\r\n    .mercado-solidario-hero {\r\n        padding: 3rem 1rem;\r\n    }\r\n    .hero-title {\r\n        font-size: 2.5rem;\r\n    }\r\n    .hero-stats {\r\n        gap: 2rem;\r\n    }\r\n    .stat-number {\r\n        font-size: 2rem;\r\n    }\r\n}',
                        ]),
                    ], [
                        'theme_customization_id' => 14,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'html' => '<section class="valores-section">\r\n    <div class="container">\r\n        <h2 class="section-title">Nossos Valores Cristãos<\/h2>\r\n        <p class="section-subtitle">Princípios que guiam nossa missão de caridade<\/p>\r\n        \r\n        <div class="valores-grid">\r\n            <div class="valor-card">\r\n                <div class="valor-icon fe">\r\n                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">\r\n                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"\/>\r\n                    <\/svg>\r\n                <\/div>\r\n                <h3>Fé<\/h3>\r\n                <p>Nossa fé em Cristo é o fundamento de todo trabalho solidário que realizamos.<\/p>\r\n            <\/div>\r\n            \r\n            <div class="valor-card">\r\n                <div class="valor-icon solidariedade">\r\n                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">\r\n                        <path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zM12.1 18.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"\/>\r\n                    <\/svg>\r\n                <\/div>\r\n                <h3>Solidariedade<\/h3>\r\n                <p>Amor ao próximo é o princípio que move cada ação de caridade.<\/p>\r\n            <\/div>\r\n            \r\n            <div class="valor-card">\r\n               <div class="valor-icon transparencia">\r\n    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">\r\n        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"\/>\r\n    <\/svg>\r\n<\/div>\r\n                <h3>Transparência<\/h3>\r\n                <p>Compromisso total com a honestidade e clareza em todas as nossas ações.<\/p>\r\n            <\/div>\r\n            \r\n          \r\n        <\/div>\r\n    <\/div>\r\n<\/section>',
                            'css'  => '.valores-section {\r\n    background: linear-gradient(135deg, #fef7ed 0%, #e6f3f5 100%);\r\n    padding: 5rem 2rem;\r\n}\r\n\r\n.container {\r\n    max-width: 1200px;\r\n    margin: 0 auto;\r\n}\r\n\r\n.section-title {\r\n    text-align: center;\r\n    font-size: 3rem;\r\n    font-weight: 800;\r\n    color: #1f2937;\r\n    margin-bottom: 1rem;\r\n}\r\n\r\n.section-subtitle {\r\n    text-align: center;\r\n    font-size: 1.25rem;\r\n    color: #6b7280;\r\n    margin-bottom: 4rem;\r\n    max-width: 600px;\r\n    margin-left: auto;\r\n    margin-right: auto;\r\n}\r\n\r\n.valores-grid {\r\n    display: grid;\r\n    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));\r\n    gap: 2rem;\r\n}\r\n\r\n.valor-card {\r\n    background: white;\r\n    padding: 2.5rem 2rem;\r\n    border-radius: 1rem;\r\n    text-align: center;\r\n    box-shadow: 0 10px 25px rgba(0,0,0,0.08);\r\n    transition: all 0.3s ease;\r\n    border: 2px solid transparent;\r\n}\r\n\r\n.valor-card:hover {\r\n    transform: translateY(-8px);\r\n    box-shadow: 0 20px 40px rgba(0,0,0,0.12);\r\n    border-color: #f59e0b;\r\n}\r\n\r\n.valor-icon {\r\n    width: 80px;\r\n    height: 80px;\r\n    border-radius: 50%;\r\n    display: flex;\r\n    align-items: center;\r\n    justify-content: center;\r\n    margin: 0 auto 1.5rem;\r\n    transition: all 0.3s ease;\r\n}\r\n\r\n.valor-icon.fe {\r\n    background: linear-gradient(135deg, #f59e0b, #d97706);\r\n    color: white;\r\n}\r\n\r\n.valor-icon.solidariedade {\r\n    background: linear-gradient(135deg, #15616f, #0f4a57);\r\n    color: white;\r\n}\r\n\r\n.valor-icon.transparencia {\r\n    background: linear-gradient(135deg, #3b82f6, #2563eb);\r\n    color: white;\r\n}\r\n\r\n.valor-icon.compromisso {\r\n    background: linear-gradient(135deg, #f59e0b, #d97706);\r\n    color: white;\r\n}\r\n\r\n.valor-card:hover .valor-icon {\r\n    transform: scale(1.1);\r\n}\r\n\r\n.valor-title {\r\n    font-size: 1.5rem;\r\n    font-weight: 700;\r\n    color: #1f2937;\r\n    margin-bottom: 1rem;\r\n}\r\n\r\n.valor-description {\r\n    color: #6b7280;\r\n    line-height: 1.6;\r\n    font-size: 1rem;\r\n}\r\n\r\n@media (max-width: 768px) {\r\n    .valores-section {\r\n        padding: 3rem 1rem;\r\n    }\r\n    \r\n    .section-title {\r\n        font-size: 2.5rem;\r\n    }\r\n    \r\n    .valores-grid {\r\n        grid-template-columns: 1fr;\r\n        gap: 1.5rem;\r\n    }\r\n    \r\n    .valor-card {\r\n        padding: 2rem 1.5rem;\r\n    }\r\n}',
                        ]),
                    ], [
                        'theme_customization_id' => 15,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'html' => '<section class="como-funciona-section">\r\n    <div class="container">\r\n        <h2 class="section-title">Como Funciona Nossa Missão<\/h2>\r\n        <p class="section-subtitle">Entenda como cada compra ajuda a igreja e famílias em necessidade<\/p>\r\n        \r\n        <div class="timeline">\r\n            <div class="timeline-item">\r\n                <div class="timeline-number">1<\/div>\r\n                <div class="timeline-content">\r\n                    <div class="timeline-icon">\r\n                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">\r\n                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"\/>\r\n                        <\/svg>\r\n                    <\/div>\r\n                    <h3 class="timeline-title">Seleção de Produtos<\/h3>\r\n                    <p class="timeline-description">Selecionamos produtos de qualidade de parceiros comprometidos com nossa causa solidária.<\/p>\r\n                <\/div>\r\n            <\/div>\r\n            \r\n            <div class="timeline-item">\r\n                <div class="timeline-number">2<\/div>\r\n                <div class="timeline-content">\r\n                    <div class="timeline-icon">\r\n                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">\r\n                            <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03L21.7 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"\/>\r\n                        <\/svg>\r\n                    <\/div>\r\n                    <h3 class="timeline-title">Você Compra<\/h3>\r\n                    <p class="timeline-description">Você adquire produtos de qualidade sabendo que está ajudando uma causa nobre.<\/p>\r\n                <\/div>\r\n            <\/div>\r\n            \r\n            <div class="timeline-item">\r\n                <div class="timeline-number">3<\/div>\r\n                <div class="timeline-content">\r\n                    <div class="timeline-icon">\r\n                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">\r\n                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"\/>\r\n                        <\/svg>\r\n                    <\/div>\r\n                    <h3 class="timeline-title">Parte para a Igreja<\/h3>\r\n                    <p class="timeline-description"><strong>De cada compra, uma parte é direcionada para a igreja<\/strong> para manter nossos projetos de caridade e apoio comunitário.<\/p>\r\n                <\/div>\r\n            <\/div>\r\n            \r\n            <div class="timeline-item">\r\n                <div class="timeline-number">4<\/div>\r\n                <div class="timeline-content">\r\n                    <div class="timeline-icon">\r\n                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">\r\n                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"\/>\r\n                        <\/svg>\r\n                    <\/div>\r\n                    <h3 class="timeline-title">Transformação<\/h3>\r\n                    <p class="timeline-description">Famílias são ajudadas e vidas são transformadas através da solidariedade da igreja.<\/p>\r\n                <\/div>\r\n            <\/div>\r\n        <\/div>\r\n    <\/div>\r\n<\/section>',
                            'css'  => '.como-funciona-section {\r\n    background: white;\r\n    padding: 5rem 2rem;\r\n}\r\n\r\n.container {\r\n    max-width: 1200px;\r\n    margin: 0 auto;\r\n}\r\n\r\n.section-title {\r\n    text-align: center;\r\n    font-size: 3rem;\r\n    font-weight: 800;\r\n    color: #1f2937;\r\n    margin-bottom: 1rem;\r\n}\r\n\r\n.section-subtitle {\r\n    text-align: center;\r\n    font-size: 1.25rem;\r\n    color: #6b7280;\r\n    margin-bottom: 4rem;\r\n    max-width: 700px;\r\n    margin-left: auto;\r\n    margin-right: auto;\r\n}\r\n\r\n.timeline {\r\n    position: relative;\r\n    max-width: 800px;\r\n    margin: 0 auto;\r\n    padding: 2rem 0;\r\n}\r\n\r\n.timeline::before {\r\n    content: \'\';\r\n    position: absolute;\r\n    left: 50%;\r\n    top: 0;\r\n    bottom: 0;\r\n    width: 4px;\r\n    background: linear-gradient(135deg, #f59e0b, #15616f);\r\n    transform: translateX(-50%);\r\n}\r\n\r\n.timeline-item {\r\n    position: relative;\r\n    margin-bottom: 3rem;\r\n    display: flex;\r\n    align-items: center;\r\n}\r\n\r\n.timeline-item:nth-child(odd) {\r\n    flex-direction: row;\r\n}\r\n\r\n.timeline-item:nth-child(even) {\r\n    flex-direction: row-reverse;\r\n}\r\n\r\n.timeline-number {\r\n    position: absolute;\r\n    left: 50%;\r\n    top: 0;\r\n    width: 60px;\r\n    height: 60px;\r\n    background: linear-gradient(135deg, #f59e0b, #15616f);\r\n    color: white;\r\n    border-radius: 50%;\r\n    display: flex;\r\n    align-items: center;\r\n    justify-content: center;\r\n    font-size: 1.5rem;\r\n    font-weight: 800;\r\n    transform: translateX(-50%);\r\n    z-index: 2;\r\n    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.2);\r\n}\r\n\r\n.timeline-content {\r\n    width: 45%;\r\n    padding: 2rem;\r\n    background: white;\r\n    border-radius: 1rem;\r\n    box-shadow: 0 10px 25px rgba(0,0,0,0.08);\r\n    position: relative;\r\n    border: 2px solid transparent;\r\n    transition: all 0.3s ease;\r\n}\r\n\r\n.timeline-content:hover {\r\n    border-color: #f59e0b;\r\n    transform: translateY(-2px);\r\n}\r\n\r\n.timeline-item:nth-child(odd) .timeline-content {\r\n    margin-right: 55%;\r\n}\r\n\r\n.timeline-item:nth-child(even) .timeline-content {\r\n    margin-left: 55%;\r\n}\r\n\r\n.timeline-icon {\r\n    width: 48px;\r\n    height: 48px;\r\n    background: linear-gradient(135deg, #fef7ed, #e6f3f5);\r\n    border-radius: 50%;\r\n    display: flex;\r\n    align-items: center;\r\n    justify-content: center;\r\n    color: #f59e0b;\r\n    margin-bottom: 1rem;\r\n}\r\n\r\n.timeline-title {\r\n    font-size: 1.25rem;\r\n    font-weight: 700;\r\n    color: #1f2937;\r\n    margin-bottom: 0.75rem;\r\n}\r\n\r\n.timeline-description {\r\n    color: #6b7280;\r\n    line-height: 1.6;\r\n}\r\n\r\n.timeline-description strong {\r\n    color: #15616f;\r\n    font-weight: 700;\r\n}\r\n\r\n@media (max-width: 768px) {\r\n    .como-funciona-section {\r\n        padding: 3rem 1rem;\r\n    }\r\n    \r\n    .section-title {\r\n        font-size: 2.5rem;\r\n    }\r\n    \r\n    .timeline::before {\r\n        left: 30px;\r\n    }\r\n    \r\n    .timeline-item {\r\n        flex-direction: row !important;\r\n        margin-left: 60px;\r\n    }\r\n    \r\n    .timeline-number {\r\n        left: 30px;\r\n        transform: none;\r\n    }\r\n    \r\n    .timeline-content {\r\n        width: calc(100% - 60px);\r\n        margin: 0 !important;\r\n    }\r\n}',
                        ]),
                    ], [
                        'theme_customization_id' => 16,
                        'locale'                 => $locale,
                        'options'                => json_encode([
                            'html' => '<section class="sobre-projeto-section">\r\n    <div class="container">\r\n        <h2 class="section-title">Sobre o Projeto Mercado Solidário<\/h2>\r\n        <p class="section-subtitle">Conheça mais sobre nossa iniciativa de caridade<\/p>\r\n        \r\n        <div class="sobre-grid">\r\n            <div class="sobre-card">\r\n                <div class="sobre-icon">\r\n                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">\r\n                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"\/>\r\n                    <\/svg>\r\n                <\/div>\r\n                <h3 class="sobre-titulo">Nossa Origem<\/h3>\r\n                <p class="sobre-descricao">O Mercado Solidário nasceu do coração da igreja, movido pelo desejo de fazer a diferença na vida das famílias em necessidade.<\/p>\r\n            <\/div>\r\n            \r\n            <div class="sobre-card">\r\n                <div class="sobre-icon">\r\n                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">\r\n                        <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A1.5 1.5 0 0 0 18.54 8H17c-.8 0-1.54.37-2.01 1L12 12.5V8c0-.55-.45-1-1-1s-1 .45-1 1v6.5L9.01 9C8.54 8.37 7.8 8 7 8H5.46c-.8 0-1.54.37-2.01 1L1 16.5V22h2v-6h2.5l2.54 7.63A1.5 1.5 0 0 0 9.54 22H11c.8 0 1.54-.37 2.01-1L16 15.5V22h2v-6h2z"\/>\r\n                    <\/svg>\r\n                <\/div>\r\n                <h3 class="sobre-titulo">Nossa Missão<\/h3>\r\n                <p class="sobre-descricao">Conectar pessoas que querem ajudar com aquelas que precisam de apoio, criando um ciclo de solidariedade e amor cristão.<\/p>\r\n            <\/div>\r\n            \r\n            <div class="sobre-card">\r\n                <div class="sobre-icon">\r\n                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">\r\n                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"\/>\r\n                    <\/svg>\r\n                <\/div>\r\n                <h3 class="sobre-titulo">Nosso Impacto<\/h3>\r\n                <p class="sobre-descricao">Em apenas 3 anos, já ajudamos mais de 500 famílias através de nossos projetos de caridade e apoio comunitário.<\/p>\r\n            <\/div>\r\n        <\/div>\r\n        \r\n        <div class="sobre-info">\r\n            <h3>Por que o Mercado Solidário?<\/h3>\r\n            <p>Nossa abordagem única combina comércio justo com caridade cristã, permitindo que cada compra tenha um impacto positivo na vida de famílias necessitadas.<\/p>\r\n        <\/div>\r\n    <\/div>\r\n<\/section>',
                            'css'  => '.sobre-projeto-section {\r\n    background: white;\r\n    padding: 5rem 2rem;\r\n}\r\n\r\n.container {\r\n    max-width: 1200px;\r\n    margin: 0 auto;\r\n}\r\n\r\n.section-title {\r\n    text-align: center;\r\n    font-size: 3rem;\r\n    font-weight: 800;\r\n    color: #1f2937;\r\n    margin-bottom: 1rem;\r\n}\r\n\r\n.section-subtitle {\r\n    text-align: center;\r\n    font-size: 1.25rem;\r\n    color: #6b7280;\r\n    margin-bottom: 4rem;\r\n    max-width: 600px;\r\n    margin-left: auto;\r\n    margin-right: auto;\r\n}\r\n\r\n.sobre-grid {\r\n    display: grid;\r\n    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));\r\n    gap: 2rem;\r\n    margin-bottom: 4rem;\r\n}\r\n\r\n.sobre-card {\r\n    background: linear-gradient(135deg, rgba(254, 247, 237, 0.8) 0%, rgba(230, 243, 245, 0.8) 100%);\r\n    /* Creme e azul pastel com 80% de opacidade */\r\n    padding: 2.5rem 2rem;\r\n    border-radius: 1rem;\r\n    text-align: center;\r\n    border: 2px solid transparent;\r\n    transition: all 0.3s ease;\r\n}\r\n\r\n.sobre-card:hover {\r\n    transform: translateY(-5px);\r\n    border-color: rgba(245, 158, 11, 0.7); /* Dourado com 70% de opacidade */\r\n    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);\r\n}\r\n\r\n.sobre-icon {\r\n    width: 80px;\r\n    height: 80px;\r\n    background: linear-gradient(135deg, rgba(245, 158, 11, 0.7), rgba(21, 97, 111, 0.8));\r\n    /* Dourado com 70% e teal com 80% de opacidade */\r\n    border-radius: 50%;\r\n    display: flex;\r\n    align-items: center;\r\n    justify-content: center;\r\n    color: white;\r\n    margin: 0 auto 1.5rem;\r\n}\r\n\r\n.sobre-titulo {\r\n    font-size: 1.5rem;\r\n    font-weight: 700;\r\n    color: #1f2937;\r\n    margin-bottom: 1rem;\r\n}\r\n\r\n.sobre-descricao {\r\n    color: #6b7280;\r\n    line-height: 1.6;\r\n}\r\n\r\n.sobre-info {\r\n    background: linear-gradient(135deg, rgba(245, 158, 11, 0.7), rgba(21, 97, 111, 0.8));\r\n    /* Dourado com 70% e teal com 80% de opacidade */\r\n    color: white;\r\n    padding: 3rem 2rem;\r\n    border-radius: 1rem;\r\n    text-align: center;\r\n    max-width: 800px;\r\n    margin: 0 auto;\r\n}\r\n\r\n.sobre-info h3 {\r\n    font-size: 2rem;\r\n    margin-bottom: 1.5rem;\r\n}\r\n\r\n.sobre-info p {\r\n    font-size: 1.1rem;\r\n    line-height: 1.6;\r\n    opacity: 0.9;\r\n}\r\n\r\n@media (max-width: 768px) {\r\n    .sobre-grid {\r\n        grid-template-columns: 1fr;\r\n    }\r\n}',
                        ]),
                    ],
                ]);
        }
    }

    /**
     * Store image in storage.
     *
     * @return void
     */
    public function storeFileIfExists($targetPath, $file, $default = null)
    {
        if (file_exists(base_path(self::BASE_PATH.$file))) {
            return 'storage/'.Storage::putFile($targetPath, new File(base_path(self::BASE_PATH.$file)));
        }

        if (! $default) {
            return;
        }

        if (file_exists(base_path(self::BASE_PATH.$default))) {
            return 'storage/'.Storage::putFile($targetPath, new File(base_path(self::BASE_PATH.$default)));
        }
    }
}
