lib.footerContent >
lib {
footerContent
footerContent = COA
  footerContent.wrap = <div class="container"><div class="row">|</div></div>
  footerContent {
    10 < styles.content.get
    10.select.where = colPos={$plugin.tx_bootstrapcore.website.footer.centerColPos}
    10.stdWrap.wrap = <div id="{$plugin.tx_bootstrapcore.website.footer.centerColPos}" class="col-md-12 col-sm-12 text-center">|</div>
  }
}