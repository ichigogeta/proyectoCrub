<?php

use Illuminate\Database\Seeder;

class WebSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'field' => 'company_name',
                'value' => 'Company Name'
            ],
            [
                'field' => 'company_cif',
                'value' => 'A2363586E'
            ],
            [
                'field' => 'company_address',
                'value' => 'Avenida de ejemplo, 123'
            ],
            [
                'field' => 'company_address2',
                'value' => 'Avenida de ejemplo dirección 2, 456'
            ],
            [
                'field' => 'company_bank_account',
                'value' => 'CH1504845095754571001'
            ],
            [
                'field' => 'company_email',
                'value' => 'info@example.com'
            ],
            [
                'field' => 'company_phone',
                'value' => '+34123123123'
            ],
            [
                'field' => 'company_fax',
                'value' => '+34123123123'
            ],
            [
                'field' => 'company_country',
                'value' => 'Spain'
            ],
            [
                'field' => 'iva',
                'value' => '21'
            ],
        ];

        foreach ($datas as $data){
            $webConfig = \App\WebSetting::firstOrCreate($data);
        }
    }
}
