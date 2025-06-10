<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;
    
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Garantir que estamos usando o banco de dados de teste
        config([
            'database.default' => 'pgsql_testing',
        ]);
    }
}
