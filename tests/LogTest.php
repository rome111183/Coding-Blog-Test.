<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LogTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLog()
    {
        $message = 'test';
        
        \Log::emergency($message);
        \Log::alert($message);
        \Log::critical($message);
        \Log::error($message);
        \Log::warning($message);
        \Log::notice($message);
        \Log::info($message);
        \Log::debug($message);
    }
}
