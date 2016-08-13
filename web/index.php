<?php

use Twitogram\Provider\TwitterServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new TwitterServiceProvider());

$app->get('/', function() {
    return 'Try /hello/:name';
});

$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello ' . $app->escape($name);
});

$app->get('/histogram/{name}', function ($name) use ($app) {
    try {
        /** @var \Twitogram\Service\TwitterService $app['twitter.service'] */
        $histogram = $app['twitter.service']->histogram($name);
        return new \Symfony\Component\HttpFoundation\JsonResponse($histogram);
    } catch (\Twitogram\Client\Exception\Exception $e) {
        return new \Symfony\Component\HttpFoundation\Response('Error calling twitter API - ' . $e->getMessage(), 500);
    } catch (Exception $e) {
        return new \Symfony\Component\HttpFoundation\Response('Error occurred - ' . $e->getMessage(), 500);
    }
});

$app->run();