<?php
$collection = new \Gap\Routing\RouteCollection();

$collection
    ->site('www')
    ->noFilter()
    ->get(
        '/a/{zcode:[a-zA-Z0-9-]+}',
        'fetchArticle',
        'Tec\Article\Article\Ui\FetchArticleUi@show'
    )

    ->filter('login')
    ->get(
        '/article/request-create',
        'reqCreateArticle',
        'Tec\Article\Article\Ui\ReqCreateArticleUi@show'
    )
    ->get(
        '/article/request-update/{zcode:[a-zA-Z0-9-]+}',
        'reqUpdateArticle',
        'Tec\Article\Article\Ui\ReqUpdateArticleUi@show'
    )

    ->site('front')
    ->noFilter()
    ->get(
        '/article/{zcode:[a-zA-Z0-9-]+}/show',
        'showArticle',
        'Tec\Article\Article\Ui\ShowArticleUi@show'
    );

return $collection;
