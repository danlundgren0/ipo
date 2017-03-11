/* --------------------
 * Configuration
 */
config {
	#htmlTag_setParams = lang="en" dir="ltr"
	pageTitleFirst = 1

	absRefPrefix = /
	prefixLocalAnchors = all
}


/* --------------------
 * Page
 */
page = PAGE
page {
	typeNum = 0
	10 = FLUIDTEMPLATE
	10 {
		layoutRootPath = {$plugin.tx_bootstrapcore.theme.baseDir}/tmpl/backend_layout/Layouts/
		partialRootPath = {$plugin.tx_bootstrapcore.theme.baseDir}/tmpl/backend_layout/Partials/

		file.cObject = CASE
		file.cObject {
			key.data = levelfield:-1, backend_layout_next_level, slide
			key.override.field = backend_layout
			default = TEXT
			default.value = {$plugin.tx_bootstrapcore.theme.baseDir}/tmpl/backend_layout/tmpl_default.html
			2 = TEXT
			2.value       = {$plugin.tx_bootstrapcore.theme.baseDir}/tmpl/backend_layout/tmpl_home.html
			3 = TEXT
			3.value       = {$plugin.tx_bootstrapcore.theme.baseDir}/tmpl/backend_layout/tmpl_empty.html
		}

		variables {
			content < styles.content.get
			content_sidebar < styles.content.get
			content_sidebar.select.where = colPos=1
		}
	}

	meta {
		author   =
		robots   = index,follow
	}

	includeCSS {
		# see condition applicationContext for development settings
		# Grunt merged single css (Production Context)
		bootstrap >
		bootstrap_core >
		lightbox >
		custom = {$plugin.tx_bootstrapcore.theme.baseDir}/css/all.min.css
	}
	includeJSlibs {
		jquery = {$plugin.tx_bootstrapcore.theme.jQueryJsFile}
	}
	includeJSFooterlibs {
		# see condition applicationContext below for development settings
		# Grunt merged single js (Production Context)
		bootstrap >
		lightbox >
		custom = {$plugin.tx_bootstrapcore.theme.baseDir}/js/scripts.min.js
	}

}


/* --------------------
* tt_content customizations
*/
tt_content {

	image.20 {

		# Settings for responsive images rendering-type
		# Activated in constants, see styles.content.imgtext.layoutKey = srcset
		1 {
			# width and height added
			layout.srcset.element = <img src="###SRC###" srcset="###SOURCECOLLECTION###" width="###WIDTH###" height="###HEIGHT###"###PARAMS######ALTPARAMS######SELFCLOSINGTAGSLASH###>
			# sources settings, for layoutKey = srcset
			sourceCollection {
				small {
					width = 200
					srcsetCandidate = 600w
				}
				# image size = with * pixelDensity
				smallRetina {
					width = 375
					pixelDensity = 2
					srcsetCandidate = 600w 2x
				}
				big {
					width = 1140
					srcsetCandidate = 1200w
				}
			}
		}

		# Image max size based on backend_layout
		/*
		maxW >
		maxW.cObject = CASE
		maxW.cObject {
			key.data = levelfield:-1, backend_layout_next_level, slide
			key.override.data = TSFE:page|backend_layout

			# default template, home, fullwidth
			default = TEXT
			default.value = {$styles.content.imgtext.maxW}

			# template with sidebar
			1 = CASE
			1 {
				key.field = colPos
				# main col
				default = TEXT
				default.value = 750
				#default.value = 1500

				# sidebar
				1 = TEXT
				1.value = 360
				#1.value = 720
			}

		}
		*/

	}

	# Use header fields in gridelements
	#gridelements_pi1.10 =< lib.stdheader
}

/* --------------------
* Layout blocks, libs
*/
lib {
	logo = COA
	logo.wrap = <div class="logo">|</div>
	logo {
		10 = TEXT
		10.value = <img src="{$plugin.tx_bootstrapcore.theme.baseDir}/img/logo.png" class="logo img-responsive" />
		10.typolink.parameter = 1
	}

	footerContent = COA
	footerContent.wrap = <div class="container"><div class="row">|</div></div>
	footerContent {
		# left footer col
		10 < styles.content.get
		10 {
			select.pidInList = {$plugin.tx_bootstrapcore.website.footer.pageId}
			#slide = -1
			select.where = colPos={$plugin.tx_bootstrapcore.website.footer.leftColPos}
			stdWrap.wrap = <div class="col-md-4 col-sm-4">|</div>
		}
		# center
		20 < .10
		20.select.where = colPos={$plugin.tx_bootstrapcore.website.footer.centerColPos}
		20.stdWrap.wrap = <div class="col-md-4 col-sm-4 text-center">|</div>
		# right
		30 < .10
		30.select.where = colPos={$plugin.tx_bootstrapcore.website.footer.rightColPos}
		30.stdWrap.wrap = <div class="col-md-4 col-sm-4 text-right">|</div>
	}

	copyright = COA
	copyright {
		10 = TEXT
		10.data = date:U
		10.strftime = %Y
		10.wrap =  &copy; Copyright&nbsp;|&nbsp;Firma AG

		20 = HMENU
		20.wrap = &nbsp; &#124; &nbsp;|
		20 {
			entryLevel = 0
			#excludeUidList = 11
			1 = TMENU
			1 {
				wrap = |
				expAll = 1
				NO = 1
				NO.allWrap >
				NO.wrapItemAndSub = | |*| &nbsp;-&nbsp;| |*| &nbsp;-&nbsp;|
			}
		}
	}
}


/* --------------------
* Conditional stuff
*/
# Development Environment
#
[applicationContext = Development*]
	page {
		meta {
			robots   = noindex,nofollow
		}
		includeCSS {
			bootstrap = {$plugin.tx_bootstrapcore.theme.bootstrapCssFile}
			bootstrap_core = {$plugin.tx_bootstrapcore.theme.contentCssFile}
			lightbox = {$plugin.tx_bootstrapcore.theme.lightboxCssFile}
			# css/styles.css (created by grunt scss task if scss/styles.scss is used)
			custom = {$plugin.tx_bootstrapcore.theme.baseDir}/css/styles.css
		}
		includeJSFooterlibs {
			bootstrap = {$plugin.tx_bootstrapcore.theme.bootstrapJsFile}
			lightbox = {$plugin.tx_bootstrapcore.theme.lightboxJsFile}
			# js/includes/custom.js
			custom = {$plugin.tx_bootstrapcore.theme.baseDir}/js/includes/custom.js
			# or _includes.js (created by grunt concat task)
			#custom = {$plugin.tx_bootstrapcore.theme.baseDir}/js/_includes.js
		}
	}
[global]

# Staging
[applicationContext = Production/Staging]
	page {
		meta {
			robots   = noindex,nofollow
		}
	}
[global]

/*
# On home
[globalVar = TSFE:id = 1]
# change site/page title order
config.pageTitleFirst = 0
[global]
*/


/* --------------------
* Additional configurations
*/
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/nav/setup.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/lang/multilang.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/lang/langnav.ts">


# --- Extension setups (see constants.ts) ---
#
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/ext/indexed_search/setup.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/ext/felogin/setup.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/ext/grids/setup.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/ext/iconfont/setup.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/ext/formhandler/setup.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/ext/sr_freecap/setup.ts">
