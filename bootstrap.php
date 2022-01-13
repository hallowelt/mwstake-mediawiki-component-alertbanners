<?php

if ( defined( 'MWSTAKE_MEDIAWIKI_COMPONENT_ALERTBANNERS_VERSION' ) ) {
	return;
}

define( 'MWSTAKE_MEDIAWIKI_COMPONENT_ALERTBANNERS_VERSION', '1.0.0' );

MWStake\MediaWiki\ComponentLoader\Bootstrapper::getInstance()
->register( 'alertbanners', function() {
	$GLOBALS['mwsgAlertBannersProviderRegistry'] = [];

	$GLOBALS['mwsgAlertBannersProviderFactories'] = [
		'globalvars-config' => [
			'class' => "\\MWStake\\MediaWiki\\Component\\AlertBanners\\AlertProviderFactory\\GlobalVars",
			'services' => [ 'ObjectFactory' ]
		],
		'hook' => [
			'class' => "\\MWStake\\MediaWiki\\Component\\AlertBanners\\AlertProviderFactory\\Hook",
			'services' => [ 'ObjectFactory', 'HookContainer' ]
		]
	];

	$GLOBALS['wgHooks']['SiteNoticeAfter'][] =
		'MWStake\\MediaWiki\\Component\\AlertBanners\\Hook\\SiteNoticeAfter\\AddAlerts::callback';

	$GLOBALS['wgResourceModules']['mwstake.component.alertbanners'] = [
		'scripts' => [
			'resources/mwstake.components.alertbanners.js'
		],
		'localBasePath' => __DIR__
	];
} );
