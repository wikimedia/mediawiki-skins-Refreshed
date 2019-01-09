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
		toolbox: document.getElementById( 'refreshed-toolbox' ),
		stuckClass: 'refreshed-toolbox-stuck',
		toolboxHasStuckClass: false,
		searchInput: document.getElementById( 'searchInput' ),
		suggestionsClass: 'suggestions',
		headerSuggestionsId: 'header-suggestions',
		body: document.body,
		sidebarTogglerCheckbox: document.getElementById( 'sidebar-toggler-checkbox' ),
		sidebarToggler: document.getElementById( 'sidebar-toggler' )
	};

	/*******************************************************************************
	************************************ TOOLBOX ***********************************
	*******************************************************************************/

	/******** Add/remove class from toolbox based if toolbox is stuck/ not ********/

	if ( CSS.supports( 'position: sticky' ) || CSS.supports( 'position: -webkit-sticky' ) ) {
		Refreshed.toolboxHasStuckClass = Refreshed.toolbox.classList.contains( Refreshed.stuckClass );

		// returns true if the toolbox's top property (in pixels) is the distance that
		// the toolbox is from the top of the viewport, as in that case, it is stuck
		Refreshed.toolboxIsStuck = function() {
			return parseFloat( window.getComputedStyle( this.toolbox ).getPropertyValue( 'top' ) ) == this.toolbox.getBoundingClientRect().top;
		};

		// remove stuckClass from toolbox if toolbox isn't stuck;
		// add stuckClass to toolbox if toolbox is stuck
		Refreshed.updateToolboxClasses = function() {
			if ( this.toolboxIsStuck() != this.toolboxHasStuckClass ) {
				this.toolbox.classList.toggle( this.stuckClass );
				this.toolboxHasStuckClass = !this.toolboxHasStuckClass;
			}
		};

		// run once in case the toolbox starts out as stuck on page load
		Refreshed.updateToolboxClasses();

		// attach/detach the toolbox to the top depending on scroll position
		window.addEventListener( 'scroll', function() {
				Refreshed.updateToolboxClasses();
		} );
	}

	/*******************************************************************************
	************************************ SEARCH ************************************
	*******************************************************************************/

	/***************** Clear the search bar when it's not focused; ****************/
	/*********** focus the search bar when the search button is opened ************/

	Refreshed.clearTopSearchBar = function() {
		this.searchInput.value = '';
	};

	Refreshed.focusTopSearchBar = function() {
		this.searchInput.focus();
	};

	$( '#header-search-dropdown-checkbox' ).change( function() {
		Refreshed.clearTopSearchBar();
		if ( this.checked ) {
			Refreshed.focusTopSearchBar();
		}
	} );

	/*********** Add class to the suggestions box for the header search ***********/

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

	/*******************************************************************************
	*********************************** CHECKBOXES *********************************
	*******************************************************************************/

	/******** Hide dropdowns if their corresponding button is hidden; ***********/
	/**************** hide sidebar when sidebar button is hidden ****************/

	// for example, the header category checkboxes may stay checked, so their
	// dropdowns may stay open, after the viewport shrinks and the header category
	// buttons disappear

	Refreshed.hideDropdownsWithHiddenButtons = function() {
		var checkbox = null;
		var button = null;
		var headerTopCoord = 0;
		var buttonTopCoord = 0;
		var headerBottomCoord = 0;
		var buttonBottomCoord = 0;
		$( '.refreshed-dropdown-tray' ).not(':visible').each( function() {
			checkbox = $( this ).siblings( '.refreshed-checkbox' ).first();
			button = $( this ).siblings( '.refreshed-dropdown-button' ).first();
			// if the button has overflowed, its bottom is above the top of the
			// header, or its top is above the bottom of the header
			headerTopCoord = $( '#header-wrapper' ).offset().top;
			buttonTopCoord = $( button ).offset().top;
			headerBottomCoord = headerTopCoord + $( '#header-wrapper' ).outerHeight();
			buttonBottomCoord = buttonTopCoord + $( button ).outerHeight();
			if ( buttonBottomCoord <= headerTopCoord || buttonTopCoord >= headerBottomCoord ) {
				checkbox.prop( 'checked', false );
			}
		} );
	};

	Refreshed.hideSidebarWhenSidebarTogglerHidden = function() {
		if ( Refreshed.sidebarTogglerCheckbox.checked && $( Refreshed.sidebarToggler ).is( ':hidden' ) ) {
			Refreshed.sidebarTogglerCheckbox.checked = false;
		}
	};

	window.addEventListener( 'resize', function() {
			Refreshed.hideDropdownsWithHiddenButtons();
			Refreshed.hideSidebarWhenSidebarTogglerHidden();
	} );

}
