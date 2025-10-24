<?php declare(strict_types=1);

namespace App\Providers;

use IsmayilDev\ApiDocKit\Providers\ApiDocKitServiceProvider as BaseApiDocKitServiceProvider;
use OpenApi\Attributes\Info;
use OpenApi\Attributes\OpenApi;
use OpenApi\Attributes\Server;
use OpenApi\Attributes\ServerVariable;

#[OpenApi(info: new Info(version: '1.0.0', title: 'Your App API'))]
class ApiDocKitServiceProvider extends BaseApiDocKitServiceProvider
{
    public function boot(): void
    {
        parent::boot();

         $this->app->bind('api-doc-kit.servers', function () {
             return [
                 new Server(
                     url: 'https://localhost',
                     description: ' Local development',
                     variables: [
                         new ServerVariable('email', 'Your email', 'me@ismayil.dev'),
                         new ServerVariable('password', 'Your password', 'password'),
                     ]
                 ),
                 new Server(
                     url: 'https://staging.apidockit.com',
                     description: 'Staging',
                     variables: [
                         new ServerVariable('email', 'Your email', 'me@ismayil.dev'),
                         new ServerVariable('password', 'Your password', 'password'),
                         new ServerVariable(
                             serverVariable: 'version',
                             description: 'API Version',
                             default: 'v1',
                             enum: ['v1', 'v2']
                         ),
                     ]
                 ),
                 new Server(
                     url: 'https://apidockit.com',
                     description: 'Production',
                     variables: [
                         new ServerVariable('email', 'Your email', 'me@ismayil.dev'),
                         new ServerVariable('password', 'Your password', 'password'),
                         new ServerVariable(
                             serverVariable: 'version',
                             description: 'API Version',
                             default: 'v1',
                             enum: ['v1', 'v2']
                         ),
                     ]
                 ),
             ];
         });
    }
}
