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

use Nette\Application\UI\Form;

class PasswordHashGeneratorPresenter extends \Nette\Application\UI\Presenter
{

	/**
	 * @param string|null $password
	 */
	public function renderDefault($password = NULL)
	{
		if (!empty($password)) {
			$this->template->hash = \Nette\Security\Passwords::hash($password);
		}

		$this->setLayout(FALSE);
		$this->template->setFile(__DIR__ . '/template.latte');
	}

	protected function createComponentForm()
	{
		$form = new Form;
		$form->setMethod(Form::GET);

		$form->addPassword('password', 'Password')->setRequired();
		$form->addSubmit('submit', 'Generate');

		return $form;
	}

}
