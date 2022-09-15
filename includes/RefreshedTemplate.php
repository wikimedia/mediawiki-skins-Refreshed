<?php

use MediaWiki\MediaWikiServices;
use MediaWiki\Revision\RevisionAccessException;
use MediaWiki\Revision\SlotRecord;

class RefreshedTemplate extends BaseTemplate {

	/**
	 * Parses MediaWiki:Refreshed-wiki-dropdown.
	 * Forked from Games' parseSidebarMenu(), which in turn was forked from
	 * Monaco's parseSidebarMenu(), but none of these three methods are
	 * identical.
	 *
	 * @param string $messageKey Message name
	 * @return array
	 */
	private function parseSiteNavigationMenu( $messageKey ) {
		$lines = $this->getLines( $messageKey );
		$nodes = [];
		$i = 0;

		if ( is_array( $lines ) ) {
			foreach ( $lines as $line ) {
				# ignore empty lines
				if ( strlen( $line ) == 0 ) {
					continue;
				}

				$node = $this->parseSiteNavigationItem( $line );
				for ( $x = $i; $x >= 0; $x-- ) {
					if ( $x == 0 ) {
						break;
					}
				}

				$nodes[$i + 1] = $node;
				$i++;
			}
		}

		return $nodes;
	}

	/**
	 * Helper method for parseSiteNavigationMenu.
	 * Parse one pipe-separated line from MediaWiki message to an array with
	 * indexes "wikiName" (string), "logoURL" (string|null),
	 * "wikiURL" (string|null)
	 * (This array will eventually be used to construct a link in the site
	 * dropdown via renderSiteNavigationItems.)
	 * Each line follows this format of text separated by pipe symbols:
	 * name|logo URL|wiki URL.
	 * Special cases:
	 * - If no logo URL is provided (name||wiki URL), 'logoURL' => null.
	 * - If no wiki URL is provided (name|logo URL|badly formed wiki URL, or
	 * name|logo URL|, or name|logo URL), 'wikiURL' => '#'.
	 * - Finally if neither is provided (name or name||) then both of the above
	 * apply.
	 *
	 * @param string $line Line (beginning with a *) from a MediaWiki: message
	 * @return array attributes for the resulting link
	 */
	public static function parseSiteNavigationItem( $line ) {
		// trim spaces and asterisks from line and split it to maximum three chunks
		$line_temp = explode( '|', trim( $line, '* ' ), 3 );

		// Likewise we assume the logoURL will be null and the wiki URL will be #,
		// but if we find alternatives when parsing, we'll switch to them.
		$logoURL = null;
		$wikiURL = '#';

		$wikiName = $line_temp[0];

		// has logo URL if at least 2 chunks and the 2nd isn't empty
		if ( count( $line_temp ) >= 2 && $line_temp[1] !== '' ) {
			$logoURL = trim( $line_temp[1] );
		}

		// get link from third chunk if it exists and is a URL
		if (
			isset( $line_temp[2] ) &&
			preg_match( '/^(?:' . wfUrlProtocols() . ')/', $line_temp[2] )
		)
		{
			$wikiURL = $line_temp[2];
		}

		return [
			'wikiName' => $wikiName,
			'logoURL' => $logoURL,
			'wikiURL' => $wikiURL,
		];
	}

	/**
	 * @param string $messageKey Name of a MediaWiki: message
	 * @return array|null Array if $messageKey has been given, otherwise null
	 */
	private function getMessageAsArray( $messageKey ) {
		$messageObj = $this->getSkin()->msg( $messageKey )->inContentLanguage();
		if ( !$messageObj->isDisabled() ) {
			$lines = explode( "\n", $messageObj->text() );
			if ( count( $lines ) > 0 ) {
				return $lines;
			}
		}
		return null;
	}

	/**
	 * @param string $messageKey Name of a MediaWiki: message
	 * @return array|null
	 */
	private function getLines( $messageKey ) {
		$title = Title::newFromText( $messageKey, NS_MEDIAWIKI );
		$revision = MediaWikiServices::getInstance()->getRevisionLookup()->getRevisionByTitle( $title );
		if ( $revision !== null ) {
			$contentObj = null;
			try {
				$contentObj = $revision->getContent( SlotRecord::MAIN );
			} catch ( RevisionAccessException $ex ) {
			}
			$contentText = '';
			if ( $contentObj !== null ) {
				$contentText = trim( ContentHandler::getContentText( $contentObj ) );
			}
			if ( $contentText !== '' ) {
				$temp = $this->getMessageAsArray( $messageKey );
				if ( count( $temp ) > 0 ) {
					wfDebugLog( 'Refreshed', sprintf( 'Get LOCAL %s, which contains %s lines', $messageKey, count( $temp ) ) );
					$lines = $temp;
				}
			}
		}

		if ( empty( $lines ) ) {
			$lines = $this->getMessageAsArray( $messageKey );
			// if $lines isn't countable, should log a different debug message that
			// does not include count( $lines ) since in PHP 7.2 and beyond, counting
			// non-countable objects prompts a warning that will break the page
			if ( is_array( $lines ) || $lines instanceof Countable ) {
				wfDebugLog( 'Refreshed', sprintf( 'Get %s, which contains %s lines', $messageKey, count( $lines ) ) );
			} else {
				wfDebugLog( 'Refreshed', sprintf( 'Get %s, which is empty', $messageKey ) );
			}
		}

		return $lines;
	}

	/**
	 * Return an inline SVG containing the inputted icon, as a string.
	 *
	 * @param string|null $iconName string or null if no icon
	 * @return string|bool string if the icon exists, otherwise false
	 */
	private function makeIcon( $iconName ) {
		// return null if $iconName isn't a string or is the empty string
		if ( !is_string( $iconName ) || $iconName === '' ) {
			return '';
		}

		// Sometimes $iconName may be of the form "nstab-something" if it represents
		// an article button (like "user page"). In this case, there are many
		// possible suffixes like "-user", "-project", etc. We can't possibly
		// predict all those suffixes since some of them may represent namespaces
		// that one wiki in particular has defined. As such, we will strip the
		// suffix to leave just "nstab" for every namespace. That way article
		// buttons always use the same icon.
		if ( strpos( $iconName, 'nstab' ) === 0 ) {
			$iconName = 'nstab';
		}

		// get the icon
		$direction_dependent_url = __DIR__ . '/../refreshed/icons/' . $this->getSkin()->getLanguage()->getDir() . '/' . $iconName . '.svg';
		$direction_independent_url = __DIR__ . '/../refreshed/icons/no-direction/' . $iconName . '.svg';
		if ( file_exists( $direction_dependent_url ) ) {
			return file_get_contents( $direction_dependent_url );
		} elseif ( file_exists( $direction_independent_url ) ) {
			return file_get_contents( $direction_independent_url );
		} else {
			return false;
		}
	}

