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
		global $wgLang, $wgContLang, $wgMemc;
		$cache = ( $wgLang->getCode() == $wgContLang->getCode() );

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
