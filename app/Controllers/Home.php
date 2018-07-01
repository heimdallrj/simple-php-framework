<?php
declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use App\Bootstrap\View;

class Home
{
    private $foo;
    private $response;

    public function __construct(
        string $foo,
        ResponseInterface $response
    ) {
        $this->foo = $foo;
        $this->response = $response;
    }

    public function __invoke(): ResponseInterface
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $html = View::load('home');
        $response->getBody()->write($html);
        return $response;
    }
}
