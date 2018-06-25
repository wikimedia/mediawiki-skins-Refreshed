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

		// Inject webfont loader CSS file inline here so that it'll work even for IE11
		// Conditional comments aren't supported in IE10+ so we have no way of loading
		// this just for IE, so better to have all font declarations here (and
		// maybe one day we'll rename the file to just "fontloader.css" or something)
		// Based on some quick-ish testing on 25 July 2016, it appears that font
		// declarations need to be loaded before they're used so that they work
		// under IE(11).
		// See https://phabricator.wikimedia.org/T134653 for more info.
		$out->addHeadItem( 'webfontfix',
			 Html::element( 'link', [
				'href' => $wgLocalStylePath . '/Refreshed/refreshed/styles/screen/iefontfix.css',
				'rel' => 'stylesheet'
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
}