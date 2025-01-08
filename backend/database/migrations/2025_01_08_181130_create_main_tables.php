<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // users
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image', 255)->nullable()->index();
            $table->string('first_name', 180)->nullable()->index();
            $table->string('last_name', 180)->nullable()->index();
            $table->string('email', 180)->index();
            $table->string('phone', 20)->nullable()->index();
            $table->string('password', 255)->index();
            $table->string('city', 180)->nullable()->index();
            $table->string('country', 180)->nullable()->index();
            $table->string('zip_code', 180)->nullable()->index();
            $table->text('address')->nullable();
            $table->tinyInteger('status')->default(0)->index();
            $table->rememberToken();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // categories
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->index();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // brands
        Schema::create('brands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->index();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        
        // sizes
        Schema::create('sizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->index();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // colours
        Schema::create('colours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 64)->index();
            $table->string('name', 100)->index();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // newsletters
        Schema::create('newsletters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip_address', 45)->index();
            $table->string('email', 180)->index();
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // settings
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key_name', 255)->index();
            $table->longText('key_value');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // payments
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->index();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // products
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('brand_id')->index();
            $table->string('sku', 64)->index();
            $table->string('name', 255)->index();
            $table->decimal('price', 18, 4)->default(0)->index();   
            $table->Integer('rating')->default(0)->index();
            $table->dateTime('published_date')->index();
            $table->longText('description');
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->foreign('brand_id')->references('id')->on('brands'); 
            $table->engine = 'InnoDB';
        });

        // products_categories
        Schema::create('products_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('category_id');
            $table->primary(["product_id", "category_id"]);
            $table->foreign('product_id')->references('id')->on('products'); 
            $table->foreign('category_id')->references('id')->on('categories'); 
            $table->engine = 'InnoDB';
        });

        // products_images
        Schema::create('products_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index();
            $table->string('path', 255)->index();
            $table->Integer('sort')->default(0)->index();
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products'); 
            $table->engine = 'InnoDB';
        });

        // products_reviews
        Schema::create('products_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->Integer('rating')->default(0)->index();
            $table->text('review');
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products'); 
            $table->foreign('user_id')->references('id')->on('users'); 
            $table->engine = 'InnoDB';
        });

        // products_inventories
        Schema::create('products_inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('size_id')->index();
            $table->unsignedBigInteger('color_id')->index();
            $table->Integer('stock')->default(0)->index();
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products'); 
            $table->foreign('size_id')->references('id')->on('sizes'); 
            $table->foreign('color_id')->references('id')->on('colours'); 
            $table->engine = 'InnoDB';
        });

        // orders
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('payment_id')->nullable()->index();
            $table->string('invoice_number', 64)->index();
            $table->Integer('total_item')->default(0)->index();
            $table->decimal('subtotal', 18, 4)->default(0)->index();  
            $table->decimal('total_taxes', 18, 4)->default(0)->index();  
            $table->decimal('total_shipment', 18, 4)->default(0)->index();  
            $table->decimal('total_paid', 18, 4)->default(0)->index();  
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users'); 
            $table->foreign('payment_id')->references('id')->on('payments'); 
            $table->engine = 'InnoDB';
        });

        // orders_details
        Schema::create('orders_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('product_inventory_id')->index();
            $table->decimal('price', 18, 4)->default(0)->index();  
            $table->Integer('qty')->default(0)->index();
            $table->decimal('total', 18, 4)->default(0)->index(); 
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders'); 
            $table->foreign('product_inventory_id')->references('id')->on('products_inventories'); 
            $table->engine = 'InnoDB';
        });

        // activties
        Schema::create('activties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('event', 180)->index();
            $table->string('subject', 180)->index();
            $table->string('description', 255)->index();
            $table->tinyInteger('status')->default(0)->index();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users'); 
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('sizes');
        Schema::dropIfExists('colours');
        Schema::dropIfExists('newsletters');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('products');
        Schema::dropIfExists('products_categories');
        Schema::dropIfExists('products_images');
        Schema::dropIfExists('products_reviews');
        Schema::dropIfExists('products_inventories');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('orders_details');
        Schema::dropIfExists('activties');
    }
};
