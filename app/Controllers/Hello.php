<?php
declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use App\Bootstrap\View;

class Hello
{
    private $response;

    public function __construct(ResponseInterface $response) {
      $this->response = $response;
    }

    public function __invoke(): ResponseInterface
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $html = View::load('hello');
        $response->getBody()->write($html);
        return $response;
    }
}
