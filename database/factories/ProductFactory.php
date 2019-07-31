<?php

use Faker\Generator as Faker;
use App\Lib\Location;
use Carbon\Carbon;

Location::load();

$factory->define(App\Product::class, function (Faker $faker) {
    $now = Carbon::now();
    $cat = random_int(1, 6);
    $cityID = random_int(1, 63);
    $city = Location::getCity($cityID);
    $dist = $city['district'][array_rand($city['district'])];
    $ward = 0;
    if (!empty($dist['ward'])) {
        $ward = $dist['ward'][array_rand($dist['ward'])];
    }
    $street = 0;
    if (!empty($dist['street'])) {
        $street = $dist['street'][array_rand($dist['street'])];
    }

    $childCat = App\Category::where('parent_id', $cat)->first();

    // 63 710 11287 35805
    $product = [
        'title'           => $faker->sentence(8, true),
        'city'            => $cityID,
        'district'        => $dist['id'],
        'ward'            => $ward['id'],
        'street'          => $street['id'],
        'content'         => $faker->paragraph(100, true),
        'category_parent' => $cat,
        'category'        => $childCat->id,
        'level'           => random_int(1, 2),
        'status'          => 1,
        'contact_name'    => $faker->name,
        'contact_phone'   => $faker->phoneNumber,
        'contact_email'   => $faker->email,
        'contact_address' => $faker->address,
        'keywords'        => json_encode($faker->words(3)),
        'images'          => json_encode([]),
        'from'            => Carbon::now(),
        'to'              => Carbon::now()->addDays(30),
        'updated_at'      => $now,
        'created_at'      => $now,
        'provider'        => config('product.provider')[array_rand(config('product.provider'))]['id'],
        'price'           => random_int(1, 100) * 100000,
        'price_unit'      => 'tháng',
        'currency'        => 'VND',
    ];

    if ($cat == 1) {
        $product['pano_type']   = config('product.pano.type')[array_rand(config('product.pano.type'))]['id'];
        $product['pano_size']   = config('product.pano.size')[array_rand(config('product.pano.size'))]['id'];
        $product['pano_border'] = config('product.pano.border')[array_rand(config('product.pano.border'))]['id'];
        $product['pano_light']  = config('product.pano.light')[array_rand(config('product.pano.light'))]['id'];
    } else if ($cat == 2) {
        $product['ad_channel']  = config('product.ad.channel')[array_rand(config('product.ad.channel'))]['id'];
        $product['ad_coverage'] = config('product.ad.coverage')[array_rand(config('product.ad.coverage'))]['id'];
        $product['ad_time']     = config('product.ad.time')[array_rand(config('product.ad.time'))]['id'];
    } else if ($cat == 3) {
        $product['social_type']   = config('product.social.type')[array_rand(config('product.social.type'))]['id'];
        $product['social_follow'] = config('product.social.follow')[array_rand(config('product.social.follow'))]['id'];
    } else if ($cat == 4) {
        $product['web_type']     = config('product.web.type')[array_rand(config('product.web.type'))]['id'];
        $product['web_position'] = config('product.web.position')[array_rand(config('product.web.position'))]['id'];
    } else if ($cat = 6) {
    }

    return $product;
});
