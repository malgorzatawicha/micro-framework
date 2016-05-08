<?php
use MW\Route;

return [
   'homeRoute' => new Route('', 'HomeController'),
   'fooRoute' => new Route('foo', 'GetFooController')  
];
