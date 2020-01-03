<?php

// inherit main code from SkinTemplate, set the CSS and template filter
class SkinRefreshed extends SkinTemplate {
	public $skinname = 'refreshed',
		$stylename = 'refreshed',
		$template = 'RefreshedTemplate',
		$headerNav = [];

	/**
	 * Initializes OutputPage and sets up skin-specific parameters
	 *
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		global $wgLocalStylePath;

		parent::initPage( $out );

		$out->addMeta( 'viewport', 'width=device-width' );

		// prevent iOS from zooming out when the sidebar is opened
		$out->addHeadItem( 'viewportforios',
			Html::element( 'meta', [
				'name' => 'viewport',
				'content' => 'width=device-width, initial-scale=1.0'
			] )
		);

		// Add JavaScript via ResourceLoader
		$out->addModules( 'skins.refreshed.js' );
	}

	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );

		// Add CSS via ResourceLoader
		$out->addModuleStyles( [
			'mediawiki.skinning.interface',
			'mediawiki.skinning.content.externallinks',
			'skins.refreshed'
		] );
	}

	/**
	 * Updates memcached data when a new version of some Refreshed interface message
	 * is saved.
	 * The caching is done in RefreshedTemplate::execute().
	 *
	 * @see https://phabricator.wikimedia.org/T166943
	 */
	public static function onPageContentSaveComplete( $wikiPage, $user, $content, $summary, $isMinor, $isWatch, $section, $flags, $revision, $status, $baseRevId ) {
		global $wgLang, $wgMemc;

		$contLang = MediaWiki\MediaWikiServices::getInstance()->getContentLanguage();
		$cache = ( $wgLang->getCode() == $contLang->getCode() );

		if ( !$cache ) {
			return true;
		}

		$title = $wikiPage->getTitle();
		if (
			$title instanceof Title &&
			$title->inNamespace( NS_MEDIAWIKI )
		)
		{
			$pageName = $title->getText();
			$cacheKey = '';
			if ( $pageName == 'Refreshed-wiki-dropdown' ) {
				$cacheKey = $wgMemc->makeKey( 'refreshed', 'dropdownmenu' );
			} elseif ( $pageName == 'Refreshed-navigation' ) {
				$cacheKey = $wgMemc->makeKey( 'refreshed', 'header' );
			}

			if ( $cacheKey ) {
				$wgMemc->delete( $cacheKey );
			}
		}
	}

}
