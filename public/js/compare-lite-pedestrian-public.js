/**
	* All of the code for your public-facing JavaScript source
	* should reside in this file.
	*
	* Note: It has been assumed you will write jQuery code here, so the
	* $ function reference has been prepared for usage within the scope
	* of this function.
	*
	* This enables you to define handlers, for when the DOM is ready:
	*
	* $(function() {
	*
	* });
	*
	* When the window is loaded:
	*
	* $( window ).load(function() {
	*
	* });
	*
	* ...and/or other possibilities.
	*
	* Ideally, it is not considered best practise to attach more than a
	* single DOM-ready or window-load handler for a particular page.
	* Although scripts in the WordPress core, Plugins and Themes may be
	* practising this, we should strive to set a better example in our own work.
**/

var compareLitePostCodes = new Array;
const verifyPostCode = (postCode) => {

    let selectedCompareLitePostCodes = compareLitePostCodes.filter(compareLitePostCode => compareLitePostCode == postCode);
    if(selectedCompareLitePostCodes.length){
        return true;
    }
    return false;

}
// https://www.econnex.com.au/lifehacker/?postcode=2000,%20SYDNEY,%20NSW&utm_source=lifehacker
var firstParam=true;
jQuery('body').on('click', '.compare_lite_postcode_submit', function () {
	console.log( 'loadCompareLite executed in post: ' + postId );
	let userPostCode = jQuery(this).prevAll('.compare_lite_postcode_search').val();
	console.log(userPostCode);
	
	if(!verifyPostCode(userPostCode)){

		jQuery(this).prev('.error_compare_lite_post_code').addClass('active').text('Please enter either your post-code or suburb and then select from the list provided.');

		return false;
	
	}

	var compareLiteQueryParams = '';
	var firstParam = true;

	compareLiteQueryParams += urlFinal + utmSource;

	if (userPostCode) {
		if (firstParam) {
			compareLiteQueryParams += '?postcode=' + userPostCode;
			firstParam = false;
		} else {
			compareLiteQueryParams += '&postcode=' + userPostCode;
		}
	}

	if (utmSource) {
		if (firstParam) {
			compareLiteQueryParams += '?utm_source=' + utmSource;
			firstParam = false;
		} else {
			compareLiteQueryParams += '&utm_source=' + utmSource;
		}
	}
	
	//window.location = compareLiteQueryParams;
	window.open(compareLiteQueryParams, '_blank');

});
function loadCompareLite() {

	console.log( 'loadCompareLite executed in post: ' + postId );

	//call to postcodes.txt
	jQuery.get( pluginDirUrl + 'public/js/postcodes.txt', function (data) {

		console.log(pluginDirUrl + 'public/js/postcodes.json');
		
		var array = data.split('\n');
		jQuery.each(array, function (a, i) {
		compareLitePostCodes.push(i);
		});

		const linesDescription = ["postcode"];
		const arrayx = [];
		let obj = {};
		var lines = data.split("\n");
		let x = 0;
		for(var line = 0; line < lines.length; line++){
		  obj[linesDescription[x]] = lines[line].trim();
		  x++;
		  if (x >= linesDescription.length) {
			arrayx.push(obj);
			x = 0;
			obj = {};
		  }
		};

		var json = JSON.stringify(arrayx);

	});

	var compareLiteTermTemplate = "<span class='ui-autocomplete-term'>%s</span>";

	jQuery(".compare_lite_postcode_search")
	.autocomplete({
	source: function (request, response) {
		var results = jQuery.ui.autocomplete.filter(compareLitePostCodes, request.term);
		var that = jQuery(this);
		if (!results.length) {
			that[0].element[0].nextSibling.nextElementSibling.classList.add("active");
			that[0].element[0].nextSibling.nextElementSibling.innerHTML = 'No result found related to your inputs.';
		}
		response(results);
	},
	appendTo: "#ui-complete-result-box",
	open: function () {
		if (jQuery(".compare_lite_postcode_search").hasClass("woolworth_autocomplete")) {
		jQuery(".ui-autocomplete:visible").css({
			top: "+=0",
			left: "+=20",
		});
		}
		var acData = jQuery(this).data("uiAutocomplete");
		var styledTerm = compareLiteTermTemplate.replace("%s", acData.term);
		acData.menu.element.find("div").each(function () {
		var me = jQuery(this);
		var keywords = acData.term;
		me.html(
			me
			.text()
			.replace(new RegExp("(" + keywords + ")", "gi"), styledTerm)
		);
		});
	},
	close: function (event, ui) {
		var input_length = jQuery(".compare_lite_postcode_search").val().length;
	},
	select: function (event, ui) {
		if (event.which == 13) {
			console.log('event.which : ',event.which);
		jQuery(".compare_lite_postcode_submit").click();
		}
		jQuery(".compare_lite_postcodelisting").hide();
		jQuery(".compare_lite_postcode_submit").attr("disabled", false);
	},
	minLength: 3,
	})
	.autocomplete("widget")
	.addClass("compare_lite_postcodelisting");

	jQuery('.compare_lite_postcode_search,.compare_lite_postcode_submit').attr('disabled',false);

}
loadCompareLite();