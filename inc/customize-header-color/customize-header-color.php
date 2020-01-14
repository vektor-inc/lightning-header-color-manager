<?php
add_action( 'customize_register', 'lightning_customize_register_color' );
function lightning_customize_register_color( $wp_customize ) {

	$wp_customize->add_setting(
		'color_header_subtitle',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new Custom_Html_Control(
			$wp_customize,
			'color_header_subtitle',
			array(
				'label'            => '',
				'section'          => 'lightning_design',
				'type'             => 'text',
				'custom_title_sub' => __( 'Header Color', 'lightning-pro' ),
				'custom_html'      => '',
				'priority'         => 601,
			)
		)
	);

	// Header Bg
	$wp_customize->add_setting(
		'lightning_theme_options[color_header_bg]',
		array(
			'default'           => '',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'color_header_bg',
			array(
				'label'    => __( 'Header Background Color', 'lightning-pro' ),
				'section'  => 'lightning_design',
				'settings' => 'lightning_theme_options[color_header_bg]',
				'priority' => 601,
			)
		)
	);

	// color
	$wp_customize->add_setting(
		'lightning_theme_options[color_header_text]',
		array(
			'default'           => '',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'color_header_text',
			array(
				'label'    => __( 'Header Text Color', 'lightning-pro' ),
				'section'  => 'lightning_design',
				'settings' => 'lightning_theme_options[color_header_text]',
				'priority' => 601,
			)
		)
	);

}


/*
 色の出力 */

/*
  Print head
/*-------------------------------------------*/
add_action( 'wp_head', 'lightning_print_css_header', 3 );
function lightning_print_css_header() {
	$options     = get_option( 'lightning_theme_options' );
	$dynamic_css = '';

	if ( ! empty( $options['color_header_bg'] ) ) {
		$color_header_bg = esc_html( $options['color_header_bg'] );
		$dynamic_css    .= '
			.headerTop,.siteHeader { 
				background-color:' . $color_header_bg . ' ; 
			}';

		// origin2 ///////////////////
		$skin = get_option( 'lightning_design_skin' );
		if ( $skin == 'origin2' ) {
			$dynamic_css .= '
			@media (min-width: 992px){
				.header_scrolled .gMenu_outer { 
					background-color:' . $color_header_bg . ' ; 
				}
			}';
		}

		if ( function_exists( 'lightning_check_color_mode' ) && lightning_check_color_mode( $color_header_bg ) == 'light' ) {

			// Light Color ///////////////////

			$dynamic_css .= '
			.headerTop { 
				border-bottom:1px solid rgba(0,0,0,0.1); 
			}
			.header_scrolled .gMenu>li{ 
				border-left: 1px solid rgba(0,0,0,0.1);
			}';

		} else {

			// Dark Color ///////////////////

			$dynamic_css .= '
				.headerTop {
					border-bottom:1px solid rgba(255,255,255,0.2);
				}
				.header_scrolled .gMenu>li{
					border-left:1px solid rgba(255,255,255,0.2);
				}
				.headerTop_contactBtn .btn.btn-primary {
					color:' . $color_header_bg . ';
					background-color: #fff;
					border-color:rgba(255,255,255,0.2);
				}
				.headerTop_contactBtn .btn.btn-primary:hover {
					opacity: 0.9;
				}';
			// Mobile Nav Button
			$dynamic_css .= '
			.vk-mobile-nav-menu-btn {
				border-color:rgba(255,255,255,0.6);
				background-color:rgba(0,0,0,0.3);
				background-image: url(' . get_template_directory_uri() . '/inc/vk-mobile-nav/package/images/vk-menu-btn-white.svg);
			}
			.gMenu .acc-btn{
				background-image: url(' . get_template_directory_uri() . '/inc/vk-mobile-nav/package/images/vk-menu-acc-icon-open-white.svg);
			}
			.gMenu .acc-btn.acc-btn-close {
				background-image: url(' . get_template_directory_uri() . '/inc/vk-mobile-nav/package/images/vk-menu-close-white.svg);
			}
			.vk-menu-acc .acc-btn{
				border: 1px solid #fff;
			}';
		}
	}

	if ( ! empty( $options['color_header_text'] ) ) {
		$color_header_text = esc_html( $options['color_header_text'] );
		$dynamic_css      .= '
			.navbar-brand a { color: ' . $color_header_text . ' ;}
			@media (min-width: 992px){
				.headerTop,
				.headerTop li a,
				ul.gMenu>li>a,
				ul.gMenu>li>a:hover { color: ' . $color_header_text . ' ; }
			} /* @media (min-width: 992px) */
			';
	}

	if ( $dynamic_css ) {
		// delete before after space
		$dynamic_css = trim( $dynamic_css );
		// convert tab and br to space
		$dynamic_css = preg_replace( '/[\n\r\t]/', '', $dynamic_css );
		// Change multiple spaces to single space
		$dynamic_css = preg_replace( '/\s(?=\s)/', '', $dynamic_css );
		wp_add_inline_style( 'lightning-design-style', $dynamic_css );
	}

}
