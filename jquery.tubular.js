/* jQuery tubular plugin
|* by Sean McCambridge
|* http://www.seanmccambridge.com/tubular
|* Copyright 2010
|* licensed under the MIT License
|* Do not remove this copyright notice
|* Enjoy.
|* 
|* Thanks,
|* Sean */


// set params
var videoWidth = 853;
var videoRatio = 16/9; // either 4/3 or 16/9

jQuery.fn.tubular = function(videoId,wrapperId,zIndex) {
	t = setTimeout("resizePlayer()",1000);
	jQuery('html,body').css('height','100%');
	jQuery('body').prepend('<div id="yt-container" style="overflow: hidden; position: fixed; z-index:'+zIndex+';"><div id="ytapiplayer">You need Flash player 8+ and JavaScript enabled to view this video.</div></div><div id="video-cover" style="position: fixed; width: 100%; height: 100%; z-index: 2;"></div>');
	jQuery('#' + wrapperId).css({position: 'relative', 'z-index': 99});
	
	// initiailize vars
	var ytplayer = 0;
	var pageWidth = 0;
	var pageHeight = 0;
	var videoHeight = videoWidth / videoRatio;
	var duration;
	
	// swfobject embed yt player
	var params = { allowScriptAccess: "always", wmode: "transparent" };
	var atts = { id: "myytplayer" };
	swfobject.embedSWF("http://www.youtube.com/v/" + videoId + "?enablejsapi=1&playerapiid=ytplayer&loop=1", "ytapiplayer", videoWidth, videoHeight, "8", null, null, params, atts);
		
	jQuery(window).resize(function() {
		resizePlayer();
	});
	
	return this;
}


// player calls this function on ready
function onYouTubePlayerReady(playerId) {
	ytplayer = document.getElementById("myytplayer");
	ytplayer.setPlaybackQuality('medium');
	ytplayer.mute();
}


function resizePlayer() {
	var newWidth = jQuery(window).width(); // original page width
	var newHeight = jQuery(window).height(); // original page height
	jQuery('#yt-container, #video-cover').width(newWidth).height(newHeight);
	if (newHeight > newWidth / videoRatio) { // if window ratio becomes taller than video
		newWidth = newHeight * videoRatio; // overflow video to sides instead of bottom
	}
	jQuery('#myytplayer').width(newWidth).height(newWidth/videoRatio);
}