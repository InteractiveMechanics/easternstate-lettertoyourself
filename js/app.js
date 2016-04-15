var dotIndex = 0;
$(document).ready(function(){
	$("#MessagePage textarea").keyup(function(){
		var count = $(this).val().length;
		$("#MessagePage .count").text((500 - count) + " characters remaining");
		
		if(count > 0) {
			if($("#MessagePage .next-button a").hasClass('faded')) {
				$("#MessagePage .next-button a").removeClass('faded');
			}
		}
		
		if(count == 0) {
			if(!$("#MessagePage .next-button a").hasClass('faded')) {
				$("#MessagePage .next-button a").addClass('faded');
			}
		}
	});

	$("#Message2Page textarea").keyup(function(){
		var count = $(this).val().length;
		$("#Message2Page .count").text((500 - count) + " characters remaining");
		
		if(count > 0) {
			if($("#Message2Page .next-button a").hasClass('faded')) {
				$("#Message2Page .next-button a").removeClass('faded');
			}
		}
		
		if(count == 0) {
			if(!$("#Message2Page .next-button a").hasClass('faded')) {
				$("#Message2Page .next-button a").addClass('faded');
			}
		}
	});

	$("#Message3Page textarea").keyup(function(){
		var count = $(this).val().length;
		$("#Message3Page .count").text((500 - count) + " characters remaining");
		
		if(count > 0) {
			if($("#Message3Page .next-button a").hasClass('faded')) {
				$("#Message3Page .next-button a").removeClass('faded');
			}
		}
		
		if(count == 0) {
			if(!$("#Message3Page .next-button a").hasClass('faded')) {
				$("#Message3Page .next-button a").addClass('faded');
			}
		}
	});

    setSendDates()

	$('.getting-started').click(function(){
		$('#modal-link').removeClass('faded');
		$("a#modal-link").attr("href", "#open-modal")
		$('#StartPage').addClass('animated bounceOutLeft');
		
		$('.dots').fadeIn(1200);
	});
	
	$('.back-button').click(function(){
		var divid = $(this).data('divid');
		$('#' + divid).removeClass('animated bounceOutLeft');
		$('#' + divid).addClass('animated bounceInLeft');
		
		if(divid == 'Options2Page') {
			$('.bg-paper').removeClass('before-removal');
			$('.bg-paper').removeClass('after-removal');
		}

		if(divid == 'MessagePage') {
			console.log('focus');
			$('#MessagePage textarea').focus();
		}

		if(divid == 'Message2Page') {
			console.log('focus');
			$('#Message2Page textarea').focus();
		}

		if(divid == 'Message3Page') {
			console.log('focus');
			$('#Message3Page textarea').focus();
		}
	});
	
	$('.next-button').click(function(){
		var divid = $(this).data('divid');
		
		if(validateInputs(divid)) {
			$('#' + divid).addClass('animated bounceOutLeft');
			
			/*$('.dots ul li').removeClass('active');
			$('.dots ul li:eq(' + dotIndex + ')').addClass('active');
			dotIndex += 1;*/
			
			if(divid == 'Options2Page') {
				$('.bg-paper').addClass('before-removal');
				$('.bg-paper').addClass('after-removal');
			}

			if(divid == 'PickPostcardPage') {
				console.log('focus');
				$('#MessagePage textarea').focus();
			}

			if(divid == 'MessagePage') {
				console.log('focus');
				$('#Message2Page textarea').focus();
			}

			if(divid == 'Message2Page') {
				console.log('focus');
				$('#Message3Page textarea').focus();
			}
			
			if(divid == 'CompletePage') {
				//$('#PostcardPage').addClass('animated slideInDown rotate-card');
				
				$('.dots').hide();
				$('.error-email').css("display","none");
				$('.error-first-name').css("display","none");
			
				$('#CompletePage').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
					$('#PostcardPage').addClass('animated slideInDown show rotate-card');
					$('#PostcardPage').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
						$('#postage-stamp').addClass('animated fadeInDown show rotate-card');
						
						setTimeout(function(){
							document.getElementById('complete-link').click();
							$("a#modal-link").attr("href", "#close")
						}, 2500);
					});
				});
			}
			
		}
	});
	
	$('.post-cards ul li').click(function() {

        if ($(this).closest('li').hasClass('selected')){
            $(this).closest('li').removeClass('selected');
        } else {
            var selected = $('ul li.selected');
            if (selected.length < 3) {
                $(this).closest('li').addClass('selected');
            }
        }
	});
	
	$('.checkbox').click(function(){
		if($(this).hasClass('unselected')) {
			$(this).removeClass('unselected');
			$(this).addClass('selected');
		} else {
			$(this).removeClass('selected');
			$(this).addClass('unselected');
		}
	});
});

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateInputs(divid) {
	if(divid == 'MessagePage') {
		var not_continue = $('#MessagePage textarea').val().length > 0;
		
		alert(not_continue);
		if(not_continue) {
			$('#MessagePage textarea').addClass('missing-text');
			
		
		}
	}

	if(divid == 'Message2Page') {
		console.log('focus');
		return $('#Message2Page textarea').val().length > 0;;
	}

	if(divid == 'Message3Page') {
		console.log('focus');
		return $('#Message3Page textarea').val().length > 0;
	}
	
	if(divid == "CompletePage") {
		var email_boolean = validateEmail($('#email').val());
		
		if(!email_boolean) {
			$('.error-email').css("display","block");
		} else {
			$('.error-email').css("display","none");

		}
		
		var first_boolean = $('#firstname').val().length > 0;
		
		if(!first_boolean) {
			$('.error-first-name').css("display","block");
		} else {
			$('.error-first-name').css("display","none");
		}
		
		return email_boolean && first_boolean;
	}
	return true;
}

function setSendDates(){
    var monthname = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    var d = new Date();

    $('#first-date').text(monthname[d.getMonth() + 2] + ' ' + d.getDate() + ', ' + d.getFullYear());
    $('#second-date').text(monthname[d.getMonth()] + ' ' + d.getDate() + ', ' + (d.getFullYear() + 1));
    $('#third-date').text(monthname[d.getMonth()] + ' ' + d.getDate() + ', ' + (d.getFullYear() + 3));
}
