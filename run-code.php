<?php
/*
Template Name: run code
*/
?>
<!doctype html>
<html lang="sl">
	<head>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		<?php wp_head(); ?>
	</head>
	<body>
<?php
$urls = array('/branje/moj-fant/', '/esej-kolumna/moja-domovina/', '/esej-kolumna/uvodnik/komparativistika-in-njen-smisel/', '/esej-kolumna/uvodnik/nam-je-slovenscina-tuj-jezik/', '/esej-kolumna/prepustnica/', '/esej-kolumna/uvodnik/manj-rednih-sluzb-vec-prekarnosti/', '/esej-kolumna/nikoli-ne-bom-general/', '/kritika-komentar/o-nacionalizmih/', '/kritika-komentar/o-tezkanju-teksta-in-konteksta/', '/branje/carver/', '/branje/mojstrovina/', '/kritika-komentar/vitomil-zupan-in-menuet-za-kitaro-na-petindvajset-strelov/', '/kritika-komentar/bodo-knjiznice-skladisca-slabih-knjig-ali-tocke-kvalitetnih-dialogov-med-knjigami-in-bralci/', '/esej-kolumna/kako-sem-skoraj-obupal-nad-slovensko-kritiko/', '/branje/tehno/', '/branje/mladi-slovenski-pesniki/', '/esej-kolumna/slog-ali-za-koga-kritiziramo/', '/esej-kolumna/poslednja-pesem-o-tebi/', '/esej-kolumna/uvodnik/iz-kvalitete-v-kvantiteto/', '/branje/kratka-zgodovina-slovenskega-stripa-v-stripu/', '/kritika-komentar/ce-je-slovenska-proza-v-krizi-je-dramatiki-ze-odklenkalo/', '/esej-kolumna/brutalni-realizem/', '/esej-kolumna/polaganje-dlani/', '/branje/pesniki-plitkih-strasti/', '/kritika-komentar/srecna-ker-sem-zenska-poskus-narobne-kritike/', '/branje/proza/ponedeljek-18-3-2014/', '/branje/47845/', '/branje/proza/cona-udobja/', '/esej-kolumna/uvodnik/kako-privarcevati-s-pomocjo-literarne-kritike/', '/kritika-komentar/bi-morala-kot-mlada-zenska-vcasih-preprosto-drzati-jezik-za-zobmi/', '/branje/jutro-ponoci/', '/kritika-komentar/opazovanje-vs-participacija/', '/kritika-komentar/slovo-brez-konteksta/', '/branje/dokazi/', '/branje/proza/andrej-hocevar/', '/branje/z-okna-apartmaja-v-malinski/', '/branje/spal-sem-deset-minut-zdelo-se-je-kot-ure/', '/branje/odtekanje/', '/kritika-komentar/o-poniznosti/', '/branje/poletje/', '/esej-kolumna/izstopna-izjava/', '/branje/proza/clovekoljub/', '/kritika-komentar/strasna-strasna-knjiga/', '/esej-kolumna/facebook-med-literarci/', '/kritika-komentar/gospod-a-danes-pa-ne-boste-kupili-solate/', '/kritika-komentar/neznosna-lahkost-strahu/', '/esej-kolumna/odziv-na-dviganje-prahu-v-dsp/', '/intervju/ce-te-pesem-nekje-pricaka-jo-moras-uglasbiti-tako-da-obstaja-naprej/', '/esej-kolumna/avtor-inali-delo/', '/branje/proza/bozicna-vecerja/');



$return = array();
foreach ($urls as $url) {
	$return[] = url_to_postid($url);
}
echo implode(', ', $return);
?>
	<?php wp_footer(); ?>
	</body>
</html>
