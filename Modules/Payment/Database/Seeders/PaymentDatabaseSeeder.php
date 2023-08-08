<?php

namespace Modules\Payment\Database\Seeders;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
=======
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
>>>>>>> origin/module/payment

class PaymentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
    }
}
