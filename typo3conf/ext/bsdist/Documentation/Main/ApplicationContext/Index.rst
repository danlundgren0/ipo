.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. _docs.typo3.org: https://docs.typo3.org/typo3cms/CoreApiReference/ApiOverview/Bootstrapping/Index.html#bootstrapping-context


Application Context
===================
TYPO3 CMS provides three build-in contexts:

- Production (default)

- Development

- Testing


Environment variable TYPO3_CONTEXT
----------------------------------
The application context can be changed by setting the environment variable TYPO3_CONTEXT.  If not set, *Production* is the default context.

In your Apache configuration you may use

.. code:: bash

    SetEnv TYPO3_CONTEXT Development

to set the environment variable TYPO3_CONTEXT and change the TYPO3 Application Context to *Development*.


Development Context in bsdist
-----------------------------
In the setup file *theme/typoscript/setup.ts* is a conditional part with settings for development environments included.
It is only a basic setup. The CSS and Javascript files are not merged and meta robots is set to noindex,nofollow in the development context.

.. code-block:: typoscript

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

You will find more information about Application Context on `docs.typo3.org`_.