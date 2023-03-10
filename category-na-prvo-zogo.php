<?php
/*
Template Name: Stran za kategorije
 */
?>

<?php get_header('home'); ?>

<!-- category.php -->
<!-- LOOP -->
<?php
global $post, $wpdb, $my_query, $paged, $wp_query, $request; // brez tega ne dela get_post_meta
global $myNumberOfPosts;
$myNumberOfPosts = 20;

$args = array(
	'posts_per_page' => $myNumberOfPosts,
	'posts_per_archive_page' => $myNumberOfPosts,
	'paged' => get_query_var('paged'),
	'cat' => get_query_var('cat'),
	'post_type' => $wp_query->query_vars['post_type']
);


$myCoverStoriesNum = 999; // to pomeni, da bdo praktično vsi prispevki, kadar jih prikazujemo na arhivski strani, eden pod drugim, tj. nikoli ne bodo po denimo štirje na vrstico (kot bi bili na prvi strani)
$myCurrentLoop = new WP_Query($args);

if ($myCurrentLoop->have_posts()) :
	$catDesc = category_description(get_query_var('cat'));
?>
<!--
<div class="mobile-override top-stripe-category light-blue-background fullw">
	<div class="text-outer minimal-padding">
		<p class="one-two font-size-2 bold">Arhiv prispevkov v rubriki <?php echo get_cat_name(get_query_var('cat')); ?> (<?php echo $myCurrentLoop->found_posts; ?>)</p>
	</div>
</div>-->
<div class="large-top-padding stretch-full-width-not gray-background-not large-bottom-padding two-three center center-margins leading-tight bold display-font font-size-5">
<h1 class="bold">Na prvo žogo</h1>
</div>


<?php if(!empty($catDesc)) { ?>
<div class='stretch-full-width gray-background gray-4-not no-indent-not large-top-padding large-bottom-padding' style="/*max-width: 33em; margin-left: auto; margin-right: auto;*/">
	<div class="two-three-not light font-size-2 leading-loose medium-top-padding medium-bottom-padding medium-left-padding medium-right-padding white-background center-margins">
		<div style="max-width: 33em; margin: auto">
			<?php echo $catDesc; ?>
			<p class="center serif no-indent small-top-margin"><em>Mojca Pišek</em></p>
			<div class="large-top-margin this-author-photo one-five center circle center-margins" style="margin-bottom: 2em">
				<div class="cover ratio-1-1" style="background-image: url(http://www.ludliteratura.si/wp-content/uploads/2014/08/Mojca-Pisek-140x140.jpg)"></div>
			</div>
		</div>
	</div>
</div>

<!-- begin chart container -->
<style>
#charts {
	text-align: center;
}
#chartContainer {
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	justify-content: space-around;
}
#charts .button {
	background-color: #2578D8;
	border-radius: 5px;
	padding: 5px;
	display: inline-block;
	color: #eee;
	cursor: pointer;
	font-family: sans-serif;
	cursor: pointer;
	text-indent: 0;
}

#charts .createChartLink {
	display: inline-block;
	background: #eee;
	padding: 2px 1em;
	margin: 0.5em 1em 0 0;
	border-radius: 999999999px;
	font-size: 0.75em;
	font-family: sans-serif;
	color: darkgray;
	cursor: pointer;
}

#charts .createChartLink:hover,
#charts .createChartLink.shown {
	background-color: #2578D8;
	color: #eee;
}
#charts .canvas-wrap.single-chart {
	width: 40%;
	min-height: 50vh;
}
#charts .canvas-wrap.multiple-charts {
	width: 30%;
	min-height: 30vh;
	margin-top: 5em;
}

#roles .button {
	background-color: transparent;
	border: 1px solid;
	color: black;
}
#roles .button:hover,
#roles .button.shown {
	background-color: #2578D8;
	color: #eee;
}

@media only screen and (max-width: 768px) {

#charts .canvas-wrap.single-chart {
	width: 75%;
	min-height: 67vh;
}
#charts .canvas-wrap.multiple-charts {
	width: 50%;
	min-height: 50vh;
	margin-top: 5em;
}
}
@media only screen and (max-width: 500px) {

#charts .canvas-wrap.single-chart {
	width: 100%;
	min-height: 67vh;
}
#charts .canvas-wrap.multiple-charts {
	width: 50%;
	min-height: 50vh;
	margin-top: 5em;
}
}


