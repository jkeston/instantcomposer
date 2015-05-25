	$(document).ready(function(){
		$("input").attr("maxlength", 48);
		$("#notify").click(function(){
			$("#notify_email").toggle();
		});
	});
	function pop(e,f) {
		$(e).val(f);
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
			$("#review_title").html($("#title").val());
		}
		if ($("#author").val().length > 0) {
			$("#review_author").html('By '+$("#author").val());
		}
		if ($("#tonality").val().length > 0) {
			$("#review_tonality").html($("#tonality").val());
		}
		if ($("#tempo").val().length > 0) {
			$("#review_tempo").html($("#tempo").val());
		}
		$("#review_length").html( secs2Mins( $("#length").val() ) );
		if ($("#mood").val().length > 0) {
			$("#review_mood").html($("#mood").val());
		}
		if ($("#dynamics").val().length > 0) {
			$("#review_dynamics").html($("#dynamics").val());
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
			$("#review_instruments").html( output );
		}
	}