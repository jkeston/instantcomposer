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
		}
	}