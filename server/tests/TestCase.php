<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {

    public $base_uri = 'http://localhost/registerapp/server/public/api/';
    public $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL3JlZ2lzdGVyYXBwXC9zZXJ2ZXJcL3B1YmxpY1wvYXBpXC9sb2dpbiIsImlhdCI6MTYzNzgyMDY4MywiZXhwIjoxNjM3ODQyMjgzLCJuYmYiOjE2Mzc4MjA2ODMsImp0aSI6ImxNQ3RaV2ZhTVVRS1RFdWIiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.rAhBVZEk3ImUzqFYrI0MhepsyKagh1yLQB42GXDHUE8';

    use CreatesApplication;
}
