var playing;
var onDeck;
$(document).ready(function() {
	playing = false;
	onDeck = 0;
	loadQueued();
	$(document).keyup(function(e) {
		// console.log(e.which);
		// 1 = 49, 2 = 50, 3 = 51, 4 = 52, 5 = 53, space = 32
		if(e.which == 49) {
			var n = $('#sequence0').val();
			startScore(n);
		}
		if(e.which == 50) {
			var n = $('#sequence1').val();
			startScore(n);
		}
		if(e.which == 51) {
			var n = $('#sequence2').val();
			startScore(n);
		}
		if(e.which == 52) {
			var n = $('#sequence3').val();
			startScore(n);
		}
		if(e.which == 53) {
			var n = $('#sequence4').val();
			startScore(n);
		}
		if(e.which == 32 && onDeck > 0) {
			playing = true;
		}
	});
});
function loadQueued() {
	$.ajax({
		url: 'start_score.php',
		data: { 
			action: 'load',
			sid: 0
		},
		type: 'post',                   
		async: 'false',
		dataType: 'json',
		success: function(result) {
			// alert('result|'+result.status);
			var list = '';
			for (var i=0; i < result.length; ++i ) {
				list += '<div id="queued'+result[i].id+'">\n';
				list += '<h3><strong>'+result[i].title+'</strong></h2>\n';
				list += '<h4><strong>By '+result[i].author+'</strong></h3>\n';
				list += '<p class="review"><strong>For '+result[i].instruments+'</strong>\n';
				// list += '<button onclick="startScore('+result[i].id+');return false;">START!</button>\n';
				list += '<input type="hidden" value="'+result[i].id+'" id="sequence'+i+'" />';
				list += '</div>\n';
			}
			// console.log(list);
			$('#qlist').html(list);
			$('#view_score').css('opacity',0.125);
			//alert(list);
		},
	});
	return false;	
}
function startScore(sid) {
	$.ajax({
		url: 'start_score.php',
		data: { 
			action: 'start', 
			sid: sid
		},
		type: 'post',                   
		async: 'false',
		dataType: 'json',
        success: function(result) {
        	// alert('result|'+result.status);
            if ( result.status == true ) {
            	onDeck = result.id;
            	$('#playing_id').val(result.id);
				$('#review_title').html(result.title);
				$('#review_author').html('By '+result.author);
				$('#review_instruments').html(result.instruments);
				$('#review_tonality').html(result.tonality);
				$('#review_tempo').html(result.tempo);
				$('#review_length').html(secs2Mins(result.len));
				$('#review_mood').html(result.mood);
				$('#review_dynamics').html(result.dynamics);
				$('#view_score').animate({opacity: 1},1000);
				$('#queued'+result.id).slideToggle(500, function() {
					$('#queued'+result.id).remove();
					loadQueued();
				});
            }
            if (result.status == false ) {
            	if ( !playing && onDeck==0 ) {
            		// a score has a status of playing so put it in
            		onDeck = result.id;
	            	$('#playing_id').val(result.id);
					$('#review_title').html(result.title);
					$('#review_author').html('By '+result.author);
					$('#review_instruments').html(result.instruments);
					$('#review_tonality').html(result.tonality);
					$('#review_tempo').html(result.tempo);
					$('#review_length').html(secs2Mins(result.len));
					$('#review_mood').html(result.mood);
					$('#review_dynamics').html(result.dynamics);
					$('#nothing').html('');
					$('#view_score').animate({opacity: 1},3000);
            	}
            	else {
	            	// Do nothing and let the score finish
   	         	}
            }
        },
    });
    return false;	
}
function stopScore(sid) {
	$.ajax({
		url: 'start_score.php',
        data: { 
        	action: 'stop', 
        	sid: sid
        },
        type: 'post',                   
        async: 'false',
		dataType: 'json',
        success: function(result) {
        	// alert('result|'+result.status);
            if ( result.status == true ) {
            	playing = false;
            	onDeck = 0;
            	$('#view_score').animate({opacity: 0.125},3500);
    			$("#playing_id").val('');
				// $("#review_title").html('___________');
				// $("#review_author").html('By ___________');
				// $("#review_instruments").html('___________');
				// $("#review_tonality").html('___________');
				// $("#review_tempo").html('___________');
				// $("#review_length").html('___________');
				// $("#review_mood").html('___________');
				// $("#review_dynamics").html('___________');
            }
        },
    });
    return false;	
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
setInterval(function(){ 
	if ( playing ) {
		var time = $('#review_length').html();
		var p = time.split(':');
		var secs = ( Number(p[0]) * 60 ) + Number(p[1]);
		secs -= 1;
		$('#review_length').html(secs2Mins(secs));
		if (secs < 1) {
			stopScore($('#playing_id').val());
			playing = false;
			onDeck = 0;
		}
	}
}, 1000);