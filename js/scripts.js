$(document).ready(function(){
	$("input").attr("maxlength", 48);
	$("#notify").click(function(){
		$("#notify_email").slideToggle(300, "easeInOutSine");
	});
});
function pop(e,f) {
	$(e).val(f);
	$('ul[data-input="'+e+'"] li').removeClass().addClass('ui-screen-hidden');
}
function updateMins(e) {
	$('#len').html(secs2Mins(e.value));
}
function secs2Mins(e) {
	var m = Math.floor(e / 60);
	var s = e - (m * 60);
	if ( s < 10 ) {
		s = '0' + s;
	}
	var l = m + ':' + s;
	return l;
}
function renderReview() {
	if ($("#title").val().length > 0) {
		$("#review_title").html($("#title").val()).addClass('review-heading');
	}
	if ($("#author").val().length > 0) {
		$("#review_author").html('By '+$("#author").val()).addClass('review-heading');
	}
	else {
		$("#review_author").html('By anonymous').addClass('review-heading');
	}
	if ($("#tonality").val().length > 0) {
		$("#review_tonality").html($("#tonality").val()).addClass('review-items');
	}
	if ($("#tempo").val().length > 0) {
		$("#review_tempo").html($("#tempo").val()).addClass('review-items');
	}
	$("#review_length").html( secs2Mins($("#length").val())).addClass('review-items');
	if ($("#mood").val().length > 0) {
		$("#review_mood").html($("#mood").val()).addClass('review-items');
	}
	if ($("#dynamics").val().length > 0) {
		$("#review_dynamics").html($("#dynamics").val()).addClass('review-items');
	}
	var inst = ($("#instruments").val() || []);
	var n = inst.length;
	var output = '';
	for ( i = 0; i < n; ++i ) {
		if ( inst[i] != 'undefined' ) {
			if ( i < n-1 ) {
				output += inst[i]+', ';
			}
			if ( i == n-1 ) {
				output += ' and ' + inst[i];
			}
		}
	}
	if ( output.length > 0 ) {
		$("#review_instruments").html( output ).addClass('review-items');
		$("#inst_joined").val( output );
	}
}
function validateEmail(email) {
	var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	return re.test(email);
}
function validate_score() {
	var valid = true;
	var message = '<h3>Please fix the following:</h3>';
	var inst = ($("#instruments").val() || []);
	if ( $("#title").val().length < 1 ) {
		message += "Give your piece a title.<br />\n<br />\n";
		valid = false;
	}
	if ( inst.length < 2 || inst.length > 7 ) {
		message += "Choose two to seven instruments.<br />\n<br />\n";
		valid = false;
	}
	if ( $("#tonality").val().length < 1 ) {
		message += "Describe the tonality of your piece.<br />\n<br />\n";
		valid = false;
	}
	if ( $("#dynamics").val().length < 1 ) {
		message += "Define the dynamics of your piece.<br />\n<br />\n";
		valid = false;
	}
	if ( $("#mood").val().length < 1 ) {
		message += "Set the mood of your piece.<br />\n<br />\n";
		valid = false;
	}
	if ( $("#tempo").val().length < 1 ) {
		message += "Set the tempo of your piece.<br />\n<br />\n";
		valid = false;
	}
	if ( $('#notify').is(':checked') ) {
		if ( !validateEmail($('#email').val()) ) {
			message += "Enter a valid email for notification.<br />\n<br />\n";
			valid = false;
		}
	}
	if ( $('#agree').is(':checked') == false ) {
		message += "Please allow your piece to be performed.<br />\n";
		valid = false;
	}
	if ( valid ) {
		$.ajax({
			url: 'queue_score.php',
            data: { 
            	action: 'queue', 
            	formData: $('#queuescore').serialize()
            },
            type: 'post',                   
            async: 'false',
			dataType: 'json',
            // beforeSend: function() {
            // 	// alert('beforeSend');
            //     // This callback function will trigger before data is sent
            //     $.mobile.loading('show'); // This will show ajax spinner
            // },
            // complete: function() {
            // 	// alert('complete');
            //     // This callback function will trigger on data sent/received complete
            //     $.mobile.loading('show'); // This will hide ajax spinner
            // },
            success: function (result) {
            	// alert('result|'+result.status);
                if( result.status ) {
                    $.mobile.navigate("#thanks"); 
                    valid = true;                       
                }
                else {
                	valid = false;
                	// console.log("duplicate|"+valid);
					message += "A score with that title has already been submitted. Please change the title.<br />\n";
					$("#validate p").html( message );
					$( "#validate" ).popup('open',{
						transition: 'slidedown'
					});
                }
            },
            // error: function (request,error) {
            //     // This callback function will trigger on unsuccessful action                
            //     alert('Network error has occurred please try again!');
            // }
        });		
	}
	if ( !valid ) {
		// invoke the popup
		$("#validate p").html( message );
		$( "#validate" ).popup('open',{
			transition: 'slidedown'
		});
	}
	return false;
}