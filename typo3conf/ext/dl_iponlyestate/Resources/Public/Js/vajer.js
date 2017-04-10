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
        
        if(($(obj).closest('.noteContainer').find('.btn-success.active').length>0 && !$(obj).closest('.noteContainer').find('.btn-success.active').hasClass('btn-measure'))
            || ($(obj).closest('.noteContainer').find('.input-note').val()!='' && $(obj).closest('.noteContainer').find('.state-buttons').find('.active').length>0)) {
            this.isReadyForSave = true;
            $(obj).closest('.noteContainer').find($('.save-btn')).removeClass('hidden');
        }
        else {
            this.isReadyForSave = false;
            $(obj).closest('.noteContainer').find($('.save-btn')).addClass('hidden');
        }
	},
	addNewNote: function() {
        if($(this).hasClass('disabled')) {
            return;
        }
        var me = $(this);
        ver = $(this).closest('.noteContainer').find('[name="note"]').val();

        if(!parseInt(ver)>0) {
            return;
        }
		DanL.ajax.fetch({
			command: 'getNewNoteTmpl',
			arguments: {
				latestVersion: ver
			}
		}).done(function(data, textStatus, jqXHR) {
            $(me).closest('.col-md-8').append(data.data.response);
            $('me').closest('.noteContainer').find('.input-note').on('change', DanL.Note.setNoteState);
            $('me').closest('.noteContainer').find('.state-buttons .btn').on('click', DanL.Note.setButtonState);
            $('me').closest('.noteContainer').find('.save-note').on('click', DanL.Note.saveNote);
            $('me').closest('.noteContainer').find('.add-btn .btn').on('click', DanL.Note.addNewNote);
            $(me).addClass('disabled');
            console.log(data);
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log('getNewNoteTmpl failed: ' + textStatus);
		});
	},
    postForm: function() {
        //TODO: Notes are saved as uncomplete until the form is posted
    },
    getRelatedNotes: function() {        
        console.log($(this).data('trigger-cpuid'));
        console.log($(this).data('trigger-quid'));
        var cpUid = $(this).data('trigger-cpuid');
        var qUid = $(this).data('trigger-quid');
        if($(this).attr('aria-expanded')=='true') {
            return;            
            console.log('Already visible');
        }
        else if($(this).attr('data-isloaded')=='true') {
            console.log('Data already loaded');
        }
        else {
            $(this).attr('data-isloaded','true');            
            console.log('Not visible');
        }
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
            //var me = $(this);
            //$(me).closest('.col-md-8').append(data.data.response);
            //$('me').closest('.noteContainer').find('.input-note').on('change', DanL.Note.setNoteState);
            //$('me').closest('.noteContainer').find('.state-buttons .btn').on('click', DanL.Note.setButtonState);
            //$('me').closest('.noteContainer').find('.save-note').on('click', DanL.Note.saveNote);
            //$('me').closest('.noteContainer').find('.add-btn .btn').on('click', DanL.Note.addNewNote);
            //$(me).addClass('disabled');
            console.log(data);
            $('.btn-save-report').addClass('hidden');
            $('.outer-posted-notes-container').empty();
            $('.outer-posted-notes-container').html('<div class="alert alert-success input-disabled-note" role="alert">Rapport inskickad</div>');
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log('getNewNoteTmpl failed: ' + textStatus);
		});
        if($(this).hasClass('disabled')) {
            return;
        }
        //$(this).closest('.noteContainer').find('.btn-ipaction').removeClass('active').addClass('disabled');
        //$(this).addClass('disabled');
        //$(this).closest('.noteContainer').find('.input-note').attr('disabled','disabled');
        //$(this).closest('.noteContainer').find('.add-btn').removeClass('hidden');
    },
    saveMeasureValue: function() {
        if($(this).hasClass('disabled')) {
            return;
        }
        var me = $(this);        
        var noteObj = $(this).closest('.noteContainer');
        var estateUid = $(noteObj).attr('data-estateuid'); 
        var questUid = $(noteObj).attr('data-questionuid');
        var measureUid = $(noteObj).attr('data-noteuid');
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
            var me = $(this);
            //$(me).closest('.col-md-8').append(data.data.response);
            $('me').closest('.noteContainer').find('.input-note').on('change', DanL.Note.setNoteState);
            $('me').closest('.noteContainer').find('.state-buttons .btn').on('click', DanL.Note.setButtonState);
            $('me').closest('.noteContainer').find('.save-note').on('click', DanL.Note.saveNote);
            $('me').closest('.noteContainer').find('.add-btn .btn').on('click', DanL.Note.addNewNote);
            $(me).addClass('disabled');
            $('[aria-controls="uid_'+questUid+'"]').addClass('color_1');
            $('.link-to-list-button').removeClass('hidden');
            console.log(data);
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log('getNewNoteTmpl failed: ' + textStatus);
		});
        if($(this).hasClass('disabled')) {
            return;
        }
        $(this).closest('.noteContainer').find('.btn-ipaction').removeClass('active').addClass('disabled');
        $(this).addClass('disabled');
        $(this).closest('.noteContainer').find('.input-note').attr('disabled','disabled');
        $(this).closest('.noteContainer').find('.add-btn').removeClass('hidden');
    },
    saveNote: function() {
        var me = $(this);        
        var noteObj = $(this).closest('.noteContainer');
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
            var me = $(this);
            //$(me).closest('.col-md-8').append(data.data.response);
            $('me').closest('.noteContainer').find('.input-note').on('change', DanL.Note.setNoteState);
            $('me').closest('.noteContainer').find('.state-buttons .btn').on('click', DanL.Note.setButtonState);
            $('me').closest('.noteContainer').find('.save-note').on('click', DanL.Note.saveNote);
            $('me').closest('.noteContainer').find('.add-btn .btn').on('click', DanL.Note.addNewNote);
            $('[aria-controls="uid_'+questUid+'"]').addClass('color_'+noteState);
            $(me).addClass('disabled');
            $('.link-to-list-button').removeClass('hidden');
            console.log(data);
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log('getNewNoteTmpl failed: ' + textStatus);
		});
        if($(this).hasClass('disabled')) {
            return;
        }
        $(this).closest('.noteContainer').find('.btn-ipaction').removeClass('active').addClass('disabled');
        $(this).addClass('disabled');
        $(this).closest('.noteContainer').find('.input-note').attr('disabled','disabled');
        $(this).closest('.noteContainer').find('.add-btn').removeClass('hidden');
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
            console.log(data);
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
    setButtonState: function() {
        if($(this).hasClass('disabled')) {
            return;
        }
        if($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).closest('.noteContainer').find('.input-note').slideUp();
            DanL.Note.isButtonSet = false;            
        }
        else {
            $(this).closest('.state-buttons').find('.btn-ipaction').removeClass('active');
            $(this).addClass('active');
            if($(this).hasClass('btn-text-slide')) {
                $(this).closest('.noteContainer').find('.input-note').slideDown();
            }            
            DanL.Note.isButtonSet = true;
        }
        DanL.Note.setReadyForSave(this);
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
}
$(function() {    
    $('.input-note').on('change', DanL.Note.setNoteState);
    $('.input-message,.input-purchase').on('keyup', DanL.Note.setMsgButtonState);
    $('.state-buttons .btn').on('click', DanL.Note.setButtonState);
    $('.save-note').on('click', DanL.Note.saveNote);
    $('.add-btn .btn').on('click', DanL.Note.addNewNote);
    $('[data-toggle="tab"]').on('click', DanL.Note.getRelatedNotes);
    $('[data-remember="message"]').on('click', DanL.Note.saveMessages);
    //$('.btn-ip-post-report button').on('click', DanL.Note.saveReport);
    $('.btn-save-report').on('click', DanL.Note.saveReport);
    $('.note-fixed').on('change', DanL.Note.setNoteFixed);
    $('.save-fixed-btn button').on('click', DanL.Note.saveNoteFixed);
    $('.save-measure-value').on('click', DanL.Note.saveMeasureValue);    
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