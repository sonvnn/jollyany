<?php

/**
 * @package   Astroid Framework
 * @author    JoomDev https://www.joomdev.com
 * @copyright Copyright (C) 2009 - 2019 JoomDev.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 * 	DO NOT MODIFY THIS FILE DIRECTLY AS IT WILL BE OVERWRITTEN IN THE NEXT UPDATE
 *  You can easily override all files under /frontend/ folder.
 * 	Just copy the file to ROOT/templates/YOURTEMPLATE/html/frontend/ folder to create and override
 */
// No direct access.
defined('_JEXEC') or die;
jimport('joomla.filesystem.helper');

extract($displayData);
//Font family
$ast_fontfamily = array();
// Body Font Styles
$body_font = $template->params->get('body_typography_options', NULL);
if ($body_font === NULL) {
   $body_font = new \stdClass();
}

$in_head = true;
if (isset($params) && !empty($params) && !$params['in_head']) {
   $in_head = false;
}

$typography = array('body', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6');

$styles = $menu_style = $submenu_style = $top_bar_style = $footer_style = ['desktop' => '', 'tablet' => '', 'mobile' => ''];

$libraryFonts = AstroidFrameworkHelper::getUploadedFonts($template->template);

// Body, H1 - H6 font styles.
foreach ($typography as $typo) {
   $typoType = $template->params->get($typo . '_typography');
   if (trim($typoType) == 'custom') {
      $typoOption = $typo . '_typography_options';
      $typoParams = $template->params->get($typoOption);
      $fontface = str_replace('+', ' ', explode(":", $typoParams->font_face));
      $styles['desktop'] .= $typo . ',.' . $typo . '{';

      $styles['tablet'] .= $typo . ',.' . $typo . '{';
      $styles['mobile'] .= $typo . ',.' . $typo . '{';

      if (isset($fontface[0]) && !empty($fontface[0])) {
         if (isset($libraryFonts[$fontface[0]])) {
            $styles['desktop'] .= 'font-family: ' . $libraryFonts[$fontface[0]]['name'] . ',' . $typoParams->alt_font_face . ';';
            AstroidFrameworkHelper::loadLibraryFont($libraryFonts[$fontface[0]], $template);
         } else {
            $styles['desktop'] .= 'font-family: ' . $fontface[0] . ',' . $typoParams->alt_font_face . ';';
            if (!AstroidFrameworkHelper::isSystemFont($fontface[0])) {
               array_push($ast_fontfamily, $typoParams->font_face);
            }
         }
         //$document->addStyleSheet('https://fonts.googleapis.com/css?family='.$fontface[0]);
      }

      if (isset($typoParams->font_size) && !empty($typoParams->font_size)) {
         if (is_object($typoParams->font_size)) {
            // if responsive
            foreach (['desktop', 'tablet', 'mobile'] as $device) {
               $font_size_unit = isset($typoParams->font_size_unit->{$device}) ? $typoParams->font_size_unit->{$device} : 'em';
               $styles[$device] .= 'font-size: ' . $typoParams->font_size->{$device} . $font_size_unit . ';';
            }
         } else {
            // if old type value
            $font_size_unit = isset($typoParams->font_size_unit) ? $typoParams->font_size_unit : 'em';
            $styles['desktop'] .= 'font-size: ' . $typoParams->font_size . $font_size_unit . ';';
         }
      }

      if (isset($typoParams->font_color) && !empty($typoParams->font_color)) {
         $styles['desktop'] .= 'color: ' . $typoParams->font_color . ';';
      }

      if (isset($typoParams->letter_spacing) && !empty($typoParams->letter_spacing)) {
         if (is_object($typoParams->letter_spacing)) {
            // if responsive
            foreach (['desktop', 'tablet', 'mobile'] as $device) {
               $letter_spacing_unit = isset($typoParams->letter_spacing_unit->{$device}) ? $typoParams->letter_spacing_unit->{$device} : 'em';
               $styles[$device] .= 'letter-spacing: ' . $typoParams->letter_spacing->{$device} . $letter_spacing_unit . ';';
            }
         } else {
            // if old type value
            $letter_spacing_unit = isset($typoParams->letter_spacing_unit) ? $typoParams->letter_spacing_unit : 'em';
            $styles['desktop'] .= 'letter-spacing: ' . $typoParams->letter_spacing . $letter_spacing_unit . ';';
         }
      }

      if (isset($typoParams->font_weight) && !empty($typoParams->font_weight)) {
         $styles['desktop'] .= 'font-weight: ' . $typoParams->font_weight . ';';
      }

      if (isset($typoParams->line_height) && !empty($typoParams->line_height)) {
         if (is_object($typoParams->line_height)) {
            // if responsive
            foreach (['desktop', 'tablet', 'mobile'] as $device) {
               $line_height_unit = isset($typoParams->line_height_unit->{$device}) ? $typoParams->line_height_unit->{$device} : 'em';
               $styles[$device] .= 'line-height: ' . $typoParams->line_height->{$device} . $line_height_unit . ';';
            }
         } else {
            // if old type value
            $line_height_unit = isset($typoParams->line_height_unit) ? $typoParams->line_height_unit : 'em';
            $styles['desktop'] .= 'line-height: ' . $typoParams->line_height . $line_height_unit . ';';
         }
      }

      if (isset($typoParams->text_transform) && !empty($typoParams->text_transform)) {
         $styles['desktop'] .= 'text-transform: ' . $typoParams->text_transform . ';';
      }
      $styles['desktop'] .= '}';
      $styles['tablet'] .= '}';
      $styles['mobile'] .= '}';
   }
}

// Menu Font Styles
$menuType = $template->params->get('menus_typography');
if (trim($menuType) == 'custom') {
   $menu_font = $template->params->get('menu_typography_options');
   $menu_fontface = str_replace('+', ' ', explode(":", $menu_font->font_face));

   $menu_style = ['desktop' => '.astroid-nav>li>a,.astroid-sidebar-menu>li>a {', 'tablet' => '.astroid-nav>li>a,.astroid-sidebar-menu>li>a {', 'mobile' => '.astroid-nav>li>a,.astroid-sidebar-menu>li>a {'];

   if (isset($menu_fontface[0]) && !empty($menu_fontface[0])) {

      if (isset($libraryFonts[$menu_fontface[0]])) {
         $menu_style['desktop'] .= 'font-family: ' . $libraryFonts[$menu_fontface[0]]['name'] . ';';
         AstroidFrameworkHelper::loadLibraryFont($libraryFonts[$menu_fontface[0]], $template);
      } else {
         $menu_style['desktop'] .= 'font-family: ' . $menu_fontface[0] . ';';
         if (!AstroidFrameworkHelper::isSystemFont($menu_fontface[0])) {
            array_push($ast_fontfamily, $menu_font->font_face);
         }
      }
   }

   if (isset($menu_font->font_size) && !empty($menu_font->font_size)) {
      if (is_object($menu_font->font_size)) {
         // if responsive
         foreach (['desktop', 'tablet', 'mobile'] as $device) {
            $font_size_unit = isset($menu_font->font_size_unit->{$device}) ? $menu_font->font_size_unit->{$device} : 'em';
            $menu_style[$device] .= 'font-size: ' . $menu_font->font_size->{$device} . $font_size_unit . ';';
         }
      } else {
         // if old type value
         $font_size_unit = isset($menu_font->font_size_unit) ? $menu_font->font_size_unit : 'em';
         $menu_style['desktop'] .= 'font-size: ' . $menu_font->font_size . $font_size_unit . ';';
      }
   }

   if (isset($menu_font->font_color) && !empty($menu_font->font_color)) {
      $menu_style['desktop'] .= 'color: ' . $menu_font->font_color . ';';
   }

   if (isset($menu_font->letter_spacing) && !empty($menu_font->letter_spacing)) {
      if (is_object($menu_font->letter_spacing)) {
         // if responsive
         foreach (['desktop', 'tablet', 'mobile'] as $device) {
            $letter_spacing_unit = isset($menu_font->letter_spacing_unit->{$device}) ? $menu_font->letter_spacing_unit->{$device} : 'em';
            $menu_style[$device] .= 'letter-spacing: ' . $menu_font->letter_spacing->{$device} . $letter_spacing_unit . ';';
         }
      } else {
         // if old type value
         $letter_spacing_unit = isset($menu_font->letter_spacing_unit) ? $menu_font->letter_spacing_unit : 'em';
         $menu_style['desktop'] .= 'letter-spacing: ' . $menu_font->letter_spacing . $letter_spacing_unit . ';';
      }
   }

   if (isset($menu_font->font_weight) && !empty($menu_font->font_weight)) {
      $menu_style['desktop'] .= 'font-weight: ' . $menu_font->font_weight . ';';
   }

   if (isset($menu_font->line_height) && !empty($menu_font->line_height)) {
      if (is_object($menu_font->line_height)) {
         // if responsive
         foreach (['desktop', 'tablet', 'mobile'] as $device) {
            $line_height_unit = isset($menu_font->line_height_unit->{$device}) ? $menu_font->line_height_unit->{$device} : 'em';
            $menu_style[$device] .= 'line-height: ' . $menu_font->line_height->{$device} . $line_height_unit . ';';
         }
      } else {
         // if old type value
         $line_height_unit = isset($menu_font->line_height_unit) ? $menu_font->line_height_unit : 'em';
         $menu_style['desktop'] .= 'line-height: ' . $menu_font->line_height . $line_height_unit . ';';
      }
   }

   if (isset($menu_font->text_transform) && !empty($menu_font->text_transform)) {
      $menu_style['desktop'] .= 'text-transform: ' . $menu_font->text_transform . ';';
   }
   $menu_style['desktop'] .= '}';
   $menu_style['mobile'] .= '}';
   $menu_style['tablet'] .= '}';

   if (isset($menu_font->line_height) && !empty($menu_font->line_height)) {
      if (is_object($menu_font->line_height)) {
         // if responsive
         foreach (['desktop', 'tablet', 'mobile'] as $device) {
            $line_height_unit = isset($menu_font->line_height_unit->{$device}) ? $menu_font->line_height_unit->{$device} : 'em';
            $menu_style[$device] .= 'line-height: ' . $menu_font->line_height->{$device} . $line_height_unit . ';';
            $menu_style[$device] .= '.astroid-sidebar-menu li > .nav-item-caret{line-height: ' . $menu_font->line_height->{$device} . $line_height_unit . ' !important;}';
         }
      } else {
         // if old type value
         $line_height_unit = isset($menu_font->line_height_unit) ? $menu_font->line_height_unit : 'em';
         $menu_style['desktop'] .= 'line-height: ' . $menu_font->line_height . $line_height_unit . ';';
         $menu_style['desktop'] .= '.astroid-sidebar-menu li > .nav-item-caret{line-height: ' . $menu_font->line_height . $line_height_unit . ' !important;}';
      }
   }
}

// SubMenu Font Styles
$submenuType = $template->params->get('submenus_typography');
if (trim($submenuType) == 'custom') {
   $submenu_font = $template->params->get('submenu_typography_options');
   $submenu_fontface = str_replace('+', ' ', explode(":", $submenu_font->font_face));
   $submenu_style = '.nav-submenu-container .nav-submenu > li, .jddrop-content .megamenu-item .megamenu-menu li, .nav-submenu {';

   $tablet_submenu_style = '.nav-submenu-container .nav-submenu > li, .jddrop-content .megamenu-item .megamenu-menu li, .nav-submenu {';

   $mobile_submenu_style = '.nav-submenu-container .nav-submenu > li, .jddrop-content .megamenu-item .megamenu-menu li, .nav-submenu {';

   $submenu_style = ['desktop' => '.nav-submenu-container .nav-submenu > li, .jddrop-content .megamenu-item .megamenu-menu li, .nav-submenu {', 'tablet' => '.nav-submenu-container .nav-submenu > li, .jddrop-content .megamenu-item .megamenu-menu li, .nav-submenu {', 'mobile' => '.nav-submenu-container .nav-submenu > li, .jddrop-content .megamenu-item .megamenu-menu li, .nav-submenu {'];

   if (isset($submenu_fontface[0]) && !empty($submenu_fontface[0])) {
      if (isset($libraryFonts[$submenu_fontface[0]])) {
         $submenu_style['desktop'] .= 'font-family: ' . $libraryFonts[$submenu_fontface[0]]['name'] . ',' . $submenu_font->alt_font_face . ';';
         AstroidFrameworkHelper::loadLibraryFont($libraryFonts[$submenu_fontface[0]], $template);
      } else {
         $submenu_style['desktop'] .= 'font-family: ' . $submenu_fontface[0] . ', ' . $submenu_font->alt_font_face . ';';
         if (!AstroidFrameworkHelper::isSystemFont($submenu_fontface[0])) {
            array_push($ast_fontfamily, $submenu_font->font_face);
         }
      }
   }

   if (isset($submenu_font->line_height) && !empty($submenu_font->line_height)) {
      if (is_object($submenu_font->line_height)) {
         // if responsive
         foreach (['desktop', 'tablet', 'mobile'] as $device) {
            $font_size_unit = isset($submenu_font->font_size_unit->{$device}) ? $submenu_font->font_size_unit->{$device} : 'em';
            $submenu_style[$device] .= 'font-size: ' . $submenu_font->font_size->{$device} . $font_size_unit . ';';
         }
      } else {
         // if old type value
         $font_size_unit = isset($submenu_font->font_size_unit) ? $submenu_font->font_size_unit : 'em';
         $submenu_style['desktop'] .= 'font-size: ' . $submenu_font->font_size . $font_size_unit . ';';
      }
   }

   if (isset($submenu_font->font_color) && !empty($submenu_font->font_color)) {
      $submenu_style['desktop'] .= 'color: ' . $submenu_font->font_color . ';';
   }

   if (isset($submenu_font->letter_spacing) && !empty($submenu_font->letter_spacing)) {
      if (is_object($submenu_font->letter_spacing)) {
         // if responsive
         foreach (['desktop', 'tablet', 'mobile'] as $device) {
            $letter_spacing_unit = isset($submenu_font->letter_spacing_unit->{$device}) ? $submenu_font->letter_spacing_unit->{$device} : 'em';
            $submenu_style[$device] .= 'letter-spacing: ' . $submenu_font->letter_spacing->{$device} . $letter_spacing_unit . ';';
         }
      } else {
         // if old type value
         $letter_spacing_unit = isset($submenu_font->letter_spacing_unit) ? $submenu_font->letter_spacing_unit : 'em';
         $submenu_style['desktop'] .= 'letter-spacing: ' . $submenu_font->letter_spacing . $letter_spacing_unit . ';';
      }
   }

   if (isset($submenu_font->font_weight) && !empty($submenu_font->font_weight)) {
      $submenu_style['desktop'] .= 'font-weight: ' . $submenu_font->font_weight . ';';
   }

   if (isset($submenu_font->line_height) && !empty($submenu_font->line_height)) {
      if (is_object($submenu_font->line_height)) {
         // if responsive
         foreach (['desktop', 'tablet', 'mobile'] as $device) {
            $line_height_unit = isset($submenu_font->line_height_unit->{$device}) ? $submenu_font->line_height_unit->{$device} : 'em';
            $submenu_style[$device] .= 'line-height: ' . $submenu_font->line_height->{$device} . $line_height_unit . ';';
         }
      } else {
         // if old type value
         $line_height_unit = isset($submenu_font->line_height_unit) ? $submenu_font->line_height_unit : 'em';
         $submenu_style['desktop'] .= 'line-height: ' . $submenu_font->line_height . $line_height_unit . ';';
      }
   }

   if (isset($submenu_font->text_transform) && !empty($submenu_font->text_transform)) {
      $submenu_style['desktop'] .= 'text-transform: ' . $submenu_font->text_transform . ';';
   }
   $submenu_style['desktop'] .= '}';
   $submenu_style['tablet'] .= '}';
   $submenu_style['mobile'] .= '}';
}

// Top Bar Font Styles
$topbarType = $template->params->get('top_bar_typography');
if (trim($topbarType) == 'custom') {
	$top_bar_font = $template->params->get('top_bar_typography_options');
	$top_bar_fontface = str_replace('+', ' ', explode(":", $top_bar_font->font_face));
	$top_bar_style = '.top-bar {';

	$top_bar_style = ['desktop' => '.top-bar {', 'tablet' => '.top-bar {', 'mobile' => '.top-bar {'];

	if (isset($top_bar_fontface[0]) && !empty($top_bar_fontface[0])) {
		if (isset($libraryFonts[$top_bar_fontface[0]])) {
			$top_bar_style['desktop'] .= 'font-family: ' . $libraryFonts[$top_bar_fontface[0]]['name'] . ',' . $top_bar_font->alt_font_face . ';';
			AstroidFrameworkHelper::loadLibraryFont($libraryFonts[$top_bar_fontface[0]], $template);
		} else {
			$top_bar_style['desktop'] .= 'font-family: ' . $top_bar_fontface[0] . ', ' . $top_bar_font->alt_font_face . ';';
			if (!AstroidFrameworkHelper::isSystemFont($top_bar_fontface[0])) {
				array_push($ast_fontfamily, $top_bar_font->font_face);
			}
		}
	}

	if (isset($top_bar_font->line_height) && !empty($top_bar_font->line_height)) {
		if (is_object($top_bar_font->line_height)) {
			// if responsive
			foreach (['desktop', 'tablet', 'mobile'] as $device) {
				$font_size_unit = isset($top_bar_font->font_size_unit->{$device}) ? $top_bar_font->font_size_unit->{$device} : 'em';
				$top_bar_style[$device] .= 'font-size: ' . $top_bar_font->font_size->{$device} . $font_size_unit . ';';
			}
		} else {
			// if old type value
			$font_size_unit = isset($top_bar_font->font_size_unit) ? $top_bar_font->font_size_unit : 'em';
			$top_bar_style['desktop'] .= 'font-size: ' . $top_bar_font->font_size . $font_size_unit . ';';
		}
	}

	if (isset($top_bar_font->font_color) && !empty($top_bar_font->font_color)) {
		$top_bar_style['desktop'] .= 'color: ' . $top_bar_font->font_color . ';';
	}

	if (isset($top_bar_font->letter_spacing) && !empty($top_bar_font->letter_spacing)) {
		if (is_object($top_bar_font->letter_spacing)) {
			// if responsive
			foreach (['desktop', 'tablet', 'mobile'] as $device) {
				$letter_spacing_unit = isset($top_bar_font->letter_spacing_unit->{$device}) ? $top_bar_font->letter_spacing_unit->{$device} : 'em';
				$top_bar_style[$device] .= 'letter-spacing: ' . $top_bar_font->letter_spacing->{$device} . $letter_spacing_unit . ';';
			}
		} else {
			// if old type value
			$letter_spacing_unit = isset($top_bar_font->letter_spacing_unit) ? $top_bar_font->letter_spacing_unit : 'em';
			$top_bar_style['desktop'] .= 'letter-spacing: ' . $top_bar_font->letter_spacing . $letter_spacing_unit . ';';
		}
	}

	if (isset($top_bar_font->font_weight) && !empty($top_bar_font->font_weight)) {
		$top_bar_style['desktop'] .= 'font-weight: ' . $top_bar_font->font_weight . ';';
	}

	if (isset($top_bar_font->line_height) && !empty($top_bar_font->line_height)) {
		if (is_object($top_bar_font->line_height)) {
			// if responsive
			foreach (['desktop', 'tablet', 'mobile'] as $device) {
				$line_height_unit = isset($top_bar_font->line_height_unit->{$device}) ? $top_bar_font->line_height_unit->{$device} : 'em';
				$top_bar_style[$device] .= 'line-height: ' . $top_bar_font->line_height->{$device} . $line_height_unit . ';';
			}
		} else {
			// if old type value
			$line_height_unit = isset($top_bar_font->line_height_unit) ? $top_bar_font->line_height_unit : 'em';
			$top_bar_style['desktop'] .= 'line-height: ' . $top_bar_font->line_height . $line_height_unit . ';';
		}
	}

	if (isset($top_bar_font->text_transform) && !empty($top_bar_font->text_transform)) {
		$top_bar_style['desktop'] .= 'text-transform: ' . $top_bar_font->text_transform . ';';
	}
	$top_bar_style['desktop'] .= '}';
	$top_bar_style['tablet'] .= '}';
	$top_bar_style['mobile'] .= '}';
}

// Footer Font Styles
$footerType = $template->params->get('footer_typography');
if (trim($footerType) == 'custom') {
	$footer_font = $template->params->get('footer_typography_options');
	$footer_fontface = str_replace('+', ' ', explode(":", $footer_font->font_face));
	$footer_style = '#astroid-footer {';

	$footer_style = ['desktop' => '#astroid-footer {', 'tablet' => '#astroid-footer {', 'mobile' => '#astroid-footer {'];

	if (isset($footer_fontface[0]) && !empty($footer_fontface[0])) {
		if (isset($libraryFonts[$footer_fontface[0]])) {
			$footer_style['desktop'] .= 'font-family: ' . $libraryFonts[$footer_fontface[0]]['name'] . ',' . $footer_font->alt_font_face . ';';
			AstroidFrameworkHelper::loadLibraryFont($libraryFonts[$footer_fontface[0]], $template);
		} else {
			$footer_style['desktop'] .= 'font-family: ' . $footer_fontface[0] . ', ' . $footer_font->alt_font_face . ';';
			if (!AstroidFrameworkHelper::isSystemFont($footer_fontface[0])) {
				array_push($ast_fontfamily, $footer_font->font_face);
			}
		}
	}

	if (isset($footer_font->line_height) && !empty($footer_font->line_height)) {
		if (is_object($footer_font->line_height)) {
			// if responsive
			foreach (['desktop', 'tablet', 'mobile'] as $device) {
				$font_size_unit = isset($footer_font->font_size_unit->{$device}) ? $footer_font->font_size_unit->{$device} : 'em';
				$footer_style[$device] .= 'font-size: ' . $footer_font->font_size->{$device} . $font_size_unit . ';';
			}
		} else {
			// if old type value
			$font_size_unit = isset($footer_font->font_size_unit) ? $footer_font->font_size_unit : 'em';
			$footer_style['desktop'] .= 'font-size: ' . $footer_font->font_size . $font_size_unit . ';';
		}
	}

	if (isset($footer_font->font_color) && !empty($footer_font->font_color)) {
		$footer_style['desktop'] .= 'color: ' . $footer_font->font_color . ';';
	}

	if (isset($footer_font->letter_spacing) && !empty($footer_font->letter_spacing)) {
		if (is_object($footer_font->letter_spacing)) {
			// if responsive
			foreach (['desktop', 'tablet', 'mobile'] as $device) {
				$letter_spacing_unit = isset($footer_font->letter_spacing_unit->{$device}) ? $footer_font->letter_spacing_unit->{$device} : 'em';
				$footer_style[$device] .= 'letter-spacing: ' . $footer_font->letter_spacing->{$device} . $letter_spacing_unit . ';';
			}
		} else {
			// if old type value
			$letter_spacing_unit = isset($footer_font->letter_spacing_unit) ? $footer_font->letter_spacing_unit : 'em';
			$footer_style['desktop'] .= 'letter-spacing: ' . $footer_font->letter_spacing . $letter_spacing_unit . ';';
		}
	}

	if (isset($footer_font->font_weight) && !empty($footer_font->font_weight)) {
		$footer_style['desktop'] .= 'font-weight: ' . $footer_font->font_weight . ';';
	}

	if (isset($footer_font->line_height) && !empty($footer_font->line_height)) {
		if (is_object($footer_font->line_height)) {
			// if responsive
			foreach (['desktop', 'tablet', 'mobile'] as $device) {
				$line_height_unit = isset($footer_font->line_height_unit->{$device}) ? $footer_font->line_height_unit->{$device} : 'em';
				$footer_style[$device] .= 'line-height: ' . $footer_font->line_height->{$device} . $line_height_unit . ';';
			}
		} else {
			// if old type value
			$line_height_unit = isset($footer_font->line_height_unit) ? $footer_font->line_height_unit : 'em';
			$footer_style['desktop'] .= 'line-height: ' . $footer_font->line_height . $line_height_unit . ';';
		}
	}

	if (isset($footer_font->text_transform) && !empty($footer_font->text_transform)) {
		$footer_style['desktop'] .= 'text-transform: ' . $footer_font->text_transform . ';';
	}
	$footer_style['desktop'] .= '}';
	$footer_style['tablet'] .= '}';
	$footer_style['mobile'] .= '}';
}

// styles for tablet
$tabletCSS = '';
if (!empty($styles['tablet'])) {
	$tabletCSS .= $styles['tablet'];
}
if (!empty($menu_style['tablet'])) {
	$tabletCSS .= $menu_style['tablet'];
}
if (isset($submenu_style['tablet'])) {
	$tabletCSS .= $submenu_style['tablet'];
}
if (isset($top_bar_style['tablet'])) {
	$tabletCSS .= $top_bar_style['tablet'];
}
if (isset($footer_style['tablet'])) {
	$tabletCSS .= $footer_style['tablet'];
}

// styles for mobile
$mobileCSS = '';
if (!empty($styles['mobile'])) {
	$mobileCSS .= $styles['mobile'];
}
if (!empty($menu_style['mobile'])) {
	$mobileCSS .= $menu_style['mobile'];
}
if (isset($submenu_style['mobile'])) {
	$mobileCSS .= $submenu_style['mobile'];
}
if (isset($top_bar_style['mobile'])) {
	$mobileCSS .= $top_bar_style['mobile'];
}
if (isset($footer_style['mobile'])) {
	$mobileCSS .= $footer_style['mobile'];
}

// Let's add combined style sheet here
$ast_fontfamily_list = implode("|", str_replace(" ", "+", array_unique($ast_fontfamily)));
if ($in_head) {
   $document = JFactory::getDocument();
   if (!empty($ast_fontfamily_list)) {
      $document->addStyleSheet('https://fonts.googleapis.com/css?family=' . $ast_fontfamily_list);
   }

	$template->addStyleDeclaration($styles['desktop']);
	$template->addStyleDeclaration($menu_style['desktop']);
	$template->addStyleDeclaration($submenu_style['desktop']);
	$template->addStyleDeclaration($footer_style['desktop']);
	$template->addStyleDeclaration($top_bar_style['desktop']);

	$template->addStyleDeclaration($tabletCSS, 'tablet');
	$template->addStyleDeclaration($mobileCSS, 'mobile');
} else {
   if (!empty($ast_fontfamily_list)) {
      echo '<link href="' . 'https://fonts.googleapis.com/css?family=' . $ast_fontfamily_list . '" rel="stylesheet" type="text/css" />';
   }
   echo "<style>";
   echo $styles['desktop'];
   echo $menu_style['desktop'];
   echo $submenu_style['desktop'];
   echo $top_bar_style['desktop'];
   echo $footer_style['desktop'];
   echo $tabletCSS;
   echo $mobileCSS;
   echo "</style>";
}
