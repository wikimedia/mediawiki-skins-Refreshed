<?php

use MediaWiki\MediaWikiServices;

class RefreshedTemplate extends BaseTemplate {
	// list of inline svg icons used throughout the skin
	private static $iconListAllDirections = [
		'blockip' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-blockip ooui-icon-block" aria-hidden="true">
										<path d="M10 1a9 9 0 1 0 9 9 9 9 0 0 0-9-9zm5 10H5V9h10z"/>
									</svg>',
		'citethispage' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-cite ooui-icon-reference" aria-hidden="true">
									<path d="M15 1v9l-2.78-2.78L9.44 10V1H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2z"/>
								</svg>',
		'close' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-close ooui-icon-close" aria-hidden="true">
									<path d="M3.636 2.224l14.142 14.142-1.414 1.414L2.222 3.638z"/>
									<path d="M17.776 3.636L3.634 17.778 2.22 16.364 16.362 2.222z"/>
								</svg>',
		'delete' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-delete ooui-icon-trash" aria-hidden="true">
									<path d="M17 2h-3.5l-1-1h-5l-1 1H3v2h14zM4 17a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5H4z"/>
								</svg>',
		'edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-edit ooui-icon-edit" aria-hidden="true">
								<path d="M16.77 8l1.94-2a1 1 0 0 0 0-1.41l-3.34-3.3a1 1 0 0 0-1.41 0L12 3.23zm-5.81-3.71L1 14.25V19h4.75l9.96-9.96-4.75-4.75z"/>
							</svg>',
		'ellipsis' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-ellipsis ooui-icon-ellipsis" aria-hidden="true">
										<circle cx="10" cy="10" r="2"/>
										<circle cx="3" cy="10" r="2"/>
										<circle cx="17" cy="10" r="2"/>
									</svg>',
		'emailuser' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-emailuser ooui-icon-message" aria-hidden="true">
											<path d="M0 8v8a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8l-10 4z"/>
											<path d="M18 2H2a2 2 0 0 0-2 2v2l10 4 10-4V4a2 2 0 0 0-2-2z"/>
										</svg>',
		'feeds' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="refreshed-icon refreshed-icon-feeds font-awesome-icon-rss-square" aria-hidden="true">
											<path d="M400 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zM112 416c-26.51 0-48-21.49-48-48s21.49-48 48-48 48 21.49 48 48-21.49 48-48 48zm157.533 0h-34.335c-6.011 0-11.051-4.636-11.442-10.634-5.214-80.05-69.243-143.92-149.123-149.123-5.997-.39-10.633-5.431-10.633-11.441v-34.335c0-6.535 5.468-11.777 11.994-11.425 110.546 5.974 198.997 94.536 204.964 204.964.352 6.526-4.89 11.994-11.425 11.994zm103.027 0h-34.334c-6.161 0-11.175-4.882-11.427-11.038-5.598-136.535-115.204-246.161-251.76-251.76C68.882 152.949 64 147.935 64 141.774V107.44c0-6.454 5.338-11.664 11.787-11.432 167.83 6.025 302.21 141.191 308.205 308.205.232 6.449-4.978 11.787-11.432 11.787z"/>
										</svg>',
		'history' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-history ooui-icon-history" aria-hidden="true">
										<path d="M9 6v5h.06l2.48 2.47 1.41-1.41L11 10.11V6H9z"/>
										<path d="M10 1a9 9 0 0 0-7.85 13.35L.5 16H6v-5.5l-2.38 2.38A7 7 0 1 1 10 17v2a9 9 0 0 0 0-18z"/>
									</svg>',
		'info' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-info ooui-icon-info" aria-hidden="true">
								<path d="M9.5 16A6.61 6.61 0 0 1 3 9.5 6.61 6.61 0 0 1 9.5 3 6.61 6.61 0 0 1 16 9.5 6.63 6.63 0 0 1 9.5 16zm0-14A7.5 7.5 0 1 0 17 9.5 7.5 7.5 0 0 0 9.5 2zm.5 6v4.08h1V13H8.07v-.92H9V9H8V8zM9 6h1v1H9z"/>
							</svg>',
		'more' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-more ooui-icon-ellipsis" aria-hidden="true">
								<circle cx="10" cy="10" r="2"/>
								<circle cx="3" cy="10" r="2"/>
								<circle cx="17" cy="10" r="2"/>
							</svg>',
		'move' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-move ooui-icon-move" aria-hidden="true">
								<path d="M19 10l-4-3v2h-4V5h2l-3-4-3 4h2v4H5V7l-4 3 4 3v-2h4v4H7l3 4 3-4h-2v-4h4v2l4-3z"/>
							</svg>',
		'permalink' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-permalink ooui-icon-link" aria-hidden="true">
											<path d="M4.83 15h2.91a4.88 4.88 0 0 1-1.55-2H5a3 3 0 1 1 0-6h3a3 3 0 0 1 2.82 4h2.1a4.82 4.82 0 0 0 .08-.83v-.34A4.83 4.83 0 0 0 8.17 5H4.83A4.83 4.83 0 0 0 0 9.83v.34A4.83 4.83 0 0 0 4.83 15z"/>
											<path d="M15.17 5h-2.91a4.88 4.88 0 0 1 1.55 2H15a3 3 0 1 1 0 6h-3a3 3 0 0 1-2.82-4h-2.1a4.82 4.82 0 0 0-.08.83v.34A4.83 4.83 0 0 0 11.83 15h3.34A4.83 4.83 0 0 0 20 10.17v-.34A4.83 4.83 0 0 0 15.17 5z"/>
										</svg>',
		'print' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-print ooui-icon-printer" aria-hidden="true">
									<path d="M5 1h10v4H5zm12 5H3a2 2 0 0 0-2 2v7h4v4h10v-4h4V8a2 2 0 0 0-2-2zm-3 12H6v-6h8zm2-8a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"/>
								</svg>',
		'protect' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-protect ooui-icon-unLock" aria-hidden="true">
										<path d="M16.07 8H15V5s0-5-5-5a4.63 4.63 0 0 0-4.88 4h2C7.31 2.93 8 2 10 2c3 0 3 2 3 3.5V8H3.93A1.93 1.93 0 0 0 2 9.93v8.15A1.93 1.93 0 0 0 3.93 20h12.14A1.93 1.93 0 0 0 18 18.07V9.93A1.93 1.93 0 0 0 16.07 8zM10 16a2 2 0 1 1 2-2 2 2 0 0 1-2 2z"/>
									</svg>',
		'purge' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-purge ooui-icon-reload" aria-hidden="true">
									<path d="M15.65 4.35A8 8 0 1 0 17.4 13h-2.22a6 6 0 1 1-1-7.22L11 9h7V2z"/>
								</svg>',
		'recentchangeslinked' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-recentchangeslinked ooui-icon-mapTrail" aria-hidden="true">
																<path d="M20 6l-1-1-1.5 1.5L16 5l-1 1 1.5 1.5L15 9l1 1 1.5-1.5L19 10l1-1-1.5-1.5L20 6zm-9 8.5A3.54 3.54 0 0 1 7.5 18a3.5 3.5 0 0 1 0-7 3.54 3.54 0 0 1 3.5 3.5z"/>
																<circle cx="7" cy="3" r="2"/>
																<circle cx="13" cy="7" r="1"/>
																<circle cx="10" cy="6" r="1"/>
																<circle cx="3" cy="3" r="1"/>
																<circle cx="1" cy="6" r="1"/>
																<circle cx="1" cy="9" r="1"/>
																<circle cx="3" cy="12" r="1"/>
															</svg>',
		'refreshed-collapsible-collapse' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-refreshed-collapsible-collapse ooui-icon-collapse" aria-hidden="true">
																					<path d="M1 13.75l1.5 1.5 7.5-7.5 7.5 7.5 1.5-1.5-9-9-9 9z"/>
																				</svg>',
		'refreshed-collapsible-expand' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-refreshed-collapsible-expand ooui-icon-expand" aria-hidden="true">
																				<path d="M19 6.25l-1.5-1.5-7.5 7.5-7.5-7.5L1 6.25l9 9 9-9z"/>
																			</svg>',
		'refreshed-dropdown-expand' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-refreshed-dropdown-expand ooui-icon-expand" aria-hidden="true">
																			<path d="M19 6.25l-1.5-1.5-7.5 7.5-7.5-7.5L1 6.25l9 9 9-9z"/>
																		</svg>',
		'refreshed-menu' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-refreshed-menu ooui-icon-menu" aria-hidden="true">
								<path d="M1 3v2h18V3zm0 8h18V9H1zm0 6h18v-2H1z"/>
							</svg>',
		'search' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-search ooui-icon-search" aria-hidden="true">
									<path d="M19 17l-5.15-5.15a7 7 0 1 0-2 2L17 19zM3.5 8A4.5 4.5 0 1 1 8 12.5 4.5 4.5 0 0 1 3.5 8z"/>
								</svg>',
		'undelete' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-undelete ooui-icon-unTrash" aria-hidden="true">
										<path d="M16 14.78L6.22 5l-1-1-2-2-2-2L0 1.22l4 4V17a2 2 0 0 0 2 2h8a2 2 0 0 0 2-1.8l2.8 2.8 1.2-1.22zM17 4V2h-3.5l-1-1h-5l-1 1h-.84l2 2H17zm-1 1H8.66L16 12.34V5z"/>
									</svg>',
		'unprotect' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-unprotect ooui-icon-lock" aria-hidden="true">
										<path d="M16.07 8H15V5s0-5-5-5-5 5-5 5v3H3.93A1.93 1.93 0 0 0 2 9.93v8.15A1.93 1.93 0 0 0 3.93 20h12.14A1.93 1.93 0 0 0 18 18.07V9.93A1.93 1.93 0 0 0 16.07 8zM10 16a2 2 0 1 1 2-2 2 2 0 0 1-2 2zm3-8H7V5.5C7 4 7 2 10 2s3 2 3 3.5z"/>
									</svg>',
		'upload' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-upload ooui-icon-upload" aria-hidden="true">
									<path d="M17 12v5H3v-5H1v5a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5z"/>
									<path d="M15 7l-5-6-5 6h4v8h2V7h4z"/>
								</svg>',
		'user-anon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-user-anon ooui-icon-userAnonymous avatar-image" aria-hidden="true">
											<path d="M15 2H5L4 8h12l-1-6zM0 10s2 1 10 1 10-1 10-1l-4-2H4zm6 2a3 3 0 1 0 3 3 3 3 0 0 0-3-3zm8 0a3 3 0 1 0 3 3 3 3 0 0 0-3-3z"/>
											<path d="M8 14h4v1H8z"/>
										</svg>',
		'user-loggedin' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-user-loggedin ooui-icon-userActive avatar-image" aria-hidden="true">
													<path d="M10 12.5c-5.92 0-9 3.5-9 5.5v1h18v-1c0-2-3.08-5.5-9-5.5z"/>
													<circle cx="10" cy="6" r="5"/>
												</svg>',
		'userrights' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-userrights ooui-icon-key" aria-hidden="true">
											<path d="M15 6a1.54 1.54 0 0 1-1.5-1.5 1.5 1.5 0 0 1 3 0A1.54 1.54 0 0 1 15 6zm-1.5-5A5.55 5.55 0 0 0 8 6.5a6.81 6.81 0 0 0 .7 2.8L1 17v2h4v-2h2v-2h2l3.2-3.2a5.85 5.85 0 0 0 1.3.2A5.55 5.55 0 0 0 19 6.5 5.55 5.55 0 0 0 13.5 1z"/>
										</svg>',
		'viewsource' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-viewsource ooui-icon-eye" aria-hidden="true">
											<path d="M10 7.5a2.5 2.5 0 1 0 2.5 2.5A2.5 2.5 0 0 0 10 7.5zm0 7a4.5 4.5 0 1 1 4.5-4.5 4.5 4.5 0 0 1-4.5 4.5zM10 3C3 3 0 10 0 10s3 7 10 7 10-7 10-7-3-7-10-7z"/>
										</svg>',
		'wikilove' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-wikilove ooui-icon-heart" aria-hidden="true">
										<path d="M14.75 1A5.24 5.24 0 0 0 10 4 5.24 5.24 0 0 0 0 6.25C0 11.75 10 19 10 19s10-7.25 10-12.75A5.25 5.25 0 0 0 14.75 1z"/>
									</svg>'
	];

