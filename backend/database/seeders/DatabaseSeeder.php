<?php

/**
* This file is part of the Sandy Andryanto Online Store Website.
*
* @author     Sandy Andryanto <sandy.andryanto.blade@gmail.com>
* @copyright  2025
*
* For the full copyright and license information,
* please view the LICENSE.md file that was distributed
* with this source code.
*/

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $total = Models\User::Count();
        if($total == 0)
        {
            $this->CreateUser();
            $this->CreateSetting();
            $this->CreateCategories();
            $this->CreateBrands();
            $this->CreateColours();
            $this->CreatePayment();
            $this->CreateSize();
            $this->CreateProduct();
        }
    }

    private function CreateUser()
    {
        for($i = 1; $i <=10; $i++)
        {
            $faker = Faker::create();
            $user =  new Models\User();
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->email = $faker->safeEmail;
            $user->password = Hash::make("Qwerty123!");
            $user->phone = $faker->phoneNumber;
            $user->city = $faker->city;
            $user->country = $faker->country;
            $user->zip_code = $faker->postcode;
            $user->address = $faker->streetAddress;
            $user->status = 1;
            $user->remember_token = $faker->uuid;
            $user->save();

            $auth = new Models\Authentication();
            $auth->user_id = $user->id;
            $auth->type = "email-verification";
            $auth->credential = $user->email;
            $auth->token = $faker->uuid;
            $auth->expired_at = date("Y-m-d H:i:s");
            $auth->status = 1;
            $auth->save();

        }
    }

    private function CreateProduct()
    {

        $description = "
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur
            adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        ";

        $details = "
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        ";

        for($i = 1; $i <=9; $i++)
        {
            $brand = Models\Brand::inRandomOrder()->first();
            $product = new Models\Product();
            $product->brand_id = $brand->id;
            $product->sku = "P00".$i;
            $product->name = "Product ".$i;
            $product->price = rand(100, 999);
            $product->published_date = date("Y-m-d");
            $product->description = $description;
            $product->details = $details;
            $product->status = 1;
            $product->save();

            $categories = Models\Category::inRandomOrder()->limit(3)->get()->pluck("id")->toArray();
            $product->Categories()->sync($categories);
            $reviewers = Models\User::inRandomOrder()->limit(5)->get();

            foreach($reviewers as $reviewer)
            {
                $pr = new Models\ProductReview();
                $pr->product_id = $product->id;
                $pr->user_id = $reviewer->id;
                $pr->rating = rand(0,100);
                $pr->review = $description;
                $pr->status = 1;
                $pr->save();
            }

            for($in = 0; $in < 3; $in++)
            {
                $image = rand(0, 8);
                $path = $this->ProductImages()[$image];
                $pi = new Models\ProductImage();
                $pi->product_id = $product->id;
                $pi->path = $path;
                $pi->sort = ($in+1);
                $pi->status = $in == 0 ? 1 : 0;
                $pi->save();
            }

            $sizes = Models\Size::All();
            $colours = Models\Colour::All();

            foreach($sizes as $size)
            {
                foreach($colours as $colur)
                {
                    $inv = new Models\ProductInventory();
                    $inv->product_id = $product->id;
                    $inv->size_id = $size->id;
                    $inv->color_id = $colur->id;
                    $inv->stock = rand(1, 50);
                    $inv->status = 1;
                    $inv->save();
                }
            }


        }
    }

    private function CreateCategories()
    {
        $items = ["Laptop", "Smartphone", "Camera", "Accessories", "Others"];

        foreach($items as $item)
        {
            Models\Category::create(["name"=> $item, "status"=> 1]);
        }

    }

    private function CreateBrands()
    {
        $items = ["Samsung", "LG", "Sony", "Apple", "Microsoft"];

        foreach($items as $item)
        {
            Models\Brand::create(["name"=> $item, "status"=> 1]);
        }
    }

    private function CreateColours()
    {
        $colors = [
            "#FF0000"   => "Red",
            "#0000FF"   => "Blue",
            "#FFFF00"   => "Yellow",
            "#000000"   => "Black",
            "#FFFFFF"   => "White",
            "#666"      => "Dark Gray",
            "#AAA"      => "Light Gray"
        ];

        foreach($colors as $key => $value)
        {
            Models\Colour::create(["code"=> $key, "name"=> $value, "status"=> 1]);
        }
    }

    private function CreatePayment()
    {
        $items = ["Direct Bank Transfer", "Cheque Payment", "Paypal System"];
        $description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua";

        foreach($items as $item)
        {
            Models\Payment::create(["name"=> $item, "description"=> $description, "status"=> 1]);
        }
    }

    private function CreateSize()
    {
        $items = ["11 to 12 Inches", "13 to 14 Inches", "15 to 16 Inches", "17 to 18 Inches"];

        foreach($items as $item)
        {
            Models\Size::create(["name"=> $item, "status"=> 1]);
        }
    }

    private function CreateSetting()
    {
        $settings = [
            "about"         => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.",
            "com.location"  => "West Java, Indonesia",
            "com.phone"     => "+62-898-921-8470",
            "com.email"     => "sandy.andryanto.blade@gmail.com",
            "com.currency"  => "USD",
            "img.hotdeal"   => "https://i.ibb.co.com/prGN70n/hotdeal.png",
            "img.logo"      => "https://i.ibb.co.com/xCcHLY9/logo.png",
            "img.react"     => "https://i.ibb.co.com/n0S85sv/react.png",
            "img.shop1"     => "https://i.ibb.co.com/w0C2BL8/shop01.png",
            "img.shop2"     => "https://i.ibb.co.com/n6Yktzg/shop02.png",
            "img.shpp3"     => "https://i.ibb.co.com/xLNj90z/shop03.png",
            "installed"     => 1
        ];

        foreach($settings as $key => $value)
        {
            Models\Setting::create(["key_name"=> $key, "key_value"=> $value,]);
        }

    }

    private function ProductImages()
    {
        return [
            "https://i.ibb.co.com/9G1VGD3/product01.png",
            "https://i.ibb.co.com/jyy3K7K/product02.png",
            "https://i.ibb.co.com/0qLD2KT/product03.png",
            "https://i.ibb.co.com/nsRfS3s/product04.png",
            "https://i.ibb.co.com/nMygJ4X/product05.png",
            "https://i.ibb.co.com/bm2Hw5Z/product06.png",
            "https://i.ibb.co.com/tYhgnVn/product07.png",
            "https://i.ibb.co.com/hXTVmY1/product08.png",
            "https://i.ibb.co.com/JvjBMY8/product09.png"
        ];
    }

}
