<?php

namespace src\Provider;

use src\Domain\User;
use Doctrine\ORM\EntityManager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\App;
use src\Repository\UserRepository;
/**
 * A ServiceProvider for registering services related
 * to Slim such as request handlers, routing and the
 * App service itself.
 */
class Slim implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $cnt)
    {
        $cnt[UserRepository::class] = function (Container $cnt) {

            return new UserRepository(
                $cnt[EntityManager::class]
            );

        };

        $cnt[App::class] = function (Container $cnt): App {
            $app = new App($cnt);

            $app->post('/users', UserRepository::class);
            return $app;
        };
    }
}