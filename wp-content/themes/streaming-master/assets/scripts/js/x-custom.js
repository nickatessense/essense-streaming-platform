jQuery(document).foundation();

//Mobile Menu

var forEach=function(t,o,r){if("[object Object]"===Object.prototype.toString.call(t))for(var c in t)Object.prototype.hasOwnProperty.call(t,c)&&o.call(r,t[c],c,t);else for(var e=0,l=t.length;l>e;e++)o.call(r,t[e],e,t)};

var hamburgers = document.querySelectorAll(".hamburger");
if (hamburgers.length > 0) {
  forEach(hamburgers, function(hamburger) {
    hamburger.addEventListener("click", function() {
      this.classList.toggle("is-active");
    }, false);
  });
}

jQuery("button.hamburger").click(function() {
	if(jQuery(this).hasClass('is-active')) {
        jQuery(".mobile-list").removeClass('deactive');
	} else {
    	jQuery(".mobile-list").addClass('deactive');
	}
});

//Event Calendar tabs
jQuery('.event-post').hide();
jQuery(document).on('click', 'a.tribe-events-calendar-month__calendar-event-title-link', function () {
  var tabDivId = this.hash;
  jQuery('a.tribe-events-calendar-month__calendar-event-title-link').removeClass('current');
  jQuery(this).addClass('current');
  jQuery('.event-post, .placeholder-content').hide();
  jQuery(tabDivId).fadeIn();
  return false;
});

jQuery(document).ready(function() {
  jQuery('.tabletVideo').click(function(){
    document.location.href = "/live-window"
  });
});

/*---------------------------------
          DATABASE CONTENT
----------------------------------*/ 

// Track user time on page

var pageTimeTracker = 0;

setInterval(function(){pageTimeTracker += 1;},1000);

/**
 * Sends Ajax Post to backend to update database with time
 * Function is called when window closes with the window.onbeforeunload function
 */
function updateTimeSpentOnPage(){

  let data = {
    'action': 'time_spent_on_page',
    'time': pageTimeTracker
  }; 

  jQuery.ajax({
    type : "POST",
    dataType : "json",
    url : wp_data.ajax_url,
    data : data,
    success: function(response) {
        
    }
  });

}

// Downloads of files tracking function
trackDownloads = function(e){
  e.preventDefault();
  
  // Get File Name from the URL
  var url = e.target.href;
  
  var pos1 = url.lastIndexOf("/") + 1;
  var downloadTitle = url.substr(pos1);
  // var downloadTitle = e.path[0].nextSibling.nextSibling.innerText;

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
  };
  xhr.open('GET', '/download-tracker/?title=' + downloadTitle);
  xhr.send();

  window.open(url, '_blank'); 
}

// Downloaded Calendar Invite from Event tracking function
jQuery("a[title|='Add to Google Calendar']").on("click",function(e){
  e.preventDefault();  
  var pid = e.target.offsetParent.id;
  var url = e.target.href;

  // Get Event Title
  var titleContainer = jQuery("a[href|='#"+ pid +"'")[0];
  var title = titleContainer.innerText;

  // AJAX
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
  };
  xhr.open('GET', '/download-cal-invite/?title=' + title);
  xhr.send();
  
  // Do e's action
  window.open(url, '_blank'); 
});

// Clicked "I am interested" button function
jQuery(".capture").on("click",function(e){
  e.preventDefault();

  var url = window.location.href;
  var pos1 = url.indexOf('/', 9);
  var pos2 = url.indexOf('/', pos1 + 1);
  var pos3 = url.indexOf('/', pos2 + 1);

  var company = url.substring(pos2 + 1, pos3);
  var requestUrl = '/user-interested/?comp='+company;

  // AJAX
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
  };
  xhr.open('GET', requestUrl);
  xhr.send();
});

