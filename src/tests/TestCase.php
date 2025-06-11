<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    
    /**
     * Define a conexão de banco de dados para o trait RefreshDatabase.
     */
    protected $connectionsToTransact = ['pgsql_testing'];
    
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Forçar o uso do banco de testes independente do ambiente
        Config::set('database.default', 'pgsql_testing');
        
        // Garantir que o RefreshDatabase usa apenas o banco de testes
        $this->artisan('migrate:fresh', [
            '--database' => 'pgsql_testing',
            '--force' => true,
        ]);
    }
}
