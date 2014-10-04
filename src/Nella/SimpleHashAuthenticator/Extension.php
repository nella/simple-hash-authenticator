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

class Extension extends \Nette\DI\CompilerExtension
{

    public $defaults = array(
        'users' => array(), // of [user => password] or [user => ['password' => password, 'roles' => [role]]]
    );

    public function loadConfiguration()
    {
        $config = $this->getConfig($this->defaults);
        $builder = $this->getContainerBuilder();

        foreach ($config['users'] as $username => $data) {
            $users[$username] = is_array($data) ? $data['password'] : $data;
            $roles[$username] = is_array($data) && isset($data['roles']) ? $data['roles'] : NULL;
        }

        $builder->addDefinition($this->prefix('authenticator'))
            ->setClass('Nella\SimpleHashAuthenticator\Authenticator', array($users, $roles));
    }

}
