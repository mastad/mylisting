/*
 * Show More jQuery Plugin
 * Author: Jason Alvis
 * Author Site: http://www.jasonalvis.com
 * License: Free General Public License (GPL)
 * Version: 1.0.4
 * Date: 21.05.2013
 */
(function(a){a.fn.showMore=function(b){var c={speedDown:300,speedUp:300,height:"265px",showText:"Show",hideText:"Hide"};var b=a.extend(c,b);return this.each(function(){var e=a(this),d=e.height();if(d>parseInt(b.height)){e.wrapInner('<div class="showmore_content" />');e.find(".showmore_content").css("height",b.height);e.append('<div class="showmore_trigger"><span class="more">'+b.showText+'</span><span class="less" style="display:none;">'+b.hideText+"</span></div>");e.find(".showmore_trigger").on("click",".more",function(){a(this).hide();a(this).next().show();a(this).parent().prev().animate({height:d},b.speedDown)});e.find(".showmore_trigger").on("click",".less",function(){a(this).hide();a(this).prev().show();a(this).parent().prev().animate({height:b.height},b.speedUp)})}})}})(jQuery);


//custom file input
( function ( document, window, index )
{
    var inputs = document.querySelectorAll( '.inputfile' );
    Array.prototype.forEach.call( inputs, function( input )
    {
        var label	 = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
            var fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.querySelector( 'span' ).innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });

        // Firefox bug fix
        input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
        input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
    });
}( document, window, 0 ));




