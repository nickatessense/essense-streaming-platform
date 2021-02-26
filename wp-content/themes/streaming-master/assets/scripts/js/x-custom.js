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