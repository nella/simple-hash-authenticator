Simple hash authenticator for [Nette Framework](http://nette.org)
=================================================================

[![Build Status](https://travis-ci.org/nella/simple-hash-authenticator.svg?branch=master)](https://travis-ci.org/nella/simple-hash-authenticator)
[![SensioLabsInsight Status](https://insight.sensiolabs.com/projects/455da9d6-b50b-4d8f-b455-f30d93029e65/mini.png)](https://insight.sensiolabs.com/projects/455da9d6-b50b-4d8f-b455-f30d93029e65)
[![Latest Stable Version](https://poser.pugx.org/nella/simple-hash-authenticator/version.png)](https://packagist.org/packages/nella/simple-hash-authenticator)
[![Composer Downloads](https://poser.pugx.org/nella/simple-hash-authenticator/d/total.png)](https://packagist.org/packages/nella/simple-hash-authenticator)
[![Dependency Status](https://www.versioneye.com/user/projects/54315275fc3f5c2f0b00055c/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54315275fc3f5c2f0b00055c)
[![HHVM Status](http://hhvm.h4cc.de/badge/nella/simple-hash-authenticator.svg)](http://hhvm.h4cc.de/package/nella/simple-hash-authenticator)

Installation
------------

```
composer require nella/simple-hash-authenticator
```

Usage
------

```php

$authenticator = new \Nella\SimpleHashAuthenticator\Authenticator(array(
    'demo' => '$2y$10$l5cjVRLvK2mjm6hzj8.s8.yjXmtO0Eio0JNt.JwAbZccndN9m1IVi', // hash of 'test'
), array(
    'demo' => array(
        'admin'
    ),
));

/** @var \Nette\Security\User $user */
$user->setAuthenticator($authenticator);

```

or register extension

```yml

extensions:
    authenticator: Nella\SimpleHashAuthenticator\Extension

authenticator:
    users:
        demo:
            password: '$2y$10$l5cjVRLvK2mjm6hzj8.s8.yjXmtO0Eio0JNt.JwAbZccndN9m1IVi'
            roles:
                - admin

# or without roles

authenticator:
    users:
        demo: '$2y$10$l5cjVRLvK2mjm6hzj8.s8.yjXmtO0Eio0JNt.JwAbZccndN9m1IVi'

```

For hash generator:

```yml

authenticator:
    router: @router # or your router service name

```

and go to `http://yourweb.local/authenticator`

License
-------
Simple hash authenticator for Nette Framework is licensed under the MIT License - see the LICENSE file for details
