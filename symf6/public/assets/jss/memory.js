
var cards1 = ["ciri.png", "geralt.png", "jaskier.png", "iorweth.png", "triss.png", "yen.png"];

var cards = [];

function randomImg()
{
	cards = []

	var ilosc = 0;

	while(ilosc<cards1.length*2){
		let random = cards1[Math.floor(Math.random() * cards1.length)];
		var ile=0;
		for(let j=0;j<=cards1.length*2;j++){
			if(cards[j]===random){
				ile++;
			}
		}
		if(ile<2)
		{
			cards.push(random);
			ilosc++;
		}
	}
}

window.onload = randomImg;

var handle = [];

for (let i = 0; i < cards1.length*2; i++) {

	handle.push(document.getElementById('c'+i));

  	handle[i].addEventListener('click', function() { revealcard(i); });
}




var oneVisible = false;

var turnCounter = 0;

var odkryta;

var lock = false;

var pairsLeft = 6;

function revealcard(nr)
{
	var opacityValue = $('#c'+nr).css('opacity');
	//alert(opacityValue);

	if(opacityValue !=0 && lock==false)
	{
		//alert(nr);


		var obraz = "url(/images/gwent/"+cards[nr]+")";
		$('#c'+nr).css('background-image',obraz);
		$('#c'+nr).removeClass('card');
		$('#c'+nr).addClass('cardA');

		if(oneVisible == false)
		{
			//first card

			oneVisible = true; 
			odkryta = nr;
		}
		else
		{
			//second card

			//alert(odkryta);
			if(nr!=odkryta)
			{
				lock = true;

				if(cards[nr]==cards[odkryta]){
					setTimeout(function() { hide2Cards(nr, odkryta)}, 750 );
					
				}
				else
				{
					setTimeout(function() { restore2Cards(nr, odkryta)}, 1000 );
				}


				turnCounter++;
				$('.score').html('Turn counter: '+turnCounter);
				oneVisible = false;
			}

		}
	}

	

}

function hide2Cards(nr1, nr2)
{
	$('#c'+nr1).css('opacity','0');
	$('#c'+nr2).css('opacity','0');
	lock = false;

	pairsLeft--;

	if(pairsLeft==0){
		$('.board').html('<h1>You win!<br/>Done in '+turnCounter+' turns <br/><span onclick="window.location.reload()">JESZCZE RAZ!</span>');
		$('span').css('cursor','pointer');
		$('span').css('color','white');
	}
}

function restore2Cards(nr1, nr2)
{
	$('#c'+nr1).css('background-image', 'url("/images/gwent/karta.png")' );
	$('#c'+nr1).removeClass('card');
	$('#c'+nr1).addClass('cardA');

	$('#c'+nr2).css('background-image', 'url("/images/gwent/karta.png")' );
	$('#c'+nr2).removeClass('card');
	$('#c'+nr2).addClass('cardA');
	lock = false;
}