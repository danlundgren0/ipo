DanL.Search = {

}
DanL.Result = {
    getSearchOptionsByEstate: function(el) {
        console.log('getSearchOptionsByEstate');
        console.log($(el));
    },
}
$(function() {
    $('[name="tx_dliponlyestate_reportsearch[estates]"]').on('change', function() {
        DanL.Result.getSearchOptionsByEstate($(this));
        DanL.ajax.fetch({
            command: 'getEstateSearchSettings',
            arguments: {
                estateUid: $(this).val()
            }
        }).done(function(data, textStatus, jqXHR) {            
            $('.saved-messages').html('');
            $('.saved-purchases').purchases('');
            $('.input-purchase').val('');
            $('.input-message').val('');
            $.each(data.data.message, function(index, value) {                
                $('.saved-messages').append(value);
            });
            $.each(data.data.purchase, function(index, value) {
                $('.saved-purchases').append(value);
            });
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            console.log('getNewNoteTmpl failed: ' + textStatus);
        }); 
    });
    var $table = $('.table-like').isotope({
        layoutMode: 'vertical',
        getSortData: {
            type: '.type',
            name: '.name',
            report: '.report',
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
        }
    });
    //$container.isotope('reLayout');
    // bind sort button click
    $('.header').on( 'click', 'div', function() {
        var sortClass = $(this).hasClass('sort-asc');
        var sortValue = $(this).attr('data-sort-value');
        $(this).toggleClass('sort-asc');
        $table.isotope({ sortBy: sortValue, sortAscending: !sortClass });
    });

    $(".js_search-header").sticky({topSpacing:-20,zIndex:20000});

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
});