</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>


<script type="text/javascript">
$( document ).ready(function() {
var chartContainer = $('#chartContainer');

backgroundColors = ["#263238", "#37474F", "#455A64", "#546E7A", "#607D8B", "#78909C", "#90A4AE", "#B0BEC5", "#CFD8DC", "#ECEFF1"];
var myDataBureaucrats = [
	{
		type: 'doughnut',
		data: {
			labels: [ "administracija", "korespondenca, sestanki", "izobraževanje", "kulturne prireditve" ],
			datasets: [{
				label: "Povprečen delovnik",
				data: [6, 5, 1, 1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Povprečen delovnik"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["družbena odgovornost", "izziv, zanimivost", "izobrazba", "naključje", "poklicanost", "socialna varnost"],
			datasets: [{
				label: "Čemu ta poklic?",
				data: [3, 3, 2, 2, 2, 1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Čemu ta poklic?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["družbena odgovornost", "koristnost", "uspeh"],
			datasets: [{
				label: "Kaj je motivacija pri delu?",
				data: [4,2,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kaj te pri delu motivira?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["birokracija", "nesporazumi, nerazumljenost", "kulturna politika", "neprofesionalnost", "pomanjkanje sredstev", "zakonodaja", "drugo", "konflikti znotraj kulture", "stres"],
			datasets: [{
				label: "Kateri problemi se pojavljajo ob delu?",
				data: [3,3,2,2,2,2,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kateri problemi se pojavljajo ob delu?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["dialog", "kulturna politika", "zakonodaja", "družbena odgovornost", "izobraževanje", "povezovanje", "zaposlovanje"],
			datasets: [{
				label: "Kako rešiti probleme ob delu?",
				data: [3,3,2,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kako rešiti probleme ob delu?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["izgorelost", "nerazumljenost", "birokracija", "neprofesionalnost", "odsotnost sprememb", "slabi odnosi"],
			datasets: [{
				label: "Česa se pri delu bojiš?",
				data: [2,2,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Česa se pri delu bojiš?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["se profesionalno ukvarjajo s kulturo", "se ukvarja s kulturo", "ima afiniteto do kulture", "način življenja"],
			datasets: [{
				label: "Kdo so kulturniki?",
				data: [3,3,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kdo so kulturniki?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["kulturniki", "ni jasno", "stanje duha", "ustvarjalci", "vir tolažbe", "vizija"],
			datasets: [{
				label: "Kdo so umetniki?",
				data: [3,1,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kdo so umetniki?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["odrske umetnosti", "glasba", "film", "literatura", "vizualne umetnosti"],
			datasets: [{
				label: "Katerih kulturnih prireditev se udeležuješ?",
				data: [6,5,4,4,4],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Katerih kulturnih prireditev se udeležuješ?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["družbotvornost", "osebnostna rast", "identiteta", "narodotvornost"],
			datasets: [{
				label: "Čemu kultura?",
				data: [5,4,3,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Čemu kultura?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["kulturna politika", "javni interes", "majhnost trga", "financiranje"],
			datasets: [{
				label: "Čemu ministrstvo za kulturo?",
				data: [4,2,2,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Čemu ministrstvo za kulturo?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["politični ugled", "poznavanje področja", "razumevanje potreb", "dialog, povezovanje", "afiniteta do kulture, kulturnik", "odločnost", "politični vpliv", "širina duha", "vizija"],
			datasets: [{
				label: "Idealen minister za kulturo",
				data: [3,3,3,2,1,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Idealen minister za kulturo"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["več sredstev", "dialog", "razumevanje potreb", "ureditev statusa", "enakopravnost področij", "poudarek na kvaliteti", "tržna usmerjenost"],
			datasets: [{
				label: "Idealna kulturna reforma",
				data: [4,2,2,2,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Idealna kulturna reforma"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["konflikti interesov", "jalovi", "neutemeljeni", "nujni"],
			datasets: [{
				label: "Konflikti z ministrstvom za kulturo",
				data: [4,3,2,2],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Konflikti z ministrstvom za kulturo"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["mogoče", "ne", "ja"],
			datasets: [{
				label: "Je pritoževanja preveč?",
				data: [3,3,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Je pritoževanja preveč?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["strožji kriteriji", "ureditev statusa", "več sredstev", "vizija", "zaposlovanje", "boljša razporeditev sredstev", "dialog"],
			datasets: [{
				label: "Katero spremembo bi sam najprej uvedel?",
				data: [2,2,2,2,2,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Katero spremembo bi sam najprej uvedel?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["zaposlovanje", "drugo", "manj birokracije", "profesionalizacija", "dialog"],
			datasets: [{
				label: "Kako bi s svojim delom izboljšal položaj v kulturi?",
				data: [3,2,2,2,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kako bi s svojim delom izboljšal položaj v kulturi?"}}
	}
]

backgroundColors = ["#BF360C", "#D84315", "#E64A19", "#F4511E", "#FF5722", "#FF7043", "#FF8A65", "#FFAB91", "#FFCCBC", "#FBE9E7"];
var myDataProducers = [
	{
		type: 'doughnut',
		data: {
			labels: [ "korespondenca, sestanki", "administracija", "ustvarjanje, produkcija", "izobraževanje", "kulturne prireditve" ],
			datasets: [{
				label: "Povprečen delovnik",
				data: [5,2,2,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Povprečen delovnik"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["delo z ljudmi", "izkušnje", "izziv, zanimivost", "naključje", "poklicanost", "družbena odgovornost", "izobrazba"],
			datasets: [{
				label: "Čemu ta poklic?",
				data: [2,2,2,2,2,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Čemu ta poklic?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["delo z ljudmi", "družbena odgovornost", "potovanje", "uspeh", "ustvarjalnost", "zanimivost"],
			datasets: [{
				label: "Kaj je motivacija pri delu?",
				data: [2,2,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kaj te pri delu motivira?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["pomanjkanje sredstev", "drugo", "kulturna politika", "neprofesionalnost", "nesporazumi, nerazumljenost", "zakonodaja"],
			datasets: [{
				label: "Kateri problemi se pojavljajo ob delu?",
				data: [4,1,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kateri problemi se pojavljajo ob delu?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["kulturna politika", "več sredstev", "povezovanje"],
			datasets: [{
				label: "Kako rešiti probleme ob delu?",
				data: [3,2,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kako rešiti probleme ob delu?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["birokracija", "nerazumljenost", "pomanjkanja sredstev", "pomanjkanje sredstev"],
			datasets: [{
				label: "Česa se pri delu bojiš?",
				data: [1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Česa se pri delu bojiš?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["se profesionalno ukvarjajo s kulturo", "se ukvarja s kulturo", "ima afiniteto do kulture"],
			datasets: [{
				label: "Kdo so kulturniki?",
				data: [5,2,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kdo so kulturniki?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["ustvarjalci", "kulturniki", "stanje duha", "vizija"],
			datasets: [{
				label: "Kdo so umetniki?",
				data: [3,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kdo so umetniki?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["odrske umetnosti", "vizualne umetnosti", "glasba", "festivali", "film", "literatura"],
			datasets: [{
				label: "Katerih kulturnih prireditev se udeležuješ?",
				data: [5,5,4,2,2,2],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Katerih kulturnih prireditev se udeležuješ?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["družbotvornost", "identiteta", "osebnostna rast"],
			datasets: [{
				label: "Čemu kultura?",
				data: [3,2,2],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Čemu kultura?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["kulturna politika", "financiranje", "javni interes", "ne potrebujemo"],
			datasets: [{
				label: "Čemu ministrstvo za kulturo?",
				data: [4,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Čemu ministrstvo za kulturo?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["poznavanje področja", "odločnost", "afiniteta do kulture, kulturnik", "politični ugled", "razumevanje potreb", "dialog, povezovanje", "drugo", "vizija"],
			datasets: [{
				label: "Idealen minister za kulturo",
				data: [4,3,2,2,2,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Idealen minister za kulturo"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["dialog", "razumevanje potreb", "več sredstev", "vizija"],
			datasets: [{
				label: "Idealna kulturna reforma",
				data: [1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Idealna kulturna reforma"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["jalovi", "nujni", "konflikti interesov", "škodljivi"],
			datasets: [{
				label: "Konflikti z ministrstvom za kulturo",
				data: [3,3,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Konflikti z ministrstvom za kulturo"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["ne", "mogoče"],
			datasets: [{
				label: "Je pritoževanja preveč?",
				data: [6,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Je pritoževanja preveč?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["vizija", "drugo", "kulturni evro", "več sredstev", "zaposlovanje"],
			datasets: [{
				label: "Katero spremembo bi sam najprej uvedel?",
				data: [2,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Katero spremembo bi sam najprej uvedel?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["izobraževanje", "več sredstev", "dialog", "manj birokracije", "profesionalizacija", "ureditev statusa", "več časa", "zaposlovanje"],
			datasets: [{
				label: "Kako bi s svojim delom izboljšal položaj v kulturi?",
				data: [3,2,1,1,1,1,1, 1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kako bi s svojim delom izboljšal položaj v kulturi?"}}
	}
];

backgroundColors = [ "#1B5E20", "#2E7D32", "#388E3C", "#43A047", "#4CAF50", "#66BB6A", "#81C784", "#A5D6A7", "#C8E6C9", "#E8F5E9"];
var myDataArtists = [
	{
		type: 'doughnut',
		data: {
			labels: [ "administracija", "ustvarjanje, produkcija", "korespondenca, sestanki", "gospodinjstvo", "pot" ],
			datasets: [{
				label: "Povprečen delovnik",
				data: [4,4,3,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Povprečen delovnik"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["izkušnje", "naključje", "družbena odgovornost", "poklicanost", "socialna varnost"],
			datasets: [{
				label: "Čemu ta poklic?",
				data: [3,3,2,2,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Čemu ta poklic?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["ustvarjalnost", "svoboda", "delo z ljudmi", "osebnostna rast", "uspeh", "zanimivost"],
			datasets: [{
				label: "Kaj je motivacija pri delu?",
				data: [3,2,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kaj te pri delu motivira?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["birokracija", "neprofesionalnost", "pomanjkanje sredstev", "nesporazumi, nerazumljenost", "pomanjkanje časa", "konflikti znotraj kulture"],
			datasets: [{
				label: "Kateri problemi se pojavljajo ob delu?",
				data: [4,4,4,2,2,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kateri problemi se pojavljajo ob delu?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["kulturna politika", "profesionalizacija", "dialog", "več časa", "več sredstev", "zakonodaja", "zaposlovanje"],
			datasets: [{
				label: "Kako rešiti probleme ob delu?",
				data: [4,3,1,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kako rešiti probleme ob delu?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["birokracija", "izgorelost", "nerazumljenost", "odsotnost sprememb", "administracija"],
			datasets: [{
				label: "Česa se pri delu bojiš?",
				data: [3,2,2,2,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Česa se pri delu bojiš?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["se profesionalno ukvarjajo s kulturo", "se ukvarja s kulturo", "stanje duha"],
			datasets: [{
				label: "Kdo so kulturniki?",
				data: [3,2,2],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kdo so kulturniki?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["ustvarjalci", "vizija", "družbeni vpliv", "nimajo nič izgubiti", "stanje duha"],
			datasets: [{
				label: "Kdo so umetniki?",
				data: [3,2,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kdo so umetniki?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["film", "literatura", "odrske umetnosti", "glasba", "vizualne umetnosti"],
			datasets: [{
				label: "Katerih kulturnih prireditev se udeležuješ?",
				data: [4,4,4,3,2],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Katerih kulturnih prireditev se udeležuješ?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["družbotvornost", "osebnostna rast", "profitabilnost"],
			datasets: [{
				label: "Čemu kultura?",
				data: [6,3,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Čemu kultura?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["majhnost trga", "financiranje", "javni interes", "kulturna politika", "ohranjanje kulturne dediščine"],
			datasets: [{
				label: "Čemu ministrstvo za kulturo?",
				data: [3,2,2,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Čemu ministrstvo za kulturo?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["razumevanje potreb", "afiniteta do kulture, kulturnik", "širina duha", "dialog, povezovanje", "odločnost", "vizija", "drugo", "politični ugled", "politični vpliv", "poznavanje področja"],
			datasets: [{
				label: "Idealen minister za kulturo",
				data: [5,3,3,2,2,2,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Idealen minister za kulturo"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["poudarek na kvaliteti", "razumevanje potreb", "ureditev statusa", "enakopravnost področij", "povezovanje", "več svobode"],
			datasets: [{
				label: "Idealna kulturna reforma",
				data: [3,2,2,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Idealna kulturna reforma"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["jalovi", "konflikti interesov", "neutemeljeni", "nujni"],
			datasets: [{
				label: "Konflikti z ministrstvom za kulturo",
				data: [6,2,2,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Konflikti z ministrstvom za kulturo"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["ne", "mogoče", "ja"],
			datasets: [{
				label: "Je pritoževanja preveč?",
				data: [6,4,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Je pritoževanja preveč?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["ureditev statusa", "boljša razporeditev sredstev", "več sredstev", "drugo", "ureditev trga"],
			datasets: [{
				label: "Katero spremembo bi sam najprej uvedel?",
				data: [3,2,2,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Katero spremembo bi sam najprej uvedel?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["več sredstev", "boljša razporeditev sredstev", "drugo", "manj birokracije", "profesionalizacija"],
			datasets: [{
				label: "Kako bi s svojim delom izboljšal položaj v kulturi?",
				data: [2,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kako bi s svojim delom izboljšal položaj v kulturi?"}}
	}
]

backgroundColors = ["#E91E63", "#2196F3", "#9C27B0", "#00BCD4", "#673AB7", "#FFC107", "#FFCA28", "#FFD54F", "#FFE082", "#FFECB3"];
var myDataCopy = [
	{
		type: 'doughnut',
		data: {
			labels: [ "korespondenca, sestanki", "administracija", "ustvarjanje, produkcija", "izobraževanje", "kulturne prireditve", "gospodinjstvo", "pot" ],
			datasets: [{
				label: "Povprečen delovnik",
				data: [13, 12, 6, 2, 2, 1, 1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Povprečen delovnik"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["naključje", "družbena odgovornost", "poklicanost", "izkušnje", "izziv, zanimivost", "izobrazba", "delo z ljudmi", "socialna varnost"],
			datasets: [{
				label: "Čemu ta poklic?",
				data: [7, 6, 6, 5, 5, 3, 2, 2],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Čemu ta poklic?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["družbena odgovornost", "ustvarjalnost", "delo z ljudmi", "uspeh", "koristnost", "svoboda", "zanimivost", "osebnostna rast", "potovanje"],
			datasets: [{
				label: "Kaj je motivacija pri delu?",
				data: [6, 4, 3, 3, 2, 2, 2, 1, 1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kaj te pri delu motivira?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["pomanjkanje sredstev", "birokracija", "neprofesionalnost", "nesporazumi, nerazumljenost", "kulturna politika", "zakonodaja", "drugo", "konflikti znotraj kulture", "pomanjkanje časa", "stres"],
			datasets: [{
				label: "Kateri problemi se pojavljajo ob delu?",
				data: [10,7,7,6,5,5,2,2,2,2],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kateri problemi se pojavljajo ob delu?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["kulturna politika", "dialog", "profesionalizacija", "več sredstev", "zakonodaja", "povezovanje", "zaposlovanje", "družbena odgovornost", "izobraževanje", "več časa"],
			datasets: [{
				label: "Kako rešiti probleme ob delu?",
				data: [10,4,3,3,3,2,2,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kako rešiti probleme ob delu?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["birokracija", "nerazumljenost", "izgorelost", "odsotnost sprememb", "administracija", "neprofesionalnost", "pomanjkanja sredstev", "pomanjkanje sredstev", "slabi odnosi"],
			datasets: [{
				label: "Česa se pri delu bojiš?",
				data: [5,5,4,3,1,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Česa se pri delu bojiš?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["se profesionalno ukvarjajo s kulturo", "se ukvarja s kulturo", "ima afiniteto do kulture", "stanje duha", "način življenja"],
			datasets: [{
				label: "Kdo so kulturniki?",
				data: [11,7,2,2,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kdo so kulturniki?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["ustvarjalci", "kulturniki", "vizija", "stanje duha", "družbeni vpliv", "ni jasno", "nimajo nič izgubiti", "vir tolažbe"],
			datasets: [{
				label: "Kdo so umetniki?",
				data: [7,4,4,3,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kdo so umetniki?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["odrske umetnosti", "glasba", "vizualne umetnosti", "film", "literatura", "festivali"],
			datasets: [{
				label: "Katerih kulturnih prireditev se udeležuješ?",
				data: [15,12,11,10,10,2],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Katerih kulturnih prireditev se udeležuješ?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["družbotvornost", "osebnostna rast", "identiteta", "narodotvornost", "profitabilnost"],
			datasets: [{
				label: "Čemu kultura?",
				data: [14,8,4,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Čemu kultura?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["kulturna politika", "javni interes", "majhnost trga", "financiranje", "ne potrebujemo", "ohranjanje kulturne dediščine"],
			datasets: [{
				label: "Čemu ministrstvo za kulturo?",
				data: [9,5,5,4,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Čemu ministrstvo za kulturo?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["razumevanje potreb", "poznavanje področja", "afiniteta do kulture, kulturnik", "odločnost", "politični ugled", "dialog, povezovanje", "širina duha", "vizija", "drugo", "politični vpliv"],
			datasets: [{
				label: "Idealen minister za kulturo",
				data: [10,8,6,6,6,5,5,4,2,2],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Idealen minister za kulturo"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["razumevanje potreb", "več sredstev", "poudarek na kvaliteti", "ureditev statusa", "dialog", "enakopravnost področij", "povezovanje", "tržna usmerjenost", "več svobode", "vizija"],
			datasets: [{
				label: "Idealna kulturna reforma",
				data: [5,5,4,4,3,2,1,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Idealna kulturna reforma"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["jalovi", "konflikti interesov", "nujni", "neutemeljeni", "škodljivi za kulturo"],
			datasets: [{
				label: "Konflikti z ministrstvom za kulturo",
				data: [12,7,6,4,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Konflikti z ministrstvom za kulturo"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["ne", "mogoče", "ja"],
			datasets: [{
				label: "Je pritoževanja preveč?",
				data: [15, 8, 2],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Je pritoževanja preveč?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["ureditev statusa", "več sredstev", "vizija", "boljša razporeditev sredstev", "zaposlovanje", "drugo", "strožji kriteriji", "dialog", "kulturni evro", "ureditev trga"],
			datasets: [{
				label: "Katero spremembo bi sam najprej uvedel?",
				data: [5,5,4,3,3,2,2,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Katero spremembo bi sam najprej uvedel?"}}
	},
	{
		type: 'doughnut',
		data: {
			labels: ["manj birokracije", "profesionalizacija", "več sredstev", "zaposlovanje", "drugo", "izobraževanje", "dialog", "boljša razporeditev sredstev", "ureditev statusa", "več časa"],
			datasets: [{
				label: "Kako bi s svojim delom izboljšal položaj v kulturi?",
				data: [4,4,4,4,3,3,2,1,1,1],
				backgroundColor: backgroundColors
			}],
		},
		options: {legend: {position: 'bottom'},  title: { display: true, text: "Kako bi s svojim delom izboljšal položaj v kulturi?"}}
	}
]

var myData = jQuery.extend(true, [], myDataCopy);
var myEveryChart = [];
var myDataCurrent = [];


//var myDataCopy = myData.slice();

function createChart() {
	myData = jQuery.extend(true, [], myDataCopy);
	var ns;
	var myChart;
	// FIXME
	if (myData.length == 0) {
		alert("no more charts to draw!"); 
	} else {
		if ((arguments.length == 1) && Array.isArray(arguments[0])) {
			ns = arguments[0];
		} else if (arguments.length > 1) {
			ns = Array.prototype.slice.call(arguments);
		} else {
			ns = [arguments[0]];
		}
		if (ns.length == 1) { //single chart
			current = ns[0];
			if((myData[current] !== undefined) && (myData[current] != null)) {
				//let myWrap, myCanvas;
				myDataCurrent[current] = jQuery.extend(true, [], myData[current]);
				$(chartContainer).find(".canvas-wrap").remove(); //removes children as well
				myWrap = $("<div class='canvas-wrap single-chart'></div>");
				$(chartContainer).append(myWrap);
				
				myCanvas = $("<canvas class='canvas-chart' id='chart'></canvas>");
				myCanvas.data('chart', current);
				$(myWrap).append(myCanvas);
				
				myChart = new Chart(myCanvas, myData[current]);
				//myEveryChart.splice(current, 0, myChart);
				myEveryChart[current] = myChart;
				$("#chartsLinksContainer").find(".shown").removeClass("shown");
				$("#chartsLinksContainer").find(".createChartLink").filter(function() {
					if ($(this).data('chart') == current) {
						$(this).toggleClass('shown');
					}
				});
			}
		} else { //multiple arguments, ie. array (therefore show all)
			$(chartContainer).find(".canvas-wrap").remove();
			$("#chartsLinksContainer").find(".shown").removeClass("shown");
			
			for (n = 0; n < ns.length; ++n) {
				current = ns[n];
				if((myData[current] !== undefined) && (myData[current] != null)) {
					myDataCurrent[current] = jQuery.extend(true, [], myData[current]);
					myWrap = $("<div class='canvas-wrap multiple-charts'></div>");
					myCanvas = $("<canvas id='chart-" + current + "'></canvas>");
					myCanvas.data('chart', current);
					$(chartContainer).append(myWrap);
					$(myWrap).append(myCanvas);
	
					myChart = new Chart(myCanvas, myData[current]);
					myEveryChart.splice(current, 1, myChart);
					$("#chartsLinksContainer").find(".createChartLink").filter(function() {
						if ($(this).data('chart') == current) {
							$(this).toggleClass('shown');
						}
					});
				}
			}
		}
	}
}

function createRandomChart() {
	$("#roles").find(".button").removeClass("shown");	
	if (myData.length == 0) {
		alert("no more charts to draw!"); 
	} else {
		var rand = [Math.floor(Math.random() * myData.length)];
		createChart(rand);
	}
	$("#roles").find("#allButton").addClass("shown");		
}

function createRemainingCharts() {
	$("#roles").find(".button").removeClass("shown");	
	var items = [];
	for (i = 0; i < myData.length; ++i) {
		items.push(i);
	}
	createChart(items);
	$("#roles").find("#allButton").addClass("shown");		
}

$("#randomChartButton").on('click', function(){
	createRandomChart();
});
$("#createRemainingChartsButton").on('click', function() {
	createRemainingCharts();
});

$("#chartsLinksContainer").on('click', 'span.createChartLink', function() {
	$("#roles").find(".button").removeClass("shown");	
	createChart($(this).data('chart'));
	$("#roles").find("#allButton").addClass("shown");		
});

$("#removeChartsButton").on('click', function() {
	$("#chartContainer .canvas-wrap").remove();
	$("#chartsLinksContainer").find(".createChartLink").removeClass("shown");
	$("#roles").find(".button").removeClass("shown");
});

$("#artistsButton").on('click', function() {
	$("#roles").find(".button").removeClass("shown");
	updateCharts('artists');
	$(this).addClass("shown");
});
$("#producersButton").on('click', function() {
	$("#roles").find(".button").removeClass("shown");
	updateCharts('producers');
	$(this).addClass("shown");
});
$("#bureaucratsButton").on('click', function() {
	$("#roles").find(".button").removeClass("shown");
	updateCharts('bureaucrats');
	$(this).addClass("shown");
});
$("#allButton").on('click', function() {
	$("#roles").find(".button").removeClass("shown");
	updateCharts('all');
	$(this).addClass("shown");
});





function createChartsLinks() {
	var chartsLinksContainer = $("#chartsLinksContainer");
	for (i = 0; i < myData.length; ++i) {
		var title = myData[i].options.title.text;
		var element = $('<span class="createChartLink">' + title + '</span>');
		chartsLinksContainer.append(element);
		element.data('chart', i);
	}
}


function updateCharts(role) {
	var whichData;
	if (role == "artists") {
		whichData = myDataArtists;
	} else if (role == "producers") {
		whichData = myDataProducers;
	} else if (role == "bureaucrats") {
		whichData = myDataBureaucrats;
	} else if (role == "all") {
		whichData = myDataCopy;
	}
	

	$("#charts").find("canvas").each(function(i){
		chartNumber = $(this).data("chart");
		insert = [];
		
		insert[0] = whichData[chartNumber].data.labels.slice();
		insert[1] = whichData[chartNumber].data.datasets[0].data.slice();
		insert[2] = whichData[chartNumber].data.datasets[0].backgroundColor.slice();
		
		myEveryChart[chartNumber].data.labels = insert[0].slice(0);
		myEveryChart[chartNumber].data.datasets[0].data = insert[1].slice(0);
		myEveryChart[chartNumber].data.datasets[0].backgroundColor = insert[2].slice(0);
		
		myEveryChart[chartNumber].update();
	});
}




createChartsLinks();
createRandomChart();
});



</script>



<section id="charts" class="medium-top-padding medium-bottom-padding">
	<div id="chartContainer" class="large-bottom-margin"></div>
	<div class="center center-margins">
		<p id="randomChartButton" class="button">naključni diagram</p>
		<p id="createRemainingChartsButton" class="button">vsi diagrami</p>
		<p id="removeChartsButton" class="button">odstrani vse</p>
		<div id="roles" class="medium-top-margin">
			<p id="bureaucratsButton" class="button">birokrati</p>
			<p id="producersButton" class="button">producenti</p>
			<p id="artistsButton" class="button">ustvarjalci</p>
			<p id="allButton" class="button">vsi<p>
		</div>


		<div id="chartsLinksContainer" class="medium-top-margin center"></div>
	</div>

<div class="gray font-size-1 leading-loose sans large-top-padding align-left medium-bottom-padding">
	<p>Opomba uredništva: Analiza je bila opravljena tako, da je bilo na vsako vprašanje mogočih več odgovorov, vendar pa se pri posameznem anketirancu niso smeli ponavljati. Pri analizi podatkov za izdelavo zgornjih diagramov ni šlo brez poenostavitev in posplošitev.</p>
	<p class="show-on-request hide">Niz intervjujev na Prvo žogo je namreč zanimiv tudi zato, ker prinaša osebne poglede, uvide in refleksije izbranih sogovornikov, zaradi česar je bilo posamezne odgovore pogosto težko kvantificirati. In kolikor so posamezni odgovori zanimivi prav zaradi svoje specifičnosti, toliko so diagrami zanimivi zaradi poskusa izluščiti bistvene poglede in tendence. V diagramih denimo ni vidna občasna resigniranost (npr. problemi se lahko rešijo le z ravnodušnostjo in prilagodljivostjo), kar dvakrat omenjena ideja, da bi kulturniki in birokrati začasno zamenjali mesta, in da so celo nekateri kulturniki sami za strožje kriterije in zoper hiperprodukcijo. Kot pa razkrijejo nekateri prispevki, je tako med drugim zato, ker se celo kulturniki sami bojijo sprememb. Zanimivo je, da je pri vlogi oz. pomenu kulture močno prevladovala družbotvornost, kar pomeni bistven obrat, saj je izrecno nadomestila po novem nepriljubljeno in zastarelo narodotvornost. Nekajkrat je bila omenjena kulturna dediščina. Ljubiteljska kultura tako rekoč sploh ne. Tu in tam je bila kot problem omenjena majhnost trga. Pri kulturnih dogodkih je denimo nejasno, kakšni glasbeni in odrski dogodki so mišljeni, pri čemer pa velja poudariti, da je bil nekajkrat izrecno omenjen tudi ples. Več anketirancev je med kulturniki posebej omenilo tudi tehnično osebje. Vabljeni k branju in dialogu!</p>
	<a href="#" class="small-top-margin center center-margins show-hide readMoreLink gray-background-3 block one-one center">Podrobneje</a>
</div>



</section>

<!-- end chart container -->

<?php } ?>
<?php endif; ?>
<?php require('loop-articles.php'); ?>
<?php get_footer(); ?>
