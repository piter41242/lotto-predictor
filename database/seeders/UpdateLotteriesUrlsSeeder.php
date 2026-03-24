<?php

namespace Database\Seeders;

use App\Models\Lottery;
use Illuminate\Database\Seeder;

class UpdateLotteriesUrlsSeeder extends Seeder
{
    public function run(): void
    {
        $urls = [
            // ========== LOTERÍAS TRADICIONALES ==========
            [
                'code' => 'medellin',
                'api_url' => 'https://www.loteriamedellin.com.co/resultados',
                'scraper_url' => 'https://www.loteriamedellin.com.co/resultados-anteriores',
            ],
            [
                'code' => 'bogota',
                'api_url' => 'https://www.loterias.com.co/bogota/resultados',
                'scraper_url' => 'https://www.loterias.com.co/bogota/resultados-anteriores',
            ],
            [
                'code' => 'huila',
                'api_url' => 'https://www.loterias.com.co/huila/resultados',
                'scraper_url' => 'https://www.loterias.com.co/huila/resultados-anteriores',
            ],
            [
                'code' => 'tolima',
                'api_url' => 'https://www.loterias.com.co/tolima/resultados',
                'scraper_url' => 'https://www.loterias.com.co/tolima/resultados-anteriores',
            ],
            [
                'code' => 'manizales',
                'api_url' => 'https://www.loterias.com.co/manizales/resultados',
                'scraper_url' => 'https://www.loterias.com.co/manizales/resultados-anteriores',
            ],
            [
                'code' => 'boyaca',
                'api_url' => 'https://www.loterias.com.co/boyaca/resultados',
                'scraper_url' => 'https://www.loterias.com.co/boyaca/resultados-anteriores',
            ],
            [
                'code' => 'quindio',
                'api_url' => 'https://www.loterias.com.co/quindio/resultados',
                'scraper_url' => 'https://www.loterias.com.co/quindio/resultados-anteriores',
            ],
            [
                'code' => 'cundinamarca',
                'api_url' => 'https://www.loterias.com.co/cundinamarca/resultados',
                'scraper_url' => 'https://www.loterias.com.co/cundinamarca/resultados-anteriores',
            ],
            [
                'code' => 'santander',
                'api_url' => 'https://www.loterias.com.co/santander/resultados',
                'scraper_url' => 'https://www.loterias.com.co/santander/resultados-anteriores',
            ],
            [
                'code' => 'valle',
                'api_url' => 'https://www.loterias.com.co/valle/resultados',
                'scraper_url' => 'https://www.loterias.com.co/valle/resultados-anteriores',
            ],
            [
                'code' => 'cruz_roja',
                'api_url' => 'https://www.loterias.com.co/cruz-roja/resultados',
                'scraper_url' => 'https://www.loterias.com.co/cruz-roja/resultados-anteriores',
            ],
            [
                'code' => 'risaralda',
                'api_url' => 'https://www.loterias.com.co/risaralda/resultados',
                'scraper_url' => 'https://www.loterias.com.co/risaralda/resultados-anteriores',
            ],
            [
                'code' => 'cauca',
                'api_url' => 'https://www.loterias.com.co/cauca/resultados',
                'scraper_url' => 'https://www.loterias.com.co/cauca/resultados-anteriores',
            ],
            [
                'code' => 'narino',
                'api_url' => 'https://www.loterias.com.co/narino/resultados',
                'scraper_url' => 'https://www.loterias.com.co/narino/resultados-anteriores',
            ],
            [
                'code' => 'atlantico',
                'api_url' => 'https://www.loterias.com.co/atlantico/resultados',
                'scraper_url' => 'https://www.loterias.com.co/atlantico/resultados-anteriores',
            ],
            [
                'code' => 'meta',
                'api_url' => 'https://www.loterias.com.co/meta/resultados',
                'scraper_url' => 'https://www.loterias.com.co/meta/resultados-anteriores',
            ],
            [
                'code' => 'sucre',
                'api_url' => 'https://www.loterias.com.co/sucre/resultados',
                'scraper_url' => 'https://www.loterias.com.co/sucre/resultados-anteriores',
            ],
            [
                'code' => 'cordoba',
                'api_url' => 'https://www.loterias.com.co/cordoba/resultados',
                'scraper_url' => 'https://www.loterias.com.co/cordoba/resultados-anteriores',
            ],
            [
                'code' => 'casanare',
                'api_url' => 'https://www.loterias.com.co/casanare/resultados',
                'scraper_url' => 'https://www.loterias.com.co/casanare/resultados-anteriores',
            ],
            [
                'code' => 'magdalena',
                'api_url' => 'https://www.loterias.com.co/magdalena/resultados',
                'scraper_url' => 'https://www.loterias.com.co/magdalena/resultados-anteriores',
            ],
            [
                'code' => 'caribe',
                'api_url' => 'https://www.loterias.com.co/caribe/resultados',
                'scraper_url' => 'https://www.loterias.com.co/caribe/resultados-anteriores',
            ],
            [
                'code' => 'sabana',
                'api_url' => 'https://www.loterias.com.co/sabana/resultados',
                'scraper_url' => 'https://www.loterias.com.co/sabana/resultados-anteriores',
            ],
            [
                'code' => 'cali',
                'api_url' => 'https://www.loterias.com.co/cali/resultados',
                'scraper_url' => 'https://www.loterias.com.co/cali/resultados-anteriores',
            ],

            // ========== CHANCES DORADO ==========
            [
                'code' => 'dorado_dia',
                'api_url' => 'https://www.eldorado.com.co/resultados/dia',
                'scraper_url' => 'https://www.eldorado.com.co/resultados-anteriores/dia',
            ],
            [
                'code' => 'dorado_tarde',
                'api_url' => 'https://www.eldorado.com.co/resultados/tarde',
                'scraper_url' => 'https://www.eldorado.com.co/resultados-anteriores/tarde',
            ],
            [
                'code' => 'dorado_noche',
                'api_url' => 'https://www.eldorado.com.co/resultados/noche',
                'scraper_url' => 'https://www.eldorado.com.co/resultados-anteriores/noche',
            ],

            // ========== CHANCES ANTIOQUEÑITA ==========
            [
                'code' => 'antioquenita_dia',
                'api_url' => 'https://www.antioquenita.com/resultados/dia',
                'scraper_url' => 'https://www.antioquenita.com/resultados-anteriores/dia',
            ],
            [
                'code' => 'antioquenita_tarde',
                'api_url' => 'https://www.antioquenita.com/resultados/tarde',
                'scraper_url' => 'https://www.antioquenita.com/resultados-anteriores/tarde',
            ],

            // ========== CHANCES FANTÁSTICA ==========
            [
                'code' => 'fantastica_dia',
                'api_url' => 'https://www.fantastica.com.co/resultados/dia',
                'scraper_url' => 'https://www.fantastica.com.co/resultados-anteriores/dia',
            ],
            [
                'code' => 'fantastica_noche',
                'api_url' => 'https://www.fantastica.com.co/resultados/noche',
                'scraper_url' => 'https://www.fantastica.com.co/resultados-anteriores/noche',
            ],

            // ========== CHANCES PAISITA ==========
            [
                'code' => 'paisita_dia',
                'api_url' => 'https://www.paisita.com/resultados/dia',
                'scraper_url' => 'https://www.paisita.com/resultados-anteriores/dia',
            ],
            [
                'code' => 'paisita_noche',
                'api_url' => 'https://www.paisita.com/resultados/noche',
                'scraper_url' => 'https://www.paisita.com/resultados-anteriores/noche',
            ],

            // ========== CHANCES CHONTICO ==========
            [
                'code' => 'chontico_dia',
                'api_url' => 'https://www.chontico.com/resultados/dia',
                'scraper_url' => 'https://www.chontico.com/resultados-anteriores/dia',
            ],
            [
                'code' => 'chontico_noche',
                'api_url' => 'https://www.chontico.com/resultados/noche',
                'scraper_url' => 'https://www.chontico.com/resultados-anteriores/noche',
            ],

            // ========== PIJAO DE ORO ==========
            [
                'code' => 'pijao_oro',
                'api_url' => 'https://www.pijaodeoro.com/resultados',
                'scraper_url' => 'https://www.pijaodeoro.com/resultados-anteriores',
            ],

            // ========== SUPER ASTRO ==========
            [
                'code' => 'super_astro_sol',
                'api_url' => 'https://www.superastro.com.co/resultados/sol',
                'scraper_url' => 'https://www.superastro.com.co/resultados-anteriores/sol',
            ],
            [
                'code' => 'super_astro_luna',
                'api_url' => 'https://www.superastro.com.co/resultados/luna',
                'scraper_url' => 'https://www.superastro.com.co/resultados-anteriores/luna',
            ],

            // ========== CHANCE NACIONAL ==========
            [
                'code' => 'chance_nacional',
                'api_url' => 'https://www.loterias.com.co/chance-nacional/resultados',
                'scraper_url' => 'https://www.loterias.com.co/chance-nacional/resultados-anteriores',
            ],
        ];

        foreach ($urls as $data) {
            Lottery::where('code', $data['code'])->update([
                'api_url' => $data['api_url']
            ]);
        }

        $this->command->info('✅ URLs actualizadas para ' . count($urls) . ' loterías');
    }
}