<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Voucher;
use App\VoucherProduct;
use App\DiscountTier;
use App\ApiSetting;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('ProductsTableSeeder');
        $this->call('DiscountTierTableSeeder');
        $this->call('VoucherTableSeeder');
        $this->call('ProductsTableSeeder');
        $this->call('ApiSettingsTableSeeder');
    }
}

class ProductsTableSeeder extends Seeder {

    public function run()
    {
        Product::create(array(
            'name' => 'apple iPhone 7',
            'price' => '27000',
        ));
        Product::create(array(
            'name' => 'HTC One X10',
            'price' => '12000',
        ));
        Product::create(array(
            'name' => 'Motorola Moto Z',
            'price' => '17000',
        ));
        Product::create(array(
            'name' => 'Huawei P10',
            'price' => '16499',
        ));
        Product::create(array(
            'name' => 'iPhone 6s',
            'price' => '17999',
        ));Product::create(array(
        'name' => 'Samsung Galaxy S8',
        'price' => '24999',
    ));
    }

}

class DiscountTierTableSeeder extends Seeder {

    public function run()
    {

        DiscountTier::create(array('percent' => '10'));
        DiscountTier::create(array('percent' => '15'));
        DiscountTier::create(array('percent' => '20'));
        DiscountTier::create(array('percent' => '25'));
    }

}

class VoucherTableSeeder extends Seeder {

    public function run()
    {
        Voucher::create(array(
            'IDs' => '789845651232',
            'start_date' => '2017-06-10',
            'end_date' => '2017-07-10',
            'discount_tiers_id' => 1,
        ));
        Voucher::create(array(
            'IDs' => '132346567989',
            'start_date' => '2017-06-10',
            'end_date' => '2017-07-10',
            'discount_tiers_id' => 4,
        ));
    }

}

class VoucherProductTableSeeder extends Seeder {

    public function run()
    {
        ApiSetting::create(array(
            'products_id' => '1',
            'vouchers_id' => '1',
        ));
        VoucherProduct::create(array(
            'products_id' => '5',
            'vouchers_id' => '1',
        ));
        VoucherProduct::create(array(
            'products_id' => '1',
            'vouchers_id' => '2',
        ));
        VoucherProduct::create(array(
            'products_id' => '4',
            'vouchers_id' => '2',
        ));
    }

}

class ApiSettingsTableSeeder extends Seeder {

    public function run()
    {
        ApiSetting::create(array(
            'name' => 'api key for tests',
            'key' => 'firstKey',
            'secret' => 'aallsskk33'
        ));

    }

}