// Clicked "Read More" button function
jQuery("#readmore").on("click",function(e){
  var url = window.location.href;
  var pos1 = url.indexOf('/', 9);
  var pos2 = url.indexOf('/', pos1 + 1);
  var pos3 = url.indexOf('/', pos2 + 1);

  var company = url.substring(pos2 + 1, pos3);
  var requestUrl = '/user-read-more/?comp='+company;

  // AJAX
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
  };
  xhr.open('GET', requestUrl);
  xhr.send();

  jQuery(".more").show();
  jQuery("#readmore").hide();
});

/*---------------------------------
Youtube Iframe API
Documentation: https://developers.google.com/youtube/iframe_api_reference
----------------------------------*/

// This code loads the IFrame Player API code asynchronously.

var videoSrc = jQuery('#essense-partners-youtube-vid').data('vid-src');

var videoId = getYoutubeVideoID(videoSrc); 

var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// This function creates an <iframe> (and YouTube player)
// after the API code downloads.
var player;
function onYouTubeIframeAPIReady() {
  player = new YT.Player('essense-partners-youtube-vid', {
    height: '100%',
    width: '100%',
    videoId: videoId,
    playerVars: {
      'playsinline': 1
    },
    events: {
      'onReady': onPlayerReady,
      'onStateChange': onPlayerStateChange
    }
  });
}

// The API will call this function when the video player is ready.
var videoTitle;
function onPlayerReady(event) {
  event.target.playVideo()

  // Code below retrieves video title from video id with youtube api
  var url = "https://www.googleapis.com/youtube/v3/videos?part=snippet&id="+videoId+"&key=AIzaSyC7EJZQYfWUPbBRujQ88GUFOPetS7ekN7k"; 
  getJSON(url,function(err, data) {

    if (err !== null) {
    } else {
      videoTitle = data.items[0].snippet.title;
    }
  });

}

// Call YT API to get title of video from ID
var getJSON = function(url, callback) {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', url, true);
  xhr.responseType = 'json';
  xhr.onload = function() {
    var status = xhr.status;
    if (status === 200) {
      callback(null, xhr.response);
    } else {
      callback(status, xhr.response);
    }
  };
  xhr.send();
};


// Simple function to get youtube video id from url
function getYoutubeVideoID(url){
  var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
  var match = url.match(regExp);
  return (match&&match[7].length==11)? match[7] : false;
}

// The API calls this function when the player's state changes.
function onPlayerStateChange(event) {

  var eventState = event.data;

  if(eventState == -1){ // -1 unstarted

  }else if(eventState == 0){ // 0 done

    clearInterval(videoInterval);

  }else if(eventState == 1){ // 1 playing

    startVideoCounter();

  }else if(eventState == 2){ // 2 paused

    clearInterval(videoInterval);

  }else if(eventState == 3){ // 3 bufferring

  }else if(eventState == 5){ // 5 video cued

  }

}

/*---------------------------------
Code for tracking user time spent on video. 
Dependent on Youtube Iframe API
----------------------------------*/

var videoInterval;
var videoTimer = 0; // in seconds

// Will update videoTimer by 1 second every second
function startVideoCounter(){ videoInterval = setInterval(function(){ videoTimer += 1; }, 1000);}

// Function to update backend sql with time spent on video
function updateTimeSpentOnVid(){
  let data = {
    'action': 'time_spent_on_vid',
    'time': videoTimer,
    'videoTitle': videoTitle
  }; 

  jQuery.ajax({
    type : "POST",
    dataType : "json",
    url : wp_data.ajax_url,
    data : data,
    success: function(response) {
        
    },
    error: function(response){
    }
  });

}

/**
 * Functions to perform when user closes, changes, or refreshes page
 * note: window.onbeforeunload does not work on opera browser
 */
window.onbeforeunload = function(){ 

  // updates database with time spent on page
  updateTimeSpentOnPage();

  // updates database with time spent watching video
  updateTimeSpentOnVid();
  
}


 // Track time logged off from log off button
jQuery('.logout').on("click", function(e){
  e.preventDefault();

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
  };
  xhr.open('GET', '/logoff-time');
  xhr.send();

  // alert('done!');
  document.location.href = "/wp-login.php?action=logout";
});