	private static $iconListLTR = [
		'addsection' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-ltr refreshed-icon-addsection ooui-icon-speechBubbleAdd-ltr" aria-hidden="true">
											<path d="M17 1H3a2 2 0 0 0-2 2v16l4-4h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm-2 8h-4v4H9V9H5V7h4V3h2v4h4z"/>
										</svg>',
		'contributions' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-ltr refreshed-icon-contributions ooui-icon-signature-ltr" aria-hidden="true">
													<path d="M0 18h20v1H0zm-.003-6.155l1.06-1.06 4.363 4.362-1.06 1.06z"/>
													<path d="M.004 15.147l4.363-4.363 1.06 1.061-4.362 4.363zM17 5c0 9-11 9-11 9v-1.5s8 .5 9.5-6.5C16 4 15 2.5 14 2.5S11 4 10.75 10c-.08 2 .75 4.5 3.25 4.5 1.5 0 2-1 3.5-1a2.07 2.07 0 0 1 2.25 2.5h-1.5s.13-1-.5-1C16 15 16 16 14 16c0 0-4.75 0-4.75-6S12 1 14 1c.5 0 3 0 3 4z"/>
												</svg>',
		'log' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-ltr refreshed-icon-log refreshed-icon-viewDetails-ltr" aria-hidden="true">
								<path d="M8 6h9v2H8zm0-3h11v2H8zM1 3h6v6H1zm7 11h9v2H8zm0-3h11v2H8zm-7 0h6v6H1z"/>
							</svg>',
		'nstab' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-ltr refreshed-icon-nstab ooui-icon-article-ltr" aria-hidden="true">
									<path d="M15 1H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zM5 4h5v1H5zm0 2h5v1H5zm0 2h5v1H5zm10 7H5v-1h10zm0-2H5v-1h10zm0-2H5v-1h10zm0-2h-4V4h4z"/>
								</svg>',
		'refreshed-explore' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-ltr refreshed-icon-refreshed-explore ooui-icon-map-ltr" aria-hidden="true">
															<path d="M13 3L7 1 1 3v16l6-2 6 2 6-2V1zM7 14.89l-4 1.36V4.35L7 3zm10 .75L13 17V5.1l4-1.36z"/>
														</svg>',
		'refreshed-submenu-expand' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-ltr refreshed-icon-refreshed-submenu-expand ooui-icon-next-ltr" aria-hidden="true">
																		<path d="M6.2 1L4.8 2.5l7.4 7.5-7.4 7.5L6.2 19l9-9z"/>
																	</svg>',
		'report-problem' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-ltr refreshed-icon-report-problem ooui-icon-feedback-ltr" aria-hidden="true">
													<path d="M19 16L2 12a3.83 3.83 0 0 1-1-2.5A3.83 3.83 0 0 1 2 7l17-4z"/>
													<rect width="4" height="8" x="4" y="9" rx="2" ry="2"/>
												</svg>',
		'smwbrowserlink' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-ltr refreshed-icon-smwbrowserlink ooui-icon-puzzle-ltr" aria-hidden="true">
													<circle cx="17" cy="10" r="3"/>
													<path d="M10.58 3A3 3 0 0 1 11 4.5a3 3 0 0 1-6 0A3 3 0 0 1 5.42 3H1v12a2 2 0 0 0 2 2h12V3z"/>
												</svg>',
		'talk' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-ltr refreshed-icon-talk ooui-icon-speechBubbles-ltr" aria-hidden="true">
								<path d="M18 4h-1v7a2 2 0 0 1-2 2H4v1a2 2 0 0 0 2 2h10l4 4V6a2 2 0 0 0-2-2z"/>
								<path d="M14 0H2a2 2 0 0 0-2 2v14l4-4h10a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
							</svg>',
		'view' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-ltr refreshed-icon-view ooui-icon-book-ltr" aria-hidden="true">
								<path d="M15 2a7.65 7.65 0 0 0-5 2 7.65 7.65 0 0 0-5-2H1v15h4a7.65 7.65 0 0 1 5 2 7.65 7.65 0 0 1 5-2h4V2zm2.5 13.5H14a4.38 4.38 0 0 0-3 1V5s1-1.5 4-1.5h2.5z"/>
								<path d="M9 3.5h2v1H9z"/>
							</svg>',
		'whatlinkshere' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="2 2 20 20" class="refreshed-icon refreshed-icon-ltr refreshed-icon-whatlinkshere ooui-icon-references-ltr" aria-hidden="true">
													<path d="M3 6v12h4V6H3zm3 10H4v-1h2v1zm0-3H4v-1h2v1zm2-7v12h4V6H8zm3 10H9v-1h2v1zm0-3H9v-1h2v1zm.934-5.353L18 18l3.449-2.021-6.065-10.354-3.45 2.022zm7.643 7.111l-1.726 1.012-.506-.862 1.725-1.012.507.862zM18.06 12.17l-1.725 1.011-.506-.862 1.726-1.012.505.863z"/>
												</svg>'
	];

