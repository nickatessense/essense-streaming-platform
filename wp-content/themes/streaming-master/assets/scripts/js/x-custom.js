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
// Downloads of files tracking function
trackDownloads = function(e){
  e.preventDefault();
  
  // Get File Name from the URL
  var url = e.target.href;
  
  var pos1 = url.lastIndexOf("/") + 1;
  var downloadTitle = url.substr(pos1);
  // var downloadTitle = e.path[0].nextSibling.nextSibling.innerText;
  console.log(downloadTitle);

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

jQuery('#live-window').on("click", function(e){
  var videoSrc = jQuery('iframe').attr('src');
  var pos = videoSrc.lastIndexOf("/") + 1;
  var pos2 = videoSrc.lastIndexOf("?");
  var vid = videoSrc.slice(pos, pos2);
  
  var url = "https://www.googleapis.com/youtube/v3/videos?part=snippet&id="+vid+"&key=AIzaSyC7EJZQYfWUPbBRujQ88GUFOPetS7ekN7k"; 

  getJSON(url,function(err, data) {
    if (err !== null) {
    } else {
      var title = data.items[0].snippet.title;
      console.log(title);
    }
  });
});

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