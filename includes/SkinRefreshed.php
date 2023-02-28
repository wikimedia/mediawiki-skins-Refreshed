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
		$title = $wikiPage->getTitle();
		self::purgeCacheKeys( $title );
	}

	/**
	 * Like above, but for when either [[MediaWiki:Refreshed-wiki-dropdown]]
	 * or [[MediaWiki:Refreshed-navigation]] was deleted...
	 *
	 * @param MediaWiki\Page\ProperPageIdentity $page The only param we care about
	 * @param MediaWiki\Permissions\Authority $deleter
	 * @param string $reason Deletion reason
	 * @param int $pageID
	 * @param MediaWiki\Revision\RevisionRecord $deletedRev
	 * @param ManualLogEntry $logEntry
	 * @param int $archivedRevisionCount
	 */
	public static function onPageDeleteComplete(
		MediaWiki\Page\ProperPageIdentity $page,
		MediaWiki\Permissions\Authority $deleter,
		string $reason,
		int $pageID,
		MediaWiki\Revision\RevisionRecord $deletedRev,
		ManualLogEntry $logEntry,
		int $archivedRevisionCount
	) {
		$title = MediaWikiServices::getInstance()->getWikiPageFactory()->newFromTitle( $page )->getTitle();
		self::purgeCacheKeys( $title );
	}

	/**
	 * Given a Title (from the PageSaveComplete hook subscriber) or a MediaWiki\Page\ProperPageIdentity
	 * (from the PageDeleteComplete hook subscriber), checks if either [[MediaWiki:Refreshed-wiki-dropdown]]
	 * or [[MediaWiki:Refreshed-navigation]] was impacted (either edited or deleted), deletes
	 * cached data.
	 *
	 * @param Title|MediaWiki\Page\ProperPageIdentity $title
	 */
	public static function purgeCacheKeys( $title ) {
		global $wgLang;

		$services = MediaWikiServices::getInstance();
		$contLang = $services->getContentLanguage();
		if ( $wgLang->getCode() != $contLang->getCode() ) {
			return;
		}

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
