<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ProductTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $this->get('/api/products')
             ->seeJsonStructure([
                'data' => [],
                'total'
             ]);
    }

    public function testCreate()
    {
        $this->json('POST', '/api/products', [
            'code' => 'TEST#1',
            'name' => 'Testing 1',
            'price' => 100000,
            'stock' => 100
            ])
             ->seeJson([
                'code' => 'TEST#1',
                'name' => 'Testing 1',
                'price' => 100000,
                'stock' => 100,
             ]);

        $this->seeInDatabase('products', ['code' => 'TEST#1']);
    }

}
