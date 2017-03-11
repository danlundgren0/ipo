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
        
        if($(obj).closest('.noteContainer').find('.btn-success.active').length>0
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
            $('me').closest('.noteContainer').find('.save-btn .btn').on('click', DanL.Note.saveNote);
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
    saveNote: function() {
        //TODO: Come up with good versioning handling
        var me = $(this);
        var noteObj = $(this).closest('.noteContainer');
        var questUid = $(noteObj).attr('data-questionuid');
        var noteUid = $(noteObj).attr('data-noteuid');
        var ver = $(noteObj).attr('data-notever');
        var reportUid = $(noteObj).attr('data-reportuid');
        var cpUid = $(noteObj).attr('data-cpuid');
        var nodeTypeUid = $(noteObj).attr('data-nodetypeuid');
        var noteText = $(this).closest('.noteContainer').find('.input-note').val();
        var noteState = $(this).closest('.noteContainer').find('.btn-ipaction.active').data('type');
        
        
		DanL.ajax.fetch({
			command: 'saveNote',
			arguments: {
				cpUid: cpUid,
                questUid: questUid,
                noteUid: noteUid,
                ver: ver,
                noteText: noteText,
                noteState: noteState,
                reportUid: reportUid,
                nodeTypeUid: nodeTypeUid
			}
		}).done(function(data, textStatus, jqXHR) {
            var me = $(this);
            //$(me).closest('.col-md-8').append(data.data.response);
            $('me').closest('.noteContainer').find('.input-note').on('change', DanL.Note.setNoteState);
            $('me').closest('.noteContainer').find('.state-buttons .btn').on('click', DanL.Note.setButtonState);
            $('me').closest('.noteContainer').find('.save-btn .btn').on('click', DanL.Note.saveNote);
            $('me').closest('.noteContainer').find('.add-btn .btn').on('click', DanL.Note.addNewNote);
            $(me).addClass('disabled');
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
            DanL.Note.isButtonSet = false;            
        }
        else {
            $(this).closest('.state-buttons').find('.btn-ipaction').removeClass('active');
            $(this).addClass('active');            
            DanL.Note.isButtonSet = true;
        }
        DanL.Note.setReadyForSave(this);
    },
}
$(function() {    
    $('.input-note').on('change', DanL.Note.setNoteState);
    $('.state-buttons .btn').on('click', DanL.Note.setButtonState);
    $('.save-btn .btn').on('click', DanL.Note.saveNote);
    $('.add-btn .btn').on('click', DanL.Note.addNewNote);
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