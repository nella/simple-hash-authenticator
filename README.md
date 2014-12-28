Simple hash authenticator for [Nette Framework](http://nette.org)
=================================================================

[![Build Status](https://img.shields.io/travis/nella/simple-hash-authenticator.svg?style=flat-square)](https://travis-ci.org/nella/simple-hash-authenticator)
[![SensioLabsInsight Status](https://img.shields.io/sensiolabs/i/455da9d6-b50b-4d8f-b455-f30d93029e65.svg?style=flat-square)](https://insight.sensiolabs.com/projects/455da9d6-b50b-4d8f-b455-f30d93029e65)
[![Latest Stable Version](https://img.shields.io/packagist/v/nella/simple-hash-authenticator.svg?style=flat-square)](https://packagist.org/packages/nella/simple-hash-authenticator)
[![Composer Downloads](https://img.shields.io/packagist/dt/nella/simple-hash-authenticator.svg?style=flat-square)](https://packagist.org/packages/nella/simple-hash-authenticator)
[![Dependency Status](https://img.shields.io/versioneye/d/user/projects/54315275fc3f5c2f0b00055c.svg?style=flat-square)](https://www.versioneye.com/user/projects/54315275fc3f5c2f0b00055c)
[![HHVM Status](https://img.shields.io/hhvm/nella/simple-hash-authenticator.svg?style=flat-square)](http://hhvm.h4cc.de/package/nella/simple-hash-authenticator)

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
