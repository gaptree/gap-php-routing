<?php return array (
  'routeMap' => 
  array (
    'fetchArticle' => 
    array (
      'ui' => 
      array (
        'GET' => 
        Gap\Routing\Route::__set_state(array(
           'status' => 0,
           'name' => 'fetchArticle',
           'action' => 'Tec\\Article\\Article\\Ui\\FetchArticleUi@show',
           'site' => 'www',
           'app' => 'article',
           'mode' => 'ui',
           'access' => 'public',
           'params' => 
          array (
          ),
           'pattern' => '/a/{zcode:[a-zA-Z0-9-]+}',
           'method' => 'GET',
        )),
      ),
    ),
    'reqCreateArticle' => 
    array (
      'ui' => 
      array (
        'GET' => 
        Gap\Routing\Route::__set_state(array(
           'status' => 0,
           'name' => 'reqCreateArticle',
           'action' => 'Tec\\Article\\Article\\Ui\\ReqCreateArticleUi@show',
           'site' => 'www',
           'app' => 'article',
           'mode' => 'ui',
           'access' => 'login',
           'params' => 
          array (
          ),
           'pattern' => '/article/request-create',
           'method' => 'GET',
        )),
      ),
    ),
    'reqUpdateArticle' => 
    array (
      'ui' => 
      array (
        'GET' => 
        Gap\Routing\Route::__set_state(array(
           'status' => 0,
           'name' => 'reqUpdateArticle',
           'action' => 'Tec\\Article\\Article\\Ui\\ReqUpdateArticleUi@show',
           'site' => 'www',
           'app' => 'article',
           'mode' => 'ui',
           'access' => 'login',
           'params' => 
          array (
          ),
           'pattern' => '/article/request-update/{zcode:[a-zA-Z0-9-]+}',
           'method' => 'GET',
        )),
      ),
    ),
    'updateCommit' => 
    array (
      'ui' => 
      array (
        'GET' => 
        Gap\Routing\Route::__set_state(array(
           'status' => 0,
           'name' => 'updateCommit',
           'action' => 'Tec\\Article\\Commit\\Ui\\UpdateCommitUi@show',
           'site' => 'www',
           'app' => 'commit',
           'mode' => 'ui',
           'access' => 'login',
           'params' => 
          array (
          ),
           'pattern' => '/commit/update',
           'method' => 'GET',
        )),
      ),
      'rest' => 
      array (
        'POST' => 
        Gap\Routing\Route::__set_state(array(
           'status' => 0,
           'name' => 'updateCommit',
           'action' => 'Tec\\Article\\Commit\\Rest\\UpdateCommitRest@post',
           'site' => 'www',
           'app' => 'commit',
           'mode' => 'rest',
           'access' => 'login',
           'params' => 
          array (
          ),
           'pattern' => '/rest/commit/update',
           'method' => 'POST',
        )),
      ),
    ),
  ),
  'dispatchDataMap' => 
  array (
    'www' => 
    array (
      0 => 
      array (
        'GET' => 
        array (
          '/article/request-create' => 
          array (
            'name' => 'reqCreateArticle',
            'mode' => 'ui',
            'method' => 'GET',
          ),
          '/commit/update' => 
          array (
            'name' => 'updateCommit',
            'mode' => 'ui',
            'method' => 'GET',
          ),
        ),
        'POST' => 
        array (
          '/rest/commit/update' => 
          array (
            'name' => 'updateCommit',
            'mode' => 'rest',
            'method' => 'POST',
          ),
        ),
      ),
      1 => 
      array (
        'GET' => 
        array (
          0 => 
          array (
            'regex' => '~^(?|/a/([a-zA-Z0-9-]+)|/article/request\\-update/([a-zA-Z0-9-]+)())$~',
            'routeMap' => 
            array (
              2 => 
              array (
                0 => 
                array (
                  'name' => 'fetchArticle',
                  'mode' => 'ui',
                  'method' => 'GET',
                ),
                1 => 
                array (
                  'zcode' => 'zcode',
                ),
              ),
              3 => 
              array (
                0 => 
                array (
                  'name' => 'reqUpdateArticle',
                  'mode' => 'ui',
                  'method' => 'GET',
                ),
                1 => 
                array (
                  'zcode' => 'zcode',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);