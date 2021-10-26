<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Province::create([
            'id' => Uuid::uuid4()->toString(),
            'province' => 'asdfaskfjdals',
        ]);
    }
}
