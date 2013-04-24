<?php

class EnvironmentMiddleware extends \Slim\Middleware
{
    public function __construct(){
        var_dump($this->app);
    }

    public function call()
    {
        // Get reference to application
        $app = $this->app;

        // Run inner middleware and application
        $this->next->call();

        // Capitalize response body
        $res = $app->response();
        $body = $res->body();
        $res->body(strtoupper($body));

        var_dump('HERE');

        exit;
    }
}