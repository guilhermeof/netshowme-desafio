<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Contact;
use Illuminate\Http\UploadedFile;

class ContactTest extends TestCase
{
    /**
     * Test return all contacts
     * @return void
     */
    public function testIndex()
    {
        $this->get(route('contacts.all'))
            ->assertStatus(200)
            ->assertJsonCount(0);

        factory(Contact::class, 2)->create();
        $this->get(route('contacts.all'))
            ->assertStatus(200)
            ->assertJsonCount(2);
    }

    /**
     * Test show contact
     * @return void
     */
    public function testShow()
    {
        $this->get(route('contacts.show', 100))
            ->assertStatus(404)
            ->assertExactJson(['message' => 'Nenhum contato encontrado!']);

        $contact = factory(Contact::class)->create();
        $this->get(route('contacts.show', $contact->id))
            ->assertStatus(200);
    }

    /**
     * Test store contact
     * @return void
     */
    public function testStore()
    {
        $file = UploadedFile::fake()->create('fileTest.txt', 500, 'text/plain');
        $contact = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'message' => $this->faker->realText(200),
            'attachment' => $file,
        ];

        $this->post(route('contacts.post'), $contact)
            ->assertStatus(201);

        // Fail Test
        $file = UploadedFile::fake()->create('fileTest.txt', 600, 'text/plain');
        $contact = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'message' => $this->faker->realText(200),
            'attachment' => $file,
        ];

        $this->post(route('contacts.post'), $contact)
            ->assertStatus(422);
    }
}
