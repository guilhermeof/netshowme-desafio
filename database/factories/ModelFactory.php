<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Attachment;
use App\Models\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'message' => $faker->text,
        'ip' => $faker->ipv4,
        'attachment_id' => factory(Attachment::class)->create()->id,
    ];
});

$factory->define(Attachment::class, function (Faker $faker) {
    $file = \Illuminate\Http\UploadedFile::fake()->create('arquivo.txt', 500, 'text/plain');

    return [
        'name' => $file->name,
        'mime' => $file->getMimeType(),
        'extension' => $file->getExtension(),
        'location' => $file->hashName(),
    ];
});
