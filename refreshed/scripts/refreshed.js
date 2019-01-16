/****** The code that runs in scroll events was written without jQuery for
faster performance. Speed isn't as important here, so this code uses
jQuery for readability. ******/

// based on https://stackoverflow.com/a/39993724
if ( document.readyState === 'interactive' || document.readyState === 'complete' ) {
	runRefreshedJS();
} else {
	document.addEventListener('DOMContentLoaded', function () {
		runRefreshedJS();
	} );
}

function runRefreshedJS() {

	var Refreshed = {
		positionStickyRules: [ 'sticky', '-webkit-sticky' ],
		shouldUseSticky: false,
		stickyClass: 'refreshed-toolbox-sticky',
		toolbox: document.getElementById( 'refreshed-toolbox' ),
		stuckClass: 'refreshed-toolbox-stuck',
		headlineClass: 'mw-headline',
		toolboxHasStuckClass: false,
		searchInput: document.getElementById( 'searchInput' ),
		headerSearchDropdownCheckbox: document.getElementById( 'header-search-dropdown-checkbox' ),
		suggestionsClass: 'suggestions',
		headerSuggestionsId: 'header-suggestions',
		body: document.body,
		sidebarTogglerCheckbox: document.getElementById( 'sidebar-toggler-checkbox' ),
		sidebarToggler: document.getElementById( 'sidebar-toggler' ),
		headerWrapper: document.getElementById( 'header-wrapper' ),
		dropdownCheckboxClass: 'refreshed-dropdown-checkbox',
		dropdownButtonClass: 'refreshed-dropdown-button',
		submenuDropdownCheckboxClass: 'refreshed-submenu-dropdown-checkbox',
		elementOrParentsHaveDisplayNone: function( element ) {
			// per https://stackoverflow.com/a/21696585; assumes element not fixed
			return element.offsetParent === null;
		}
	};

	/*****************************************************************************
	*********************************** TOOLBOX **********************************
	*****************************************************************************/

	/******* Add/remove class from toolbox based if toolbox is stuck/ not *******/

	for ( var stickyCounter = 0; stickyCounter < Refreshed.positionStickyRules.length; stickyCounter++ ) {
		if ( CSS.supports( 'position', Refreshed.positionStickyRules[stickyCounter] ) ) {
			Refreshed.shouldUseSticky = true;
			break;
		}
	}

	if ( Refreshed.shouldUseSticky ) {

		Refreshed.toolbox.classList.add( Refreshed.stickyClass );

		Refreshed.toolboxHasStuckClass = Refreshed.toolbox.classList.contains( Refreshed.stuckClass );

		// returns true if the toolbox's top property (in px) is no less than the
		// distance that the toolbox is from the top of the viewport, as in that
		// case, it is stuck (if the two are equal) or we have scrolled past the
		// body content, in which case the toolbox technically isn't stuck, but
		// it should still be styles as if it were, since it's not in its original
		// place
		Refreshed.toolboxIsStuck = function() {
			return parseFloat( window.getComputedStyle( this.toolbox ).getPropertyValue( 'top' ) ) >= this.toolbox.getBoundingClientRect().top;
		};

		// remove stuckClass from toolbox if toolbox isn't stuck;
		// add stuckClass to toolbox if toolbox is stuck
		Refreshed.updateToolboxClasses = function() {
			if ( this.toolboxIsStuck() != this.toolboxHasStuckClass ) {
				this.toolbox.classList.toggle( this.stuckClass );
				this.toolboxHasStuckClass = !this.toolboxHasStuckClass;
			}
		};

		Refreshed.headlines = document.getElementsByClassName( Refreshed.headlineClass );

		// adjust the padding-top and margin-top of the headlines so when a link
		// to that specific headline is clicked, the headline isn't blocked by the
		// toolbox
		Refreshed.updateHeadlineSpacing = function() {
			var toolboxHeight = window.getComputedStyle( this.toolbox ).getPropertyValue( 'height' );
			for ( var headlineCounter = 0; headlineCounter < this.headlines.length; headlineCounter++ ) {
				var currentStyle = window.getComputedStyle( this.headlines[headlineCounter] );
				var currentPaddingTop = currentStyle.getPropertyValue( 'padding-top' );
				var currentMarginTop = currentStyle.getPropertyValue( 'margin-top' );
				this.headlines[headlineCounter].style.paddingTop = parseFloat( currentPaddingTop ) + parseFloat( toolboxHeight ) + 'px';
				this.headlines[headlineCounter].style.marginTop = parseFloat( currentMarginTop ) - parseFloat( toolboxHeight ) + 'px';
			}
		};

		// run once in case the toolbox starts out as stuck on page load
		Refreshed.updateToolboxClasses();
		Refreshed.updateHeadlineSpacing();

		// attach/detach the toolbox to the top depending on scroll position
		window.addEventListener( 'scroll', function() {
				Refreshed.updateToolboxClasses();
		} );
	}

	/*****************************************************************************
	*********************************** SEARCH ***********************************
	*****************************************************************************/

	/**************** Clear the search bar when it's not focused; ***************/
	/********** focus the search bar when the search button is opened ***********/

	Refreshed.clearTopSearchBar = function() {
		this.searchInput.value = '';
	};

	Refreshed.focusTopSearchBar = function() {
		this.searchInput.focus();
	};

	Refreshed.headerSearchDropdownCheckbox.addEventListener( 'change', function() {
		Refreshed.clearTopSearchBar();
		if ( this.checked ) {
			Refreshed.focusTopSearchBar();
		}
	} );

	/********** Add class to the suggestions box for the header search **********/

	Refreshed.labelHeaderSuggestionsBox = function( headerSuggestions ) {
		headerSuggestions.id = Refreshed.headerSuggestionsId;
	};

	// find the 1st search suggestions element that's added, give it the id
	// Refreshed.headerSuggestionsId
	Refreshed.mutationCallback = function( mutationList, observer ) {
		mutationList.forEach( function( mutation ) {
			if ( mutation.type == 'childList' ) {
				var lastSuggestionsElement = null;
				// get the first added search suggestions element
				mutation.addedNodes.forEach( function( element ) {
					if ( element.classList.contains( Refreshed.suggestionsClass ) ) {
						// give the element the id Refreshed.headerSuggestionsId
						Refreshed.labelHeaderSuggestionsBox( element );
						// the goal is done; no need to keep observing/iterating
						observer.disconnect();
						return;
					}
				} );
			}
		} );
	};

	Refreshed.searchSuggestionsMutationObserver = new MutationObserver( Refreshed.mutationCallback );
	Refreshed.searchSuggestionsMutationObserver.observe( Refreshed.body, { childList: true, attributes: false, subtree: false } );

	/*****************************************************************************
	********************************** CHECKBOXES ********************************
	*****************************************************************************/

	/******** Hide dropdowns if their corresponding button is hidden; ***********/
	/**************** hide sidebar when sidebar button is hidden ****************/

	// for example, the header category checkboxes may stay checked, so their
	// dropdowns may stay open, after the viewport shrinks and the header category
	// buttons disappear

	Refreshed.dropdownCheckboxes = Refreshed.headerWrapper.getElementsByClassName( Refreshed.dropdownCheckboxClass );

	// returns true if element is entirely above/below container, otherwise false
	Refreshed.elementOverflowsContainer = function( element, container ) {
		// if the element is outside of the container, its bottom is above the top
		// of the container, or its top is above the bottom of the container
		var elementCoords = element.getBoundingClientRect();
		var containerCoords = container.getBoundingClientRect();
		return elementCoords.bottom <= containerCoords.top || elementCoords.top >= containerCoords.bottom;
	};

	// Takes in a dropdown checkbox.
	// Returns a boolean if the checkbox should be disabled, otherwise false.
	// A checkbox should be disabled if:
	// 1) it has display: none, or
	// 2) it is NOT a checkbox triggering an submenu and it has overflowed outside
	//    headerWrapper
	// (Note this process will correctly deal with disabling submenu checkboxes,
	// because they will be disabled when the menu that contains them is hidden.)
	Refreshed.dropdownCheckboxShouldBeDisabled = function( checkbox ) {
		var button = checkbox.parentNode.getElementsByClassName( this.dropdownButtonClass ).item(0);
		return this.elementOrParentsHaveDisplayNone( button ) ||
		( !checkbox.classList.contains( Refreshed.submenuDropdownCheckboxClass ) && this.elementOverflowsContainer( button, this.headerWrapper ) );
	};

	// Hide dropdowns if their corresponding button is either explicitly hidden
	// with display: none or is hidden because it is above or below headerWrapper.
	// Note this method is designed to only apply to dropdowns in #header-wrapper,
	// since the toolbox dropdown doesn't have its checkbox as the button's
	// sibling, so a different method would be needed to target it
	// (and the toolbox isn't ever hidden anyway, so it doesn't matter)
	Refreshed.disableHiddenDropdownCheckboxes = function() {
		for (var hiddenDropdownCounter = 0; hiddenDropdownCounter < Refreshed.dropdownCheckboxes.length; hiddenDropdownCounter++) {
			// If the checkbox is hidden, uncheck and disable it.
			// If the checkbox is not hidden, enable it.
			if ( this.dropdownCheckboxShouldBeDisabled( this.dropdownCheckboxes[hiddenDropdownCounter] ) ) {
				this.dropdownCheckboxes[hiddenDropdownCounter].checked = false;
				this.dropdownCheckboxes[hiddenDropdownCounter].disabled = true;
			} else {
				this.dropdownCheckboxes[hiddenDropdownCounter].disabled = false;
			}
		}
	};

	Refreshed.hideSidebarWhenSidebarTogglerHidden = function() {
		if ( this.sidebarTogglerCheckbox.checked && this.elementOrParentsHaveDisplayNone( this.sidebarToggler ) ) {
			this.sidebarTogglerCheckbox.checked = false;
		}
	};

	Refreshed.disableHiddenDropdownCheckboxes();

	for (var checkboxCounter = 0; checkboxCounter < Refreshed.dropdownCheckboxes.length; checkboxCounter++) {
		Refreshed.dropdownCheckboxes[checkboxCounter].addEventListener( 'change', function() {
			Refreshed.disableHiddenDropdownCheckboxes();
		} );
	}

	window.addEventListener( 'resize', function() {
		Refreshed.disableHiddenDropdownCheckboxes();
		Refreshed.hideSidebarWhenSidebarTogglerHidden();
	} );

}
