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
            $('me').closest('.noteContainer').find('.enable-buttons').removeClass('hidden');
        }
        else if(!$(obj).hasClass('upload-btn')) {
            this.isReadyForSave = false;
            $(obj).closest('.noteContainer').find($('.save-btn')).addClass('hidden');
            $('me').closest('.noteContainer').find('.enable-buttons').addClass('hidden');
        }
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
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log('getNewNoteTmpl failed: ' + textStatus);
		});
        if($(this).hasClass('disabled')) {
            return;
        }
        $(me).closest('.noteContainer').find('.btn-ipaction').addClass('disabled');
        $(me).closest('.noteContainer').find('.active').removeClass('active').addClass('disabled').addClass('pre-active');
        $(me).addClass('disabled');
        $(me).closest('.noteContainer').find('.input-note').attr('disabled','disabled');
        $(me).closest('.noteContainer').find('.add-btn').removeClass('hidden');
        $(me).closest('.noteContainer').find('.enable-buttons').removeClass('hidden');
        $(me).closest('.noteContainer').find('.enable-buttons').removeClass('disabled');
    },
    saveNote: function() {
        if($(this).hasClass('disabled') || $(this).attr('type') == 'submit') {
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
console.log(noteState);
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
            $('[aria-controls="uid_'+questUid+'"]').prop('class','');
            $('[aria-controls="uid_'+questUid+'"]').addClass('color_'+noteState);
            $(me).addClass('disabled');
            $('.link-to-list-button').removeClass('hidden');
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			console.log('getNewNoteTmpl failed: ' + textStatus);
		});
        if($(this).hasClass('disabled')) {
            return;
        }
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
            $(this).closest('.state-buttons').find('.btn-ipaction').removeClass('active');
            $(this).addClass('active');
            var questUid = $(this).closest('.noteContainer').find('[name="tx_dliponlyestate_cp[questionuid]"]').val();
            var noteState = $(this).attr('data-type');
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
                $(this).closest('.noteContainer').find('.save-btn').removeClass('hidden');
                $(this).closest('.noteContainer').find('.input-note').removeAttr('disabled');
                $(this).closest('.noteContainer').find('.save-note-btn').removeClass('disabled');
            }
            else {
                $(this).closest('.noteContainer').find('.save-note-btn').attr('type','button');
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
}
$(function() {    
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