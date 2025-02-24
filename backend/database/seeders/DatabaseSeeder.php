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

            $thumbnail = $this->ProductImages()[rand(0, 8)];
            $brand = Models\Brand::inRandomOrder()->first();
            $product = new Models\Product();
            $product->image = $thumbnail;
            $product->brand_id = $brand->id;
            $product->sku = "P00".$i;
            $product->name = "Product ".$i;
            $product->total_order = rand(100, 1000);
            $product->total_rating = rand(100, 1000);
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
        $items = [
            "Laptop"        => "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product01.png",
            "Smartphone"    => "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product02.png",
            "Camera"        => "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product03.png",
            "Accessories"   => "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product04.png",
            "Others"        => "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product05.png",
        ];

        $num = 1;
        foreach($items as $image => $name)
        {
            Models\Category::create([
                "name"=> $name,
                "image"=> $image,
                "status"=> 1,
                "displayed"=> $num <= 3 ? 1: 0
            ]);
            $num++;
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
            "about_section"         => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.",
            "com_location"          => "West Java, Indonesia",
            "com_phone"             => "+62-898-921-8470",
            "com_email"             => "sandy.andryanto.blade@gmail.com",
            "com_currency"          => "USD",
            "img_hotdeal"           => "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/hotdeal.png",
            "img_logo"              => "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/logo.png",
            "img_app"               => "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/app.png",
            "img_shop1"             => "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/shop01.png",
            "img_shop2"             => "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/shop02.png",
            "img_shpp3"             => "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/shop03.png",
            "installed"             => 1,
            "hot_deal_title"        => "hot deal this week",
            "hot_deal_description"  => "New Collection Up to 50% OFF",
            "discount_active"       => 1,
            "discount_value"        => 50,
            "discount_start"        => date("Y-m-d H:i:s"),
            "discount_end"          => date("Y-m-d H:i:s", strtotime("+7 day"))
        ];

        foreach($settings as $key => $value)
        {
            Models\Setting::create(["key_name"=> $key, "key_value"=> $value,]);
        }

    }

    private function ProductImages()
    {
        return [
            "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product01.png",
            "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product02.png",
            "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product03.png",
            "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product04.png",
            "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product05.png",
            "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product06.png",
            "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product07.png",
            "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product08.png",
            "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product09.png"
        ];
    }

}
