<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create {name} {description} {price} {category_id} {image}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $description = $this->argument('description');
        $price = $this->argument('price');
        $category_id = $this->argument('category_id');
        $imagePath = $this->argument('image');

        if (file_exists($imagePath)) {
            // Your image file and desired file name
            $fileName = uniqid('product_') . '.' . pathinfo($imagePath, PATHINFO_EXTENSION);

            // Store the image in the storage/app/public/product directory
            Storage::disk('public')->put('product/' . $fileName, file_get_contents($imagePath));

            // Create a new product in the database with the uploaded image path
            Product::create([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category_id' => $category_id,
                'image' => 'product/' . $fileName, // Set the image path with 'product/' subdirectory
            ]);

            $this->info('Product created successfully!');
        } else {
            $this->error('Image file not found: ' . $imagePath);
        }
    }
}
