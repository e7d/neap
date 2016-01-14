<?php
return array(
    'zf-mvc-auth' => array(
        'authentication' => array(
            'adapters' => array(
                'oauth2' => array(
                    'adapter' => 'ZF\\MvcAuth\\Authentication\\OAuth2Adapter',
                    'storage' => array(
                        'dsn' => 'sqlite:vendor/zfcampus/zf-oauth2/data/dbtest.sqlite',
                    ),
                ),
            ),
        ),
    ),
    'zf-oauth2' => array(
        'db' => array(
            'dsn' => 'sqlite:vendor/zfcampus/zf-oauth2/data/dbtest.sqlite',
        ),
    )
);
