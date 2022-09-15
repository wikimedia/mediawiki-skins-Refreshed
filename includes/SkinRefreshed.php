<?php

use MediaWiki\MediaWikiServices;

// inherit main code from SkinTemplate, set the CSS and template filter
class SkinRefreshed extends SkinTemplate {
	/**
	 * Updates cached data when a new version of some Refreshed interface message
	 * is saved.
	 * The caching is done in RefreshedTemplate::execute().
	 *
	 * @see https://phabricator.wikimedia.org/T166943
	 */
	public static function onPageSaveComplete( WikiPage $wikiPage ) {
		global $wgLang;

		$services = MediaWikiServices::getInstance();
		$contLang = $services->getContentLanguage();
		if ( $wgLang->getCode() != $contLang->getCode() ) {
			return true;
		}

		$title = $wikiPage->getTitle();
		if ( $title->inNamespace( NS_MEDIAWIKI ) ) {
			$cache = $services->getMainWANObjectCache();
			$pageName = $title->getText();
			$cacheKey = '';
			if ( $pageName == 'Refreshed-wiki-dropdown' ) {
				$cacheKey = $cache->makeKey( 'refreshed', 'dropdownmenu' );
			} elseif ( $pageName == 'Refreshed-navigation' ) {
				$cacheKey = $cache->makeKey( 'refreshed', 'header' );
			}

			if ( $cacheKey ) {
				$cache->delete( $cacheKey );
			}
		}
	}

	/**
	 * Returns whether or not Echo is allowed to disable the default "you have new messages" banner.
	 * Set $wgRefreshedEchoCanAbortNewMessagesAlert to false to display the banner in addition to
	 * a standard Echo notification when users receive new messages.
	 *
	 * @see https://phabricator.wikimedia.org/rECHO87053b91a68c1a980563b3a722af2cd5b631a533
	 */
	 public static function onEchoCanAbortNewMessagesAlert() {
		 global $wgRefreshedEchoCanAbortNewMessagesAlert;
		 return $wgRefreshedEchoCanAbortNewMessagesAlert;
	 }

}
