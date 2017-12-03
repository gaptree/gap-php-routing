<?php
$collection = new \Gap\Routing\RouteCollection();
$collection
    ->site('www')
    ->access('login')

    ->get(
        '/commit/update',
        'updateCommit',
        'Tec\Article\Commit\Ui\UpdateCommitUi@show'
    )
    ->postRest(
        '/rest/commit/update',
        'updateCommit',
        'Tec\Article\Commit\Rest\UpdateCommitRest@post'
    );
return $collection;
