<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Account;
use Mockery;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $mock = Mockery::mock('overload:' . Account::class);
        $mock->shouldReceive('all')
            ->once()
            ->andReturn(collect([
                (object) ['id' => 1, 'name' => 'Account 1'],
                (object) ['id' => 2, 'name' => 'Account 2'],
            ]));
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
