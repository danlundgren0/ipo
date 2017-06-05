DanL.Search = {
    getSearchOptionsByEstate: function(el) {
    },
    addCities: function(cities) {
        $('[name="tx_dliponlyestate_reportsearch[cities]"]').empty();
        $.each(cities, function(index, value) {
            $('[name="tx_dliponlyestate_reportsearch[cities]"]').append('<option value="'+value+'">'+value+'</option>');
        });
    },
    addNodeTypes: function(nodeTypes) {
        $('[name="tx_dliponlyestate_reportsearch[nodeTypes]"]').empty();
        $.each(nodeTypes, function(index, value) {
            $('[name="tx_dliponlyestate_reportsearch[nodeTypes]"]').append('<option value="'+index+'">'+value+'</option>');
        });
    },
    addNotes: function(notes) {
        $('[name="tx_dliponlyestate_reportsearch[notes]"]').empty();
        $.each(notes, function(index, value) {
            $('[name="tx_dliponlyestate_reportsearch[notes]"]').append('<option value="'+index+'">'+value+'</option>');
        });
    },
    addTechnicians: function(technicians) {
        $('[name="tx_dliponlyestate_reportsearch[technicians]"]').empty();
        $.each(technicians, function(index, value) {
            $('[name="tx_dliponlyestate_reportsearch[technicians]"]').append('<option value="'+index+'">'+value+'</option>');
        });
    },
    getCompleteReport: function(el) {
        DanL.ajax.fetch({
            command: 'getCompleteReport',
            arguments: {
                reportUid: $(el).data('report'),
                estateUid: $(el).data('estate')
            }
        }).done(function(data, textStatus, jqXHR) {
            //$('#genericModalReport').remove();
            //$('.modal-backdrop').remove();
            $('body').append(data.data.response);
            $('#genericModalReport').modal({
              keyboard: false
            })
            $('#genericModalReport').on('hidden.bs.modal', function (e) {
                $('#genericModalReport').remove();
                $('.modal-backdrop').remove();
            })
            console.log(data);
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            console.log('getReportData failed: ' + textStatus);
        }); 
    },
    getCriticalReport: function(el) {
        DanL.ajax.fetch({
            command: 'getCriticalReport',
            arguments: {
                reportUid: $(el).data('report'),
                estateUid: $(el).data('estate')
            }
        }).done(function(data, textStatus, jqXHR) {
            //$('#genericModalReport').remove();
            //$('.modal-backdrop').remove();
            $('body').append(data.data.response);
            $('#criticalModalReport').modal({
              keyboard: false
            })
            $('#criticalModalReport').on('hidden.bs.modal', function (e) {
                $('#criticalModalReport').remove();
                $('.modal-backdrop').remove();
            })
            console.log(data);
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            console.log('getReportData failed: ' + textStatus);
        }); 
    },
    getRemarkReport: function(el) {
        DanL.ajax.fetch({
            command: 'getRemarkReport',
            arguments: {
                reportUid: $(el).data('report'),
                estateUid: $(el).data('estate')
            }
        }).done(function(data, textStatus, jqXHR) {
            //$('#genericModalReport').remove();
            //$('.modal-backdrop').remove();
            $('body').append(data.data.response);
            $('#remarkModalReport').modal({
              keyboard: false
            })
            $('#remarkModalReport').on('hidden.bs.modal', function (e) {
                $('#remarkModalReport').remove();
                $('.modal-backdrop').remove();
            })
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            console.log('getReportData failed: ' + textStatus);
        }); 
    },
    getPurchaseReport: function(el) {
        DanL.ajax.fetch({
            command: 'getPurchaseReport',
            arguments: {
                reportUid: $(el).data('report'),
                estateUid: $(el).data('estate')
            }
        }).done(function(data, textStatus, jqXHR) {
            //$('#genericModalReport').remove();
            //$('.modal-backdrop').remove();
            $('body').append(data.data.response);
            $('#purchaseModalReport').modal({
              keyboard: false
            })
            $('#purchaseModalReport').on('hidden.bs.modal', function (e) {
                $('#purchaseModalReport').remove();
                $('.modal-backdrop').remove();
            })
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            console.log('getReportData failed: ' + textStatus);
        }); 
    },
    getAllCompletedRemarksReport: function(el) {
        DanL.ajax.fetch({
            command: 'getAllCompletedRemarksReport',
            arguments: {
                reportUid: $(el).data('report'),
                estateUid: $(el).data('estate')
            }
        }).done(function(data, textStatus, jqXHR) {
            //$('#genericModalReport').remove();
            //$('.modal-backdrop').remove();
            $('body').append(data.data.response);
            $('#CompletedRemarksModalReport').modal({
              keyboard: false
            })
            $('#CompletedRemarksModalReport').on('hidden.bs.modal', function (e) {
                $('#CompletedRemarksModalReport').remove();
                $('.modal-backdrop').remove();
            })
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            console.log('getReportData failed: ' + textStatus);
        }); 
    }    
}
DanL.Result = {

}
$(function() {

    $(".affix-header").affix({offset: {top: $(".top").outerHeight(true)+$('.search-box').outerHeight(true)} });
    $('.affix-header').on('affixed.bs.affix', function () {
        $('.affix-header').css('width', $('.table-like').width());
    })
    
    $('[data-method="getCompleteReport"]').on('click', function(event) {
        event.preventDefault();
        DanL.Search.getCompleteReport($(this));
    });
    $('[data-method="getCriticalReport"]').on('click', function(event) {
        event.preventDefault();
        DanL.Search.getCriticalReport($(this));
    });
    $('[data-method="getRemarkReport"]').on('click', function(event) {
        event.preventDefault();
        DanL.Search.getRemarkReport($(this));
    });
    $('[data-method="getAllCompletedRemarksReport"]').on('click', function(event) {
        event.preventDefault();
        DanL.Search.getAllCompletedRemarksReport($(this));
    });    
    $('[data-method="getPurchaseReport"]').on('click', function(event) {
        event.preventDefault();
        DanL.Search.getPurchaseReport($(this));
    });
    $('[name="tx_dliponlyestate_reportsearch[estates]"]').on('change', function() {
        DanL.Search.getSearchOptionsByEstate($(this));
        DanL.ajax.fetch({
            command: 'getEstateSearchSettings',
            arguments: {
                estateUid: $(this).val()
            }
        }).done(function(data, textStatus, jqXHR) {
            DanL.Search.addCities(data.data.cities);
            DanL.Search.addNodeTypes(data.data.nodetype);
            DanL.Search.addNotes(data.data.notes);
            DanL.Search.addTechnicians(data.data.technicians);
            //$('[name="tx_dliponlyestate_reportsearch[cities]"]')
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            console.log('getNewNoteTmpl failed: ' + textStatus);
        }); 
    });
    var $table = $('.table-like').isotope({
        layoutMode: 'vertical',
        itemSelector: '.latest-report',
        getSortData: {
            type: '.type',
            name: '.name',
            report: '[data-sortversion]',
            resptech: '.resptech',
            critical: '.critical parseInt',
            remark: '.remark parseInt',
            preremark: '.preremark parseInt',
            exetech: '.exetech',
            note: '.note parseInt',
            purchase: '.purchase parseInt'
            /*category: '.category',
            weight: function( itemElem ) {
              var weight = $( itemElem ).find('.weight').text();
              return parseFloat( weight.replace( /[\(\)]/g, '') );
            }*/
        },
        sortBy: ['resptech','type']
    });
    //$container.isotope('reLayout');
    // bind sort button click
    $('.sort-header').on( 'click', 'div', function() {
    	var sortClass = 'sort-'+$(this).attr('data-sort');
        var hasClass = $(this).hasClass('sort-'+$(this).attr('data-sort'));
        var sortValue = $(this).attr('data-sort-value');
        $(this).toggleClass(sortClass);    	

        //var sortClass = $(this).hasClass('sort-asc');
        //var sortValue = $(this).attr('data-sort-value');
        //$(this).toggleClass('sort-asc');
console.log($(this).attr('data-sort'));
console.log($table);
console.log(hasClass);
console.log(sortClass);
console.log(sortValue);
        $table.isotope({ sortBy: sortValue, sortAscending: !hasClass });
    });

    $(".js_search-header").sticky({topSpacing:0,zIndex:20000});

    // change is-checked class on buttons
    $('.header').each( function( i, buttonGroup ) {
        var $buttonGroup = $( buttonGroup );
        $buttonGroup.on( 'click', 'div', function() {
            $buttonGroup.find('.is-checked').removeClass('is-checked');
            $( this ).addClass('is-checked');
        });
    });
    $('.panel-collapse').on('shown.bs.collapse', function () {
        $table.isotope('layout');
    })
    $('.panel-collapse').on('hidden.bs.collapse', function () {        
        $table.isotope('layout');
    })
    $('#myModalReport').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var imgSrc = button.data('imgsrc');
        var question = button.data('question');
        var cp = button.data('cp');
        var comment = button.data('comment');
        $(this).find('.modal-body img').attr('src', imgSrc);
        $(this).find('.modal-title').append(cp);
        $(this).find('.modal-body .modal-h2').append(question);
        $(this).find('.modal-body .modal-comment').append(comment);
      
    });
    $('#myModalReport').on('hidden.bs.modal', function (event) {
        $(this).find('.modal-body img').attr('src', '');
        $(this).find('.modal-title').empty();
        $(this).find('.modal-body .modal-h2').empty();
        $(this).find('.modal-body .modal-comment').empty();
    });
    $('[data-action="hideme"]').on('click', function() {
        $(this).closest('.show-more-link').fadeOut();
    });    
});