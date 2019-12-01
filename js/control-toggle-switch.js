(function( $ ) {

    // Available social icons
    var vctSocialIcons = [
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'pinterest',
        'youtube',
        'vimeo',
        'flickr',
        'github',
        'email'
    ];
    function isToggleTrue( el ) {
        return $( el ).prop( 'checked' );
    }

    function hideHeaderSection () {
        $( '#accordion-section-cit_header_and_menu_area' ).addClass( 'hiddenSection' );
    }

    function showHeaderSection () {
        $( '#accordion-section-cit_header_and_menu_area' ).removeClass( 'hiddenSection' );
    }

    function hideFooterSection () {
        $( '#accordion-section-cit_footer_area' ).addClass( 'hiddenSection' );
    }

    function showFooterSection () {
        $( '#accordion-section-cit_footer_area' ).removeClass( 'hiddenSection' );
    }

    function hideSocialIcons() {
        $.each( vctSocialIcons, function( key, icon ) {
            $( '#customize-control-cit_footer_area_social_link_' + icon ).hide();
        });
    }

    function showSocialIcons() {
        $.each( vctSocialIcons, function( key, icon ) {
            $( '#customize-control-cit_footer_area_social_link_' + icon ).show();
        });
    }

    function hideNumberOfContactColumns() {
        $( '#customize-control-cit_footer_area_widgetized_contact_columns, #customize-control-cit_footer_area_contact_bg, #customize-control-cit_footer_area_textarea_widget_area' ).hide();
    }

    function showNumberOfContactColumns() {
        $( '#customize-control-cit_footer_area_widgetized_contact_columns, #customize-control-cit_footer_area_contact_bg, #customize-control-cit_footer_area_textarea_widget_area' ).show();
    }
	
    function hideNumberOfColumns() {
        $( '#customize-control-cit_footer_area_widgetized_columns' ).hide();
    }

    function showNumberOfColumns() {
        $( '#customize-control-cit_footer_area_widgetized_columns' ).show();
    }

    function hideFeaturedImageSettings() {
        $( '#customize-control-cit_overall_site_featured_image_width' ).hide();
        $( '#customize-control-cit_overall_site_featured_image_height' ).hide();
        $( '#customize-control-cit_overall_site_featured_image_custom_height' ).hide();
    }

    function showFeaturedImageSettings() {
        $( '#customize-control-cit_overall_site_featured_image_width' ).show();
        $( '#customize-control-cit_overall_site_featured_image_height' ).show();
        if ( 'custom' === $( 'select[data-customize-setting-link="cit_overall_site_featured_image_height"]' ).val() ) {
            $( '#customize-control-cit_overall_site_featured_image_custom_height' ).show();
        }
    }

    function hideBackgroundImageSettings () {
        $( '#customize-control-cit_overall_site_bg_image' ).hide();
        $( '#customize-control-cit_overall_site_bg_image_style' ).hide();
    }

    function showBackgroundImageSettings () {
        $( '#customize-control-cit_overall_site_bg_image' ).show();
        $( '#customize-control-cit_overall_site_bg_image_style' ).show();
    }

    wp.customize.controlConstructor['toggle-switch'] = wp.customize.Control.extend( {
        ready: function() {
            var control = this;
			var value = ( undefined !== control.setting._value ) ? control.setting._value : '';

            /**
             * Social Icons
             */
            this.container.on( 'change', 'input:checkbox', function() {
                var $this = $( this );
                value = isToggleTrue( this );
                if ( 'cit_overall_site_disable_header' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        showHeaderSection();
                    } else {
                        hideHeaderSection();
                    }
                }
                if ( 'cit_overall_site_disable_footer' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        showFooterSection();
                    } else {
                        hideFooterSection();
                    }
                }
                if ( 'cit_footer_area_social_icons' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        hideSocialIcons();
                    } else {
                        showSocialIcons();
                    }
                }
                if ( 'cit_footer_area_contact_widget_area' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        hideNumberOfContactColumns();
                    } else {
                        showNumberOfContactColumns();
                    }
                }
                if ( 'cit_footer_area_widget_area' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        hideNumberOfColumns();
                    } else {
                        showNumberOfColumns();
                    }
                }
                if ( 'cit_overall_site_featured_image' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        hideFeaturedImageSettings();
                    } else {
                        showFeaturedImageSettings();
                    }
                }
                if ( 'cit_overall_site_featured_image_height' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        hideFeaturedImageSettings();
                    } else {
                        showFeaturedImageSettings();
                    }
                }

                if ( 'cit_overall_site_enable_bg_image' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        hideBackgroundImageSettings();
                    } else {
                        showBackgroundImageSettings();
                    }
                }
                control.setting.set( value );

				if ( 'woocommerce_header_cart_icon' !== $this.attr( 'id' ) ) {

					// Refresh the preview
					wp.customize.previewer.refresh();
				}
            });
        }

    });

    $( document ).ready( function() {
        if ( isToggleTrue( '#cit_overall_site_disable_header' ) ) {
            hideHeaderSection();
        }
        if ( isToggleTrue( '#cit_overall_site_disable_footer' ) ) {
            hideFooterSection();
        }
        if ( ! isToggleTrue( '#cit_footer_area_social_icons' ) ) {
            hideSocialIcons();
        }
        if ( ! isToggleTrue( '#cit_footer_area_widget_area' ) ) {
            hideNumberOfColumns();
        }
        if ( ! isToggleTrue( '#cit_footer_area_contact_widget_area' ) ) {
            hideNumberOfContactColumns();
        }
        if ( ! isToggleTrue( '#cit_overall_site_featured_image' ) ) {
            hideFeaturedImageSettings();
        }
        if ( ! isToggleTrue( '#cit_overall_site_enable_bg_image' ) ) {
            hideBackgroundImageSettings();
        }
		if ( ! isToggleTrue( '#woocommerce_header_cart_icon' ) ) {
			$( '#customize-control-woo_cart_color' ).hide();
			$( '#customize-control-woo_cart_text_color' ).hide();
		}
    });

	// Woocmmerce cart icon dependency
	wp.customize( 'woocommerce_header_cart_icon', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				$( '#customize-control-woo_cart_color' ).show();
				$( '#customize-control-woo_cart_text_color' ).show();
			} else {
				$( '#customize-control-woo_cart_color' ).hide();
				$( '#customize-control-woo_cart_text_color' ).hide();
			}
		} );
	} );
})( window.jQuery );
