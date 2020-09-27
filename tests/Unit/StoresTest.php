<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Stores;

class StoresTest extends TestCase
{
    /**
     * @test
     */
    public function testCreateStore()
    {
        $newStore = [
            'platform' => 'shopify',
        ];

        $this->json('POST', '/api/stores', $newStore)
            ->assertStatus(200)
            ->assertJson([
                'platform' => 'shopify',
            ]);
    }

    /**
     * @test
     */
    public function testStores() {
        factory(Stores::class)->create([
            'platform' => 'shopify',
        ]);
        factory(Stores::class)->create([
            'platform' => 'woocommerce',
        ]);
        $this->json('GET', '/api/stores')
            ->assertStatus(200)
            ->assertJson([
                [ 'platform' => 'shopify' ],
                [ 'platform' => 'woocommerce' ],
            ])
            ->assertJsonStructure([
                [
                    'id',
                    'platform',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    /**
     * @test
     */
    public function testStoresProduct() {
        $stores = factory(Stores::class)->create([
            'platform' => 'shopify',
        ]);
        $store = json_decode($stores, true);
        self::assertFileExists("resources/json/{$store['platform']}/products.json");
    }

}