jQuery.fn.textlimit = function(limit)
{
    return this.each(function(index,val)
    {
        var $elem = jQuery(this);
        var $limit = limit;
        var $strLngth = jQuery(val).text().length;  // Getting the text
        if($strLngth > $limit)
        {
            jQuery($elem).text(jQuery($elem).text().substr( 0, $limit )+ "...");
        }
    })
};
//masonary
(function(jQuery) {
    var $container = jQuery('.masonry-content');
    $container.masonry({
        columnWidth: '.item-masonry',
        itemSelector: '.item-masonry'
    });
    
    //Reinitialize masonry inside each panel after the relative tab link is clicked - 
    jQuery('.tab-button a[data-toggle=tab]').each(function () {
        var $this = jQuery(this);

        $this.on('shown.bs.tab', function () {
        
            if(jQuery('div').hasClass('masonry-content')){
                $container.masonry({
                    columnWidth: '.item-masonry',
                    itemSelector: '.item-masonry'
                });
            }
            

        }); //end shown
    });  //end each
})(jQuery);
//classiEra JS
jQuery(document).ready(function(jQuery){
    "use strict";
    jQuery.noConflict();
	//click on parent menu
    jQuery('.navbar .dropdown > a').on('click', function(){
        location.href = this.href;
    });
    //remove class and attribute from off canvas
    jQuery(".offcanvas ul li a.dropdown-toggle").removeClass('dropdown-toggle');
	jQuery(".offcanvas ul li.menu-item-has-children").addClass('open');
	jQuery(".classiera-box-div.classiera-box-div-v7 .buy-sale-tag").removeClass('active');
	jQuery(".classiera-box-div.classiera-box-div-v6 .classiera-buy-sel").removeClass('active');

    //custom menu close and open
    jQuery("a.menu-btn").on('click', function (event) {
        event.preventDefault();
        jQuery(this).next().toggle();
        if(jQuery(".custom-menu-v5").hasClass("menu-open")){
            jQuery(".custom-menu-v5").removeClass("menu-open");
            jQuery(".menu-btn").children().removeClass("fa-times");
            jQuery(".menu-btn").children().addClass("fa-bars");
        }else{
            setTimeout( function(){
                jQuery(".custom-menu-v5").addClass("menu-open");
            },300);
            jQuery(".menu-btn").children().removeClass("fa-bars");
            jQuery(".menu-btn").children().addClass("fa-times");
        }
    });
    
    var total = jQuery('#single-post-carousel .item').length;
    jQuery('.num .total-num').html(total);
    //single post carousel
    // This triggers after each slide change
    jQuery('.carousel').on('slid.bs.carousel', function () {
        var carouselData = jQuery(this).data('bs.carousel');
        var currentIndex = jQuery('#single-post-carousel .active').index('#single-post-carousel .item');
        var total = carouselData.$items.length;

        // Now display this wherever you want
        var text = (currentIndex + 1);        
        jQuery('.num .init-num').html(text);
        jQuery('.num .total-num').html(total);
    });



    //match height
    jQuery('.match-height').matchHeight();

    //active for grid list
    jQuery('.view-head .view-as li').on('click', function(){
        if(jQuery(this).hasClass("active")!== true)
        {
            jQuery('.view-head .view-as li').removeClass("active");
            jQuery(this) .addClass("active");
        }
    });

    //list and grid view
    jQuery('.view-head .view-as a').on('click', function(event){
        event.preventDefault();
        
        //add remove active class
        if(jQuery(this).hasClass("active")!== true)
        {
            jQuery('.view-head .view-as a').removeClass("active");
            jQuery(this) .addClass("active");
        }
        
        // add remove grid and list class
        var aclass = jQuery(this).attr('class');
        var st = aclass.split(' ');
        var firstClass = st[0];        
        var selector = jQuery(this).closest('.view-head').next().find('div.item');
        var classStr = jQuery(selector).attr('class'),
            lastClass = classStr.substr( classStr.lastIndexOf(' ') + 1);
        jQuery(selector)
        // Remove last class
            .removeClass(lastClass)
            // Put back .item class + the clicked elements class with the added prefix "group-item-".
            .addClass('item-' + firstClass );
        jQuery('.item-grid').matchHeight();
        jQuery('.item-list').matchHeight();

        if(jQuery('div').hasClass('item-list')){
            jQuery(".masonry-content").masonry('destroy');
            jQuery('.item-list').matchHeight({ remove: true });
            var itemList = jQuery('.item-list');
            jQuery(itemList).find('figure').addClass('clearfix');
            jQuery(itemList).parent().removeClass('masonry-content');
            var mqxs = window.matchMedia( "(min-width: 1024px)" );
            if (mqxs.matches) {
                jQuery(".classiera-advertisement .classiera-box-div h5 > a").textlimit(60);
            }else{
                jQuery(".classiera-advertisement .classiera-box-div h5 > a").textlimit(60);
            }
        }else{
            if(jQuery('div').hasClass('item-masonry')){
				jQuery('.item-masonry').parent().addClass('masonry-content');
				//masonry
                var $container = jQuery('.masonry-content');
					$container.masonry('reloadItems').masonry({
                    itemSelector: '.item-masonry',
					columnWidth: '.item-masonry'
                });
			}
		}
        
    });
	if(jQuery('div').hasClass('item-list')){
        jQuery(".masonry-content").masonry('destroy');
        jQuery('.item-list').parent().removeClass('masonry-content');
    }    
    jQuery('.classiera-premium-ads-v3 .premium-carousel-v3 .item figure figcaption h5 > a').textlimit(30);
    //back to top
    var backtotop = '#back-to-top';
    if (jQuery(backtotop).length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = jQuery(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    jQuery(backtotop).addClass('show');
                } else {
                    jQuery(backtotop).removeClass('show');
                }
            };
        backToTop();
        jQuery(window).on('scroll', function () {
            backToTop();
        });
        jQuery('#back-to-top').on('click', function (e) {
            e.preventDefault();
            jQuery('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }

    //category v2 hover color
    jQuery('.category-content .av-2').on('mouseenter', function(){
        var color = jQuery(this).attr('data-color');
        jQuery(this).css('background', color);

    }).on( "mouseleave", function() {
        jQuery(this).css('background', '#fafafa');
    });

    //advance search collapse
    if(jQuery(window).innerWidth() < 1024){
        jQuery("#innerSearch").removeClass('in');
    }
	//Mobile APP Button//
	var mobileNavButton = jQuery(".mobile-submit").outerHeight();
    if(jQuery(window).innerWidth() < 1025){
        jQuery('.footer-bottom').css("margin-bottom", mobileNavButton);
    }


    //user comments
   jQuery(".user-comments .media .media-body p + h5 > a").on('click', function (event) {
        event.preventDefault();
        jQuery(this).parent().next('.reply-comment-div').toggle();
    });
   jQuery(".reply-comment-div > .reply-tg-button").on('click', function () {
		jQuery(this).parent().toggle();
   });
   //Comment Ajax// 
   jQuery(document).on('submit', '#commentform', function(event){
		event.preventDefault();
		jQuery('.comment-success').hide();
		jQuery('.comment-error').hide();
		var commentform = jQuery('#commentform');
		var formdata = jQuery(this).serialize();		
		jQuery('.classiera--loader').show();
	    var formurl = commentform.attr('action');
		jQuery.ajax({
			type: 'post',
			url: formurl,
			data: formdata,
			error: function(XMLHttpRequest, textStatus, errorThrown){
                jQuery('.comment-error').show();
				jQuery('.classiera--loader').hide();
            },
			success: function(data, textStatus){				
                if(data == "success" || textStatus == "success"){                    
					jQuery('.user-comments').append(data);					
					jQuery('.comment-success').show();
					jQuery('.classiera--loader').hide();										
                }else{
                    jQuery('.comment-error').show();
					jQuery('.classiera--loader').hide();                    
                }
            }			
		});
		
   });
   jQuery(document).on('submit', '#commentformSUB', function(event){
		event.preventDefault();
		jQuery('.comment-success').hide();
		jQuery('.comment-error').hide();
		var commentform = jQuery('#commentformSUB');
		var commentSub = jQuery(this);		
		var formdata = jQuery(this).serialize();		
		jQuery(this).parent().parent().find('.classiera--loader').show();	
	    var formurl = commentform.attr('action');
		jQuery.ajax({
			type: 'post',
			url: formurl,
			data: formdata,
			error: function(XMLHttpRequest, textStatus, errorThrown){
                jQuery('.comment-error').show();
				jQuery('.classiera--loader').hide();
            },
			success: function(data, textStatus){				
                if(data == "success" || textStatus == "success"){
					commentSub.parent().parent().parent().append(data);					
					commentSub.parent().parent().find('.comment-success').show();					
					commentSub.parent().parent().find('.classiera--loader').hide();				
					
                }else{                     
					jQuery(this).parent().parent().find('.comment-error').show();					
					jQuery(this).parent().parent().find('.classiera--loader').hide();
                }
            }			
		});
		
   });
   //Comment Ajax// 
    //range slider
    if(jQuery('div').hasClass('range-slider')){
        var rangeSlider = jQuery("#price-range");
        jQuery(rangeSlider).slider();
        jQuery(rangeSlider).on("slide", function(slideEvt) {
            var rangeSliderValOne = slideEvt.value[0];
            var rangeSliderValTwo = slideEvt.value[1];
            jQuery("input#range-first-val").val(rangeSliderValOne);
            jQuery("input#range-second-val").val(rangeSliderValTwo);
            jQuery(".price-range-text span:first-of-type").text(rangeSliderValOne);
            jQuery(".price-range-text span:last-of-type").text(rangeSliderValTwo);
        });
    }


    //show more and less
    jQuery('.inner-search-box-child').showMore({
        speedDown: 300,
        speedUp: 300,
        height: '165px',
        showText: 'Show more',
        hideText: 'Show less'
    });

    //submit post main cat and sub cat
	jQuery('.classiera-post-sub-cat').hide();
    var mainCatText;
    jQuery(".classiera-post-main-cat ul li > a").on('click', function (event){
        event.preventDefault();
		jQuery('.classiera-post-sub-cat').hide();
		jQuery('.classiera_third_level_cat').hide();
        var mainCatId = jQuery(this).attr('id');
        mainCatText = jQuery(this).find('span').text();
        jQuery(this).parent().parent().next().val(mainCatId);
        jQuery('.form-control-static').text(mainCatText);
        jQuery(this).closest('li').addClass('active');
        jQuery(this).closest('li').siblings().removeClass('active');
		var data = {
			'action': 'classieraGetSubCatOnClick',
			'mainCat': mainCatId,
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery('.classieraSubReturn').html(response);
			if(response){
				jQuery('.classiera-post-sub-cat').show();
			}			
		});

    });
    var subCatText;
	
   jQuery(document).on('click', '.classiera-post-sub-cat ul li > a', function (event){
        event.preventDefault();
		jQuery('.classiera_third_level_cat').hide();
        var subCatId = jQuery(this).attr('id');
		var data = {
			'action': 'classieraGetSubCatOnClick',
			'subCat': subCatId,
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery('.classieraSubthird').html(response);
			if(response){
				jQuery('.classiera_third_level_cat').show();
			}			
		});
        subCatText = jQuery(this).text();
        jQuery(this).parent().parent().next().val(subCatId);
        jQuery('.form-control-static').text(mainCatText +' / '+ subCatText);
    });
	jQuery('.classiera_third_level_cat').hide();
	var subThirdCatText;
	jQuery(document).on('click', '.classiera_third_level_cat ul li > a', function (event){
        event.preventDefault();
		var thirdCatId = jQuery(this).attr('id');
		subThirdCatText = jQuery(this).text();
		jQuery(this).parent().parent().next().val(thirdCatId);
		jQuery('.form-control-static').text(mainCatText +' / '+ subCatText +' / '+ subThirdCatText);
    });

    //image previews
    function readURL() {
        var $input = jQuery(this);
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $input.siblings('.classiera-image-preview').show().children('.my-image').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    }
	//Profile Image//
	function readProfileURL() {
        //var $input = jQuery(this);
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
				jQuery('.uploadImage').children('.author-avatar').attr('src', e.target.result);
                //$input.siblings('.classiera-image-preview').show().children('.author-avatar').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    }
	 jQuery(".author-UP").change(readProfileURL); 
	//Profile Image//
    jQuery(".imgInp").change(readURL);    
    jQuery(".remove-img").on('click', function () {
		jQuery(this).parents('.classiera-upload-box').find('.imgInp').val(null);
        jQuery(this).parent().hide();
        jQuery(this).prev().attr('src','#');
    });
	//Featured Image Count	
	jQuery(document).on('click', '.classiera-image-box', function(){ 
		var count = jQuery(this).index();
		jQuery('#classiera_featured_img').val(count);
	});
	jQuery(document).on('click', '.classiera-image-preview', function(){ 
		if(jQuery('.classiera-upload-box').hasClass('classiera_featured_box')){
			jQuery('.classiera-upload-box').removeClass('classiera_featured_box');
		}
		jQuery(this).parent().addClass('classiera_featured_box');
		
	});
	jQuery(document).on('click', '.edit-post-image-block img', function(){ 
		jQuery('.edit-post-image-block img').css('border','none');
		jQuery('.MultiFile-preview').css('border','none');
		jQuery(this).css('border','1px solid #e96969');
	});
	//Featured Image Count	
    //label click on submit post
    jQuery(".post-type-box .radio > label").on('click', function () {
        var bd = jQuery(this).parent().parent().parent();
        jQuery(bd).addClass('active-post-type');
        jQuery(bd).siblings().removeClass('active-post-type');
        if(jQuery(bd).hasClass()){
            jQuery(bd).removeClass('active-post-type');
            jQuery(bd).siblings().addClass('active-post-type');
        }
    });
    //owl carousel
    jQuery('.owl-carousel').each(function(){
        var owl = jQuery(this);
        jQuery(".related-blog-post-section .navText .prev").on('click', function () {
            jQuery(this).parent().parent().parent().next().find('.owl-carousel').trigger('prev.owl.carousel');
        });
        jQuery(".related-blog-post-section .navText .next").on('click', function () {
            jQuery(this).parent().parent().parent().next().find('.owl-carousel').trigger('next.owl.carousel');
        });
        jQuery(".prev").on('click', function () {
            jQuery(this).parent().prev().children().trigger('prev.owl.carousel');
        });

        jQuery(".next").on('click', function () {
            jQuery(this).parent().prev().children().trigger('next.owl.carousel');
        });

        //number from single post page carousel
        var loopLength = owl.data('car-length');
        var divLength = jQuery(this).find("div.item").length;
        if(divLength > loopLength){
            owl.owlCarousel({
                rtl: owl.data("right"),
                nav : owl.data("nav"),
                dots : owl.data("dots"),
                items: owl.data("items"),
                slideBy : owl.data("slideby"),
                rewind: owl.data("rewind"),
                center : owl.data("center"),
                loop : owl.data("loop"),
                margin : owl.data("margin"),
                autoplay : owl.data("autoplay"),
                autoplayTimeout : owl.data("autoplay-timeout"),
                autoplayHoverPause : owl.data("autoplay-hover"),
                autoWidth:owl.data("auto-width"),
                autoHeight:owl.data("auto-Height"),
                merge: owl.data("merge"),
                responsive:{
                    0:{
                        items:owl.data("responsive-small"),
                        nav:false,
                        dots : false
                    },
                    600:{
                        items:owl.data("responsive-medium"),
                        nav:false,
                        dots : false
                    },
                    1000:{
                        items:owl.data("responsive-large"),
                        nav:false
                    },
                    1900:{
                        items:owl.data("responsive-xlarge"),
                        nav:false
                    }
                }
            });

        }else{
            owl.owlCarousel({
                rtl: owl.data("right"),
                nav : owl.data("nav"),
                dots : owl.data("dots"),
                items: owl.data("items"),
                loop: false,
                margin: owl.data("margin"),
                autoplay:false,
                autoplayHoverPause:true,
                responsiveClass:true,
                autoWidth:owl.data("auto-width"),
                autoHeight:owl.data("auto-Height"),
                responsive:{
                    0:{
                        items:owl.data("responsive-small"),
                        nav:false
                    },
                    600:{
                        items:owl.data("responsive-medium"),
                        nav:false
                    },
                    1000:{
                        items:owl.data("responsive-large"),
                        nav:false
                    },
                    1900:{
                        items:owl.data("responsive-xlarge"),
                        nav:false
                    }
                }
            });
        }
    });

    var outerHeightNav = jQuery(".topBar").outerHeight();
    //navbar offset
    if(jQuery(window).innerWidth() > 1025 && outerHeightNav != null){
        jQuery(".classiera-navbar").affix({
            offset: {
                top: jQuery(".topBar").outerHeight()
            }
        });
    }
    if(jQuery(window).innerWidth() < 1025 && jQuery('section').hasClass('navbar-fixed-top')){
        jQuery('section').removeClass('navbar-fixed-top');
    }

    var navcheck = jQuery('.classiera-navbar').outerHeight() - 1;
    if(jQuery('section').hasClass('navbar-fixed-top')){
        jQuery('header').css({ 'padding-top': navcheck + 'px'});
    }
	//Custom Fields At FrontEnd
	jQuery(document).on('click', '.classiera-post-main-cat ul li a', function(){
		var val = jQuery(this).attr('id');
  		jQuery('#primaryPostForm').find(".wrap-content").css({"display":"none"});
  		jQuery('#primaryPostForm').find("#cat-" + val).css({"display":"block"});
	});
	jQuery(document).on('click', '.classiera-post-sub-cat ul li a', function(){
		var val = jQuery(this).attr('id');
		jQuery('#primaryPostForm').find(".wrap-content").css({"display":"none"});		
  		jQuery('#primaryPostForm').find("#cat-" + val).css({"display":"block"});
	});
	//Pricing Plans Function//
	jQuery(".viewcart").hide();
	jQuery('.add_to_cart_button').on('click', function(event){
		event.preventDefault();
		var $btn = jQuery(this);
		var amt = jQuery(this).parent().parent().children('input');		
		var myData = [];
		var i = 0;
		jQuery(amt).each(function(index){
			myData[i++] = jQuery(this).val();
		});
		jQuery.ajax({
			url: ajaxurl, //AJAX file path - admin_url('admin-ajax.php')
			type: "POST",
			data:{
					action:'classiera_implement_woo_ajax', 
					user_data : myData,
				},
			async : false,
			success: function(data){
				$btn.parent().hide();
				$btn.parent().parent().next('.viewcart').show();
			}
		});
    });
	//Pricing Plans Function//
	//Select Location//
	jQuery('#post_location').on('change', function(e){		
		//jQuery(".chosen-select").val('').trigger("chosen:updated");
		var data = {
			'action': 'get_states_of_country',
			'CID': jQuery(this).val()
		};		
		jQuery.post(ajaxurl, data, function(response){
			if(jQuery("#post_state").length>0){
				jQuery("#post_state").html(response);
			}
		});
    });
	jQuery('#post_state').change(function(e) {
		//jQuery(".chosen-select").val('').trigger("chosen:updated");
		var data = {
			'action': 'get_city_of_states',
			'ID': jQuery(this).val()
		};		
		jQuery.post(ajaxurl, data, function(response) {
			if(jQuery("#post_city").length>0){
				jQuery("#post_city").html(response);				
			}
		});
    });
	//Select Location//
	//Search Page Categories//
	jQuery('#main_cat').on('change', function(){	
		var mainCat = jQuery(this).val();
			// call ajax
		jQuery("#sub_cat").empty();
		var data = {
			'action': 'classiera_implement_ajax',
			'mainCat': jQuery(this).val()
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery("#sub_cat").removeAttr("disabled");
			jQuery("#sub_cat").html(response);
		});	   
	});
	//Search Page Categories//
	jQuery("#main_cat").change(function(e){
	  jQuery(".custom-field-cat").hide();
	  jQuery(".autoHide").hide();
	  jQuery(".custom-field-cat-" + jQuery(this).val()).show();
	  jQuery(".hide-" + jQuery(this).val()).show();
	});
	jQuery("#sub_cat").change(function(e){
	  jQuery(".custom-field-cat").hide();
	  jQuery(".autoHide").hide();
	  jQuery(".custom-field-cat-" + jQuery(this).val()).show();
	  jQuery(".hide-" + jQuery(this).val()).show();
	});
	
	//Get User Location//
	jQuery.ajax({
		url: "https://geoip-db.com/jsonp",
		jsonpCallback: "callback",
		dataType: "jsonp",
		success: function(location){
			//$('#country').html(location.country_name);
			//$('#state').html(location.state);
			//jQuery('#getCity').val(location.city);
			//$('#latitude').html(location.latitude);
			//$('#longitude').html(location.longitude);
			//$('#ip').html(location.IPv4);  
		}
	});	
	/*if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showLocation);
    } else { 
        jQuery('#getLocation').val('Geolocation is not supported by this browser.');
    }
	function showLocation(position){
		var latitude = position.coords.latitude;
		var longitude = position.coords.longitude;
		jQuery.ajax({
			type:'POST',
			url:ajaxLocation,
			data:'latitude='+latitude+'&longitude='+longitude,
			success:function(msg){
				if(msg){
					alert(msg);
				   jQuery("#getLocation").val(msg);
				}else{
					jQuery("#location").val('Not Available');
				}
			}
		});
	}*/
	//Classiera Search Ajax//
	jQuery('.classieraSearchLoader').hide();
	jQuery('.classieraAjaxResult').hide();
	jQuery('#classieraSearchAJax').on('keyup', function(e){	
		jQuery(this).attr('autocomplete','off');
		var searchTerm = jQuery(this).val();
		if(searchTerm.length >= 1){
			jQuery('.classieraSearchLoader').show();
			var data = {
				'action': 'get_search_classiera',
				'CID': searchTerm,
			};
			jQuery.post(ajaxurl, data, function(response){					
				jQuery(".classieraAjaxResult").html(response);
				jQuery('.classieraAjaxResult').show();
				jQuery('.classieraSearchLoader').hide();
			});
		}	
	});	
	jQuery(document).on('click', '.classieraAjaxResult li > a.SearchLink', function(e){
		e.preventDefault();
		var myResult = jQuery(this).attr('name');		
		jQuery('#classieraSearchAJax').val(myResult);
		jQuery('.classieraAjaxResult').hide();
	});
	jQuery(document).on('click', '.classieraAjaxResult li > a.SearchCat', function(e){
		e.preventDefault();
		var optionValue = jQuery(this).attr('id');
		jQuery("#ajaxSelectCat").val(optionValue).find("option[value=" + optionValue +"]").attr('selected', true);
		jQuery('.classieraAjaxResult').hide();
	});
	//Classiera Search Ajax//

    //classiera other message repost
    jQuery('input[type="radio"]').on('click', function() {
       if(jQuery(this).attr('id') == 'post_other') {
            jQuery('.otherMSG').show();           
       }

       else {
            jQuery('.otherMSG').hide();   
       }
   });
   //Make Offer On Single Page//
   jQuery(document).on('submit', '#offerForm', function(event){
		event.preventDefault();
		jQuery(this).find('.classiera--loader').show();
		var offer_price = jQuery('#offer-text').val();
		var offer_email = jQuery('#email-offer').val();
		var classiera_current_price = jQuery('#classiera_current_price').val();
		var classiera_post_title = jQuery('#classiera_post_title').val();
		var classiera_post_url = jQuery('#classiera_post_url').val();
		var classiera_author_email = jQuery('#classiera_author_email').val();
		var data = {
			'action': 'make_offer_classiera',
			'offer_price': offer_price,
			'offer_email': offer_email,
			'classiera_current_price': classiera_current_price,
			'classiera_post_title': classiera_post_title,
			'classiera_post_url': classiera_post_url,
			'classiera_author_email': classiera_author_email,
		};		
		jQuery.post(ajaxurl, data, function(response){					
			jQuery(".classieraAjaxResult").html(response);
			jQuery('.classiera--loader').hide();
			jQuery('#offerForm').find('.classieraAjaxResult').show();
		});
		
	});
   //remove disabled class from mobile menu
	var dis = jQuery('.offcanvas').find('ul li a.dropdown-toggle');
    if(jQuery(dis).hasClass('disabled')){
        jQuery(dis).removeClass('disabled');
    }
	
	jQuery(document).on('click', '#getLocation', function(e){
		e.preventDefault();
		jQuery.ajax({
			url: "https://geoip-db.com/jsonp",
			jsonpCallback: "callback",
			dataType: "jsonp",
			success: function(location){
				//$('#country').html(location.country_name);
				//$('#state').html(location.state);
				jQuery('#getCity').val(location.city);
				//$('#latitude').html(location.latitude);
				//$('#longitude').html(location.longitude);
				//$('#ip').html(location.IPv4);  
			}
		});
	});

    // partners-v2 border removing
    jQuery(".partners-v2-border").slice(4, 8).css('border-bottom', 'none');
    jQuery(".partners-v2-border:eq( 3 )").css('border-right', 'none');
    jQuery(".partners-v2-border:last").css('border-right', 'none');
	
	//Remove Image on Edit Post Page//
	jQuery('.remImage').live('click', function() {
		jQuery(this).parent().parent().fadeOut();
		jQuery(this).parent().find('input').attr('name', 'att_remove[]' );
	});
	//Get Custom Fields//
	jQuery(".classiera-post-main-cat ul li > a").on('click', function (event){
        event.preventDefault();
		jQuery('.classieraExtraFields').hide();
        var mainCatId = jQuery(this).attr('id');
		var data = {
			'action': 'classiera_Get_Custom_Fields',
			'Classiera_Cat_ID': mainCatId,
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery('.classieraExtraFields').html(response);
			if(response){
				jQuery('.classieraExtraFields').show();
			}			
		});

    });
	 jQuery(document).on('click', '.classiera-post-sub-cat ul li > a', function (event){
        event.preventDefault();
		jQuery('.classieraExtraFields').hide();
        var subCatId = jQuery(this).attr('id');
        var data = {
			'action': 'classiera_Get_Custom_Fields',
			'Classiera_Cat_ID': subCatId,
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery('.classieraExtraFields').html(response);
			if(response){
				jQuery('.classieraExtraFields').show();	
			}
		});
    });
	/*Classiera Third Cat Fields*/
	jQuery(document).on('click', '.classiera_third_level_cat ul li > a', function (event){
        event.preventDefault();
		jQuery('.classieraExtraFields').hide();
        var subThirdCatId = jQuery(this).attr('id');
        var data = {
			'action': 'classiera_Get_Custom_Fields',
			'Classiera_Cat_ID': subThirdCatId,
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery('.classieraExtraFields').html(response);
			if(response){
				jQuery('.classieraExtraFields').show();	
			}
		});
    });
	/*Classiera Third Cat Fields*/
	jQuery("#cat").change(function(e){	 
	  var editCatID = jQuery(this).val();
	  var data = {
			'action': 'classiera_Get_Custom_Fields',
			'Classiera_Cat_ID': editCatID,
		};
		jQuery.post(ajaxurl, data, function(response){
			jQuery('.classieraExtraFields').html(response);
			jQuery('.classieraExtraFields').show();
		});
	  
	});
	//Get Custom Fields//
	//phone number hide/show
	if(jQuery('span').hasClass('phNum')){
		var ph = jQuery('.phNum').text();
		var t = ph.slice(4, 20);
		var cross = 'XXXXX';
		jQuery('.phNum').html(jQuery('.phNum').html().replace(t, cross));
		jQuery('#showNum').on('click', function(event){
			event.preventDefault();
			jQuery(this).hide();
			var older_value = jQuery('this').prev('.phNum').html();
			jQuery(this).prev('.phNum').html(jQuery('.phNum').attr('data-replace')).attr('data-replace',older_value);
		});
	}
   
	//phone number hide/show
	//Currency Tag apply//
	if(jQuery('select').hasClass('post_currency_tag')){
		jQuery(".post_currency_tag").select2();
		jQuery(document).on('change', '.post_currency_tag', function (){        
			var currencyTag = jQuery(this).val();
			var data = {
				'action': 'classiera_change_currency_tag',
				'currencyTag': currencyTag,
			};
			jQuery.post(ajaxurl, data, function(response){
				jQuery('.currency__symbol').html(response);		
			});        
		});	
	}	
	//Currency Tag apply//
	//add disable to category//	
	if(jQuery('div').hasClass('classiera__inner')){		
		jQuery('#main_cat option:selected').attr('disabled', 'disabled');		
	}
	
});

