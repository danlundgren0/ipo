mod.wizards.newContentElement.wizardItems.iponlyplugins {
	header = IP-Only special plugins
	elements {
	  tx_dliponlyestate {
	     icon = ../fileadmin/Multimedia/Logos/nz.png
	     title = Estate
	     description = Add a new Estate
	     tt_content_defValues {
			CType = list
			list_type = dliponlyestate_estate
	     }
	  }
	}
	show := addToList(dliponlyestate_estate)
}
mod.wizards.newContentElement.wizardItems.iponlyplugins {
	elements {
	  tx_dliponlyestate {
	     icon = ../fileadmin/Multimedia/Logos/nz.png
	     title = Control-Point
	     description = Add a new Control-Point
	     tt_content_defValues {
			CType = list
			list_type = dliponlyestate_cp
	     }
	  }
	}
	show := addToList(dliponlyestate_cp)
}
mod.wizards.newContentElement.wizardItems.iponlyplugins.show := addToList(tx_dliponlyestate)
