<?php
/**
 * This file is part of the Nella Project (http://nella-project.org).
 *
 * Copyright (c) Patrik Votoček (http://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Nella\SimpleHashAuthenticator;

use Nette\Utils\Strings;

class Extension extends \Nette\DI\CompilerExtension
{

    public $defaults = array(
        'users' => array(), // of [user => password] or [user => ['password' => password, 'roles' => [role]]]
        'router' => NULL,
    );

    public function loadConfiguration()
    {
        $config = $this->getConfig($this->defaults);
        $builder = $this->getContainerBuilder();

        $users = array();
        $roles = array();
        foreach ($config['users'] as $username => $data) {
            $users[$username] = is_array($data) ? $data['password'] : $data;
            $roles[$username] = is_array($data) && isset($data['roles']) ? $data['roles'] : NULL;
        }

        $builder->addDefinition($this->prefix('authenticator'))
            ->setClass('Nella\SimpleHashAuthenticator\Authenticator', array($users, $roles));

        if ($config['router']) {
            $presenterFactory = $builder->getDefinition('nette.presenterFactory');

            $extensions = $this->compiler->getExtensions('Nette\Bridges\Framework\NetteExtension');
            /** @var \Nette\Bridges\Framework\NetteExtension $netteExtension */
            $netteExtension = reset($extensions);

            $netteConfig = $netteExtension->getConfig($netteExtension->defaults);
            $mapping = isset($netteConfig['application']['mapping']) ? $netteConfig['application']['mapping'] : array();
            $mapping['SimpleHashAuthenticator'] = 'Nella\SimpleHashAuthenticator\*Presenter';

            $presenterFactory->addSetup('setMapping', array($mapping));

            $builder->addDefinition($this->prefix('route'))
                ->setClass('Nette\Application\Routers\Route', array(
                    '/authenticator',
                    'SimpleHashAuthenticator:PasswordHashGenerator:default',
                ))
                ->setAutowired(FALSE);
        }
    }

    public function afterCompile(\Nette\PhpGenerator\ClassType $class)
    {
        $routerName = $this->getNormalizedRouterName();
        if ($routerName === NULL) {
            return;
        }

        $initialize = $class->methods['initialize'];

        $initialize->addBody('$authNewRouter = new Nette\Application\Routers\RouteList();');
        $initialize->addBody('$authNewRouter[] = $this->getService(?);', array($this->prefix('route')));
        $initialize->addBody('$authNewRouter[] = $this->getService(?);', array($routerName));
        $initialize->addBody('$this->removeService(?);', array($routerName));
        $initialize->addBody('$this->addService(?, $authNewRouter);', array($routerName));
    }

    /**
     * @return string|NULL
     */
    private function getNormalizedRouterName()
    {
        $config = $this->getConfig($this->defaults);
        if (empty($config['router'])) {
            return NULL;
        }

        if (Strings::startsWith($config['router'], '@')) {
            return Strings::substring($config['router'], 1);
        }
        return $config['router'];
    }

}
