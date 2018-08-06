<?php

class RefreshedTemplate extends BaseTemplate {
	// list of inline svg icons used throughout the skin
	private static $iconList = [
		'dropdown-expand' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-dropdown-expand ooui-icon-expand">
														<path d="M19 6.25l-1.5-1.5-7.5 7.5-7.5-7.5L1 6.25l9 9 9-9z"/>
													</svg>',
		'user-loggedin' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-user-loggedin ooui-icon-userActive avatar avatar-no-socialprofile">
													<path d="M10 12.5c-5.92 0-9 3.5-9 5.5v1h18v-1c0-2-3.08-5.5-9-5.5z"/>
													<circle cx="10" cy="6" r="5"/>
												</svg>',
		'user-anon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-user-anon ooui-icon-userAnonymous avatar avatar-no-socialprofile">
											<path d="M15 2H5L4 8h12l-1-6zM0 10s2 1 10 1 10-1 10-1l-4-2H4zm6 2a3 3 0 1 0 3 3 3 3 0 0 0-3-3zm8 0a3 3 0 1 0 3 3 3 3 0 0 0-3-3z"/>
											<path d="M8 14h4v1H8z"/>
										</svg>',
		'menu' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-menu ooui-icon-menu">
								<path d="M1 3v2h18V3zm0 8h18V9H1zm0 6h18v-2H1z"/>
							</svg>',
		'more' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-more ooui-icon-ellipsis">
								<circle cx="10" cy="10" r="2"/>
								<circle cx="3" cy="10" r="2"/>
								<circle cx="17" cy="10" r="2"/>
							</svg>',
		'close' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-close ooui-icon-close">
									<path d="M3.636 2.224l14.142 14.142-1.414 1.414L2.222 3.638z"/>
									<path d="M17.776 3.636L3.634 17.778 2.22 16.364 16.362 2.222z"/>
								</svg>',
		'nstab' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-nstab ooui-icon-article-ltr">
									<path d="M15 1H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zM5 4h5v1H5zm0 2h5v1H5zm0 2h5v1H5zm10 7H5v-1h10zm0-2H5v-1h10zm0-2H5v-1h10zm0-2h-4V4h4z"/>
								</svg>',
		'talk' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-talk ooui-icon-speechBubbles-ltr">
								<path d="M18 4h-1v7a2 2 0 0 1-2 2H4v1a2 2 0 0 0 2 2h10l4 4V6a2 2 0 0 0-2-2z"/>
								<path d="M14 0H2a2 2 0 0 0-2 2v14l4-4h10a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
							</svg>',
		'viewsource' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-viewsource ooui-icon-eye">
											<path d="M10 7.5a2.5 2.5 0 1 0 2.5 2.5A2.5 2.5 0 0 0 10 7.5zm0 7a4.5 4.5 0 1 1 4.5-4.5 4.5 4.5 0 0 1-4.5 4.5zM10 3C3 3 0 10 0 10s3 7 10 7 10-7 10-7-3-7-10-7z"/>
										</svg>',
		'edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-edit ooui-icon-edit">
								<path d="M16.77 8l1.94-2a1 1 0 0 0 0-1.41l-3.34-3.3a1 1 0 0 0-1.41 0L12 3.23zm-5.81-3.71L1 14.25V19h4.75l9.96-9.96-4.75-4.75z"/>
							</svg>',
		'addsection' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-addsection ooui-icon-speechBubbleAdd-ltr">
											<path d="M17 1H3a2 2 0 0 0-2 2v16l4-4h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm-2 8h-4v4H9V9H5V7h4V3h2v4h4z"/>
										</svg>',
		'history' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-history ooui-icon-history">
										<path d="M9 6v5h.06l2.48 2.47 1.41-1.41L11 10.11V6H9z"/>
										<path d="M10 1a9 9 0 0 0-7.85 13.35L.5 16H6v-5.5l-2.38 2.38A7 7 0 1 1 10 17v2a9 9 0 0 0 0-18z"/>
									</svg>',
		'delete' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-delete ooui-icon-trash">
									<path d="M17 2h-3.5l-1-1h-5l-1 1H3v2h14zM4 17a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5H4z"/>
								</svg>',
		'undelete' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-undelete ooui-icon-unTrash">
										<path d="M16 14.78L6.22 5l-1-1-2-2-2-2L0 1.22l4 4V17a2 2 0 0 0 2 2h8a2 2 0 0 0 2-1.8l2.8 2.8 1.2-1.22zM17 4V2h-3.5l-1-1h-5l-1 1h-.84l2 2H17zm-1 1H8.66L16 12.34V5z"/>
									</svg>',
		'move' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-move ooui-icon-move">
								<path d="M19 10l-4-3v2h-4V5h2l-3-4-3 4h2v4H5V7l-4 3 4 3v-2h4v4H7l3 4 3-4h-2v-4h4v2l4-3z"/>
							</svg>',
		'protect' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-protect ooui-icon-unLock">
										<path d="M16.07 8H15V5s0-5-5-5a4.63 4.63 0 0 0-4.88 4h2C7.31 2.93 8 2 10 2c3 0 3 2 3 3.5V8H3.93A1.93 1.93 0 0 0 2 9.93v8.15A1.93 1.93 0 0 0 3.93 20h12.14A1.93 1.93 0 0 0 18 18.07V9.93A1.93 1.93 0 0 0 16.07 8zM10 16a2 2 0 1 1 2-2 2 2 0 0 1-2 2z"/>
									</svg>',
		'unprotect' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-unprotect ooui-icon-lock">
										<path d="M16.07 8H15V5s0-5-5-5-5 5-5 5v3H3.93A1.93 1.93 0 0 0 2 9.93v8.15A1.93 1.93 0 0 0 3.93 20h12.14A1.93 1.93 0 0 0 18 18.07V9.93A1.93 1.93 0 0 0 16.07 8zM10 16a2 2 0 1 1 2-2 2 2 0 0 1-2 2zm3-8H7V5.5C7 4 7 2 10 2s3 2 3 3.5z"/>
									</svg>',
		'watch' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-watch ooui-icon-star">
									<path d="M20 7h-7L10 .5 7 7H0l5.46 5.47-1.64 7 6.18-3.7 6.18 3.73-1.63-7zm-10 6.9l-3.76 2.27 1-4.28L3.5 8.5h4.61L10 4.6l1.9 3.9h4.6l-3.73 3.4 1 4.28z"/>
								</svg>',
		'unwatch' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-unwatch ooui-icon-unStar">
										<path d="M20 7h-7L10 .5 7 7H0l5.46 5.47-1.64 7 6.18-3.7 6.18 3.73-1.63-7z"/>
									</svg>',
		'wikilove' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-wikilove ooui-icon-heart">
										<path d="M14.75 1A5.24 5.24 0 0 0 10 4 5.24 5.24 0 0 0 0 6.25C0 11.75 10 19 10 19s10-7.25 10-12.75A5.25 5.25 0 0 0 14.75 1z"/>
									</svg>',
		'purge' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-purge ooui-icon-reload">
									<path d="M15.65 4.35A8 8 0 1 0 17.4 13h-2.22a6 6 0 1 1-1-7.22L11 9h7V2z"/>
								</svg>',
		'report-problem' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-report-problem refreshed-icon-feedback-ltr">
													<path d="M19 16L2 12a3.83 3.83 0 0 1-1-2.5A3.83 3.83 0 0 1 2 7l17-4z"/>
													<rect width="4" height="8" x="4" y="9" rx="2" ry="2"/>
												</svg>',
		'whatlinkshere' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="2 2 20 20" class="refreshed-icon refreshed-icon-whatlinkshere ooui-icon-references-ltr">
													<path d="M3 6v12h4V6H3zm3 10H4v-1h2v1zm0-3H4v-1h2v1zm2-7v12h4V6H8zm3 10H9v-1h2v1zm0-3H9v-1h2v1zm.934-5.353L18 18l3.449-2.021-6.065-10.354-3.45 2.022zm7.643 7.111l-1.726 1.012-.506-.862 1.725-1.012.507.862zM18.06 12.17l-1.725 1.011-.506-.862 1.726-1.012.505.863z"/>
												</svg>',
		'recentchangeslinked' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-recentchangeslinked ooui-icon-stripeSummary-ltr">
																<path d="M1 7h18v2H1zm0 4h14v2H1z"/>
															</svg>',
		'contributions' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-contributions ooui-icon-signature-ltr">
													<path d="M0 18h20v1H0zm-.003-6.155l1.06-1.06 4.363 4.362-1.06 1.06z"/>
													<path d="M.004 15.147l4.363-4.363 1.06 1.061-4.362 4.363zM17 5c0 9-11 9-11 9v-1.5s8 .5 9.5-6.5C16 4 15 2.5 14 2.5S11 4 10.75 10c-.08 2 .75 4.5 3.25 4.5 1.5 0 2-1 3.5-1a2.07 2.07 0 0 1 2.25 2.5h-1.5s.13-1-.5-1C16 15 16 16 14 16c0 0-4.75 0-4.75-6S12 1 14 1c.5 0 3 0 3 4z"/>
												</svg>',
		'blockip' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-blockip ooui-icon-block">
										<path d="M10 1a9 9 0 1 0 9 9 9 9 0 0 0-9-9zm5 10H5V9h10z"/>
									</svg>',
		'log' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-log refreshed-icon-viewDetails-ltr">
								<path d="M8 6h9v2H8zm0-3h11v2H8zM1 3h6v6H1zm7 11h9v2H8zm0-3h11v2H8zm-7 0h6v6H1z"/>
							</svg>',
		'emailuser' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-emailuser ooui-icon-message">
											<path d="M0 8v8a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8l-10 4z"/>
											<path d="M18 2H2a2 2 0 0 0-2 2v2l10 4 10-4V4a2 2 0 0 0-2-2z"/>
										</svg>',
		'userrights' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-userrights ooui-icon-key">
											<path d="M15 6a1.54 1.54 0 0 1-1.5-1.5 1.5 1.5 0 0 1 3 0A1.54 1.54 0 0 1 15 6zm-1.5-5A5.55 5.55 0 0 0 8 6.5a6.81 6.81 0 0 0 .7 2.8L1 17v2h4v-2h2v-2h2l3.2-3.2a5.85 5.85 0 0 0 1.3.2A5.55 5.55 0 0 0 19 6.5 5.55 5.55 0 0 0 13.5 1z"/>
										</svg>',
		'upload' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-upload ooui-icon-upload">
									<path d="M17 12v5H3v-5H1v5a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5z"/>
									<path d="M15 7l-5-6-5 6h4v8h2V7h4z"/>
								</svg>',
		'print' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-print ooui-icon-printer">
									<path d="M5 1h10v4H5zm12 5H3a2 2 0 0 0-2 2v7h4v4h10v-4h4V8a2 2 0 0 0-2-2zm-3 12H6v-6h8zm2-8a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"/>
								</svg>',
		'permalink' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-permalink ooui-icon-link">
											<path d="M4.83 15h2.91a4.88 4.88 0 0 1-1.55-2H5a3 3 0 1 1 0-6h3a3 3 0 0 1 2.82 4h2.1a4.82 4.82 0 0 0 .08-.83v-.34A4.83 4.83 0 0 0 8.17 5H4.83A4.83 4.83 0 0 0 0 9.83v.34A4.83 4.83 0 0 0 4.83 15z"/>
											<path d="M15.17 5h-2.91a4.88 4.88 0 0 1 1.55 2H15a3 3 0 1 1 0 6h-3a3 3 0 0 1-2.82-4h-2.1a4.82 4.82 0 0 0-.08.83v.34A4.83 4.83 0 0 0 11.83 15h3.34A4.83 4.83 0 0 0 20 10.17v-.34A4.83 4.83 0 0 0 15.17 5z"/>
										</svg>',
		'info' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-info ooui-icon-info">
								<path d="M9.5 16A6.61 6.61 0 0 1 3 9.5 6.61 6.61 0 0 1 9.5 3 6.61 6.61 0 0 1 16 9.5 6.63 6.63 0 0 1 9.5 16zm0-14A7.5 7.5 0 1 0 17 9.5 7.5 7.5 0 0 0 9.5 2zm.5 6v4.08h1V13H8.07v-.92H9V9H8V8zM9 6h1v1H9z"/>
							</svg>',
		'smwbrowserlink' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-smwbrowserlink refreshed-icon-puzzle-ltr">
													<circle cx="17" cy="10" r="3"/>
													<path d="M10.58 3A3 3 0 0 1 11 4.5a3 3 0 0 1-6 0A3 3 0 0 1 5.42 3H1v12a2 2 0 0 0 2 2h12V3z"/>
												</svg>'
	];

