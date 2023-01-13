var delay_submit = (function() {
	var timer = 0;
	return function(callback, ms) {
		clearTimeout(timer);
		timer = setTimeout(callback, ms);
	}
})();


$(document).ready(function() {
	function toggleSidebar() {
        $(".sidenav-toggle").toggleClass("active");
        $(".content").toggleClass("menu-open");
        $(".sidenav").toggleClass("menu-open");
    }
  
    $(".sidenav-toggle").on("click tap", function() {
        toggleSidebar();
    });
	
	/**
	 * hover captions for icons.
	 */
	xOffset = 10;
	yOffset = 15;
	// these 2 variable determine popup's distance from the cursor
	$(document).on('mouseenter', ".definition, .tooltip", function(e){
		this.t = this.title;
		this.title = "";
		var c = (this.t != "") ? this.t : "";
		$("body").append("<div id='caption'>"+ c +"</div>");
		$("#caption")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
	});
	$(document).on('mouseleave', ".definition, .tooltip", function(e){
		this.title = this.t;
		$("#caption").remove();
	});
	$(document).on('mousemove', ".definition, .tooltip", function(e){
		$("#caption")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});

	$(window).scroll(function(e) {
		if (document.body.scrollTop >= $('header').height()) {
			$('body').addClass("sticky-nav");
		} else {
			$('body').removeClass("sticky-nav");
		}
	});
})


