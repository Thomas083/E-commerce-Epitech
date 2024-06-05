<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use \App\Models\User;
use \App\Models\Product;

abstract class TestCase extends BaseTestCase
{
   use CreatesApplication;
   use RefreshDatabase;

   public function mockUser($nb = 1, $attributes = null)
   {
       return User::factory($nb)->create($attributes);
   }

    public function mockProduct($nb = 1, $attributes = null)
    {
        return Product::factory($nb)->create($attributes);
    }
}
