var DanL = DanL || {};
DanL.ajax = {
	fetch: function(params){
		return $.ajax({
			type: 'GET',
			url: '/?type=777888',
			data: { command: params.command, arguments: params.arguments, L: params.syslanguage },
			dataType: 'json',
		});
	}
}
//TODO: Check input text, buttonstate(Pushed or not)
DanL.Note = {
	isReadyForSave: false,
    isButtonSet: false,
    isInputSet: false,
    parent: {},
	setReadyForSave: function(obj) {
        DanL.Note.parent = $(obj).closest('.noteContainer');
        //if($('btn-success').attr('aria-pressed')=='true' || (DanL.Note.isInputSet==true && DanL.Note.isButtonSet==true)) {
        
        /*if(($(obj).closest('.noteContainer').find('.btn-success.active').length>0 && !$(obj).closest('.noteContainer').find('.btn-success.active').hasClass('btn-measure'))
            || ($(obj).closest('.noteContainer').find('.input-note').val()!='' && $(obj).closest('.noteContainer').find('.state-buttons').find('.active').length>0)) {
            this.isReadyForSave = true;
            $(obj).closest('.noteContainer').find($('.save-btn')).removeClass('hidden');
            $('me').closest('.noteContainer').find('.enable-buttons').removeClass('hidden');
        }*/
        if($(obj).closest('.noteContainer').find('.input-note').val()!='' && $(obj).closest('.noteContainer').find('.state-buttons').find('.active[data-mandatory="1"]').length>0) {
            this.isReadyForSave = true;
            $(obj).closest('.noteContainer').find($('.save-btn')).removeClass('hidden');
            //$('me').closest('.noteContainer').find('.enable-buttons').removeClass('hidden');
            //$('me').closest('.noteContainer').find('.enable-buttons').removeClass('hidden');
            $(obj).closest('.tab-container').find('[role="presentation"]').removeClass('disabled');
            $(obj).closest('.tab-container').find('[role="tab"]').removeClass('disabled');
            DanL.Note.setTabClickStatus(obj, true);
            //data-trigger-cpuid="4"
        }
        else if(($(obj).closest('.noteContainer').find('.input-note').val()!='' ^ $(obj).closest('.noteContainer').find('.state-buttons').find('.active[data-mandatory="1"]').length>0)
        	|| $(obj).closest('.noteContainer').find('.save-note-btn').attr('type')=='submit') {
        	$(obj).closest('.noteContainer').find($('.save-btn')).addClass('hidden');
            DanL.Note.setTabClickStatus(obj, true);
        }
		if($(obj).closest('.noteContainer').find('.input-note').val()=='' && 
			$(obj).closest('.noteContainer').find('.state-buttons').find('.active[data-mandatory="1"]').length==0 &&
			$(obj).closest('.noteContainer').find('.save-note-btn').attr('type')!='submit') {
			$(obj).closest('.noteContainer').find($('.save-btn')).addClass('hidden');
			DanL.Note.setTabClickStatus(obj);
		}
        /*else if(!$(obj).hasClass('upload-btn')) {
            this.isReadyForSave = false;
            $(obj).closest('.noteContainer').find($('.save-btn')).addClass('hidden');
            $('me').closest('.noteContainer').find('.enable-buttons').addClass('hidden');

        }*/
    },
    postForm: function() {
        //TODO: Notes are saved as uncomplete until the form is posted
    },
    getRelatedNotes: function() {        
        var cpUid = $(this).data('trigger-cpuid');
        var qUid = $(this).data('trigger-quid');
        if($(this).attr('aria-expanded')=='true') {
            return;            
        }
        else if($(this).attr('data-isloaded')=='true') {
        }
        else {
            $(this).attr('data-isloaded','true');            
        }
    },
    createNewReport: function(event) {
        var version = $(this).attr('data-version');
        var estateUid = $(this).attr('data-estateUid');
        DanL.ajax.fetch({
            command: 'createNewReport',
            arguments: {
               version: version,
               estateUid: estateUid
            }
        }).done(function(data, textStatus, jqXHR) {
            $('.btn-new-report').fadeOut();
            $('.report-status').append('<div class="alert alert-info"><strong>Rapport påbörjad</strong></div>');
            //$('.note-fixed').prop("disabled", false);
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            console.log('createNewReport failed: ' + textStatus);
        });
    },
    saveReport: function(event) {
        event.preventDefault();
        var reportUid = $(this).attr('data-reportuid'); 
		DanL.ajax.fetch({
			command: 'saveReport',
			arguments: {
                reportUid: reportUid
			}
		}).done(function(data, textStatus, jqXHR) {
            $('.btn-save-report').addClass('hidden');
            $('.outer-posted-notes-container').empty();
            $('.outer-posted-notes-container').html('<div class="alert alert-success input-disabled-note" role="alert">Rapport inskickad</div>');
            $('[data-target="#myModal"]').addClass('hidden');
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log('getNewNoteTmpl failed: ' + textStatus);
		});
        if($(this).hasClass('disabled')) {
            return;
        }
    },
    saveMeasureValue: function() {
        $('#modal').css('display','block');
        if($(this).hasClass('disabled')) {
            return;
        }
        var me = $(this);        
        var noteObj = $(this).closest('.noteContainer');
        var pid = $(noteObj).attr('data-pid');
        var estateUid = $(noteObj).attr('data-estateuid'); 
        var questUid = $(noteObj).attr('data-questionuid');
        var measureUid = $(noteObj).attr('data-measureuid');
        var ver = $(noteObj).attr('data-notever');
        var reportUid = $(noteObj).attr('data-reportuid');
        var cpUid = $(noteObj).attr('data-cpuid');
        var nodeTypeUid = $(noteObj).attr('data-nodetypeuid');
        var measureValue = $(this).closest('.noteContainer').find('.input-note').val();
        var measureName = $(this).closest('.noteContainer').find('.input-note').attr('data-measurement-name');
        var measureUnit = $(this).closest('.noteContainer').find('.input-note').attr('data-measurement-unit');
        var reportPid  = $('#reportPid').val();

        
		DanL.ajax.fetch({
			command: 'saveMeasureValue',
			arguments: {
                pid: pid,
                estateUid: estateUid,
				cpUid: cpUid,
                questUid: questUid,
                measureUid: measureUid,
                ver: ver,
                measureValue: measureValue,
                reportUid: reportUid,
                nodeTypeUid: nodeTypeUid,
                reportPid: reportPid,
                measureValue: measureValue,
                measureName: measureName,
                measureUnit: measureUnit

			}
		}).done(function(data, textStatus, jqXHR) {
            $(me).closest('.noteContainer').attr('data-measureuid',data.data['noteUid']);
            $(me).closest('.noteContainer').attr('data-notever',data.data['curVer']);
            $(me).addClass('disabled');
            $('[aria-controls="uid_'+questUid+'"]').prop('class','');
            $('[aria-controls="uid_'+questUid+'"]').addClass('color_1');
            $('.link-to-list-button').removeClass('hidden');
            $('#modal').css('display','none');
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log('getNewNoteTmpl failed: ' + textStatus);
		});
        if($(this).hasClass('disabled')) {
            return;
        }
        DanL.Note.setTabClickStatus(me);
        $(me).closest('.noteContainer').find('.btn-ipaction').addClass('disabled');
        $(me).closest('.noteContainer').find('.active').removeClass('active').addClass('disabled').addClass('pre-active');
        $(me).addClass('disabled');
        $(me).closest('.noteContainer').find('.input-note').attr('disabled','disabled');
        $(me).closest('.noteContainer').find('.add-btn').removeClass('hidden');
        $(me).closest('.noteContainer').find('.enable-buttons').removeClass('hidden');
        $(me).closest('.noteContainer').find('.enable-buttons').removeClass('disabled');
    },
    saveNote: function() {
        $('#modal').css('display','block');
        if($(this).hasClass('disabled') || $(this).attr('type') == 'submit') {
            return;
        }
        if($(this).attr('data-post')=='1') {
            $(this).closest('.noteContainer').find('[name="tx_dliponlyestate_cp[notestate]"]').val(1);
            $(this).closest('form').submit();
            return;
        }
        var me = $(this);        
        var noteObj = $(this).closest('.noteContainer');
        var pid = $(noteObj).attr('data-pid');
        var estateUid = $(noteObj).attr('data-estateuid'); 
        var questUid = $(noteObj).attr('data-questionuid');
        var noteUid = $(noteObj).attr('data-noteuid');
        var ver = $(noteObj).attr('data-notever');
        var reportUid = $(noteObj).attr('data-reportuid');
        var cpUid = $(noteObj).attr('data-cpuid');
        var nodeTypeUid = $(noteObj).attr('data-nodetypeuid');
        var noteText = $(this).closest('.noteContainer').find('.input-note').val();
        var noteState = $(this).closest('.noteContainer').find('.btn-ipaction.active').data('type');
        var reportPid  = $('#reportPid').val();
		DanL.ajax.fetch({
			command: 'saveNote',
			arguments: {
                pid: pid,
                estateUid: estateUid,
				cpUid: cpUid,
                questUid: questUid,
                noteUid: noteUid,
                ver: ver,
                noteText: noteText,
                noteState: noteState,
                reportUid: reportUid,
                nodeTypeUid: nodeTypeUid,
                reportPid: reportPid
			}
		}).done(function(data, textStatus, jqXHR) {
            $(me).closest('.noteContainer').attr('data-noteuid',data.data['noteUid']);
            $(me).closest('.noteContainer').attr('data-notever',data.data['curVer']);
            $(me).closest('.noteContainer').find('[name="tx_dliponlyestate_cp[noteuid]"]').val(data.data['noteUid']);
            $(me).closest('.noteContainer').find('[name="tx_dliponlyestate_cp[notever]"]').val(data.data['curVer']);
            $(me).closest('.noteContainer').find('[name="tx_dliponlyestate_cp[notestate]"]').val(data.data['noteState']);
            if($(me).closest('.panel-collapse').prev('.panel-heading').length>0) {
                $(me).closest('.panel-collapse').prev('div').prop('class','');
                $(me).closest('.panel-collapse').prev('div').addClass('panel-heading');
                $(me).closest('.panel-collapse').prev('.panel-heading').addClass('color_'+noteState);
                $(me).closest('.panel-collapse').prev('.panel-heading').find('a').prop('class','');
                $(me).closest('.panel-collapse').prev('.panel-heading').find('a').addClass('accordion-toggle');
                $(me).closest('.panel-collapse').prev('.panel-heading').find('a').addClass('color_'+noteState);
            }
            else {
                $('[aria-controls="uid_'+questUid+'"]').prop('class','');
                $('[aria-controls="uid_'+questUid+'"]').addClass('color_'+noteState);
            }

            $(me).addClass('disabled');
            $('.link-to-list-button').removeClass('hidden');
            $('#modal').css('display','none');
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log('getNewNoteTmpl failed: ' + textStatus);
		});
        if($(this).hasClass('disabled')) {
            return;
        }
        DanL.Note.setTabClickStatus(me);
        $(me).closest('.noteContainer').find('.btn-ipaction').not('.add-photo-btn').addClass('disabled');
        $(me).closest('.noteContainer').find('.active').removeClass('active').addClass('disabled').addClass('pre-active');
        $(me).addClass('disabled');
        $(me).closest('.noteContainer').find('.input-note').attr('disabled','disabled');
        $(me).closest('.noteContainer').find('.add-btn').removeClass('hidden');
        $(me).closest('.noteContainer').find('.enable-buttons').removeClass('hidden');
        $(me).closest('.noteContainer').find('.enable-buttons').removeClass('disabled');
    },
    enableButtons: function() {
        $(this).closest('.noteContainer').find('.btn-ipaction').removeClass('disabled');
        $(this).closest('.noteContainer').find('.input-note').removeAttr('disabled');
        $(this).closest('.noteContainer').find('.pre-active').removeClass('pre-active').addClass('active');
        $('.input-note').on('keyup', DanL.Note.setNoteState);
        $(this).closest('.noteContainer').find('.save-btn').removeClass('hidden');
        $(this).closest('.noteContainer').find('.save-btn .btn').removeClass('disabled');
        $(this).closest('.noteContainer').find('.upload-btn').removeClass('disabled');
        $(this).addClass('hidden');
    },
    saveNoteFixed: function() {
        var isFixed = false;
        var noteUids = [];
        $('.note-fixed').each(function(index) {
            if($(this).is(':checked')) {
                isFixed = true;
                $(this).closest('.posted-note-container').remove();
                noteUids.push($(this).attr('data-noteuid'));
            }
        });
        if(isFixed == false) {
            $('.save-fixed-btn button').addClass('hidden');
            return;
        }
        str = JSON.stringify(noteUids);
		DanL.ajax.fetch({
			command: 'saveNoteFixed',
			arguments: {
                noteUids: JSON.stringify(noteUids)
			}
		}).done(function(data, textStatus, jqXHR) {
            $('.save-fixed-btn button').addClass('hidden');
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log('getNewNoteTmpl failed: ' + textStatus);
		});
    },
    setNoteFixed: function() {
        var isFixed = false;
        $('.note-fixed').each(function(index) {
            if($(this).is(':checked')) {
                isFixed = true;                
            }
        });
        if(isFixed == true) {
            $('.save-fixed-btn button').removeClass('hidden');
        }
        else {
            $('.save-fixed-btn button').addClass('hidden');
        }
    },
    setNoteState: function() {
        if($(this).val()!='') {
            DanL.Note.isInputSet = true;
        }
        else {
            DanL.Note.isInputSet = false;
        }
        DanL.Note.setReadyForSave(this);
    },
    setButtonState: function(event) {
        event.stopPropagation();        
        if($(this).hasClass('disabled')) {
            event.preventDefault();
            return;
        }
        if($(this).hasClass('active')) {
            $(this).removeClass('active');
            if($(this).hasClass('upload-btn')) {
                event.preventDefault();
            }
            else {
                var questUid = $(this).closest('.noteContainer').find('[name="tx_dliponlyestate_cp[questionuid]"]').val();
                $('.tab-container').find('[aria-controls="uid_'+questUid+'"]').prop('class','');
                $(this).closest('.noteContainer').find('.input-note').slideUp();
            }            
            DanL.Note.isButtonSet = false;            
        }
        else {
        	if($(this).hasClass('upload-btn')) {

        	}
        	else {
	            $(this).closest('.state-buttons').find('.btn-ipaction').removeClass('active');
	            $(this).addClass('active');        		
        	}
            var questUid = $(this).closest('.noteContainer').find('[name="tx_dliponlyestate_cp[questionuid]"]').val();
            //var noteState = $(this).attr('data-type');
            var noteState=undefined;
            if($(this).closest('.noteContainer').find('.state-buttons').find('.active[data-mandatory="1"]').length>0) {
                var noteState = $(this).closest('.noteContainer').find('.state-buttons').find('.active[data-mandatory="1"]').attr('data-type');    
            }
            //$(obj).closest('.noteContainer').find('.state-buttons').find('.active[data-mandatory="1"]').length==0
            if(noteState!==undefined) {
                $('.tab-container').find('[aria-controls="uid_'+questUid+'"]').prop('class','');
                $('.tab-container').find('[aria-controls="uid_'+questUid+'"]').addClass('color_'+noteState);
                $(this).closest('.noteContainer').find('[name="tx_dliponlyestate_cp[notestate]"]').val(noteState);
            }
            else {
                var curColorClass = $('[aria-controls="uid_'+questUid+'"]').attr('class');                
                if(curColorClass=='') {
                    $('.tab-container').find('[aria-controls="uid_'+questUid+'"]').addClass('color_1');                    
                }
                else {
                    $('.tab-container').find('[aria-controls="uid_'+questUid+'"]').prop('class','');
                    $('.tab-container').find('[aria-controls="uid_'+questUid+'"]').addClass(curColorClass);                    
                }
            }
            if($(this).hasClass('btn-text-slide')) {
                $(this).closest('.noteContainer').find('.input-note').slideDown();
                if($(this).hasClass('btn-measure')) {
                    $(this).closest('.noteContainer').find('.input-note').removeAttr('disabled');
                }
            }
            if($(this).hasClass('upload-btn')) {                
                $(this).closest('.noteContainer').find('.save-note-btn').attr('type','submit');
                $(this).closest('.noteContainer').find('.save-note-ok').attr('data-post','1');
                
                //$(this).closest('.noteContainer').find('.save-btn').removeClass('hidden');
                $(this).closest('.noteContainer').find('.input-note').removeAttr('disabled');
                //$(this).closest('.noteContainer').find('.save-note-btn').removeClass('disabled');
            }
            else {
                //$(this).closest('.noteContainer').find('.save-note-btn').attr('type','button');
            }
            DanL.Note.isButtonSet = true;
        }
        if(!$(this).hasClass('save-note-ok')) {
            DanL.Note.setReadyForSave(this);
        }
        else if(!$(this).hasClass('upload-btn')) {
            $(this).closest('.noteContainer').find('.input-note').slideUp();
            $('.save-btn').addClass('hidden');
        }
    },
    saveMessages: function() {
        var reportUid = $(this).attr('data-reportUid');
        var purchase = $(this).closest('.container-messages').find('.input-purchase').val();
        var message = $(this).closest('.container-messages').find('.input-message').val();
		DanL.ajax.fetch({
			command: 'saveMessages',
			arguments: {
				purchase: purchase,
                message: message,
                reportUid: reportUid
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
    },
    setMsgButtonState: function() {
        if($(this).closest('.container-messages').find('.input-purchase').val()=='' && $(this).closest('.container-messages').find('.input-message').val()=='') {
            $(this).closest('.container-messages').find('.btn-message').addClass('hidden');
        }
        else {
            $(this).closest('.container-messages').find('.btn-message').removeClass('hidden');
        }        
    },
    setTabClickStatus: function(obj, disable) {
    	/*
		$('[role="presentation"] a').click(function (event) {
		   	if(disable==true) {
		        $(obj).closest('.tab-container').find('[role="presentation"]').addClass('disabled');
		        $(obj).closest('.tab-container').find('[role="tab"]').addClass('disabled');
				event.preventDefault();
				event.stopPropagation();
		   	}
		   	else {
		        $(obj).closest('.tab-container').find('[role="presentation"]').removeClass('disabled');
		        $(obj).closest('.tab-container').find('[role="tab"]').removeClass('disabled');
		   	}
		});
		*/
		
    	if(disable==true) {
	        $(obj).closest('.tab-container').find('[role="presentation"]').addClass('disabled');
	        $(obj).closest('.tab-container').find('[role="tab"]').addClass('disabled');
	        $('[role="presentation"] a').on('click', function(event){
	            event.preventDefault();
	            event.stopPropagation();
	            //event.stopImmediatePropagation();
	        });    		
    	}
    	else {
	        $(obj).closest('.tab-container').find('[role="presentation"]').removeClass('disabled');
	        $(obj).closest('.tab-container').find('[role="tab"]').removeClass('disabled');
	        $('[role="presentation"] a').on('click', function(event){
	        	$(this).tab('show');
	        });
    	}
    },
    scrollToTabs: function() {
    	if($('#imgupload').length>0 && $('#imgupload').val()=='1') {
            var execScrollMobile = $('body').find('[name="execScrollMobile"]').val();
            if(execScrollMobile!='-1') {
                var $container = $("html,body");
                var $scrollTo = $('#'+execScrollMobile);
                console.log(execScrollMobile);                
                console.log($scrollTo.scrollTop());
                console.log($scrollTo);
                console.log($scrollTo.offset().top);
                console.log($container.offset().top);
                $container.animate({scrollTop: $scrollTo.offset().top},1);
            }
            else {
                var $container = $("html,body");
                var $scrollTo = $('.tab-container');
                $container.animate({scrollTop: $scrollTo.offset().top - $container.offset().top, scrollLeft: 0},500);
            }

    	}
		//$('html, body').animate({scrollTop: $('#contact').offset().top -100 }, 'slow');
    }
}
$(function() {
	console.log($(window).width());
	if ($(window).width() <= 458) {
		$('._js_cp-image').find('img').each(function(){
			$(this).appendTo($(this).closest('.row').find('._js_cp-container').find('._js_cp-description'));
		});
	}
    fakewaffle.responsiveTabs(['xs']);  
    //$('[role="presentation"]').find('a.disabled').on('click', function(event){
	$('.upload-btn').change(function (){
		//var fileName = $(this).val();		
		//var filename = $(this).val().split('\\').pop();
        var scrollToId = $(this).closest('.panel-body').prop('id');
        console.log('scrollToId: '+scrollToId);
        console.log('scrollToId: '+scrollToId);
        $(this).closest('.panel-body').find('[name="tx_dliponlyestate_cp[scrollToId]"]').val(scrollToId);
		var fileName = $(this).val().replace(/.*(\/|\\)/, '');
        console.log('fileName');
        console.log(fileName);
		//var fileName = $('input[type=file]')[0].files.length ? ('input[type=file]')[0].files[0].name : "";
		if(fileName=='') {
			console.log('Ingen Bild vald');
			$('.uploadStatus').addClass('hidden');
		}
		else {
            $(this).closest('.noteContainer').find('.uploadStatus').removeClass('hidden');
			//$('.uploadStatus').removeClass('hidden');
			//$('.uploadStatus .imgName').text(fileName);
			console.log('Bild '+fileName+' vald');			
		}
		//$(".filename").html(fileName);
	});
    $('.btn-new-report').on('click', DanL.Note.createNewReport);
    $('.input-note').on('keyup', DanL.Note.setNoteState);
    $('.input-message,.input-purchase').on('keyup', DanL.Note.setMsgButtonState);
    $('.state-buttons .btn').on('click', DanL.Note.setButtonState);
    $('.save-note').on('click', DanL.Note.saveNote);
    $('.save-note-ok').on('click', DanL.Note.saveNote);
    $('[data-toggle="tab"]').on('click', DanL.Note.getRelatedNotes);
    $('[data-remember="message"]').on('click', DanL.Note.saveMessages);
    //$('.btn-ip-post-report button').on('click', DanL.Note.saveReport);
    $('.btn-save-report').on('click', DanL.Note.saveReport);
    $('.note-fixed').on('change', DanL.Note.setNoteFixed);
    $('.save-fixed-btn button').on('click', DanL.Note.saveNoteFixed);
    $('.save-measure-value').on('click', DanL.Note.saveMeasureValue);  
    $('.enable-buttons').on('click', DanL.Note.enableButtons);
    $('.js_search-date').datepicker({
      dateFormat: "yy-mm-dd"
    });
    DanL.Note.scrollToTabs();
    // external js: isotope.pkgd.js

    // init Isotope
    /*var $table = $('.table-like').isotope({
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
            category: '.category',
            weight: function( itemElem ) {
              var weight = $( itemElem ).find('.weight').text();
              return parseFloat( weight.replace( /[\(\)]/g, '') );
            }
        }
    });*/
    //$container.isotope('reLayout');
    // bind sort button click
/*
    $('.header').on( 'click', 'div', function() {
        var sortClass = $(this).hasClass('sort-asc');
        var sortValue = $(this).attr('data-sort-value');
        $(this).toggleClass('');
        $table.isotope({ sortBy: sortValue, sortAscending: !sortClass });        
        $(".collapse").collapse();
        $table.isotope('layout');
    });
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
    $('.panel-group').find('.collapse').addClass('in');
    $('.accordion-toggle').off();

*/    
    //DropDown Nav
    //$('.nav .dropdown.active.open .dropdown-menu>li>a').on('click', function(event) {
    /*
    $('.nav .sub1>li>a').on('click', function(event) {
        event.preventDefault();
        $('.nav .sub1 .sub2').addClass('open');
    });
    */
});

/*
//Example object-oriented JS
function Note (theName, theEmail) {
    this.name = theName;
    this.email = theEmail;
    this.quizScores = [];
    this.currentScore = 0;
}
User.prototype = {
    constructor: User,
    saveScore:function (theScoreToAdd)  {
        this.quizScores.push(theScoreToAdd)
    },
    showNameAndScores:function ()  {
        var scores = this.quizScores.length > 0 ? this.quizScores.join(",") : "No Scores Yet";
        return this.name + " Scores: " + scores;
    },
    changeEmail:function (newEmail)  {
        this.email = newEmail;
        return "New Email Saved: " + this.email;
    }
}
*/