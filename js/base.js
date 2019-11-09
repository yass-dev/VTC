$(document).ready(function()
{
	var exScroll = 0;
	var currentSlideIMG = 0;
	var lastImageSlide = 's3';

	$('.headerLink').each(function()
	{
		if(!$(this).hasClass('active'))
			$(this).css({color: 'white'});
		else
			$(this).css({color: 'rgb(233, 186, 27)'});
	});

	$('.datepicker').attr('value', getDate());

	$('.clockpicker').clockpicker();
	var input = $('.datepicker');
	input.pickmeup(
	{
		position: 'up',
		language: 'fr',
		before_show: function()
		{
			input.pickmeup('set_date', input.val(), true);
		},
		change: function(formated)
		{
			input.val(formated);
		}
	});

	window.setTimeout(function()
	{
		$('#buttonHiddenPopupEmail').click();
	}, 15000);

	/*$('#submitEmail').on('click', function()
	{
		console.log("Send " + $('#emailInput').val());

		$.post('http://licornevtc.000webhostapp.com/newClient.php', {email : $('#emailInput').val()}, function(data)
		{
			alert(data);
		});
	});*/

	$(window).scroll(function()
	{
		//console.log($(window).scrollTop());
	});

	$('#reserverAccueilButton').on('click', function()
	{
		scrollTo('#choixTrajetDiv');
	});

	
	$('.headerLink').click(function()
	{
		scrollTo($(this).attr('rel'));
		$('.headerLink.active').css({color: 'white'});
		$('.headerLink.active').removeClass('active');
		$(this).addClass('active');
	});

	$('.tarifBlock').mouseenter(function()
	{
		$(this).css(
		{
			'box-shadow': '0px 0px 60px rgba( 0, 0, 0, 0.3 )'
		})
	});

	$('.tarifBlock').mouseleave(function()
	{
		$(this).css(
		{
			'box-shadow': '0px 0px 0px rgba( 0, 0, 0, 0 )'
		})
	});

	$('.reserverButton').mouseenter(function()
	{
		$(this).animate(
		{
			'border-color' : '#eaeaea',
			'background-color' : '#c0991a',
			'color' : 'white'
		}, 700);
	});
	$('.reserverButton').mouseleave(function()
	{
		$(this).animate(
		{
			'border-color' : '#c0991a',
			'background-color' : '#eaeaea',
			'color' : 'black'
		}, 500);
	});

	$('#sendToWebMasterButton').mouseenter(function()
	{
		$(this).animate(
		{
			'background-color' : 'white',
			'color' : 'black'
		}, 350);
	});
	$('#sendToWebMasterButton').mouseleave(function()
	{
		$(this).animate(
		{
			'background-color' : 'black',
			'color' : 'white'
		}, 350);
	});

	$('#formContactMe').on('submit', function(e)
	{
		e.preventDefault();
		$.post('contactMe.php', {name: $('#contactMe#name').val(), email: $('#contactMe#email').val(), message:$('#contactMe#message').val()});
	});
	
	$('#reserverFormButton').css('cursor', 'pointer');

	$('#reserverFormButton').mouseenter(function()
	{
		$(this).animate(
		{
			'border-color' : '#eaeaea',
			'background-color' : '#c0991a',
			'color' : 'white'
		}, 500);
	});
	$('#reserverFormButton').mouseleave(function()
	{
		$(this).animate(
		{
			'border-color' : '#c0991a',
			'background-color' : '#eaeaea',
			'color' : 'black'
		}, 500);
	});
	
	$('#reserverFormButton').on('click', function()
    {
        var startAddress = $('#startAddress').val();
        var endAddress = $('#endAddress').val();
        var distance;
    
        $.post('getLatLong.php', {startAddress : startAddress, endAddress : endAddress}, function(data)
        {
            var response = JSON.parse(data);
            distance = parseFloat(parseInt(response.rows[0].elements[0].distance.text.split(' ')[0]).toFixed(2) * 1.60934);
            
            if($('#trajetType').val() == "Aller simple")
            {
                if(distance < 10)
                {
                    alert("Vous ne pouvez pas réserver pour un trajet inférieur à 10km !");
                }
                else
                {
                    alert("Nous estimons que le prix sera approximativement de " + parseFloat(distance*1.60).toFixed(2) + "€.");
                }
            }
            else if($('#trajetType').val() == "Aller/Retour")
            {
                if(distance < 15)
                {
                    alert("Vous ne pouvez pas réserver pour un trajet inférieur à 10km !");
                }
                else
                {
                    alert("Nous estimons que le prix sera approximativement de " + parseFloat(2*distance*0.88).toFixed(2) + "€.");
                }
            }
            
            console.log(distance);    
        });
    });
    
    $('#submitReservation').on('click', function()
    {
       $.post('reservation.php', {phone: $('#phoneInput').val(), start: $('#startAddress').val(), end: $('#endAddress').val(), date: $('.datepicker').val(), heure: $('.clockpicker input').val(), passagers: $('#passagersSelect').val(), bagages: $('#bagageSelect').val(), type: $('#trajetType').val()}, function(data)
       {
            alert(data);
       }) ;
    });
});

var rad = function(x)
{
  return x * Math.PI / 180;
};

var getDistance = function(lat1, lon1, lat2, lon2)
{
  var R = 6378137; // Earth’s mean radius in meter
  var dLat = rad(lat2 - lat1);
  var dLong = rad(lon2 - lon1);
  var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(rad(lat1)) * Math.cos(rad(lat2)) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  var d = R * c;
  return d; // returns the distance in meter
};

function getDate()
{
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1;
	var yyyy = today.getFullYear();

	if(dd<10)
	{
	    dd = '0'+dd
	} 

	if(mm<10)
	{
	    mm = '0'+mm
	} 

	today = dd + '/' + mm + '/' + yyyy;
	return today;
}

function scrollTo(id)
{
	$('html, body').animate(
	{
		scrollTop : $(id).offset().top - $('.headerBarNav').height()
	}, 1500);
}