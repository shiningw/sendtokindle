<?php

namespace OCA\SendtoKindle\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Utility\ITimeFactory;
use OCP\IConfig;
use OCP\IDBConnection;
use OCP\Settings\ISettings;
use OCA\SendtoKindle\Settings;

class Personal implements ISettings
{

	/** @var IDBConnection */
	private $connection;
	/** @var ITimeFactory */
	private $timeFactory;
	/** @var IConfig */
	private $config;

	public function __construct(
		IDBConnection $connection,
		ITimeFactory $timeFactory,
		IConfig $config
	) {
		$this->connection = $connection;
		$this->timeFactory = $timeFactory;
		$this->config = $config;
		$this->UserId = \OC::$server->getUserSession()->getUser()->getUID();
		$this->settings = new Settings($this->UserId);
	}

	/**
	 * @return TemplateResponse
	 */
	public function getForm()
	{
		$parameters = [
			"path" => '/apps/sendtokindle/settings/save',
			"sendtokindle-senderemail" => $this->settings->get("sendtokindle-senderemail"),
			"sendtokindle-amazon-email" => $this->settings->get("sendtokindle-amazon-email")
		];
		return new TemplateResponse('sendtokindle', 'settings/index', $parameters, '');
	}

	/**
	 * @return string the section ID, e.g. 'sharing'
	 */
	public function getSection(): string
	{
		return 'sendtokindle';
	}

	/**
	 * @return int whether the form should be rather on the top or bottom of
	 * the admin section. The forms are arranged in ascending order of the
	 * priority values. It is required to return a value between 0 and 100.
	 *
	 * E.g.: 70
	 */
	public function getPriority(): int
	{
		return 100;
	}
}
