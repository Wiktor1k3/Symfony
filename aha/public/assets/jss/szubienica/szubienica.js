const przyslowiaPolskie = [
	"Co nagle, to po diable",
	"Baba z wozu, koniom lżej",
	"Gdzie kucharek sześć, tam nie ma co jeść",
	"Nie ma róży bez kolców",
	"Cicha woda brzegi rwie",
	"Bez pracy nie ma kołaczy",
	"Darowanemu koniowi w zęby się nie zagląda",
	"Grosz do grosza, a będzie kokosza",
	"Lepszy wróbel w garści niż gołąb na dachu",
	"Kto rano wstaje, temu Pan Bóg daje",
	"Nosił wilk razy kilka, ponieśli i wilka",
	"Kuj żelazo, póki gorące",
	"Zgoda buduje, niezgoda rujnuje",
	"Co ma wisieć, nie utonie",
	"Lepszy rydz niż nic",
	"Nie chwal dnia przed zachodem słońca",
	"W zdrowym ciele, zdrowy duch",
	"Kto pod kim dołki kopie, ten sam w nie wpada",
	"Dla chcącego nic trudnego",
	"Biednemu zawsze wiatr w oczy",
  ];

var haslo = przyslowiaPolskie[Math.floor(Math.random() * przyslowiaPolskie.length)];

haslo = haslo.toUpperCase();

var dlugosc = haslo.length;

var haslo1 = "";

var haslo2 = "";

var iloscBledow = 0;

const yes = new Audio('assets/audio/szubienica/yes.wav');

const no = new Audio('assets/audio/szubienica/no.wav');

var spacja = 28;

if(dlugosc>28)
{
	var koniec = false;

	while(koniec==false)
	{
		if(haslo.charAt(spacja)==" "){
			for(i=0; i<spacja; i++)
			{
				if( haslo.charAt(i) == " ") haslo1 = haslo1 + " ";
				else if(haslo.charAt(i) == ",")haslo1 = haslo1 + ",";
				else haslo1 = haslo1 + "-";
			}
			for(i=spacja; i<dlugosc; i++)
			{
				if( haslo.charAt(i) == " ") haslo2 = haslo2 + " ";
				else if(haslo.charAt(i) == ",")haslo2 = haslo2 + ",";
				else haslo2 = haslo2 + "-";
			}

			koniec = true;
		}
		else
		{
			spacja -= 1;
		}
	}
}	
else
{
	for(i=0; i<dlugosc; i++)
		{
			if( haslo.charAt(i) == " ") haslo1 = haslo1 + " ";
			else if(haslo.charAt(i) == ",")haslo1 = haslo1 + ",";
			else haslo1 = haslo1 + "-";
		}

}




function wypisz_haslo()
{
	if(dlugosc>28)
	{
		document.getElementById("plansza1").innerHTML = haslo1+"<br/>"+haslo2;
	}	
	else
	{
	document.getElementById("plansza1").innerHTML = haslo1;
	}
	
}

var litery = new Array(35);

litery[0] = "A";
litery[1] = "Ą";
litery[2] = "B";
litery[3] = "C";
litery[4] = "Ć";
litery[5] = "D";
litery[6] = "E";
litery[7] = "Ę";
litery[8] = "F";
litery[9] = "G";
litery[10] = "H";
litery[11] = "I";
litery[12] = "J";
litery[13] = "K";
litery[14] = "L";
litery[15] = "Ł";
litery[16] = "M";
litery[17] = "N";
litery[18] = "Ń";
litery[19] = "O";
litery[20] = "Ó";
litery[21] = "P";
litery[22] = "Q";
litery[23] = "R";
litery[24] = "S";
litery[25] = "Ś";
litery[26] = "T";
litery[27] = "U";
litery[28] = "V";
litery[29] = "W";
litery[30] = "X";
litery[31] = "Y";
litery[32] = "Z";
litery[33] = "Ż";
litery[34] = "Ź";

window.onload = start;

function start()
{
	var tresc_diva = "";

	for(i = 0; i<=34; i++)
	{
		var element = "lit"+i;

		if(i%7 == 0){
			tresc_diva = tresc_diva + '<div style="clear:both;"></div>'
		}
		tresc_diva = tresc_diva + '<div class = "litera" onclick="sprawdz('+i+')" id="'+element+'">'+litery[i]+'</div>'
		
	}

	document.getElementById("alfabet").innerHTML=tresc_diva;

	wypisz_haslo();
}

String.prototype.ustawZnak = function(miejsce, znak)
{
	if(miejsce>this.length-1){
		return this.toString();
	}
	else{
		return this.substr(0,miejsce)+znak+this.substr(miejsce+1); 
	}

}

function sprawdz(nr)
{

	var trafiona = false;

	if(dlugosc<28){
		for(i=0;i<dlugosc;i++){
			if(haslo.charAt(i)==litery[nr])
			{
				trafiona=true;
				haslo1=haslo1.ustawZnak(i,litery[nr]);
			}
		}
	}
	else{
		for(i=0;i<spacja;i++){
			if(haslo.charAt(i)==litery[nr])
			{
				trafiona=true;
				haslo1=haslo1.ustawZnak(i,litery[nr]);
			}
		}
		for(i=spacja;i<dlugosc;i++){
			if(haslo.charAt(i)==litery[nr])
			{
				trafiona=true;
				haslo2=haslo2.ustawZnak((i-(spacja)),litery[nr]);
			}
		}
	
	}


	if(trafiona == true){


		yes.play();

		var element = "lit"+nr;
		document.getElementById(element).style.background = "#003300";
		document.getElementById(element).style.color = "#00C000";
		document.getElementById(element).style.border = "3px solid #00C000";
		document.getElementById(element).style.cursor = "default";
		document.getElementById(element).setAttribute("onclick",";");


		wypisz_haslo();

	}
	else
	{

		no.play();

		var element = "lit"+nr;
		document.getElementById(element).style.background = "#330000";
		document.getElementById(element).style.color = "#C00000";
		document.getElementById(element).style.border = "3px solid #C00000";
		document.getElementById(element).style.cursor = "default";
		document.getElementById(element).setAttribute("onclick",";");

		iloscBledow++;
		document.getElementById("szubienica").innerHTML='<img src="/images/szubienica/s'+iloscBledow+'.jpg" alt=""/>';

	}

	if(haslo==haslo1+haslo2)
	{
		document.getElementById("alfabet").innerHTML="Tak jest! Podano prawidłowe hasło:"+'<br/>'+haslo+'<br/><br/><br/><span class="reset" onclick="location.reload()">JESZCZE RAZ!</span>';
	}
	else if(iloscBledow>=9)
		{
			document.getElementById("alfabet").innerHTML="Niestety, przegrałeś! Prawidłowe hasło to:"+'<br/>'+haslo+'<br/><br/><br/><span class="resetdead" onclick="location.reload()">JESZCZE RAZ!</span>';
		}

}