	private static $iconListRTL = [
		'addsection' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-rtl refreshed-icon-addsection ooui-icon-speechBubbleAdd-rtl" aria-hidden="true">
											<path d="M1 3v10c0 1.1.9 2 2 2h12l4 4V3c0-1.1-.9-2-2-2H3c-1.1 0-2 .9-2 2zm4 4h4V3h2v4h4v2h-4v4H9V9H5V7z"/>
										</svg>',
		'contributions' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-rtl refreshed-icon-contributions ooui-icon-signature-rtl" aria-hidden="true">
													<path d="M0 18h20v1H0zm14.542-2.883l4.384-4.384 1.06 1.06-4.384 4.384z"/>
													<path d="M14.54 11.86l1.06-1.062 4.384 4.384-1.06 1.061zM6 1c2 0 4.8 3 4.8 9S6 16 6 16c-2 0-2-1-3.8-1-.6 0-.5 1-.5 1H.2c0-.2-.1-.4 0-.7.1-1.1 1.1-2 2.3-1.8 1.5 0 2 1 3.5 1 2.5 0 3.3-2.5 3.3-4.5C9 4 7 2.5 6 2.5S4 4 4.5 6C6 13 14 12.5 14 12.5V14S3 14 3 5c0-4 2.5-4 3-4z"/>
												</svg>',
		'log' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-rtl refreshed-icon-log refreshed-icon-viewDetails-rtl" aria-hidden="true">
								<path d="M12 8H3V6h9v2zm0-3H1V3h11v2zm1-2h6v6h-6zm-1 13H3v-2h9v2zm0-3H1v-2h11v2zm1-2h6v6h-6z"/>
							</svg>',
		'nstab' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-rtl refreshed-icon-nstab ooui-icon-article-rtl" aria-hidden="true">
									<path d="M3 3v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2zm12 2h-5V4h5zm0 2h-5V6h5zm0 2h-5V8h5zM5 14h10v1H5zm0-2h10v1H5zm0-2h10v1H5zm0-6h4v5H5z"/>
								</svg>',
		'refreshed-explore' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-rtl refreshed-icon-refreshed-explore ooui-icon-map-rtl" aria-hidden="true">
															<path d="M1 1v16l6 2 6-2 6 2V3l-6-2-6 2zm12 2l4 1.36v11.9l-4-1.36zM3 3.74L7 5.1V17l-4-1.36z"/>
														</svg>',
		'refreshed-submenu-expand' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-rtl refreshed-icon-refreshed-submenu-expand ooui-icon-next-rtl" aria-hidden="true">
																		<path d="M4.8 10l9 9 1.4-1.5L7.8 10l7.4-7.5L13.8 1z"/>
																	</svg>',
		'report-problem' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-rtl refreshed-icon-report-problem ooui-icon-feedback-rtl" aria-hidden="true">
													<path d="M1 3l17 4c.6.7 1 1.6 1 2.5 0 .9-.4 1.8-1 2.5L1 16V3z"/>
													<path d="M16 11v4c0 1.1-.9 2-2 2s-2-.9-2-2v-4c0-1.1.9-2 2-2s2 .9 2 2z"/>
												</svg>',
		'smwbrowserlink' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-rtl refreshed-icon-smwbrowserlink ooui-icon-puzzle-rtl" aria-hidden="true">
													<circle cx="3" cy="10" r="3"/>
													<path d="M9.42 3A2.94 2.94 0 0 0 9 4.5a3 3 0 0 0 6 0 2.94 2.94 0 0 0-.42-1.5H19v12a2 2 0 0 1-2 2H5V3z"/>
												</svg>',
		'talk' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-rtl refreshed-icon-talk ooui-icon-speechBubbles-rtl" aria-hidden="true">
								<path d="M0 6v14l4-4h10c1.1 0 2-.9 2-2v-1H5c-1.1 0-2-.9-2-2V4H2C.9 4 0 4.9 0 6z"/>
								<path d="M4 2v8c0 1.1.9 2 2 2h10l4 4V2c0-1.1-.9-2-2-2H6C4.9 0 4 .9 4 2z"/>
							</svg>',
		'view' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="refreshed-icon refreshed-icon-rtl refreshed-icon-view ooui-icon-book-rtl" aria-hidden="true">
								<path d="M1 2v15h4a7.65 7.65 0 0 1 5 2 7.65 7.65 0 0 1 5-2h4V2h-4a7.65 7.65 0 0 0-5 2 7.65 7.65 0 0 0-5-2zm1.5 1.5H5C8 3.5 9 5 9 5v11.5a4.38 4.38 0 0 0-3-1H2.5z"/>
								<path d="M9 3.5h2v1H9z"/>
							</svg>',
		'whatlinkshere' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="2 2 20 20" class="refreshed-icon refreshed-icon-rtl refreshed-icon-whatlinkshere ooui-icon-references-rtl" aria-hidden="true">
													<path d="M21.449 6v12h-4V6h4zm-3 10h2v-1h-2v1zm0-3h2v-1h-2v1zm-2-7v12h-4V6h4zm-3 10h2v-1h-2v1zm0-3h2v-1h-2v1zm-.934-5.353L6.449 18 3 15.979 9.065 5.625l3.45 2.022zm-7.643 7.111l1.726 1.012.506-.862-1.725-1.012-.507.862zm1.517-2.588l1.725 1.011.506-.862-1.726-1.012-.505.863z"/>
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

		// Get the icon if it is in the list of all icons.
		// If not, get the icon if it is in the list of the LTR/RTL icons
		// (depending on the user interface language).
		if ( array_key_exists( $iconName, self::$iconListAllDirections ) ) {
			return self::$iconListAllDirections[$iconName];
		} else {
			$languageDirection = $this->getSkin()->getLanguage()->getDir();
			if ( $languageDirection === 'ltr' && array_key_exists( $iconName, self::$iconListLTR ) ) {
				return self::$iconListLTR[$iconName];
			} elseif ( $languageDirection === 'rtl' && array_key_exists( $iconName, self::$iconListRTL ) ) {
				return self::$iconListRTL[$iconName];
			}
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
	private function makeListItemWithIconAtStart( $iconName = '', $key, $item, $options = [] ) {
		return $this->makeElementWithIconHelper( 'list item', $iconName, $key, $item, $options, 'start' );
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
	private function makeLinkWithIconAtStart( $iconName = '', $key, $item, $options = [] ) {
		return $this->makeElementWithIconHelper( 'link', $iconName, $key, $item, $options, 'start' );
	}

	/**
	 * Generate a list item using BaseTemplate::makeListItem() that contains the
	 * inline SVG icon specified by $iconName just after the actual link text,
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
	private function makeListItemWithIconAtEnd( $iconName = '', $key, $item, $options = [] ) {
		return $this->makeElementWithIconHelper( 'list item', $iconName, $key, $item, $options, 'end' );
	}

	/**
	 * Generate a link using BaseTemplate::makeLink() that contains the
	 * inline SVG icon specified by $iconName just after the actual link text,
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
	private function makeLinkWithIconAtEnd( $iconName = '', $key, $item, $options = [] ) {
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

		// Find the first/last child of the first a tag from the last line. Note
		// this may not exist (if a tag is empty), in which case it's null.
		if ( $iconPosition === 'start' ) {
			$firstATagChild = $firstATagInListItemOrLink->firstChild;
		} elseif ( $iconPosition === 'end' ) {
			$firstATagChild = $firstATagInListItemOrLink->lastChild;
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
			$image = (new wAvatar( $user->getId(), 'l' ))->makeAvatarURL( [
				'class' => $imageClassList
			] );
		} else {  // if not using SocialProfile...
			$wrapperClassList .= ' avatar-no-socialprofile';

			// use the appropriate site-defined custom avatar if given;
			// otherwise, use the skin's default avatar
			if ( $this->data['loggedin'] ) {
				if ( $this->getMsg( 'refreshed-icon-logged-in' )->isDisabled() ) {
					$image = $this->makeIcon( 'user-loggedin' );
				} else { // if wiki has set custom image for logged in users
					$image = Html::element( 'img', [
						'src' => $this->getMsg( 'refreshed-icon-logged-in' )->escaped(),
						'class' => $imageClassList
					] );
				}
			} else {
				if ( $this->getMsg( 'refreshed-icon-logged-out' )->isDisabled() ) {
					$image = $this->makeIcon( 'user-anon' );
				} else { // if wiki has set custom image for logged out users
					$image = Html::element( 'img', [
						'src' => $this->getMsg( 'refreshed-icon-logged-out' )->escaped(),
						'class' => $imageClassList
					] );
				}
			}
		}

		return Html::rawElement( 'span', [ 'class' => $wrapperClassList ], $image );
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
	 * @param array $personalTools
	 */
	private function renderUserDropdownItems( $dropdownPersonalTools ) {
		foreach ( $dropdownPersonalTools as $keyAndIconName => $item ) {
			echo $this->makeListItemWithIconAtStart( $keyAndIconName, $keyAndIconName, $item, [ 'text-wrapper' => [ 'tag' => 'span' ] ] );
		}
	}

	/**
	 * Render the items of the site navigation dropdown/collapsible to appear
	 * in the header/sidebar.
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
			echo Html::rawElement( 'li', [], $this->makeWikiLinkWithLogo( $wikiLogoInfo['wikiName'], $wikiLogoInfo['logoURL'], $wikiLogoInfo['wikiURL'], $logoClassList ) );
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
	 * @param array $headerCategoryDropdown an array containing info for a header
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
	 * @param array $sub details on the section's content
	 */
	private function renderSidebarContentSection( $sub ) {
		if ( is_array( $sub ) ) { // MW-generated stuff from the sidebar message
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
	 * @param array $tools the tools to sort
	 * @return array where each key is a category and each item is an array of
	 *  the page tools in that category (if nothing is in a category, that
	 *  category's key corresponds to an empty array)
	 */
	private function sortPageTools( $tools ) {
		// which category each tool belongs in
		$categories = [
			'namespaces' => [ 'talk' ], // also anything starting with "nstab-"
			'main-actions' => [ 've-edit', 'edit',	'view', 'history', 'addsection', 'viewsource' ],
			'page-tools' => [ 'delete', 'rename', 'protect', 'unprotect', 'move', 'whatlinkshere', 'recentchangeslinked', 'print', 'permalink', 'info', 'citethispage', 'feeds' ],
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

			} else { // otherwise place the tool in its correct category
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
	 * @param array $pageTools an array of page tools generated by sortPageTools()
	 */
	private function renderToolboxDropdownItems( $pageTools ) {
		$toolboxCategories = [ 'page-tools', 'user-tools' ];
		foreach ( $toolboxCategories as $category ) {
			if ( !empty( $pageTools[$category] ) ) {
				echo Html::element( 'dt', [ 'class' => 'refreshed-dropdown-header' ], $this->getMsg( 'refreshed-' . $category  )->text() );
				$this->renderPageToolsInCategory( 'dropdown', $pageTools, $category );
			}
		}
	}

	/**
	 * Render a link for talk pages pointing back to the corresponding subject page
	 * @param object $linkRenderer the LinkRenderer
	 * @param object $title the article's title
	 */
	private function renderBackToSubjectLink( $linkRenderer, $title ) {

		echo Html::rawElement( 'li', [], $linkRenderer->makeLink(
				$title,
				$this->getMsg( 'backlinksubtitle', $title->getPrefixedText() )->escaped(),
				[ 'id' => 'back-to-subject' ]
		) );
	}

	/**
	 * Render the page tools that are in the given category, either wrapped in
	 * li tags to fit inline in the toolbox (we wrap them in li because a lot of
	 * MW features expect it--for example, double click to edit), or wrapped in
	 * dd to fit in the toolbox dropdown.
	 * @param string $mode expects 'dropdown' or 'inline'
	 * @param array $pageTools an array of page tools generated by sortPageTools()
	 * @param string $category the category of list items being generated
	 */
	private function renderPageToolsInCategory( $mode, $pageTools, $category ) {
		// if category is invalid, do nothing
		if ( !array_key_exists( $category, $pageTools ) ) {
			return;
		}

		$options = [ 'text-wrapper' => [ 'tag' => 'span', 'attributes' => [ ] ] ];

		if ( $mode == 'dropdown' ) {
			$options['text-wrapper']['attributes']['class'] = 'dropdown-tool-text';
			$options['tag'] = 'dd';
			foreach ( $pageTools[$category] as $keyAndIconName => $item ) {
				echo $this->makeListItemWithIconAtStart( $keyAndIconName, $keyAndIconName, $item, $options );
			}
		} elseif ( $mode == 'inline' ) {
			$options['text-wrapper']['attributes']['class'] = 'inline-tool-text';
			if ( isset( $toolDetails['class'] ) ) {
				$toolDetails['class'] .= ' ' . 'inline-tool-anchor';
			} else {
				$toolDetails['class'] = 'inline-tool-anchor';
			}
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
	 * @param string $category the type of links (used for a class name)
	 * @param array $links an array containing info on the links
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
	 * @param object $skin the skin object
	 * @param array $footerIcons an array containing info on the blocks of icons
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
	 * @param object $skin the skin object
	 * @param string $category the type of icons (used for a class name)
	 * @param array $blockIcons an array containing info on the icons
	 */
	private function makeFooterIconsBlock( $skin, $blockName, $blockIcons ) {
		$blockContents = '';
		foreach ( $blockIcons as $icon ) {
			$blockContents .= $skin->makeFooterIcon( $icon );
		}
		return Html::rawElement( 'li', [ 'id' => 'footer-row-' . htmlspecialchars( $blockName ), 'class' => 'footer-row-item' ], $blockContents );
	}

	public function execute() {
		global $wgMemc;

		$linkRenderer = MediaWikiServices::getInstance()->getLinkRenderer();

		$skin = $this->getSkin();
		$config = $skin->getConfig();
		$user = $skin->getUser();

		// Title processing
		$titleBase = $skin->getTitle();
		$title = $titleBase->getSubjectPage();
		$titleNamespace = $titleBase->getNamespace();

		$key = $wgMemc->makeKey( 'refreshed', 'header' );
		$headerCategories = $wgMemc->get( $key );
		if ( !$headerCategories ) {
			$headerCategories = [];
			$skin->addToSidebar( $headerCategories, 'refreshed-navigation' );
			$wgMemc->set( $key, $headerCategories, 60 * 60 * 24 ); // 24 hours
		}

		$dropdownCacheKey = $wgMemc->makeKey( 'refreshed', 'dropdownmenu' );
		$siteNavigation = $wgMemc->get( $dropdownCacheKey );
		if ( !$siteNavigation ) {
			$siteNavigation = $this->parseSiteNavigationMenu( 'Refreshed-wiki-dropdown' );
			$wgMemc->set( $dropdownCacheKey, $siteNavigation, 60 * 60 * 24 ); // 24 hours
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
		$thisWikiLinkWithLogo = $this->makeWikiLinkWithLogo( $thisWikiName, $thisLogoURL, $thisWikiURL, 'refreshed-logo refreshed-logo-current header-button', $skin->msg( 'Tooltip-p-logo' ) );
		$thisWikiLinkWithSidebarLogo = $this->makeWikiLinkWithLogo( $thisWikiName, $thisLogoURL, $thisWikiURL, 'refreshed-logo refreshed-logo-current refreshed-logo-sidebar-current header-button', $skin->msg( 'Tooltip-p-logo' ) );

		$thisWikiMobileLogo = $skin->msg( 'refreshed-this-wiki-mobile-logo' );
		$thisWikiMobileLogoImgElement = '';
		if ( !$thisWikiMobileLogo->isDisabled() ) {
			$thisWikiMobileLogoImgElement = Html::element( 'img', [
				'src' => $thisWikiMobileLogo->escaped(),
				'alt' => $config->get( 'Sitename' ),
				'class' => 'site-navigation-logo-img site-navigation-logo-icon'
			] );
		}

		$personalTools = $this->getAndRearrangePersonalTools();
		$dropdownPersonalTools = $personalTools['dropdown'];
		$extraPersonalTools = $personalTools['extra'];

		$pageTools = array_merge( $this->data['content_navigation']['views'], $this->data['content_actions'], $this->getToolbox() );
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

		$footerIcons = $this->getFooterIcons( 'icononly' );

		// allow error handling in makeElementWithIconHelper:
		// see https://secure.php.net/manual/en/simplexml.examples-errors.php
		libxml_use_internal_errors( true );

		// Output the <html> tag and whatnot
		$this->html( 'headelement' );
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
				if ( $siteNavigation ) { // if there is a site dropdown (so there are multiple wikis)
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
				} else { // if only one wiki
					?>
					<div class="site-navigation-full-logos single-wiki">
						<?php echo $thisWikiLinkWithLogo ?>
					</div>
				<?php
				}

				if ( !$thisWikiMobileLogo->isDisabled() ) { // if a mobile logo has been defined
					?>
					<div class="site-navigation-icon-logos">
						<a class="main header-button" href="<?php echo $thisWikiURL ?>"><?php echo $thisWikiMobileLogoImgElement ?></a>
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
										<span class="header-category-name header-text"><?php echo $this->getMsg( 'Refreshed-explore' )->text() ?></span>
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
						<?php if ( $extraPersonalTools ) { // if there are extra personal tools (e.g., for Echo)
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
								<span class="refreshed-username header-text"><?php echo $this->makeUsernameText( $user ) ?></span>
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
						if ( $siteNavigation ) { // if there is a site dropdown (so there are multiple wikis)
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
						} else { // if only one wiki
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
					?>
					<div class="sidebar-content sidebar-section">
						<span class="sidebar-heading"><?php echo htmlspecialchars( $main ) ?></span>
						<ul>
							<?php $this->renderSidebarContentSection( $sub ) ?>
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
				<main id="content">
					<article>
						<header id="content-heading">
							<h1 id="firstHeading" class="firstHeading"><?php $this->html( 'title' ) ?></h1>
							<?php
							if ( method_exists( $this, 'getIndicators' ) ) {
								echo $this->getIndicators();
							}
							?>
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
								if ( MWNamespace::isTalk( $titleNamespace ) ) { // if talk namespace
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
									<label for="toolbox-dropdown-checkbox" id="toolbox-dropdown-button" class="refreshed-label refreshed-dropdown-button" title="<?php echo $this->getMsg( 'toolbox' )->text() ?>" aria-label="<?php echo $this->getMsg( 'toolbox' )->text() ?>">
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
		$this->printTrail();
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
	}
}
