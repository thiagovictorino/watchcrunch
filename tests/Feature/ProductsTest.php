<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a query scope, that can return products within a price range', function () {
    $product1 = Product::factory()->create();
    $product1->price = 100;
    $product1->save();

    $product2 = Product::factory()->create();
    $product2->price = 200;
    $product2->save();

    $product3 = Product::factory()->create();
    $product3->price = 300;
    $product3->save();

    $product4 = Product::factory()->create();
    $product4->price = 400;
    $product4->save();

    $product5 = Product::factory()->create();
    $product5->price = 500;
    $product5->save();

    $productsBeetWen100and300 = Product::priceRange(100, 300)->get();
    expect($productsBeetWen100and300->count())->toBe(3);
    expect($productsBeetWen100and300[0]->id)->toBe($product1->id);
    expect($productsBeetWen100and300[1]->id)->toBe($product2->id);
    expect($productsBeetWen100and300[2]->id)->toBe($product3->id);

    $productsBeetWen200and500 = Product::priceRange(200, 500, 'DESC')->get();
    expect($productsBeetWen200and500->count())->toBe(4);
    expect($productsBeetWen200and500[0]->id)->toBe($product5->id);
    expect($productsBeetWen200and500[1]->id)->toBe($product4->id);
    expect($productsBeetWen200and500[2]->id)->toBe($product3->id);
    expect($productsBeetWen200and500[3]->id)->toBe($product2->id);

})->group('products');

it('throws exception when use a wrong sort parameter value', function () {
    Product::priceRange(100, 300, 123)->get();
})->group('products')->throws(InvalidArgumentException::class, 'The `sort` parameter should be ASC or DESC');