	/**
	 * Render an inline SVG containing the inputted icon to the page.
	 *
	 * @param string|null $iconName string or null if no icon
	 */
	private function renderIcon( $iconName ) {
		// if the icon doesn't exist, then makeIcon will return false,
		// so echoing it will produce the empty string
		echo $this->makeIcon( $iconName );
	}

	/**
	 * Generate a list item using BaseTemplate::makeListItem() that contains the
	 * inline SVG icon specified by $iconName just before the actual link text,
	 * assuming $iconName is specified.
	 * (If the icon name isn't recognized, or the list item or icon HTML can't
	 * be parsed for whatever reason, the list item is returned without
	 * adding the icon.)
	 *
	 * @param string $iconName the name of the icon
	 * @param string $key the "$key" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $item the "$item" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $options the "$options" for the standard makeLink/makeListItem
	 *  (see docs); optional
	 * @return string string representing the list item
	 */
	private function makeListItemWithIconAtStart( $iconName, $key, $item, $options = [] ) {
		return $this->makeElementWithIconHelper( 'list item', $iconName, $key, $item, $options, 'start' );
	}

	/**
	 * Generate a link using BaseTemplate::makeLink() that contains the
	 * inline SVG icon specified by $iconName just before the actual link text,
	 * assuming $iconName is specified.
	 * (If the icon name isn't recognized, or the link or icon HTML can't
	 * be parsed for whatever reason, the link is returned without
	 * adding the icon.)
	 *
	 * @param string $iconName the name of the icon
	 * @param string $key the "$key" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $item the "$item" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $options the "$options" for the standard makeLink/makeListItem
	 *  (see docs); optional
	 * @return string string representing the link
	 */
	private function makeLinkWithIconAtStart( $iconName, $key, $item, $options = [] ) {
		return $this->makeElementWithIconHelper( 'link', $iconName, $key, $item, $options, 'start' );
	}

	/**
	 * Generate a list item using BaseTemplate::makeListItem() that contains the
	 * inline SVG icon specified by $iconName just after the actual link text,
	 * assuming $iconName is specified.
	 * (If the icon name isn't recognized, or the list item or icon HTML can't
	 * be parsed for whatever reason, the list item is returned without
	 * adding the icon.)
	 *
	 * @param string $iconName the name of the icon
	 * @param string $key the "$key" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $item the "$item" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $options the "$options" for the standard makeLink/makeListItem
	 *  (see docs); optional
	 * @return string string representing the list item
	 */
	private function makeListItemWithIconAtEnd( $iconName, $key, $item, $options = [] ) {
		return $this->makeElementWithIconHelper( 'list item', $iconName, $key, $item, $options, 'end' );
	}

	/**
	 * Generate a link using BaseTemplate::makeLink() that contains the
	 * inline SVG icon specified by $iconName just after the actual link text,
	 * assuming $iconName is specified.
	 * (If the icon name isn't recognized, or the link or icon HTML can't
	 * be parsed for whatever reason, the link is returned without
	 * adding the icon.)
	 *
	 * @param string $iconName the name of the icon
	 * @param string $key the "$key" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $item the "$item" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $options the "$options" for the standard makeLink/makeListItem
	 *  (see docs); optional
	 * @return string string representing the link
	 */
	private function makeLinkWithIconAtEnd( $iconName, $key, $item, $options = [] ) {
		return $this->makeElementWithIconHelper( 'link', $iconName, $key, $item, $options, 'end' );
	}

	/**
	 * Helper method for makeListItemWithIconAtStart, makeLinkWithIconAtStart,
	 * makeListItemWithIconAtEnd, and makeLinkWithIconAtEnd.
	 *
	 * Depending on $mode, generate a) a list item containing a link using
	 * BaseTemplate::makeListItem() or b) just a link using
	 * BaseTemplate::makeLink(). Before or after (depending on settings) the
	 * actual link text, there is the inline SVG icon specified by $iconName,
	 * assuming $iconName is specified. (If the icon name isn't recognized, or the=
	 * list item/link or icon HTML can't be parsed for whatever reason, the list
	 * item/link is returned without adding the icon.)
	 *
	 * @param string $mode Expects either 'list item' or 'link'
	 * @param string $iconName the name of the icon
	 * @param string $key the "$key" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $item the "$item" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $options the "$options" for the standard makeLink/makeListItem
	 *  (see docs); optional
	 * @param string $iconPosition where to put the icon within the list item or
	 *  link; expects either 'start' or 'end'
	 * @return string string representing the list item/link
	 */
	private function makeElementWithIconHelper( $mode, $iconName, $key, $item, $options, $iconPosition ) {
		// Based on the $mode, either make a list item or link without any icon
		// added yet.
		if ( $mode === 'list item' ) {
			$outputUnedited = $this->makeListItem( $key, $item, $options );
		} elseif ( $mode === 'link' ) {
			$outputUnedited = $this->makeLink( $key, $item, $options );
		} else {
			$outputUnedited = '';
		}

		// Get the HTML of the icon we want to add (returns empty string if no icon)
		$icon = $this->makeIcon( $iconName );

		// if there is no icon to add, don't bother doing more processing; just
		// return the list item/link without the icon
		if ( $icon === false ) {
			return $outputUnedited;
		}

		// Now we know there actually is an icon we want to insert. We want to find
		// where it belongs. To do this, we will parse the HTML of the list item/
		// link.

		// (As of MW 1.31) BaseTemplate::makeListItem and BaseTemplate::makeLink
		// allow angle brackets in attributes. In case this (or something else)
		// breaks the HTML parser, rather than deal with the breaking, we will just
		// not add images/icons in that case.
		// (two separate DOMs: one for the list item/link, one for the icon)
		$listItemOrLinkDOM = $this->loadHTMLHandleErrors( $outputUnedited );
		$iconDOM = $this->loadHTMLHandleErrors( $icon );

		if ( !$listItemOrLinkDOM || !$iconDOM ) {
			return $outputUnedited;
		}

		// otherwise insert the icon into our list item/link
		// (read variable names for explanation of what's going on below)
		$xpath = new DOMXPath( $listItemOrLinkDOM );
		// Find the first a tag in the link. We know such a tag exists because one
		// is produced by makeListItem or makeLink, which we haven't modified.
		$firstATagInListItemOrLink = $xpath->query( '(//a)[1]' )->item( 0 );

		// Find the first/last child of the first a tag from the last line. Note
		// this may not exist (if a tag is empty), in which case it's null.
		if ( $iconPosition === 'start' ) {
			$firstATagChild = $firstATagInListItemOrLink->firstChild;
		} elseif ( $iconPosition === 'end' ) {
			$firstATagChild = $firstATagInListItemOrLink->lastChild;
		} else {
			$firstATagChild = null;
		}

		$iconInIconDOM = $iconDOM->documentElement;
		// Currently the icon is in the iconDOM. We have to put a copy of it in
		// $listItemOrLinkDOM so we can add the icon to the list item/link
		$iconInListItemOrLinkDOM = $listItemOrLinkDOM->importNode( $iconInIconDOM, true );

		// add the icon to the very beginning/end of the first a tag depending on
		// config settings
		if ( $firstATagChild === null ) {
			$firstATagInListItemOrLink->appendChild( $iconInListItemOrLinkDOM );
		} else {
			if ( $iconPosition === 'start' ) {
				$firstATagInListItemOrLink->insertBefore( $iconInListItemOrLinkDOM, $firstATagChild );
			} elseif ( $iconPosition === 'end' ) {
				$firstATagInListItemOrLink->appendChild( $iconInListItemOrLinkDOM );
			}
		}

		return $listItemOrLinkDOM->saveHTML();
	}