jQuery(window).on('load', function () {
    var mqxs = window.matchMedia( "(max-width: 1024px)" );
    if (mqxs.matches) {
        jQuery("ul li > a.dropdown-toggle").removeAttr('data-hover');
    }
	//tooltip
    jQuery("#getLocation").tooltip();
    //user sidebar affix
    var userConetntHeight = jQuery(".user-content-height").height();
    var userAside = jQuery("#sideBarAffix").height();
    if(jQuery(window).innerWidth() >= 1025 && userConetntHeight > userAside) {
        //sidebar fixed
        var headerHeight = jQuery('.topBar').outerHeight(true); // true value, adds margins to the total height        
        var footerHeight = jQuery('footer').outerHeight(true) + 80;
        var partnerHeight = jQuery('.partners').outerHeight(true);
        var bottomFooter = jQuery('.footer-bottom').outerHeight(true);
        var bottomHeight = footerHeight + partnerHeight + bottomFooter;

        jQuery('#sideBarAffix').affix({
            offset: {
                top: headerHeight,
                bottom: bottomHeight
            }
        }).on('affix.bs.affix', function () { // before affix

            jQuery(this).css({
                /*'top': ,*/    // for fixed height
                'width': jQuery(this).outerWidth()  // variable widths
            });
        });
    }else{
        jQuery("#sideBarAffix").removeClass('affix-top');
    }
	if(jQuery('ul').hasClass('page-numbers')){
		jQuery(".page-numbers").addClass('pagination');
	}
});