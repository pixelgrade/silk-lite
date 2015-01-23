/*global AmelieAboutMeWidget, wp */

(function($){
	'use strict';

	var AmelieAboutMeWidget = typeof window.AmelieAboutMeWidget === 'undefined' ? {} : window.AmelieAboutMeWidget,
		Attachment = wp.media.model.Attachment,
		frames = [],
		imageControl, l10n;

	// Link any localized strings.
	l10n = AmelieAboutMeWidget.l10n = typeof AmelieAboutMeWidget.l10n === 'undefined' ? {} : AmelieAboutMeWidget.l10n;

	/**
	 * imageControl module object.
	 */
	imageControl = function( el, options ) {
		var defaults, settings;

		this.$el = $( el );

		// Search within the context of the control.
		this.$target = this.$el.find( '.amelie-about-me-image-id' );

		defaults = {
			frame: {
				id: 'amelie-about-me-widget',
				title: l10n.frameTitle,
				updateText: l10n.frameUpdateText,
				multiple: false
			},
			mediaType: 'image',
			returnProperty: 'id'
		};

		options = options || {};
		options.frame = options.frame || {};
		this.settings = _.extend( {}, defaults, options );
		this.settings.frame = _.extend( {}, defaults.frame, options.frame );

		/**
		 * Initialize a media frame.
		 *
		 * @returns {wp.media.view.MediaFrame.Select}
		 */
		this.frame = function() {
			var frame = frames[ this.settings.frame.id ];

			if ( frame ) {
				frame.control = this;
				return frame;
			}

			frame = wp.media({
				title: this.settings.frame.title,
				library: {
					type: this.settings.mediaType
				},
				button: {
					text: this.settings.frame.updateText
				},
				multiple: this.settings.frame.multiple
			});

			frame.control = this;
			frames[ this.settings.frame.id ] = frame;

			// Update the selected image in the media library based on the image in the control.
			frame.on( 'open', function() {
				var selection = this.get( 'library' ).get( 'selection' ),
					attachment, ids;

				if ( frame.control.$target.length ) {
					ids = frame.control.$target.val();
					if ( ids && '' !== ids && -1 !== ids && '0' !== ids ) {
						attachment = Attachment.get( ids );
						attachment.fetch();
					}
				}

				selection.reset( attachment ? [ attachment ] : [] );
			});

			// Update the control when an image is selected from the media library.
			frame.state( 'library' ).on( 'select', function() {
				var selection = this.get( 'selection' );
				frame.control.setAttachments( selection );
				frame.control.$el.trigger( 'selectionChange.amelieaboutmewidget', [ selection ] );
			});

			return frame;
		};

		/**
		 * Set the control's attachments.
		 *
		 * @param {Array} attachments An array of wp.media.model.Attachment objects.
		 */
		this.setAttachments = function( attachments ) {
			// Insert the selected attachment id into the target element.
			if ( this.$target.length ) {
				this.$target.val( attachments.pluck( 'id' ) ).trigger( 'change' );
			}
		};
	};

	_.extend( AmelieAboutMeWidget, {
		/**
		 * Retrieve a media selection control object.
		 *
		 * @param {Object} el HTML element.
		 *
		 * @returns {Control}
		 */
		getControl: function( el ) {
			var control, $control;

			$control = $( el ).closest( '.amelie-about-me-widget-image-control' );
			control = $control.data( 'media-control' );

			if ( ! control ) {
				control = new imageControl( $control );
				$control.data( 'media-control', control );
			}

			return control;
		}
	});

	$(function(){
		var $body = $( 'body' );
		
		// Open the media library frame when the button or image are clicked.
		$body.on( 'click', '.amelie-about-me-widget-image-control__choose, .amelie-about-me-widget-form img', function( e ) {
			e.preventDefault();
			AmelieAboutMeWidget.getControl( this ).frame().open();
		});

		// Update the image preview in the widget when an image is selected.
		$body.on( 'selectionChange.amelieaboutmewidget', function( e, selection ) {
			var $control = $( e.target ),
				model = selection.first(),
				sizes = model.get( 'sizes' ),
				size, image;

			if ( sizes ) {
				size = sizes.medium || sizes.thumbnail; //default to thumbnail if medium is not available
			}

			size = size || model.toJSON();
			image = $( '<img />', { src: size.url });

			$control.find( 'img' ).remove().end()
				.prepend( image )
				.addClass( 'has-image' );
		});
	});
})( jQuery );
