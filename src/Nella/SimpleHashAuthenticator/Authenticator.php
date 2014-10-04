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

class Authenticator extends \Nette\Object implements \Nette\Security\IAuthenticator
{

    /** @var array */
    private $users;

    /** @var array */
    private $usersRoles;

    /**
     * @param string[]|array list of pairs username => password
     * @param string[]|array list of pairs username => role[]
     */
    public function __construct(array $users, array $usersRoles = array())
    {
        $this->users = $users;
        $this->usersRoles = $usersRoles;
    }


    /**
     * @return \Nette\Security\IIdentity
     * @throws \Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;
        foreach ($this->users as $name => $hash) {
            if (strcasecmp($name, $username) === 0) {
                if (\Nette\Security\Passwords::verify($password, $hash)) {
                    return new \Nette\Security\Identity(
                        $name,
                        isset($this->usersRoles[$name]) ? $this->usersRoles[$name] : NULL
                    );
                } else {
                    throw new \Nette\Security\AuthenticationException('Invalid password.', self::INVALID_CREDENTIAL);
                }
            }
        }
        throw new \Nette\Security\AuthenticationException("User '$username' not found.", self::IDENTITY_NOT_FOUND);
    }

}
