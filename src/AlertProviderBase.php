<?php

namespace MWStake\MediaWiki\Component\AlertBanners;

use Config;
use MediaWiki\MediaWikiServices;
use RequestContext;
use Skin;
use User;
use Wikimedia\Rdbms\IDatabase;
use Wikimedia\Rdbms\LoadBalancer;

abstract class AlertProviderBase implements IAlertProvider {

	/**
	 *
	 * @var LoadBalancer
	 */
	protected $loadBalancer = null;

	/**
	 *
	 * @var Skin
	 */
	protected $skin = null;

	/**
	 *
	 * @var Config
	 */
	protected $config = null;

	/**
	 *
	 * @param Skin $skin
	 * @param LoadBalancer $loadBalancer
	 * @param Config $config
	 */
	public function __construct( $skin, $loadBalancer, $config ) {
		$this->skin = $skin;
		$this->loadBalancer = $loadBalancer;
		$this->config = $config;
	}

	/**
	 *
	 * @param Skin|null $skin
	 * @return IAlertProvider
	 */
	public static function factory( $skin = null ) {
		$services = MediaWikiServices::getInstance();

		$loadBalancer = $services->getDBLoadBalancer();
		$config = $services->getMainConfig();

		if ( $skin === null ) {
			$skin = RequestContext::getMain()->getSkin();
		}

		$instance = new static( $skin, $loadBalancer, $config );

		return $instance;
	}

	/**
	 *
	 * @param int $type
	 * @return IDatabase
	 */
	protected function getDB( $type = DB_REPLICA ) {
		return $this->loadBalancer->getConnection( $type );
	}

	/**
	 *
	 * @return Config
	 */
	protected function getConfig() {
		return $this->config;
	}

	/**
	 *
	 * @return User
	 */
	protected function getUser() {
		return $this->skin->getUser();
	}
}
