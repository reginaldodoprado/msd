<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ThemeCustomizationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('theme_customizations')->delete();
        
        \DB::table('theme_customizations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'image_carousel',
                'name' => 'Carrossel de Imagens',
                'sort_order' => 1,
                'status' => 0,
                'channel_id' => 1,
                'created_at' => '2025-08-13 11:34:37',
                'updated_at' => '2025-08-15 15:33:32',
            ),
            1 => 
            array (
                'id' => 2,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'static_content',
                'name' => 'Informações de Oferta',
                'sort_order' => 2,
                'status' => 0,
                'channel_id' => 1,
                'created_at' => '2025-08-13 11:34:37',
                'updated_at' => '2025-08-15 15:33:40',
            ),
            2 => 
            array (
                'id' => 3,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'category_carousel',
                'name' => 'Coleções de Categorias',
                'sort_order' => 3,
                'status' => 0,
                'channel_id' => 1,
                'created_at' => '2025-08-13 11:34:37',
                'updated_at' => '2025-08-15 15:32:40',
            ),
            3 => 
            array (
                'id' => 4,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'product_carousel',
                'name' => 'Novos Produtos',
                'sort_order' => 4,
                'status' => 0,
                'channel_id' => 1,
                'created_at' => '2025-08-13 11:34:37',
                'updated_at' => '2025-08-15 15:32:31',
            ),
            4 => 
            array (
                'id' => 5,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'static_content',
                'name' => 'Melhores Coleções',
                'sort_order' => 5,
                'status' => 0,
                'channel_id' => 1,
                'created_at' => '2025-08-13 11:34:37',
                'updated_at' => '2025-08-15 15:17:03',
            ),
            5 => 
            array (
                'id' => 6,
                'theme_code' => 'default',
                'type' => 'static_content',
                'name' => 'Coleções Audaciosas',
                'sort_order' => 6,
                'status' => 1,
                'channel_id' => 1,
                'created_at' => '2025-08-13 11:34:37',
                'updated_at' => '2025-08-15 16:30:08',
            ),
            6 => 
            array (
                'id' => 7,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'product_carousel',
                'name' => 'Coleções em Destaque',
                'sort_order' => 7,
                'status' => 0,
                'channel_id' => 1,
                'created_at' => '2025-08-13 11:34:37',
                'updated_at' => '2025-08-15 15:14:03',
            ),
            7 => 
            array (
                'id' => 8,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'static_content',
                'name' => 'Contêiner de Jogo',
                'sort_order' => 8,
                'status' => 0,
                'channel_id' => 1,
                'created_at' => '2025-08-13 11:34:37',
                'updated_at' => '2025-08-15 15:13:41',
            ),
            8 => 
            array (
                'id' => 9,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'product_carousel',
                'name' => 'Todos os Produtos',
                'sort_order' => 9,
                'status' => 0,
                'channel_id' => 1,
                'created_at' => '2025-08-13 11:34:37',
                'updated_at' => '2025-08-15 15:14:18',
            ),
            9 => 
            array (
                'id' => 10,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'static_content',
                'name' => 'Coleções Audaciosas',
                'sort_order' => 10,
                'status' => 0,
                'channel_id' => 1,
                'created_at' => '2025-08-13 11:34:37',
                'updated_at' => '2025-08-15 15:14:25',
            ),
            10 => 
            array (
                'id' => 11,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'footer_links',
                'name' => 'Links do Rodapé',
                'sort_order' => 11,
                'status' => 1,
                'channel_id' => 1,
                'created_at' => '2025-08-13 11:34:37',
                'updated_at' => '2025-08-15 17:18:37',
            ),
            11 => 
            array (
                'id' => 12,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'services_content',
                'name' => 'Conteúdo de serviços',
                'sort_order' => 12,
                'status' => 0,
                'channel_id' => 1,
                'created_at' => '2025-08-13 11:34:37',
                'updated_at' => '2025-08-15 15:15:05',
            ),
            12 => 
            array (
                'id' => 13,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'static_content',
                'name' => 'Banner Missao Solidaria',
                'sort_order' => 1,
                'status' => 1,
                'channel_id' => 1,
                'created_at' => '2025-08-15 14:26:52',
                'updated_at' => '2025-08-18 08:30:07',
            ),
            13 => 
            array (
                'id' => 14,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'static_content',
                'name' => 'Nossos Valores',
                'sort_order' => 3,
                'status' => 1,
                'channel_id' => 1,
                'created_at' => '2025-08-15 14:29:21',
                'updated_at' => '2025-08-15 16:59:38',
            ),
            14 => 
            array (
                'id' => 15,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'static_content',
                'name' => 'Como funciona',
                'sort_order' => 2,
                'status' => 1,
                'channel_id' => 1,
                'created_at' => '2025-08-15 14:38:28',
                'updated_at' => '2025-08-15 17:04:42',
            ),
            15 => 
            array (
                'id' => 16,
                'theme_code' => 'mercado-solidario-tema',
                'type' => 'static_content',
                'name' => 'Sobre o Projeto',
                'sort_order' => 4,
                'status' => 1,
                'channel_id' => 1,
                'created_at' => '2025-08-15 15:10:49',
                'updated_at' => '2025-08-15 17:01:12',
            ),
        ));
        
        
    }
}