<?php
/**
 * Test: Nella\SimpleHashAuthenticator\Authenticator
 * @testCase
 *
 * This file is part of the Nella Project (http://nella-project.org).
 *
 * Copyright (c) Patrik Votoček (http://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Nella\SimpleHashAuthenticator;

use Tester\Assert;
use Nette\Security\IAuthenticator;

require __DIR__ . '/../../bootstrap.php';

class AuthenticatorTest extends \Tester\TestCase
{

	/**
	 * @return array[]|array
	 */
	public function dataCredentials()
	{
		return array(
			array(
				$this->getTestCredentials(),
			),
			array(
				$this->getNellaCredentials(),
			),
		);
	}

	/**
	 * @dataProvider dataCredentials
	 *
	 * @param array
	 */
	public function testSuccess($credentials)
	{
		$authenticator = $this->create();

		$identity = $authenticator->authenticate($credentials);
		Assert::type('Nette\Security\IIdentity', $identity);
		Assert::equal($credentials[IAuthenticator::USERNAME], $identity->getId());
	}

	public function testInvalidPassword()
	{
		$authenticator = $this->create();

		Assert::exception(function() use($authenticator) {
			$authenticator->authenticate(array(
				IAuthenticator::USERNAME => 'test',
				IAuthenticator::PASSWORD => 'invalid',
			));
		}, 'Nette\Security\AuthenticationException', NULL, IAuthenticator::INVALID_CREDENTIAL);
	}

	public function testInvalidUsername()
	{
		$authenticator = $this->create();

		Assert::exception(function() use($authenticator) {
			$authenticator->authenticate(array(
				IAuthenticator::USERNAME => 'invalid',
				IAuthenticator::PASSWORD => 'invalid',
			));
		}, 'Nette\Security\AuthenticationException', NULL, IAuthenticator::IDENTITY_NOT_FOUND);
	}

	public function testTestRole()
	{
		$authenticator = $this->create();

		$identity = $authenticator->authenticate($this->getTestCredentials());
		Assert::equal(array('admin'), $identity->getRoles());
	}

	public function testNellaRole()
	{
		$authenticator = $this->create();

		$identity = $authenticator->authenticate($this->getNellaCredentials());
		Assert::equal(array(), $identity->getRoles());
	}

	private function create()
	{
		return new \Nella\SimpleHashAuthenticator\Authenticator(
			array(
				'test' => '$2y$10$l5cjVRLvK2mjm6hzj8.s8.yjXmtO0Eio0JNt.JwAbZccndN9m1IVi',
				'nella' => '$2y$10$/0B2wIOBarTzs5MCJEfjgOqsR.fnNlGsqHQ3mYf6EjvK37WEMfmGe',
			),
			array(
				'test' => 'admin',
			)
		);
	}

	/**
	 * @return string[]|array
	 */
	private function getTestCredentials()
	{
		return array(
			IAuthenticator::USERNAME => 'test',
			IAuthenticator::PASSWORD => 'test',
		);
	}

	/**
	 * @return string[]|array
	 */
	private function getNellaCredentials()
	{
		return array(
			IAuthenticator::USERNAME => 'nella',
			IAuthenticator::PASSWORD => 'nella',
		);
	}

}

id(new AuthenticatorTest)->run(isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : NULL);