	/**
	 * Parses MediaWiki:Refreshed-wiki-dropdown.
	 * Forked from Games' parseSidebarMenu(), which in turn was forked from
	 * Monaco's parseSidebarMenu(), but none of these three methods are
	 * identical.
	 *
	 * @param string $messageKey Message name
	 * @return array
	 */
	private function parseSiteNavigationDropdownMenu( $messageKey ) {
		$lines = $this->getLines( $messageKey );
		$nodes = [];
		$i = 0;

		if ( is_array( $lines ) ) {
			foreach ( $lines as $line ) {
				# ignore empty lines
				if ( strlen( $line ) == 0 ) {
					continue;
				}

				$node = $this->parseSiteNavigationDropdownItem( $line );
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
	 * Helper method for parseSiteNavigationDropdownMenu.
	 * Parse one pipe-separated line from MediaWiki message to an array with
	 * indexes "wikiName" (string), "logoURL" (string|null),
	 * "wikiURL" (string|null)
	 * (This array will eventually be used to construct a link in the site
	 * dropdown via renderSiteNavigationDropdownItems.)
	 * Each line follows this format of text seperated by pipe symbols:
	 * name|logo URL|wiki URL.
	 * Special cases:
	 * - If no logo URL is provided (name||wiki URL), 'logoURL' => null.
	 * - If no wiki URL is provided (name|logo URL|badly formed wiki URL, or
	 * name|logo URL|, or name|logo URL), 'wikiURL' => '#'.
	 * - Finally if neither is provided (name or name||) then both of the above
	 * apply.
	 * @param string $line Line (beginning with a *) from a MediaWiki: message
	 * @return array attributes for the resulting link
	 */
	public static function parseSiteNavigationDropdownItem( $line ) {
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
	 * @return array
	 */
	private function getLines( $messageKey ) {
		$title = Title::newFromText( $messageKey, NS_MEDIAWIKI );
		$revision = Revision::newFromTitle( $title );
		if ( is_object( $revision ) ) {
			$contentText = ContentHandler::getContentText( $revision->getContent() );
			if ( trim( $contentText ) != '' ) {
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
	 * @param string|null $iconName string or null if no icon
	 * @return string
	 */
	private function makeIcon( $iconName ) {
		// print_r($iconList);
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

		if ( array_key_exists( $iconName, self::$iconList ) ) {
			return self::$iconList[$iconName];
		}

		return '';
	}

	/**
	 * Render an inline SVG containing the inputted icon to the page.
	 * @param string|null $iconName string or null if no icon
	 * @return string
	 */
	private function renderIcon( $iconName ) {
		echo $this->makeIcon( $iconName );
	}

	/**
	 * Generate a list item using BaseTemplate::makeListItem() that contains the
	 * inline SVG icon specified by $iconName just before the actual link text,
	 * assuming $iconName is specified.
	 * (If the icon name isn't recognized, or the list item or icon HTML can't
	 * be parsed for whatever reason, the list item is returned without
	 * adding the icon.)
	 * @param string $iconName the name of the icon
	 * @param string $key the "$key" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $item the "$item" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $options the "$options" for the standard makeLink/makeListItem
	 *  (see docs); optional
	 * @return string string representing the list item
	 */
	private function makeListItemWithIcon( $iconName = '', $key, $item, $options = [] ) {
		return $this->makeElementWithIconHelper( 'list item', $iconName, $key, $item, $options );
	}

	/**
	 * Generate a link using BaseTemplate::makeLink() that contains the
	 * inline SVG icon specified by $iconName just before the actual link text,
	 * assuming $iconName is specified.
	 * (If the icon name isn't recognized, or the link or icon HTML can't
	 * be parsed for whatever reason, the link is returned without
	 * adding the icon.)
	 * @param string $iconName the name of the icon
	 * @param string $key the "$key" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $item the "$item" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $options the "$options" for the standard makeLink/makeListItem
	 *  (see docs); optional
	 * @return string string representing the link
	 */
	private function makeLinkWithIcon( $iconName = '', $key, $item, $options = [] ) {
		return $this->makeElementWithIconHelper( 'link', $iconName, $key, $item, $options );
	}

	/**
	 * Helper method for makeListItemWithIcon and makeLinkWithIcon.
	 *
	 * Depending on $mode, generate a) a list item containing a link using
	 * BaseTemplate::makeListItem() or b) just a link using
	 * BaseTemplate::makeLink(). Before the actual link text, there is the inline
	 * SVG icon specified by $iconName, assuming $iconName is specified.
	 * (If the icon name isn't recognized, or the list item/link or icon HTML
	 * can't be parsed for whatever reason, the list item/link is returned without
	 * adding the icon.)
	 * @param string $mode Expects either 'list item' or 'link'
	 * @param string $iconName the name of the icon
	 * @param string $key the "$key" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $item the "$item" for the standard makeLink/makeListItem
	 *  (see docs)
	 * @param array $options the "$options" for the standard makeLink/makeListItem
	 *  (see docs); optional
	 * @return string string representing the list item/link
	 */
	private function makeElementWithIconHelper( $mode, $iconName, $key, $item, $options ) {
		// Based on the $mode, either make a list item or link without any icon
		// added yet. If the $mode is invalid, return null.
		if ( $mode === 'list item' ) {
			$outputUnedited = $this->makeListItem( $key, $item, $options );
		} elseif ( $mode === 'link' ) {
			$outputUnedited = $this->makeLink( $key, $item, $options );
		}

		// Get the HTML of the icon we want to add (returns empty string if no icon)
		$icon = $this->makeIcon( $iconName );

		// if there is no icon to add, don't bother doing more processing; just
		// return the list item/link without the icon
		if ( $icon === '' ) {
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

		// Find the child of the first a tag from the last line. Note this may not
		// exist (if a tag is empty), in which case it's null.
		$firstATagChild = $firstATagInListItemOrLink->firstChild;

		$iconInIconDOM = $iconDOM->documentElement;
		// Currently the icon is in the iconDOM. We have to put a copy of it in
		// $listItemOrLinkDOM so we can add the icon to the list item/link
		$iconInListItemOrLinkDOM = $listItemOrLinkDOM->importNode( $iconInIconDOM, true );

		// add the icon to the very beginning of the first a tag
		if ( $firstATagChild === null ) {
			$firstATagInListItemOrLink->appendChild( $iconInListItemOrLinkDOM );
		} else {
			$firstATagInListItemOrLink->insertBefore( $iconInListItemOrLinkDOM, $firstATagChild );
		}

		return $listItemOrLinkDOM->saveHTML();
	}

	/**
	 * Helper method for makeElementWithIconHelper.
	 * Given $text, load it into a DOMDocument as HTML. If all goes as planned
	 * (the input doesn't break the parser), return the resulting DOMDocument.
	 * Otherwise, echo errors and return false.
	 * @param string $text the text to interpret as HTML (shouldn't contain html
	 *  or body tags)
	 * @return DOMDocument|bool DOMDocument if no errors, otherwise false
	 */
	private function loadHTMLHandleErrors( $text ) {
		// error handling per https://secure.php.net/manual/en/simplexml.examples-errors.php
		$doc = new DOMDocument();
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
	 * @param User $user
	 * @return string
	 */
	private function makeAvatar( $user ) {
		// if using SocialProfile (logged in or not), return SocialProfile avatar
		if ( class_exists( 'wAvatar' ) ) {
			$avatar = new wAvatar( $user->getId(), 'l' );
			return $avatar->makeAvatarURL( [
				'class' => 'avatar avatar-image'
			] );
		} elseif ( $this->data['loggedin'] ) { // if no SocialProfile and user is logged in...
			// if wiki has not set custom image for logged in users...
			if ( $this->getMsg( 'refreshed-icon-logged-in' )->isDisabled() ) {
				return $this->makeIcon( 'user-loggedin' );
			} else { // if wiki has set custom image for logged in users...
				return Html::element( 'img', [
					'src' => $this->getMsg( 'refreshed-icon-logged-in' )->escaped(),
					'class' => 'avatar avatar-no-socialprofile avatar-image'
				] );
			}
		} else { // if no SocialProfile and user is not logged in...
			// if wiki has not set a custom image for logged out users
			if ( $this->getMsg( 'refreshed-icon-logged-out' )->isDisabled() ) {
				return $this->makeIcon( 'user-anon' );
			} else { // if wiki has set custom image for logged out users
				return Html::element( 'img', [
					'src' => $this->getMsg( 'refreshed-icon-logged-out' )->escaped(),
					'class' => 'avatar avatar-no-socialprofile avatar-image'
				] );
			}
		}
	}

	/**
	 * Get the username text (string) to be displayed in the header.
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
	 * Inspired by and partially adapted from the Timeless skin's getUserLinks
	 * function.
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
		 return [ 'dropdown' => $dropdownTools, 'extra' => $extraTools ];
	 }

	/**
	 * Render the list items to be displayed next to the user dropdown
	 * (e.g., for Echo).
	 * Inspired by how Timeless handles Echo.
	 * @param array $extraPersonalTools
	 */
	private function renderExtraPersonalTools( $extraPersonalTools ) {
		foreach ( $extraPersonalTools as $key => $item ) {
			echo $this->makeListItem( $key, $item );
		}
	}

	/**
	 * Render the list items to be displayed in the header's user dropdown.
	 * @param array $dropdownPersonalTools
	 */
	private function renderUserDropdownItems( $dropdownPersonalTools ) {
		foreach ( $dropdownPersonalTools as $keyAndIconName => $item ) {
			echo $this->makeListItemWithIcon( $keyAndIconName, $keyAndIconName, $item );
		}
	}


	/**
	 * Render the items of the site navigation dropdown to appear in the header.
	 * @param array $siteNavigationDropdown an array containing info for the site
	 *  navigation dropdown
	 */
	private function renderSiteNavigationDropdownItems( $siteNavigationDropdown ) {
		// (each item in $siteNavigationDropdown was an output of
		// parseSiteNavigationDropdownItem)
		// we're making a bunch of list items here (<li> elements, but NOT ones
		// created via makeListItem or makeListItemWithIcon...)

		// the classes to add to each of the dropdown anchors
		$classList = 'refreshed-logo refreshed-logo-other';

		foreach ( $siteNavigationDropdown as $wikiLogoInfo ) {
			// send each of the parsed pieces of wiki logo info to renderWikiLogo
			// for rendering
			echo Html::rawElement( 'li', [
				'class' => 'refreshed-dropdown-item header-dropdown-item site-navigation-dropdown-item'
			], $this->makeWikiLinkWithLogo( $wikiLogoInfo['wikiName'], $wikiLogoInfo['logoURL'], $wikiLogoInfo['wikiURL'], $classList ) );
		}
	}

	/**
	 * Render the items of the header category dropdown to appear in the header.
	 * @param array $headerCategoryDropdown an array containing info for a header
	 *  category dropdown
	 */
	private function renderHeaderCategoryDropdownItems( $headerCategoryDropdown ) {
		foreach ( $headerCategoryDropdown as $key => $value ) {
			echo Html::rawElement( 'li', [
				'class' => 'refreshed-dropdown-item header-dropdown-item header-category-dropdown-item'
			], $this->makeLink( $key, $value ) );
		}
	}

	/**
	 * Output as a string an anchor for a wiki, with the wiki's logo inside.
	 * @param string $wikiName the wiki's name
	 * @param string|null $logoURL URL to the wiki's logo image (if null, render
	 *  logo as text)
	 * @param string $wikiURL the URL the anchor goes to
	 * @param string $classList a list of the classes to add to the outputted
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
			return Html::element( 'a', $anchorAttribs, $wikiName );
		} else {
			$image = Html::element( 'img', [
				'src' => $logoURL,
				'alt' => $wikiName,
			] );
			return Html::rawElement( 'a', $anchorAttribs, $image );
		}
	}

	public function execute() {
		global $wgMemc;

		$skin = $this->getSkin();
		$config = $skin->getConfig();
		$user = $skin->getUser();

		// Title processing
		$titleBase = $skin->getTitle();
		$title = $titleBase->getSubjectPage();
		$titleNamespace = $titleBase->getNamespace();

		$key = $wgMemc->makeKey( 'refreshed', 'header' );
		$headerCategoriesDropdowns = $wgMemc->get( $key );
		if ( !$headerCategoriesDropdowns ) {
			$headerCategoriesDropdowns = [];
			$skin->addToSidebar( $headerCategoriesDropdowns, 'refreshed-navigation' );
			$wgMemc->set( $key, $headerCategoriesDropdowns, 60 * 60 * 24 ); // 24 hours
		}

		$dropdownCacheKey = $wgMemc->makeKey( 'refreshed', 'dropdownmenu' );
		$siteNavigationDropdown = $wgMemc->get( $dropdownCacheKey );
		if ( !$siteNavigationDropdown ) {
			$siteNavigationDropdown = $this->parseSiteNavigationDropdownMenu( 'Refreshed-wiki-dropdown' );
			$wgMemc->set( $dropdownCacheKey, $siteNavigationDropdown, 60 * 60 * 24 ); // 24 hours
		}

		// url to this wiki's homepage/page you visit when logo is clicked;
		// to be used with renderCurrentWikiLogoAndLink
		$thisWikiURLMsg = $skin->msg( 'refreshed-this-wiki-url' );
		if ( $thisWikiURLMsg->isDisabled() ) {
			$thisWikiURL = htmlspecialchars( Title::newMainPage()->getFullURL() );
		} else {
			$thisWikiURL = $skin->msg( 'refreshed-this-wiki-url' )->escaped();
		}

		// url to this wiki's logo image (or null if no such image);
		// to be used with renderCurrentWikiLogoAndLink
		$thisLogoURLMsg = $skin->msg( 'refreshed-this-wiki-wordmark' );
		if ( $thisLogoURLMsg->isDisabled() ) {
			$thisLogoURL = null;
		} else {
			$thisLogoURL = $skin->msg( 'refreshed-this-wiki-wordmark' )->escaped();
		}

		// this wiki's name; to be used with renderCurrentWikiLogoAndLink
		$thisWikiName = $config->get( 'Sitename' );

		// anchor containing this wiki's logo
		$thisWikiLinkWithLogo = $this->makeWikiLinkWithLogo( $thisWikiName, $thisLogoURL, $thisWikiURL, 'refreshed-logo refreshed-logo-current main header-button', $skin->msg( 'Tooltip-p-logo' ) );
		$thisWikiLinkWithSidebarLogo = $this->makeWikiLinkWithLogo( $thisWikiName, $thisLogoURL, $thisWikiURL, 'refreshed-logo refreshed-logo-current main', $skin->msg( 'Tooltip-p-logo' ) );


		$thisWikiMobileLogo = $skin->msg( 'refreshed-this-wiki-mobile-logo' );
		$thisWikiMobileLogoImgElement = '';
		if ( !$thisWikiMobileLogo->isDisabled() ) {
			$thisWikiMobileLogoImgElement = Html::element( 'img', [
				'src' => $thisWikiMobileLogo->escaped(),
				'alt' => $config->get( 'Sitename' ),
				'class' => 'refreshed-logo'
			] );
		}

		$personalTools = $this->getAndRearrangePersonalTools();
		$dropdownPersonalTools = $personalTools['dropdown'];
		$extraPersonalTools = $personalTools['extra'];

		// allow error handling in makeElementWithIconHelper:
		// see https://secure.php.net/manual/en/simplexml.examples-errors.php
		libxml_use_internal_errors( true );

		// Output the <html> tag and whatnot
		$this->html( 'headelement' );
		?>
		<a id="fade-overlay" role="presentation"></a>
		<header id="header-wrapper">
			<section id="site-info" class="header-section">
				<?php
				if ( $siteNavigationDropdown ) { // if there is a site dropdown (so there are multiple wikis)
					?>
					<nav id="site-info-main" class="multiple-wikis">
						<?php echo $thisWikiLinkWithLogo ?>
						<div id="site-navigation-dropdown" class="refreshed-dropdown">
							<a id="site-navigation-dropdown-button" class="refreshed-dropdown-button header-button">
								<?php $this->renderIcon( 'dropdown-expand' ) ?>
								<div class="refreshed-dropdown-triangle"></div>
							</a>
							<ul id="site-navigation-dropdown-tray" class="refreshed-dropdown-tray">
								<?php $this->renderSiteNavigationDropdownItems( $siteNavigationDropdown ); ?>
							</ul>
						</div>
					</nav>
					<?php
				} else { // if only one wiki
					?>
					<div id="site-info-main">
						<?php echo $thisWikiLinkWithLogo ?>
					</div>
				<?php
				}

				if ( !$thisWikiMobileLogo->isDisabled() ) { // if a mobile logo has been defined
					?>
					<div id="site-info-mobile">
						<a class="main header-button" href="<?php echo $thisWikiURL ?>"><?php echo $thisWikiMobileLogoImgElement ?></a>
					</div>
					<?php
				}
				?>
			</section>
			<div id="header-categories-user-info-search-wrapper">
				<div id="user-info-search-wrapper">
					<section id="user-info" class="header-section">
						<?php if ( $extraPersonalTools ) { // if there are extra personal tools (e.g., for Echo)
							?>
							<div id="extra-personal-tools">
								<ul id="extra-personal-tools-tray" class="personal-tools">
									<?php $this->renderExtraPersonalTools( $extraPersonalTools ) ?>
								</ul>
							</div>
							<?php
						}
						?>
						<div id="user-info-dropdown" class="refreshed-dropdown">
							<a id="user-info-dropdown-button" class="refreshed-dropdown-button header-button">
								<?php echo $this->makeAvatar( $user ) ?>
								<span class="refreshed-username"><?php echo $this->makeUsernameText( $user ) ?></span>
								<?php $this->renderIcon( 'dropdown-expand' ) ?>
								<div class="refreshed-dropdown-triangle"></div>
							</a>
							<ul id="user-info-dropdown-tray" class="refreshed-dropdown-tray personal-tools">
								<?php $this->renderUserDropdownItems( $dropdownPersonalTools ) ?>
							</ul>
						</div>
					</section>
					<section class="search header-section">
						<a class="search-shower header-button fade-trigger fadable">
							<span class="wikiglyph wikiglyph-magnifying-glass"></span>
						</a>
						<a class="search-closer header-button fade-trigger fadable faded">
							<span class="wikiglyph wikiglyph-x"></span>
						</a>
						<form class="search-form fadable faded" action="<?php $this->text( 'wgScript' ) ?>" method="get">
							<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
							<?php echo $this->makeSearchInput( [ 'id' => 'searchInput' ] ) ?>
						</form>
					</section>
				</div>
				<?php
				if ( $headerCategoriesDropdowns ) {
					?>
					<section id="header-categories" class="header-section">
						<div id="header-categories-overflow-wrapper">
							<?php
							foreach ( $headerCategoriesDropdowns as $name => $headerCategoryDropdown ) {
								?>
								<div class="refreshed-dropdown header-category-dropdown">
									<a class="refreshed-dropdown-button header-button header-category-button">
										<span class="header-category-name"><?php echo htmlspecialchars( $name ) ?></span>
										<?php $this->renderIcon( 'dropdown-expand' ) ?>
										<div class="refreshed-dropdown-triangle"></div>
									</a>
									<ul class="refreshed-header-category-dropdown-tray refreshed-dropdown-tray">
										<?php $this->renderHeaderCategoryDropdownItems( $headerCategoryDropdown ); ?>
									</ul>
								</div>
								<?php
							}
							?>
						</div>
					</section>
					<?php
				}
				?>
			</div>
		</header>
		<aside id="sidebar-wrapper">
			<a class="sidebar-shower header-button"><?php $this->renderIcon( 'menu' ); ?></a>
			<div id="sidebar-logo">
				<?php echo $thisWikiLinkWithSidebarLogo ?>
			</div>
			<div id="sidebar">
				<?php
				unset( $this->data['sidebar']['SEARCH'] );
				unset( $this->data['sidebar']['TOOLBOX'] );
				unset( $this->data['sidebar']['LANGUAGES'] );

				foreach ( $this->data['sidebar'] as $main => $sub ) {
					?>
					<section class="sidebar-section">
						<h1 class="main"><?php echo htmlspecialchars( $main ) ?></h1>
						<ul>
							<?php
							if ( is_array( $sub ) ) { // MW-generated stuff from the sidebar message
								foreach ( $sub as $key => $action ) {
									echo $this->makeListItem(
										$key,
										$action,
										[
											'link-class' => 'sub',
											'link-fallback' => 'span'
										]
									);
								}
							} else {
								// allow raw HTML block to be defined by extensions (like NewsBox)
								echo $sub;
							}
							?>
						</ul>
					</section>
					<?php
				}

				if ( $this->data['language_urls'] ) {
					?>
					<section class="sidebar-section">
						<h1 class="main"><?php echo $this->getMsg( 'otherlanguages' )->text() ?></h1>
							<ul id="languages">
								<?php
								foreach ( $this->data['language_urls'] as $key => $link ) {
									echo $this->makeListItem( $key, $link, [ 'link-class' => 'sub', 'link-fallback' => 'span' ] );
								}
								?>
							</ul>
						</div>
					</section>
					<?php
				}

				// Hook point for injecting ads
				Hooks::run( 'RefreshedInSidebar', [ $this ] ); ?>
			</div>
		</aside>
		<div id="content-wrapper" class="mw-body-content">
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
			<?php } ?>
			<main id="content">
				<article>
					<header id="content-heading">
						<?php
						if ( method_exists( $this, 'getIndicators' ) ) {
							echo $this->getIndicators();
						}
						?>
						<h1 id="firstHeading" class="scroll-shadow"><?php $this->html( 'title' ) ?></h1>
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
						<div class="standard-toolbox static-toolbox" role="menubar">
							<?php
							$lastLinkOutsideOfStandardToolboxDropdownHasBeenGenerated = false;
							$amountOfToolsGenerated = 0;

							$toolbox = $this->getToolbox();

							// if there are actions like "edit," etc.
							// (not counting generic toolbox tools like "upload file")
							// in addition to non-page-specific ones like "page" (so a "more..." link is needed)
							if ( sizeof( $this->data['content_actions'] ) > 1 ) {
								foreach ( $this->data['content_actions'] as $key => $action ) {
									if ( !$lastLinkOutsideOfStandardToolboxDropdownHasBeenGenerated ) { // this runs until all the actions outside the dropdown have been generated (generates actions outside dropdown)
										// echo $key;
										echo $this->makeLinkWithIcon( $key, $key, $action, [
											'text-wrapper' => [
												'tag' => 'span'
											]
										] );
										$amountOfToolsGenerated++;
										if (
											sizeof( $this->data['content_actions'] ) == $amountOfToolsGenerated ||
											$key == 'history' || $key == 'addsection' ||
											$key == 'protect' || $key == 'unprotect'
										)
										{
											// if this is the last action or it is the
											// history, new section, or protect/unprotect action
											// (whichever comes first)
											$lastLinkOutsideOfStandardToolboxDropdownHasBeenGenerated = true;
											?>
											<div class="toolbox-container">
												<a class="toolbox-link collapse-trigger"><?php echo $this->getMsg( 'moredotdotdot' )->text() ?></a>
												<div class="standard-toolbox-dropdown refreshed-menu-collapsible refreshed-menu-collapsed">
													<div class="dropdown-triangle"></div>
													<ul>
										<?php
										}
									} else { // generates actions inside dropdown
										?>
										<li class="toolbox-dropdown-item toolbox-dropdown-page-action">
											<?php echo $this->makeListItemWithIcon( $key, $key, $action, [
												'text-wrapper' => [
													'tag' => 'span',
													'attributes' => [
														'class' => 'toolbox-item-text'
													]
												]
											] );
											?>
										</li>
										<?php
									}
								}
								foreach ( $toolbox as $tool => $toolData ) { // generates toolbox tools inside dropdown (e.g. "upload file")
									?>
									<li class="toolbox-dropdown-item toolbox-dropdown-tool">
										<?php echo $this->makeListItemWithIcon( $tool, $tool, $toolData, [
											'text-wrapper' => [
												'tag' => 'span',
												'attributes' => [
													'class' => 'toolbox-item-text'
												]
											]
										] );
										?>
									</li>
									<?php
								}
							} else { // if there aren't actions like edit, etc. (so a "tools" link is needed instead of a "more..." link)
								foreach ( $this->data['content_actions'] as $key => $action ) { // generates first link (i.e. "page" button on the mainspace, "special page" on Special namespace, etc.); the foreach loop should once run once since there should only be one link
									echo $this->makeLinkWithIcon( $key, $key, $action );
								}
							?>
								<div class="toolbox-container">
									<a class="toolbox-link collapse-trigger"><?php echo $this->getMsg( 'toolbox' )->text() ?></a>
									<div class="standard-toolbox-dropdown refreshed-menu-collapsible refreshed-menu-collapsed">
										<div class="dropdown-triangle"></div>
										<ul>
											<?php
											foreach ( $toolbox as $tool => $toolData ) { // generates toolbox tools inside dropdown (e.g. "upload file")
												if ( $tool == 'feeds' ) {
													// HACK! Technically this should
													// use $wgAdvertisedFeedTypes, which
													// *can* include 'rss' in addition
													// to 'atom', but only 'atom'
													// is enabled by default.
													// I wasn't able to get 'rss' working
													// locally either, so...
													$dataForLink = $toolData['links']['atom'];
												} else {
													$dataForLink = $toolData;
												}
												?>
												<li class="toolbox-dropdown-item tool-dropdown-item toolbox-dropdown-tool">
													<?php echo $this->makeLinkWithIcon( $tool, $tool, $dataForLink, [
														'text-wrapper' => [
															'tag' => 'span',
															'attributes' => [
																'class' => 'toolbox-item-text'
															]
														]
													] );
													?>
											</li>
												<?php
											}
							}
							// Avoid PHP 7.1 warning of passing $this by reference
							$template = $this;
							Hooks::run( 'SkinTemplateToolboxEnd', [ &$template, true ] );
							?>
										</ul>
								</div>
							</div>
						</div>
						<?php
						if ( MWNamespace::isTalk( $titleNamespace ) ) { // if talk namespace
							echo Linker::link(
								$title,
								$this->getMsg( 'backlinksubtitle', $title->getPrefixedText() )->escaped(),
								[ 'id' => 'back-to-subject' ]
							);
						}
						?>
					</header>
					<?php
					reset( $this->data['content_actions'] );
					$pageTab = key( $this->data['content_actions'] );
					$isEditing = in_array(
						$skin->getRequest()->getText( 'action' ),
						[ 'edit', 'submit' ]
					);

					// determining how many tools need to be generated
					$totalSmallToolsToGenerate = 0;
					$listOfToolsToGenerate = [
						'wikiglyph wikiglyph-speech-bubbles' => 'ca-talk',
						'wikiglyph wikiglyph-pencil-lock-full' => 'ca-viewsource',
						'wikiglyph wikiglyph-pencil' => 'ca-edit',
						'wikiglyph wikiglyph-clock' => 'ca-history',
						'wikiglyph wikiglyph-trash' => 'ca-delete',
						'wikiglyph wikiglyph-move' => 'ca-move',
						'wikiglyph wikiglyph-lock' => 'ca-protect',
						'wikiglyph wikiglyph-unlock' => 'ca-unprotect',
						'wikiglyph wikiglyph-star' => 'ca-watch',
						'wikiglyph wikiglyph-unstar' => 'ca-unwatch'
					];

					foreach ( $this->data['content_actions'] as $action ) {
						if ( in_array( $action['id'], $listOfToolsToGenerate ) ) { // if the icon in question is one of the listed ones
							$totalSmallToolsToGenerate++;
						}
					}
					if ( MWNamespace::isTalk( $titleNamespace ) ) { // if talk namespace
						$totalSmallToolsToGenerate--; // remove a tool (the talk page tool) if the user is on a talk page
					}

					if ( $totalSmallToolsToGenerate > 0 && !$isEditing ) { // if there's more than zero tools to be generated and the user isn't editing a page
						?>
						<div id="small-toolbox-wrapper">
							<div class="small-toolbox">
								<?php
								$smallToolBeingTested = 1;
								$amountOfSmallToolsToSkipInFront = 1; // skip the "page" (or equivalent) link
								$amountOfSmallToolsGenerated = 0;

								if ( MWNamespace::isTalk( $titleNamespace ) ) { // if talk namespace
									$amountOfSmallToolsToSkipInFront = 2; // skip the "page" (or equivalent) and "talk" links
								}
								foreach ( $this->data['content_actions'] as $action ) {
									if ( $smallToolBeingTested > $amountOfSmallToolsToSkipInFront ) { // if we're not supposed to skip this tool (e.g. if we're supposed to skip the first 2 tools and we're at the 3rd tool, then the boolean is true)
										// @todo Maybe write a custom makeLink()-like function for generating this code?
										if ( in_array( $action['id'], $listOfToolsToGenerate ) ) { // if the icon being rendered is one of the listed ones (if we're supposed to generate this tool)
											?><a href="<?php echo htmlspecialchars( $action['href'] ) ?>" title="<?php echo $action['text'] ?>" class="small-tool"><span class="<?php echo array_search( $action['id'], $listOfToolsToGenerate ) // key (wikiglyph) from $listOfToolsToGenerate ?>"></span></a><?php
											$amountOfSmallToolsGenerated++; // if a tool is indeed generated, increment this variable
										}
									}
									$smallToolBeingTested++; // increment this variable (amount of tools that have been tested) regardless of whether or not the tool was generated
								}
								?>
							</div><?php if ( $totalSmallToolsToGenerate > 3 ) { ?><div id="small-tool-more"><a title="<?php echo $this->getMsg( 'moredotdotdot' )->text() ?>" class="small-tool"><span class="wikiglyph wikiglyph-ellipsis"></span></a></div><?php } ?>
						</div>
						<?php
					}
					?>
					<div id="bodyContent" role="article">
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
		<footer id="footer">
			<?php
			$footerExtra = '';
			Hooks::run( 'RefreshedFooter', [ &$footerExtra ] );
			echo $footerExtra;

			foreach ( $this->getFooterLinks() as $category => $links ) {
				?>
				<ul class="footer-row">
					<?php
					foreach ( $links as $link ) {
						?>
						<li class="footer-row-item"><?php $this->html( $link ); ?></li>
						<?php
						$noSkip = true;
					}
					?>
				</ul>
				<?php
			}
			$footerIcons = $this->getFooterIcons( 'icononly' );
			if ( count( $footerIcons ) > 0 ) { ?>
				<ul class="footer-row">
				<?php foreach ( $footerIcons as $blockName => $footerIcons ) {
						foreach ( $footerIcons as $icon ) {
							?>
							<li class="footer-row-item"><?php echo $skin->makeFooterIcon( $icon ); ?></li>
							<?php
						}
				}
				?>
				</ul> <?php
			}
			?>
		</footer>
		<?php
		$this->printTrail();
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
	}
}
