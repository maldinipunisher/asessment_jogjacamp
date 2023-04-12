<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
       //get_all
       $response = $this->get('/api/categories');
       $response->assertStatus(200);

       //get
       $response = $this->get('/api/categories/100');
       $response->assertStatus(200);

       //add
       $body = [
           'name' => 'test',
           'is_publish' => 'false'
       ];
       $response = $this->post('/api/categories' ,$body);
       $response->assertStatus(201);


       //update
       $body = [
           'name' => 'test',
           'is_publish' => 'false'
       ];
       $response = $this->put('/api/categories/100' ,$body);
       $response->assertStatus(200);

       //delete
       $response = $this->delete('/api/categories/9');
       $response->assertStatus(200);
    }
}
