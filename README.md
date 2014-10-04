Simple hash authenticator for [Nette Framework](http://nette.org)
=================================================================

[![Latest Stable Version](https://poser.pugx.org/nella/simple-hash-authenticator/version.png)](https://packagist.org/packages/nella/simple-hash-authenticator) [![Composer Downloads](https://poser.pugx.org/nella/simple-hash-authenticator/d/total.png)](https://packagist.org/packages/nella/simple-hash-authenticator) [![Dependencies Status](http://depending.in/nella/simple-hash-authenticator.png?branch=master)](http://depending.in/nella/simple-hash-authenticator)

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

License
-------
Simple hash authenticator for Nette Framework is licensed under the MIT License - see the LICENSE file for details
