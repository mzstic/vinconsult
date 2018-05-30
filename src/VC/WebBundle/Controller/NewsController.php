<?php

namespace VC\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Martin Patera <mzstic@gmail.com>
 *
 */
class NewsController extends Controller
{

	public static $news = [
		1 => [
			"title" => "Exkurze na stavbu Docklands v Hamburgu",
			"date" => "21. 08. 2017",
			"text" => "<p>Ve dnech 18.-19. 08. 2017 navštívili naši kolegové stavbu Docklands v Hamburgu, spojenou s návštěvou pobočky Inros Lackner Hamburg. Projekt úpravy nábřeží Docklands, zpracovávaný naší společností, je součástí rozsáhlé revitalizace původně průmyslové oblasti doků a skladů HAFENCITY Hamburg, která probíhá již více než 10 let.</p>
<p>Odpoledne jsme strávili okružní jízdou přístavem, prohlídkou kontejnerových překladišť i staré části \"Speicherstadt\", a večer zakončili na proslulé Reeperbahn.</p>
<p>Sobotní dopoledne bylo věnováno převážně sakrální architektuře města Lübeck a celou akci nejodvážnější jedinci zakončili kondičním tréninkovou koupelí v Ostsee.</p>",
			"photos" => [
				"aktualne/01_IL_Hamburg/01-VIN_CAT.jpg",
				"aktualne/01_IL_Hamburg/02-Bewehrungsplan.jpg",
				"aktualne/01_IL_Hamburg/03-Superstructure1.jpg",
				"aktualne/01_IL_Hamburg/04-Superstructure2.jpg",
				"aktualne/01_IL_Hamburg/05-ELP1.jpg",
				"aktualne/01_IL_Hamburg/06-Container_Terminal.jpg",
				"aktualne/01_IL_Hamburg/07-ELP2.jpg",
				"aktualne/01_IL_Hamburg/08-Speicherstadt.jpg",
				"aktualne/01_IL_Hamburg/09-Stahlbruecke.jpg",
				"aktualne/01_IL_Hamburg/10-Reeperbahn.jpg",
				"aktualne/01_IL_Hamburg/11-Music.jpg",
				"aktualne/01_IL_Hamburg/12-VIN_Luebeck.jpg",
				"aktualne/01_IL_Hamburg/13-Portal.jpg",
				"aktualne/01_IL_Hamburg/14-Ostsee.jpg",
			],
		],
		2 => [
			"title" => "Bytový dům Hadovitá před dokončením",
			"date" => "18. 05. 2018",
			"text" => "<p>Projekt bytového komplexu Hadovitá v Praze 4 Michli spěje k úspěšnému dokončení hrubé stavby. Výstavba dispozičně mimořádně komplikovaného objektu ve svahu byla bezproblémová, dokončení hrubé stavby se předpokládá do konce června 2018.</p>",
			"photos" => [
				"aktualne/02_Hadovita/01-Obj B,C_pohled do vnitrobloku (1).JPG",
				"aktualne/02_Hadovita/02-objA,B_pohled do vnitrobloku (1).JPG",
				"aktualne/02_Hadovita/03-ObjC_východní fasáda_rozestavěnost.JPG",
				"aktualne/02_Hadovita/04-ObjA a B_pohled do dvorany_rozestavěnost.JPG",
				"aktualne/02_Hadovita/05-ObjB_jižní fasáda_rozpracovanost.JPG",
				"aktualne/02_Hadovita/06-Severní pohled_rozestavěnost (1).JPG",
				"aktualne/02_Hadovita/07-Celkový pohled_rozestavěnost_vých fasády (2).JPG",
				"aktualne/02_Hadovita/08-Celkový pohled_západní fasády_rozestavěnost.JPG",
				"aktualne/02_Hadovita/09-ObjA,B,C_severní fasáda.JPG",
			],
		],
		3 => [
			"title" => "Stavba muzea čokolády v Čestlicích v plném tempu",
			"date" => "28. 05. 2018",
			"text" => "<p>Přestavba areálu bývalého autoservisu v Čestlicích na \"Muzeum čokolády\" konečně začíná nabírat tempo. Projekt vestavby a přístavby je velmi komplikovaný jak dispozičně, tak technologicky, jelikož nový charakter provozu je zásadně odlišný od původního. Oproti původním předpokladům bylo navíc nutno rekonstruovat celý odvodňovací systém, čímž stavba nabrala termínový skluz téměř dva měsíce.</p>
<p>Jednostupňový projekt pro belgického investora je m.j. zajímavý způsobem řízení stavby, který ignoruje aktuální trendy projektové přípravy. Během stavby se průběžně upravuje dispozice a koordinace profesí se upřesňuje bezprostředně před realizací, prostě \"francouzský styl\" stavění. Snad kdyby se trochu pozornosti věnovalo projektu, mohlo to být už hotové...</p>",
			"photos" => [
				"aktualne/03_Coko_Cestlice/01-83.jpg",
				"aktualne/03_Coko_Cestlice/02-36.jpg",
				"aktualne/03_Coko_Cestlice/03-48.jpg",
				"aktualne/03_Coko_Cestlice/04-28.jpg",
				"aktualne/03_Coko_Cestlice/05-29.jpg",
			],
		],
	];

	public function listAction()
	{
		return $this->render('VCWebBundle:News:list.html.twig', []);
	}

	public function detailAction($id)
	{
		return $this->render(
			'VCWebBundle:News:detail.html.twig',
			self::$news[$id]
		);
	}
}
