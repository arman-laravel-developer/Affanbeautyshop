<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = array(
            array('id' => '1', 'country_id' => '18' ,'name' => 'Chattagram','bn_name' => 'চট্টগ্রাম','url' => 'www.chittagongdiv.gov.bd'),
            array('id' => '2', 'country_id' => '18' ,'name' => 'Rajshahi','bn_name' => 'রাজশাহী','url' => 'www.rajshahidiv.gov.bd'),
            array('id' => '3', 'country_id' => '18' ,'name' => 'Khulna','bn_name' => 'খুলনা','url' => 'www.khulnadiv.gov.bd'),
            array('id' => '4', 'country_id' => '18' ,'name' => 'Barisal','bn_name' => 'বরিশাল','url' => 'www.barisaldiv.gov.bd'),
            array('id' => '5', 'country_id' => '18' ,'name' => 'Sylhet','bn_name' => 'সিলেট','url' => 'www.sylhetdiv.gov.bd'),
            array('id' => '6', 'country_id' => '18' ,'name' => 'Dhaka','bn_name' => 'ঢাকা','url' => 'www.dhakadiv.gov.bd'),
            array('id' => '7', 'country_id' => '18' ,'name' => 'Rangpur','bn_name' => 'রংপুর','url' => 'www.rangpurdiv.gov.bd'),
            array('id' => '8', 'country_id' => '18' ,'name' => 'Mymensingh','bn_name' => 'ময়মনসিংহ','url' => 'www.mymensinghdiv.gov.bd')
        );

        DB::table('divisions')->insert($divisions);

    }
}
