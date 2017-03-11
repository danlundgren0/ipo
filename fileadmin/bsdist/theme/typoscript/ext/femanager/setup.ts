
plugin.tx_femanager {
    #view {
    #    templateRootPath = fileadmin/bsdist/theme/tmpl/femanager/Templates/
    #    partialRootPath = fileadmin/bsdist/theme/tmpl/femanager/Partials/
    #}
    persistence {
        storagePid =
    }
    settings {
        new {
            # take username and copy it to the email field (so email field is not nessesary in FE)
            fillEmailWithUsername = 1
            # required fields
            validation {
                email >
                firstName.required = 1
                lastName.required = 1
                #telephone.required = 1
                company.required = 1
                #address.required = 1
                #zip.required = 1
                #city.required = 1
            }
        }
    }

    # multi lang
    _LOCAL_LANG.default {
        tx_femanager_domain_model_user.username = Email Address
    }
    _LOCAL_LANG.de {
        tx_femanager_domain_model_user.username = Email Adresse
    }
}