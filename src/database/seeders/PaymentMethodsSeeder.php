<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = ['カード払い', 'コンビニ払い'];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(['name' => $method]);
        }
    }
}