	/**
	 * Helper method for makeElementWithIconHelper.
	 * Given $text, load it into a DOMDocument as HTML. If all goes as planned
	 * (the input doesn't break the parser), return the resulting DOMDocument.
	 * Otherwise, echo errors and return false.
	 *
	 * @param string $text The text to interpret as HTML (shouldn't contain html
	 *  or body tags)
	 * @return DOMDocument|bool DOMDocument if no errors, otherwise false
	 */
	private function loadHTMLHandleErrors( $text ) {
		// error handling per https://secure.php.net/manual/en/simplexml.examples-errors.php
		$doc = new DOMDocument();
		// Let's speak UTF-8 like all civilized people do (references T266864, same issue in the RandomImage ext.)
		$text = mb_convert_encoding( $text, 'HTML-ENTITIES', 'UTF-8' );
		// config doesn't include doctype, html, or body tags per
		// https://stackoverflow.com/a/22490902
		$html = $doc->loadHTML( $text, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
		if ( $html === false ) {
			foreach ( libxml_get_errors() as $error ) {
				echo "\n", $error->message;
			}
			return false;
		}
		return $doc;
	}

	/**
	 * Return the user's avatar element as a string (if using SocialProfile).
	 * Otherwise, return the appropriate placeholder element as a string.
	 *
	 * @param User $user
	 * @return string
	 */
	private function makeAvatar( $user ) {
		$wrapperClassList = 'avatar';
		$imageClassList = 'avatar-image';

		// update wrapper classes
		if ( $this->data['loggedin'] ) {
			$wrapperClassList .= ' avatar-logged-in';
		} else {
			$wrapperClassList .= ' avatar-logged-out';
		}

		// if using SocialProfile, return the SocialProfile avatar
		if ( class_exists( 'wAvatar' ) ) {
			$image = ( new wAvatar( $user->getId(), 'l' ) )->getAvatarURL( [
				'class' => $imageClassList
			] );
		} else {  // if not using SocialProfile...
			$wrapperClassList .= ' avatar-no-socialprofile';

			// use the appropriate site-defined custom avatar if given;
			// otherwise, use the skin's default avatar
			if ( $this->data['loggedin'] ) {
				if ( $this->getMsg( 'refreshed-icon-logged-in' )->inContentLanguage()->isDisabled() ) {
					$image = $this->makeIcon( 'user-loggedin' );
				} else {  // if wiki has set custom image for logged in users
					$image = Html::element( 'img', [
						'src' => $this->getMsg( 'refreshed-icon-logged-in' )->inContentLanguage()->text(),
						'class' => $imageClassList
					] );
				}
			} else {
				if ( $this->getMsg( 'refreshed-icon-logged-out' )->inContentLanguage()->isDisabled() ) {
					$image = $this->makeIcon( 'user-anon' );
				} else {  // if wiki has set custom image for logged out users
					$image = Html::element( 'img', [
						'src' => $this->getMsg( 'refreshed-icon-logged-out' )->inContentLanguage()->text(),
						'class' => $imageClassList
					] );
				}
			}
		}

		return Html::rawElement( 'span', [ 'class' => $wrapperClassList ], $image );
	}

	/**
	 * Get the username text (string) to be displayed in the header.
	 *
	 * @param User $user
	 * @return string
	 */
	private function makeUsernameText( $user ) {
		// if logged in...
		if ( $this->data['loggedin'] ) {
			return $user->getName();
		}
		// if not logged in...
		return $this->getMsg( 'login' )->text();
	}

	/**
	 * Get the personal tools and rearrange them into "dropdown" and "extra"
	 * tools. The "dropdown" tools are the ones that should go into the user info
	 * dropdown, and the "extra" tools (like Echo ones) are ones that should be
	 * placed next to the user dropdown.
	 *
	 * Inspired by and partially adapted from the Timeless skin's getUserLinks
	 * function.
	 *
	 * @return array $rearrangedPersonalTools where the key "dropdown" contains
	 *  the dropdown tools, and the key "extra" contains the extra tools.
	 */
	 private function getAndRearrangePersonalTools() {
		 $dropdownTools = $this->getPersonalTools();
		 $extraTools = [];
		 // list of tool names that should be removed from the dropdown tools and be
		 // added to the extra tools
		 // (these tools are echo badges)
		 $toolsToMove = [ 'notifications-alert', 'notifications-notice' ];

		 foreach ( $toolsToMove as $currentToolToMove ) {
			 if ( isset( $dropdownTools[$currentToolToMove] ) ) {
				 $extraTools[$currentToolToMove] = $dropdownTools[$currentToolToMove];
				 unset( $dropdownTools[$currentToolToMove] );
			 }
		 }

		 return [
			 'dropdown' => $dropdownTools,
			 'extra' => $extraTools
		 ];
	 }

	/**
	 * Render the list items to be displayed next to the user dropdown
	 * (e.g., for Echo).
	 * Inspired by how Timeless handles Echo.
	 *
	 * @param array $extraPersonalTools
	 */
	private function renderExtraPersonalTools( $extraPersonalTools ) {
		foreach ( $extraPersonalTools as $key => $item ) {
			echo $this->makeListItem( $key, $item );
		}
	}

	/**
	 * Render the list items to be displayed in the header's user dropdown.
	 *
	 * @param array $dropdownPersonalTools
	 */
	private function renderUserDropdownItems( $dropdownPersonalTools ) {
		foreach ( $dropdownPersonalTools as $keyAndIconName => $item ) {
			echo $this->makeListItemWithIconAtStart( $keyAndIconName, $keyAndIconName, $item, [ 'text-wrapper' => [ 'tag' => 'span' ] ] );
		}
	}

	/**
	 * Render the items of the site navigation dropdown/collapsible to appear
	 * in the header/sidebar.
	 *
	 * @param array $siteNavigation an array containing info for the site
	 *  navigation colapsible
	 */
	private function renderSiteNavigationItems( $siteNavigation ) {
		// (each item in $siteNavigation was an output of
		// parseSiteNavigationItem)
		// we're making a bunch of list items here (<li> elements, but NOT ones
		// created via makeListItem or makeListItemWithIconAtStart...)

		// the classes to add to each of the dropdown anchors
		$logoClassList = 'refreshed-logo refreshed-logo-other';

		foreach ( $siteNavigation as $wikiLogoInfo ) {
			// send each of the parsed pieces of wiki logo info to renderWikiLogo
			// for rendering
			echo Html::rawElement( 'li', [], $this->makeWikiLinkWithLogo(
				$wikiLogoInfo['wikiName'], $wikiLogoInfo['logoURL'],
				$wikiLogoInfo['wikiURL'], $logoClassList
			) );
		}
	}

	/**
	 * Output as a string an anchor for a wiki, with the wiki's logo inside.
	 *
	 * @param string $wikiName The wiki's name
	 * @param string|null $logoURL URL to the wiki's logo image (if null, render
	 *  logo as text)
	 * @param string $wikiURL The URL the anchor goes to
	 * @param string $classList A list of the classes to add to the outputted
	 *  anchor element
	 * @param string $wikiTitle (optional) text to use as the anchor's title
	 *  attribute instead of $wikiName
	 * @return string HTML of the logo anchor
	*/
	private function makeWikiLinkWithLogo( $wikiName, $logoURL, $wikiURL, $classList, $wikiTitle = '' ) {
		$anchorAttribs = [
			'href' => $wikiURL,
			'title' => $wikiTitle !== '' ? $wikiTitle : $wikiName,
			'class' => $classList
		];
		// If wikiURL is null, we're making a text logo. Otherwise, we're making an
		// image logo.
		if ( $logoURL === null ) {
			$text = Html::element( 'span', [ 'class' => 'header-text site-navigation-logo-text' ], $wikiName );
			return Html::rawElement( 'a', $anchorAttribs, $text );
		} else {
			$image = Html::element( 'img', [
				'src' => $logoURL,
				'alt' => $wikiName,
				'class' => 'site-navigation-logo-img site-navigation-logo-full'
			] );
			return Html::rawElement( 'a', $anchorAttribs, $image );
		}
	}

	/**
	 * Render the items of the header category dropdown/collapsible to appear in
	 * the header/sidebar.
	 *
	 * @param array $headerCategoryDropdown An array containing info for a header
	 *  category dropdown
	 */
	private function renderHeaderCategoryItems( $headerCategoryDropdown ) {
		foreach ( $headerCategoryDropdown as $key => $value ) {
			// Since the header category items appear multiple times on the page,
			// they shouldn't have any IDs (otherwise multiple elements would have
			// the same ID)
			unset( $value['id'] );

			echo Html::rawElement( 'li', [], $this->makeLink( $key, $value, [ 'text-wrapper' => [ 'tag' => 'span' ] ] ) );
		}
	}

	/**
	 * Render one of the content sections of the sidebar
	 *
	 * @param array $sub Details on the section's content
	 */
	private function renderSidebarContentSection( $sub ) {
		if ( is_array( $sub ) ) {  // MW-generated stuff from the sidebar message
			foreach ( $sub as $key => $action ) {
				// append 'sidebar-item' class to a inside
				if ( isset( $action['class'] ) ) {
					$action['class'] .= ' sidebar-link';
				} else {
					$action['class'] = 'sidebar-link';
				}
				echo $this->makeListItem(
					$key,
					$action,
					[
						'link-class' => 'sidebar-item',
						'link-fallback' => 'span'
					]
				);
			}
		} else {
			// allow raw HTML block to be defined by extensions (like NewsBox)
			echo $sub;
		}
	}

	/**
	 * Sort all of the content actions into categories for easier use.
	 * Inspired by and adapted from Skin:Timeless.
	 *
	 * @param array $tools The tools to sort
	 * @return array where each key is a category and each item is an array of
	 *  the page tools in that category (if nothing is in a category, that
	 *  category's key corresponds to an empty array)
	 */
	private function sortPageTools( $tools ) {
		// which category each tool belongs in
		$categories = [
			'namespaces' => [ 'talk' ], // also anything starting with "nstab-"
			'main-actions' => [
				've-edit', 'edit', 'view', 'history', 'addsection', 'viewsource',
				'report-problem'
			],
			'page-tools' => [
				'delete', 'rename', 'protect', 'unprotect', 'move', 'whatlinkshere',
				'recentchangeslinked', 'print', 'permalink', 'info', 'citethispage',
				'feeds'
			],
			'user-tools' => [ 'contributions', 'blockip', 'userrights', 'log', 'wikilove' ],
			'watch' => [ 'watch', 'unwatch' ],
			'other' => [ 'upload', 'specialpages' ] // and anything that doesn't fit in other categories
		];

		// populate the output array with an empty array for each category
		$output = [];
		foreach ( $categories as $category => $toolNamesInCurrentCategory ) {
			$output[$category] = [];
		}

		// populate the output array with tools
		foreach ( $tools as $toolName => $toolDetails ) {
			// special case: if a key starts with "nstab-" then put it in namespaces
			if ( strpos( $toolName, 'nstab-' ) === 0 ) {
				if ( isset( $toolDetails['class'] ) ) {
					$toolDetails['class'] .= ' ' . 'ca-subject';
				} else {
					$toolDetails['class'] = 'ca-subject';
				}
				$output['namespaces'][$toolName] = $toolDetails;
			} else {  // otherwise place the tool in its correct category
				foreach ( $categories as $category => $toolNamesInCurrentCategory ) {
					foreach ( $toolNamesInCurrentCategory as $toolNameInCurrentCategory ) {
						if ( $toolName == $toolNameInCurrentCategory ) {
							$output[$category][$toolName] = $toolDetails;
							$toolPlaced = true;
							// once tool is placed, move on to next tool (next iteration of
							// outermost foreach)
							continue 3;
						}
					}
				}
				// if tool hasn't been placed anywhere after all that, put it in 'other'
				$output['other'][$toolName] = $toolDetails;
			}
		}

		return $output;
	}

	/**
	 * Render the page tools in the toolbox dropdown.
	 *
	 * @param array $pageTools Page tools generated by sortPageTools()
	 */
	private function renderToolboxDropdownItems( $pageTools ) {
		$toolboxCategories = [ 'page-tools', 'user-tools' ];
		foreach ( $toolboxCategories as $category ) {
			if ( !empty( $pageTools[$category] ) ) {
				echo Html::element( 'dt',
					[ 'class' => 'refreshed-dropdown-header' ],
					$this->getMsg( 'refreshed-' . $category )->text()
				);
				$this->renderPageToolsInCategory( 'dropdown', $pageTools, $category );
			}
		}
	}

	/**
	 * Render a link for talk pages pointing back to the corresponding subject page
	 *
	 * @param \MediaWiki\Linker\LinkRenderer $linkRenderer The LinkRenderer
	 * @param Title $title The article's title
	 */
	private function renderBackToSubjectLink( $linkRenderer, $title ) {
		echo Html::rawElement( 'li', [], $linkRenderer->makeLink(
				$title,
				$this->getMsg( 'backlinksubtitle', $title->getPrefixedText() )->text(),
				[ 'id' => 'back-to-subject' ]
		) );
	}

	/**
	 * Render the page tools that are in the given category, either wrapped in
	 * li tags to fit inline in the toolbox (we wrap them in li because a lot of
	 * MW features expect it--for example, double click to edit), or wrapped in
	 * dd to fit in the toolbox dropdown.
	 *
	 * @param string $mode Expects 'dropdown' or 'inline'
	 * @param array $pageTools An array of page tools generated by sortPageTools()
	 * @param string $category The category of list items being generated
	 */
	private function renderPageToolsInCategory( $mode, $pageTools, $category ) {
		// if category is invalid, do nothing
		if ( !array_key_exists( $category, $pageTools ) ) {
			return;
		}

		$options = [
			'text-wrapper' => [
				'tag' => 'span',
				'attributes' => []
			]
		];

		if ( $mode == 'dropdown' ) {
			$options['text-wrapper']['attributes']['class'] = 'dropdown-tool-text';
			$options['tag'] = 'dd';
			foreach ( $pageTools[$category] as $keyAndIconName => $item ) {
				echo $this->makeListItemWithIconAtStart( $keyAndIconName, $keyAndIconName, $item, $options );
			}
		} elseif ( $mode == 'inline' ) {
			$options['text-wrapper']['attributes']['class'] = 'inline-tool-text';
			foreach ( $pageTools[$category] as $keyAndIconName => $item ) {
				echo $this->makeListItemWithIconAtStart( $keyAndIconName, $keyAndIconName, $item, $options );
			}
		}
	}

	/**
	 * Render extra footer items
	 */
	private function renderExtraFooterItems() {
		 $footerExtra = '';
		 Hooks::run( 'RefreshedFooter', [ &$footerExtra ] );
		 echo $footerExtra;
	 }

	/**
	 * Render a row of links in the footer.
	 *
	 * @param string $category The type of links (used for a class name)
	 * @param array $links An array containing info on the links
	 */
	private function renderFooterLinksRow( $category, $links ) {
		$rowContents = '';
		foreach ( $links as $link ) {
			$rowContents .= Html::rawElement( 'li', [ 'class' => 'footer-row-item' ], $this->data[ $link ] );
		}
		echo Html::rawElement( 'ul', [ 'id' => 'footer-row-' . $category, 'class' => 'footer-row' ], $rowContents );
	}

	/**
	 * Render the row of icons in the footer.
	 *
	 * @param ContextSource|IContextSource|MessageLocalizer|Skin $skin The skin object
	 * @param array $footerIcons An array containing info on the blocks of icons
	 */
	private function renderFooterIconsRow( $skin, $footerIcons ) {
		$rowContents = '';
		foreach ( $footerIcons as $blockName => $blockIcons ) {
			$rowContents .= $this->makeFooterIconsBlock( $skin, $blockName, $blockIcons );
		}
		echo Html::rawElement( 'ul', [ 'id' => 'footer-row-icons', 'class' => 'footer-row' ], $rowContents );
	}

	/**
	 * Helper method for renderFooterIconsRow.
	 * Render a block of icons in the footer.
	 *
	 * @param ContextSource|IContextSource|MessageLocalizer|Skin $skin the skin object
	 * @param string $blockName the type of icons (used for an id name)
	 * @param array $blockIcons an array containing info on the icons
	 */
	private function makeFooterIconsBlock( $skin, $blockName, $blockIcons ) {
		$blockContents = '';
		foreach ( $blockIcons as $icon ) {
			$blockContents .= $skin->makeFooterIcon( $icon );
		}
		return Html::rawElement( 'li', [
			'id' => Sanitizer::escapeIdForAttribute( 'footer-row-' . $blockName ),
			'class' => 'footer-row-item'
		], $blockContents );
	}

	public function execute() {
		$services = MediaWikiServices::getInstance();
		$cache = $services->getMainWANObjectCache();
		$linkRenderer = $services->getLinkRenderer();

		$skin = $this->getSkin();
		$config = $skin->getConfig();
		$user = $skin->getUser();

		// Title processing
		$titleBase = $skin->getTitle();
		$title = $titleBase->getSubjectPage();
		$isTalkNamespace = $services->getNamespaceInfo()->isTalk( $titleBase->getNamespace() );

		$key = $cache->makeKey( 'refreshed', 'header' );
		$headerCategories = $cache->get( $key );
		if ( !$headerCategories ) {
			$headerCategories = [];
			$skin->addToSidebar( $headerCategories, 'refreshed-navigation' );
			$cache->set( $key, $headerCategories, 60 * 60 * 24 ); // 24 hours
		}

		$dropdownCacheKey = $cache->makeKey( 'refreshed', 'dropdownmenu' );
		$siteNavigation = $cache->get( $dropdownCacheKey );
		if ( !$siteNavigation ) {
			$siteNavigation = $this->parseSiteNavigationMenu( 'Refreshed-wiki-dropdown' );
			$cache->set( $dropdownCacheKey, $siteNavigation, 60 * 60 * 24 ); // 24 hours
		}

		// url to this wiki's homepage/page you visit when logo is clicked;
		// to be used with renderCurrentWikiLogoAndLink
		if ( $this->getMsg( 'refreshed-this-wiki-url' )->inContentLanguage()->isDisabled() ) {
			$thisWikiURL = Title::newMainPage()->getFullURL();
		} else {
			$thisWikiURL = $this->getMsg( 'refreshed-this-wiki-url' )->inContentLanguage()->text();
		}

		// url to this wiki's logo image (or null if no such image);
		// to be used with renderCurrentWikiLogoAndLink
		// when picking logo, prioritize the user's language over the content language
		$coreLogos = ResourceLoaderSkinModule::getAvailableLogos( $config );
		if ( isset( $coreLogos['wordmark'] ) ) {
			$wordmarkData = $coreLogos['wordmark'];
			$thisLogoURL = $wordmarkData['src'];
		} elseif ( !$this->getMsg( 'refreshed-this-wiki-wordmark' )->isDisabled() ) {
			$thisLogoURL = $this->getMsg( 'refreshed-this-wiki-wordmark' )->text();
		} elseif ( !$this->getMsg( 'refreshed-this-wiki-wordmark' )->inContentLanguage()->isDisabled() ) {
			$thisLogoURL = $this->getMsg( 'refreshed-this-wiki-wordmark' )->inContentLanguage()->text();
		} else {
			$thisLogoURL = null;
		}

		// this wiki's name; to be used with renderCurrentWikiLogoAndLink
		$thisWikiName = $config->get( 'Sitename' );

		// anchors containing this wiki's logo
		$thisWikiLinkWithLogo = $this->makeWikiLinkWithLogo(
			$thisWikiName, $thisLogoURL, $thisWikiURL,
			'refreshed-logo refreshed-logo-current header-button',
			$this->getMsg( 'tooltip-p-logo' )->text()
		);
		$thisWikiLinkWithSidebarLogo = $this->makeWikiLinkWithLogo(
			$thisWikiName, $thisLogoURL, $thisWikiURL,
			'refreshed-logo refreshed-logo-current refreshed-logo-sidebar-current header-button',
			$this->getMsg( 'tooltip-p-logo' )->text()
		);

		// this wiki's mobile logo image (if there is one)
		// when picking logo, prioritize the user's language over the content language
		if ( isset( $coreLogos['icon'] ) ) {
			$thisMobileLogoURL = $coreLogos['icon'];
		} elseif ( !$this->getMsg( 'refreshed-this-wiki-mobile-logo' )->isDisabled() ) {
			$thisMobileLogoURL = $this->getMsg( 'refreshed-this-wiki-mobile-logo' )->escaped();
		} elseif ( !$this->getMsg( 'refreshed-this-wiki-mobile-logo' )->inContentLanguage()->isDisabled() ) {
			$thisMobileLogoURL = $this->getMsg( 'refreshed-this-wiki-mobile-logo' )->inContentLanguage()->escaped();
		} else {
			$thisMobileLogoURL = null;
		}

		// tools
		$personalTools = $this->getAndRearrangePersonalTools();
		$dropdownPersonalTools = $personalTools['dropdown'];
		$extraPersonalTools = $personalTools['extra'];

		$pageTools = array_merge(
			$this->data['content_navigation']['views'],
			$this->data['content_actions'],
			$this->data['sidebar']['TOOLBOX']
		);
		$pageTools = $this->sortPageTools( $pageTools );

		unset( $this->data['sidebar']['SEARCH'] );
		unset( $this->data['sidebar']['TOOLBOX'] );
		unset( $this->data['sidebar']['LANGUAGES'] );
		$sidebarContentsWikiTools = [];
		if ( !empty( $pageTools['other'] ) ) {
			$sidebarContentsWikiTools = [ $this->getMsg( 'refreshed-wiki-tools' )->text() => $pageTools['other'] ];
		}
		$sidebarContentsLanguages = [];
		if ( !empty( $this->data['language_urls'] ) ) {
			$sidebarContentsLanguages = [ $this->getMsg( 'otherlanguages' )->text() => $this->data['language_urls'] ];
		}
		$sidebarContents = array_merge( $this->data['sidebar'], $sidebarContentsWikiTools, $sidebarContentsLanguages );

		// footer
		$footerIcons = $this->get( 'footericons' );
		foreach ( $footerIcons as $footerIconsKey => &$footerIconsBlock ) {
			foreach ( $footerIconsBlock as $footerIconKey => $footerIcon ) {
				if ( !isset( $footerIcon['src'] ) ) {
					unset( $footerIconsBlock[$footerIconKey] );
				}
			}
		}

		// allow error handling in makeElementWithIconHelper:
		// see https://secure.php.net/manual/en/simplexml.examples-errors.php
		libxml_use_internal_errors( true );

		// Output the <html> tag and whatnot
		?>
		<input type="checkbox" id="sidebar-toggler-checkbox" class="refreshed-checkbox">
		<header id="header-wrapper" role="navigation">
			<div id="sidebar-toggler" class="header-section">
				<label for="sidebar-toggler-checkbox" id="sidebar-toggler-button" class="refreshed-label header-button header-button-textless">
						<?php $this->renderIcon( 'refreshed-menu' ) ?>
						<div class="refreshed-modal-background"></div>
				</label>
			</div>
			<div id="site-navigation-header" class="site-navigation header-section">
				<?php
				if ( $siteNavigation ) {  // if there is a site dropdown (so there are multiple wikis)
					?>
					<nav id="site-navigation-header-dropdown" class="site-navigation-full-logos multiple-wikis refreshed-dropdown" role="listbox">
						<?php echo $thisWikiLinkWithLogo ?><!--
			 	 --><input type="checkbox" id="site-navigation-header-dropdown-checkbox" class="refreshed-dropdown-checkbox refreshed-checkbox"><!--
			   --><label for="site-navigation-header-dropdown-checkbox" id="site-navigation-header-dropdown-button" class="refreshed-label refreshed-dropdown-button header-button site-navigation-button">
							<?php $this->renderIcon( 'refreshed-dropdown-expand' ) ?>
							<div class="refreshed-dropdown-triangle"></div>
							<div class="refreshed-modal-background"></div>
						</label>
						<ul id="site-navigation-header-dropdown-tray" class="refreshed-dropdown-tray site-navigation-tray">
							<?php $this->renderSiteNavigationItems( $siteNavigation ); ?>
						</ul>
					</nav>
					<?php
				} else {  // if only one wiki
					?>
					<div class="site-navigation-full-logos single-wiki">
						<?php echo $thisWikiLinkWithLogo ?>
					</div>
				<?php
				}

				if ( $thisMobileLogoURL !== null ) {  // if a mobile logo has been defined
					?>
					<div class="site-navigation-icon-logos">
						<a class="main header-button" href="<?php echo htmlspecialchars( $thisWikiURL ) ?>">
							<img src="<?php echo $thisMobileLogoURL ?>" alt="<?php echo $thisWikiName ?>" class="site-navigation-logo-img site-navigation-logo-icon" />
						</a>
					</div>
					<?php
				}
				?>
			</div>
			<div id="header-categories-user-info-search-wrapper">
				<div id="explore-header-categories" class="header-section">
					<?php
					if ( $headerCategories ) {
						?>
						<div id="explore-header-categories-overflow-hider">
							<div id="explore-header-categories-sibling"></div>
							<div id="explore-header-categories-dropdowns">
								<div id="explore-dropdown" class="refreshed-dropdown" role="menu">
									<input type="checkbox" id="explore-dropdown-checkbox" class="refreshed-dropdown-checkbox refreshed-checkbox">
									<label for="explore-dropdown-checkbox" id="explore-dropdown-button" class="refreshed-label refreshed-dropdown-button header-button header-category-dropdown-button">
										<?php $this->renderIcon( 'refreshed-explore' ) ?>
										<span class="header-category-name header-text"><?php echo $this->getMsg( 'refreshed-explore' )->escaped() ?></span>
										<?php $this->renderIcon( 'refreshed-dropdown-expand' ) ?>
										<div class="refreshed-modal-background"></div>
										<div class="refreshed-dropdown-triangle"></div>
									</label>
									<ul id="explore-dropdown-tray" class="refreshed-dropdown-tray">
										<?php
										$exploreIndex = 0;
										foreach ( $headerCategories as $name => $headerCategoryDropdown ) {
											?>
											<li id="explore-submenu-<?php echo $exploreIndex ?>-dropdown" class="refreshed-dropdown explore-submenu-dropdown">
												<input type="checkbox" id="explore-submenu-<?php echo $exploreIndex ?>-dropdown-checkbox" class="refreshed-submenu-dropdown-checkbox refreshed-dropdown-checkbox refreshed-checkbox">
												<label for="explore-submenu-<?php echo $exploreIndex ?>-dropdown-checkbox" id="explore-submenu-<?php echo $exploreIndex ?>-dropdown-button" class="refreshed-label refreshed-dropdown-button explore-submenu-dropdown-button">
													<a class="explore-submenu-dropdown-anchor">
														<span class="explore-submenu-name"><?php echo htmlspecialchars( $name ) ?></span>
														<?php $this->renderIcon( 'refreshed-submenu-expand' ) ?>
													</a>
													<div class="refreshed-modal-background"></div>
												</label>
												<ul id="explore-submenu-<?php echo $exploreIndex ?>-dropdown-tray" class="explore-submenu-dropdown-tray refreshed-dropdown-tray">
													<?php $this->renderHeaderCategoryItems( $headerCategoryDropdown ); ?>
												</ul>
											</li>
											<?php
											$exploreIndex++;
										}
										?>
									</ul>
								</div>
								<div id="header-categories-dropdowns">
									<?php
									$headerCategoryDropdownIndex = 0;
									foreach ( $headerCategories as $name => $headerCategoryDropdown ) {
										?>
										<div id="header-category-<?php echo $headerCategoryDropdownIndex ?>-dropdown" class="refreshed-dropdown header-category-dropdown" role="menu">
											<input type="checkbox" id="header-category-<?php echo $headerCategoryDropdownIndex ?>-dropdown-checkbox" class="refreshed-dropdown-checkbox refreshed-checkbox">
											<label for="header-category-<?php echo $headerCategoryDropdownIndex ?>-dropdown-checkbox" id="header-category-<?php echo $headerCategoryDropdownIndex ?>-dropdown-button" class="refreshed-label refreshed-dropdown-button header-button header-category-dropdown-button">
												<span class="header-category-name header-text"><?php echo htmlspecialchars( $name ) ?></span>
												<?php $this->renderIcon( 'refreshed-dropdown-expand' ) ?>
												<div class="refreshed-modal-background"></div>
												<div class="refreshed-dropdown-triangle"></div>
											</label>
											<ul id="header-category-<?php echo $headerCategoryDropdownIndex ?>-dropdown-tray" class="header-category-dropdown-tray refreshed-dropdown-tray">
												<?php $this->renderHeaderCategoryItems( $headerCategoryDropdown ); ?>
											</ul>
										</div>
										<?php
										$headerCategoryDropdownIndex++;
									}
									?>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<div id="user-info-search-wrapper">
					<div id="user-info" class="header-section">
						<?php if ( $extraPersonalTools ) {  // if there are extra personal tools (e.g., for Echo)
							?>
							<div id="extra-personal-tools">
								<ul id="extra-personal-tools-tray">
									<?php $this->renderExtraPersonalTools( $extraPersonalTools )?>
								</ul>
							</div>
							<?php
						}
						?>
						<div id="user-info-dropdown" class="refreshed-dropdown" role="menu">
							<input type="checkbox" id="user-info-dropdown-checkbox" class="refreshed-dropdown-checkbox refreshed-checkbox">
							<label for="user-info-dropdown-checkbox" id="user-info-dropdown-button" class="refreshed-label refreshed-dropdown-button header-button-textless header-button">
								<?php echo $this->makeAvatar( $user ) ?>
								<span class="refreshed-username header-text"><?php echo htmlspecialchars( $this->makeUsernameText( $user ) ) ?></span>
								<?php $this->renderIcon( 'refreshed-dropdown-expand' ) ?>
								<div class="refreshed-modal-background"></div>
								<div class="refreshed-dropdown-triangle"></div>
							</label>
							<ul id="user-info-dropdown-tray" class="refreshed-dropdown-tray personal-tools">
								<?php $this->renderUserDropdownItems( $dropdownPersonalTools ) ?>
							</ul>
						</div>
					</div>
					<div id="header-search" class="header-section">
						<div id="header-search-dropdown" class="refreshed-dropdown">
							<input type="checkbox" id="header-search-dropdown-checkbox" class="refreshed-dropdown-checkbox refreshed-checkbox">
							<label for="header-search-dropdown-checkbox" id="header-search-dropdown-button" class="refreshed-label refreshed-dropdown-button header-button-textless header-button">
								<?php $this->renderIcon( 'search' ) ?>
								<div class="refreshed-modal-background"></div>
								<div class="refreshed-dropdown-triangle"></div>
							</label>
							<form id="header-search-dropdown-tray" class="search-form refreshed-dropdown-tray" action="<?php $this->text( 'wgScript' ) ?>" method="get">
								<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
								<?php
								echo $this->makeSearchInput( [ 'id' => 'searchInput' ] );
								/* The below comment is from Vector:
								 * We construct two buttons (for 'go' and 'fulltext' search modes),
								 * but only one will be visible and actionable at a time (they are
								 * overlaid on top of each other in CSS).
								 * * Browsers will use the 'fulltext' one by default (as it's the
								 *   first in tree-order), which is desirable when they are unable
								 *   to show search suggestions (either due to being broken or
								 *   having JavaScript turned off).
								 * * The mediawiki.searchSuggest module, after doing tests for the
								 *   broken browsers, removes the 'fulltext' button and handles
								 *   'fulltext' search itself; this will reveal the 'go' button and
								 *   cause it to be used.
								 */
								echo $this->makeSearchButton( 'fulltext', [ 'id' => 'mw-searchButton', 'class' => 'searchButton mw-fallbackSearchButton' ] );
								echo $this->makeSearchButton( 'go', [ 'id' => 'searchButton', 'class' => 'searchButton' ] );
								?>
							</form>
						</div>
					</div>
				</div>
			</div>
		</header>
		<div id="sidebar-wrapper">
			<div id="sidebar">
				<div id="site-navigation-sidebar-heading-categories-sidebar-wrapper">
					<div id="site-navigation-sidebar" class="site-navigation sidebar-section">
						<?php
						if ( $siteNavigation ) {  // if there is a site dropdown (so there are multiple wikis)
							?>
							<nav id="site-navigation-sidebar-collapsible" class="site-navigation-full-logos multiple-wikis refreshed-collapsible" role="listbox">
								<input type="checkbox" id="site-navigation-sidebar-collapsible-checkbox" class="refreshed-collapsible-checkbox refreshed-checkbox">
								<?php echo $thisWikiLinkWithSidebarLogo ?><!--
							--><label for="site-navigation-sidebar-collapsible-checkbox" id="site-navigation-sidebar-collapsible-button" class="refreshed-label site-navigation-button refreshed-collapsible-button sidebar-button">
									<?php $this->renderIcon( 'refreshed-collapsible-expand' ) ?>
									<?php $this->renderIcon( 'refreshed-collapsible-collapse' ) ?>
								</label>
								<ul id="site-navigation-sidebar-collapsible-tray" class="refreshed-collapsible-tray site-navigation-tray">
									<?php $this->renderSiteNavigationItems( $siteNavigation ); ?>
								</ul>
							</nav>
							<?php
						} else {  // if only one wiki
							?>
							<div id="site-navigation-sidebar-buttons-wrapper" class="site-navigation-full-logos single-wiki">
								<?php echo $thisWikiLinkWithSidebarLogo ?>
							</div>
						<?php
						}
						?>
					</div>
					<?php
					if ( $headerCategories ) {
						?>
						<div id="header-categories-sidebar" class="sidebar-section">
							<?php
							$headerCategoryCollapsibleIndex = 0;
							foreach ( $headerCategories as $name => $headerCategoryCollapsible ) {
								?>
								<div id="header-category-<?php echo $headerCategoryCollapsibleIndex ?>-collapsible" class="refreshed-collapsible header-category-collapsible sidebar-section" role="menu">
									<input type="checkbox" id="header-category-<?php echo $headerCategoryCollapsibleIndex ?>-collapsible-checkbox" class="refreshed-collapsible-checkbox refreshed-checkbox">
									<label for="header-category-<?php echo $headerCategoryCollapsibleIndex ?>-collapsible-checkbox" id="header-category-<?php echo $headerCategoryCollapsibleIndex ?>-collapsible-button" class="refreshed-label sidebar-button refreshed-collapsible-button header-category-collapsible-button">
										<span class="header-category-name sidebar-heading header-category-sidebar-name"><?php echo htmlspecialchars( $name ) ?></span>
										<span class="header-categories-sidebar-collapsible-icons-wrapper">
											<?php $this->renderIcon( 'refreshed-collapsible-expand' ) ?>
											<?php $this->renderIcon( 'refreshed-collapsible-collapse' ) ?>
										</span>
									</label>
									<ul id="header-category-<?php echo $headerCategoryCollapsibleIndex ?>-collapsible-tray" class="header-category-collapsible-tray refreshed-collapsible-tray">
										<?php $this->renderHeaderCategoryItems( $headerCategoryCollapsible ); ?>
									</ul>
								</div>
								<?php
								$headerCategoryCollapsibleIndex++;
							}
							?>
						</div>
						<?php
					}
					?>
				</div>
				<?php

				foreach ( $sidebarContents as $main => $sub ) {
					// maybe $main is a MediaWiki: message title, like 'newsbox-title'...
					$msgObj = $skin->msg( $main );
					$headerTitle = $msgObj->exists() ? $msgObj->text() : $main;
					?>
					<div class="sidebar-content sidebar-section">
						<span class="sidebar-heading"><?php echo htmlspecialchars( $headerTitle ) ?></span>
						<ul>
							<?php
								// @phan-suppress-next-line SecurityCheck-XSS
								$this->renderSidebarContentSection( $sub )
							?>
						</ul>
					</div>
					<?php
				}

				// Hook point for injecting ads
				Hooks::run( 'RefreshedInSidebar', [ $this ] );
				?>
			</div>
		</div>
		<div id="content-footer-wrapper">
			<div id="content-wrapper" class="mw-body-content" role="main">
				<?php
				if ( $this->data['sitenotice'] ) {
					?>
					<div id="site-notice" role="banner">
						<?php $this->html( 'sitenotice' ) ?>
					</div>
				<?php
				}
				// Only output this if we need to (T153625)
				if ( $this->data['newtalk'] ) {
				?>
					<div id="new-talk">
						<?php $this->html( 'newtalk' ) ?>
					</div>
				<?php
				}
				?>
				<main>
					<article>
						<header id="content-heading">
							<h1 id="firstHeading" class="firstHeading"><?php $this->html( 'title' ) ?></h1>
							<?php echo $this->getIndicators(); ?>
						</header>
						<div id="main-title-messages">
							<div id="siteSub"><?php $this->msg( 'tagline' ) ?></div>
							<?php
							if ( $this->data['subtitle'] || $this->data['undelete'] ) {
								?>
								<div id="contentSub"<?php $this->html( 'userlangattributes' ) ?>><?php $this->html( 'subtitle' ) ?><?php $this->html( 'undelete' ) ?></div>
							<?php
							}
							?>
						</div>
						<input type="checkbox" id="toolbox-dropdown-checkbox" class="refreshed-dropdown-checkbox refreshed-checkbox">
						<div id="refreshed-toolbox" role="menubar">
							<ul id="p-namespaces" class="toolbox-section">
								<?php
								if ( $isTalkNamespace ) {  // if talk namespace
									$this->renderBackToSubjectLink( $linkRenderer, $title );
								}
								$this->renderPageToolsInCategory( 'inline', $pageTools, 'namespaces' );
								?>
							</ul>
							<ul id="p-views" class="toolbox-section">
								<?php $this->renderPageToolsInCategory( 'inline', $pageTools, 'watch' ) ?>
								<?php $this->renderPageToolsInCategory( 'inline', $pageTools, 'main-actions' ) ?>
							</ul>
							<?php if ( !empty( $pageTools['page-tools'] ) || !empty( $pageTools['user-tools'] ) ) {
								?>
								<div id="p-tools" class="refreshed-dropdown toolbox-section toolbox-dropdown" role="menu">
									<label for="toolbox-dropdown-checkbox" id="toolbox-dropdown-button" class="refreshed-label refreshed-dropdown-button" title="<?php echo $this->getMsg( 'toolbox' )->escaped() ?>" aria-label="<?php echo $this->getMsg( 'toolbox' )->escaped() ?>">
										<?php
										$this->renderIcon( 'ellipsis' );
										$this->renderIcon( 'refreshed-dropdown-expand' );
										?>
										<div class="refreshed-modal-background"></div>
										<div id="toolbox-dropdown-triangle" class="refreshed-dropdown-triangle"></div>
									</label>
									<dl id="toolbox-dropdown-tray" class="refreshed-dropdown-tray">
										<?php $this->renderToolboxDropdownItems( $pageTools ) ?>
									</dl>
								</div>
								<?php
							}
							?>
							</div>
							<div id="content" role="article">
								<?php $this->html( 'bodytext' ) ?>
							</div>
						</article>
						<?php
						$this->html( 'catlinks' );
						if ( $this->data['dataAfterContent'] ) {
							$this->html( 'dataAfterContent' );
						}
						?>
					</main>
			</div>
			<footer id="footer-wrapper">
				<?php
				$this->renderExtraFooterItems();
				foreach ( $this->getFooterLinks() as $category => $links ) {
					$this->renderFooterLinksRow( $category, $links );
				}
				if ( count( $footerIcons ) > 0 ) {
					$this->renderFooterIconsRow( $skin, $footerIcons );
				}
				?>
			</footer>
		</div>
		<?php
	}
}
