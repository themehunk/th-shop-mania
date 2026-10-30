/**
 * Customizer search.
 *
 * Adds a search box at the top of the Customizer sidebar that searches every
 * panel, section and control by title and description, and focuses the
 * chosen item.
 *
 * @package Th Shop Mania
 */
( function ( $, api ) {
	'use strict';

	var l10n = window.thShopManiaCustomizerSearch || {};

	var ICONS = {
		panel: 'dashicons-category',
		section: 'dashicons-index-card',
		control: 'dashicons-admin-generic'
	};

	function escapeHtml( str ) {
		return String( str ).replace( /[&<>"']/g, function ( c ) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ c ];
		} );
	}

	function escapeRegExp( str ) {
		return str.replace( /[.*+?^${}()|[\]\\]/g, '\\$&' );
	}

	// Parse with DOMParser so markup in descriptions is never executed.
	function stripTags( html ) {
		if ( ! html ) {
			return '';
		}
		var doc = new DOMParser().parseFromString( String( html ), 'text/html' );
		return ( doc.body.textContent || '' ).replace( /\s+/g, ' ' ).trim();
	}

	function isActive( item ) {
		return ! item.active || item.active();
	}

	// Escape the text, wrapping each matched word in <mark>.
	function highlight( text, words ) {
		if ( ! text ) {
			return '';
		}
		if ( ! words.length ) {
			return escapeHtml( text );
		}
		var re = new RegExp( '(' + words.map( escapeRegExp ).join( '|' ) + ')', 'gi' );
		return text.split( re ).map( function ( part, i ) {
			return i % 2 ? '<mark>' + escapeHtml( part ) + '</mark>' : escapeHtml( part );
		} ).join( '' );
	}

	function buildIndex() {
		var index = [];

		api.panel.each( function ( panel ) {
			var title = stripTags( panel.params.title );
			if ( ! title || ! isActive( panel ) ) {
				return;
			}
			index.push( {
				type: 'panel',
				item: panel,
				title: title,
				desc: stripTags( panel.params.description ),
				path: ''
			} );
		} );

		api.section.each( function ( section ) {
			var title = stripTags( section.params.title ),
				panel;
			if ( ! title || ! isActive( section ) ) {
				return;
			}
			panel = section.panel() ? api.panel( section.panel() ) : null;
			if ( panel && ! isActive( panel ) ) {
				return;
			}
			index.push( {
				type: 'section',
				item: section,
				title: title,
				desc: stripTags( section.params.description ),
				path: panel ? stripTags( panel.params.title ) : ''
			} );
		} );

		api.control.each( function ( control ) {
			var title = stripTags( control.params.label ),
				section, panel, path;
			if ( ! title || ! isActive( control ) ) {
				return;
			}
			section = control.section() ? api.section( control.section() ) : null;
			if ( ! section || ! isActive( section ) ) {
				return;
			}
			panel = section.panel() ? api.panel( section.panel() ) : null;
			if ( panel && ! isActive( panel ) ) {
				return;
			}
			path = [ panel ? stripTags( panel.params.title ) : '', stripTags( section.params.title ) ];
			index.push( {
				type: 'control',
				item: control,
				title: title,
				desc: stripTags( control.params.description ),
				path: path.filter( Boolean ).join( ' › ' )
			} );
		} );

		return index;
	}

	function search( query ) {
		var q = query.toLowerCase().trim(),
			words = q.split( /\s+/ ).filter( Boolean ),
			results = [];

		if ( ! words.length ) {
			return { words: words, items: [] };
		}

		buildIndex().forEach( function ( entry, order ) {
			var title = entry.title.toLowerCase(),
				haystack = ( entry.title + ' ' + entry.desc + ' ' + entry.path ).toLowerCase(),
				score = 0;

			if ( ! words.every( function ( w ) { return haystack.indexOf( w ) !== -1; } ) ) {
				return;
			}
			if ( title === q ) {
				score += 100;
			} else if ( title.indexOf( q ) === 0 ) {
				score += 50;
			}
			words.forEach( function ( w ) {
				if ( title.indexOf( w ) !== -1 ) {
					score += 10;
				}
			} );
			results.push( { entry: entry, score: score, order: order } );
		} );

		results.sort( function ( a, b ) {
			return b.score - a.score || a.order - b.order;
		} );

		return {
			words: words,
			items: results.map( function ( r ) { return r.entry; } )
		};
	}

	// Briefly highlight where the user landed.
	function flash( entry ) {
		var item = entry.item,
			$target;

		if ( item.extended( api.Control ) ) {
			$target = item.container;
		} else if ( 'section' === entry.type ) {
			$target = item.contentContainer.find( '.customize-section-title' ).first();
		} else {
			$target = item.contentContainer.find( '.panel-meta' ).first();
		}
		if ( ! $target || ! $target.length ) {
			$target = item.container;
		}

		$target.removeClass( 'th-cs-flash' );
		void $target[ 0 ].offsetWidth; // Restart the animation.
		$target.addClass( 'th-cs-flash' );
		setTimeout( function () {
			$target.removeClass( 'th-cs-flash' );
		}, 1600 );
	}

	api.bind( 'ready', function () {
		var $header = $( '#customize-header-actions' ),
			$wrap, $input, $clear, $results, $list,
			current = [],
			activeIndex = -1,
			timer = null;

		if ( ! $header.length ) {
			return;
		}

		$wrap = $(
			'<div class="th-cs-wrap" role="search">' +
				'<div class="th-cs-field">' +
					'<span class="th-cs-icon dashicons dashicons-search" aria-hidden="true"></span>' +
					'<input type="search" class="th-cs-input" autocomplete="off" spellcheck="false"' +
						' role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="th-cs-list" />' +
					'<kbd class="th-cs-kbd" aria-hidden="true">/</kbd>' +
					'<button type="button" class="th-cs-clear" tabindex="-1" aria-hidden="true">&#x2715;</button>' +
				'</div>' +
				'<div class="th-cs-results">' +
					'<div class="th-cs-count"></div>' +
					'<ul class="th-cs-list" id="th-cs-list" role="listbox"></ul>' +
				'</div>' +
			'</div>'
		);
		$header.after( $wrap );

		$input = $wrap.find( '.th-cs-input' );
		$clear = $wrap.find( '.th-cs-clear' );
		$results = $wrap.find( '.th-cs-results' );
		$list = $wrap.find( '.th-cs-list' );

		$input.attr( {
			placeholder: l10n.placeholder || '',
			'aria-label': l10n.placeholder || ''
		} );

		function open() {
			$results.addClass( 'is-open' );
			$input.attr( 'aria-expanded', 'true' );
		}

		function close() {
			$results.removeClass( 'is-open' );
			$input.attr( 'aria-expanded', 'false' );
		}

		function setActive( i, scroll ) {
			var $items = $list.children( '.th-cs-item' ),
				$item;
			if ( ! $items.length ) {
				activeIndex = -1;
				return;
			}
			activeIndex = ( i + $items.length ) % $items.length;
			$items.removeClass( 'is-active' ).attr( 'aria-selected', 'false' );
			$item = $items.eq( activeIndex ).addClass( 'is-active' ).attr( 'aria-selected', 'true' );
			$input.attr( 'aria-activedescendant', $item.attr( 'id' ) );
			if ( scroll ) {
				$item[ 0 ].scrollIntoView( { block: 'nearest' } );
			}
		}

		function render() {
			var query = $input.val(),
				found, html;

			$wrap.toggleClass( 'has-text', '' !== query );

			if ( ! query.trim() ) {
				current = [];
				$list.empty();
				$input.removeAttr( 'aria-activedescendant' );
				close();
				return;
			}

			found = search( query );
			current = found.items;

			$results.find( '.th-cs-count' ).text(
				( l10n.results || '%d results' ).replace( '%d', current.length )
			);

			if ( ! current.length ) {
				$list.html(
					'<li class="th-cs-empty" role="presentation">' +
						'<span class="dashicons dashicons-search" aria-hidden="true"></span>' +
						escapeHtml( l10n.noResults || '' ) +
					'</li>'
				);
				activeIndex = -1;
				$input.removeAttr( 'aria-activedescendant' );
				open();
				return;
			}

			html = current.map( function ( entry, i ) {
				var tag = '';
				if ( 'panel' === entry.type ) {
					tag = l10n.panel;
				} else if ( 'section' === entry.type ) {
					tag = l10n.section;
				}
				return '<li class="th-cs-item" id="th-cs-item-' + i + '" role="option" aria-selected="false" data-index="' + i + '">' +
					'<span class="th-cs-tile"><span class="dashicons ' + ICONS[ entry.type ] + '" aria-hidden="true"></span></span>' +
					'<span class="th-cs-body">' +
						'<span class="th-cs-title">' + highlight( entry.title, found.words ) + '</span>' +
						( entry.path ? '<span class="th-cs-path">' + highlight( entry.path, found.words ) + '</span>' : '' ) +
						( entry.desc ? '<span class="th-cs-desc">' + highlight( entry.desc, found.words ) + '</span>' : '' ) +
					'</span>' +
					( tag ? '<span class="th-cs-tag">' + escapeHtml( tag ) + '</span>' : '' ) +
				'</li>';
			} ).join( '' );

			$list.html( html ).scrollTop( 0 );
			$results.scrollTop( 0 );
			setActive( 0, false );
			open();
		}

		function flushPending() {
			if ( timer ) {
				clearTimeout( timer );
				timer = null;
				render();
			}
		}

		function go( i ) {
			var entry = current[ i ];
			if ( ! entry ) {
				return;
			}
			close();
			$input.trigger( 'blur' );
			entry.item.focus( {
				completeCallback: function () {
					flash( entry );
				}
			} );
		}

		function clear() {
			clearTimeout( timer );
			timer = null;
			$input.val( '' );
			render();
		}

		$input.on( 'input', function () {
			$wrap.toggleClass( 'has-text', '' !== $input.val() );
			clearTimeout( timer );
			timer = setTimeout( function () {
				timer = null;
				render();
			}, 120 );
		} );

		$input.on( 'focus', function () {
			if ( $input.val().trim() ) {
				render();
			}
		} );

		$input.on( 'keydown', function ( e ) {
			switch ( e.key ) {
				case 'ArrowDown':
				case 'ArrowUp':
					flushPending();
					if ( current.length ) {
						e.preventDefault();
						open();
						setActive( activeIndex + ( 'ArrowDown' === e.key ? 1 : -1 ), true );
					}
					break;
				case 'Enter':
					e.preventDefault();
					flushPending();
					if ( activeIndex > -1 ) {
						go( activeIndex );
					}
					break;
				case 'Escape':
					e.preventDefault();
					e.stopPropagation();
					if ( $input.val() ) {
						clear();
					} else {
						close();
						$input.trigger( 'blur' );
					}
					break;
			}
		} );

		$clear.on( 'mousedown', function ( e ) {
			e.preventDefault(); // Keep focus in the input.
		} ).on( 'click', function () {
			clear();
			$input.trigger( 'focus' );
		} );

		$list.on( 'mouseenter', '.th-cs-item', function () {
			setActive( parseInt( $( this ).data( 'index' ), 10 ), false );
		} ).on( 'mousedown', '.th-cs-item', function ( e ) {
			e.preventDefault();
		} ).on( 'click', '.th-cs-item', function () {
			go( parseInt( $( this ).data( 'index' ), 10 ) );
		} );

		// Clicking outside closes the dropdown but keeps the text.
		$( document ).on( 'mousedown', function ( e ) {
			if ( ! $wrap[ 0 ].contains( e.target ) ) {
				close();
			}
		} );

		// "/" or Ctrl/Cmd+K focuses the search box.
		$( document ).on( 'keydown', function ( e ) {
			var target = e.target,
				typing = target && ( /^(input|textarea|select)$/i.test( target.tagName ) || target.isContentEditable );

			if ( ( ( e.ctrlKey || e.metaKey ) && ! e.altKey && 'k' === String( e.key ).toLowerCase() ) ||
				( '/' === e.key && ! typing && ! e.ctrlKey && ! e.metaKey && ! e.altKey ) ) {
				e.preventDefault();
				$input.trigger( 'focus' ).trigger( 'select' );
			}
		} );
	} );
}( jQuery, wp.customize ) );
