<?php 
include 'includes/config.php';

header('Content-Type: application/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";

echo "<urlset 
  xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
  xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
  xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
		http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">";


// ------------------------------------ PÁGINAS ESTÁTICAS ---------------------------------------------------------
?>

<url>
  <loc>http://www.somrurals.com/</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/ca/</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/es/</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/en/</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/fr/</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/ca/qui-som</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/es/quienes-somos</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/en/about</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/fr/qui-nous-sommes</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/ca/com-reservar</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/es/como-reservar</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/en/how-it-works</loc>
  <changefreq>weekly</changefreq>
</url>
<url>
  <loc>http://www.somrurals.com/fr/comment-reserver</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/ca/contacte</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/es/contacto</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/en/contact</loc>
  <changefreq>weekly</changefreq>
</url>
<url>
  <loc>http://www.somrurals.com/fr/contact</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/ca/alta-casa-rural</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/es/alta-casa-rural</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/en/add-holiday-cottage</loc>
  <changefreq>weekly</changefreq>
</url>
<url>
  <loc>http://www.somrurals.com/fr/inscrire-gite-rural</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/ca/preguntes-frequents</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/es/preguntas-frecuentes</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/en/faq-about-reservation</loc>
  <changefreq>weekly</changefreq>
</url>
<url>
  <loc>http://www.somrurals.com/fr/questions–frequentes</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/ca/termes-condicions</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/es/terminos-condiciones</loc>
  <changefreq>weekly</changefreq>
</url>

<url>
  <loc>http://www.somrurals.com/en/terms-conditions</loc>
  <changefreq>weekly</changefreq>
</url>
<url>
  <loc>http://www.somrurals.com/fr/conditions</loc>
  <changefreq>weekly</changefreq>
</url>


<url>
    <loc>http://www.somrurals.com/ca/recursos-turistics-catalunya</loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/es/recursos-turisticos-catalunya</loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/en/attractions-catalonia</loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/fr/ressources-touristiques-catalogne</loc>
    <changefreq>weekly</changefreq>
</url>


<?php
// ------------------------------------ FICHAS RESURSOS TURÍSTICOS ---------------------------------------------------------


//$query = mysql_query("SELECT idrecurso, title_ca, title_es, title_en, title_fr, pvid, comid, image FROM recursos WHERE published = 1") or die(mysql_error());
$db->where('published',1);
$query=$db->get('recursos',null,'idrecurso, title_ca, title_es, title_en, title_fr, pvid, comid, image');
//while ($rs = mysql_fetch_array($query)) {
foreach($query as $rs){ 
?>
<url>
    <loc>http://www.somrurals.com/ca/recursos-turistics-catalunya/<?php echo urls_amigables(GetTitleProvincia($rs['pvid']))."/".urls_amigables(GetTitleComarca($rs['comid']))."/".urls_amigables($rs['title_ca'])."-".$rs['idrecurso'];?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
<url>
    <loc>http://www.somrurals.com/en/attractions-catalonia/<?php echo urls_amigables(GetTitleProvincia($rs['pvid']))."/".urls_amigables(GetTitleComarca($rs['comid']))."/".urls_amigables($rs['title_en'])."-".$rs['idrecurso'];?></loc>
    <changefreq>weekly</changefreq>
    <loc>http://www.somrurals.com/es/recursos-turisticos-catalunya/<?php echo urls_amigables(GetTitleProvincia($rs['pvid']))."/".urls_amigables(GetTitleComarca($rs['comid']))."/".urls_amigables($rs['title_es'])."-".$rs['idrecurso'];?></loc>
    <changefreq>weekly</changefreq>
</url>

</url>

<url>
    <loc>http://www.somrurals.com/fr/ressources-touristiques-catalogne/<?php echo urls_amigables(GetTitleProvincia($rs['pvid']))."/".urls_amigables(GetTitleComarca($rs['comid']))."/".urls_amigables($rs['title_fr'])."-".$rs['idrecurso'];?></loc>
    <changefreq>weekly</changefreq>
</url>

<?php 
}
?>



<?php
// ------------------------------------ FICHAS CASAS RURALES ---------------------------------------------------------

//$query = mysql_query("SELECT eid, title, lid, tid, published FROM establiments WHERE published = 1") or die(mysql_error());
$db->where('published',1);
$query=$db->get('establiments',null,'eid, title, lid, tid, published');
//while ($rs = mysql_fetch_array($query)) { 
foreach($query as $rs){
?>
<url>
    <loc>http://www.somrurals.com/ca/casa-rural/<?php echo urls_amigables($rs['title'])."-".$rs['eid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/es/casa-rural/<?php echo urls_amigables($rs['title'])."-".$rs['eid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/en/holiday-cottage/<?php echo urls_amigables($rs['title'])."-".$rs['eid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/fr/gite-rural/<?php echo urls_amigables($rs['title'])."-".$rs['eid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>
<?php 
}
?>


<?php
// ------------------------------------ SEARCH PROVINCIAS ---------------------------------------------------------

//$query = mysql_query("SELECT pvid, title FROM provincies ORDER BY title ASC") or die(mysql_error());
$db->orderBy('title','ASC');
$query=$db->get('provincies',null,'pvid, title');
//while ($rs = mysql_fetch_array($query)) { 
foreach($query as $rs){ 
?>
<url>
    <loc>http://www.somrurals.com/ca/cases-rurals/<?php echo urls_amigables($rs['title'])."/p-".$rs['pvid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/es/casas-rurales/<?php echo urls_amigables($rs['title'])."/p-".$rs['pvid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/en/holiday-cottages/<?php echo urls_amigables($rs['title'])."/p-".$rs['pvid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/fr/maisons-rurales/<?php echo urls_amigables($rs['title'])."/p-".$rs['pvid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>
<?php 
}
?>


<?php
// ------------------------------------ SEARCH COMARCAS ---------------------------------------------------------

//$query = mysql_query("SELECT comid, pvid, title FROM comarques ORDER BY title ASC") or die(mysql_error());
$db->orderBy('title','ASC');
$query=$db->get('comarques',null,'comid, pvid, title');
//while ($rs = mysql_fetch_array($query)) {  
foreach($query as $rs){
?>
<url>
    <loc>http://www.somrurals.com/ca/cases-rurals/<?php echo urls_amigables($rs['title'])."/c-".$rs['comid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/es/casas-rurales/<?php echo urls_amigables($rs['title'])."/c-".$rs['comid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/en/holiday-cottages/<?php echo urls_amigables($rs['title'])."/c-".$rs['comid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/fr/maisons-rurales/<?php echo urls_amigables($rs['title'])."/c-".$rs['comid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>
<?php 
}
?>

<?php
// ------------------------------------ RECURSOS TURÍSTICOS PROVINCIAS ---------------------------------------------------------

//$query = mysql_query("SELECT pvid, title FROM provincies ORDER BY title ASC") or die(mysql_error());
$db->orderBy('title','ASC');
$query=$db->get('provincies',null,'pvid, title');
//while ($rs = mysql_fetch_array($query)) {  
foreach($query as $rs){
?>
<url>
    <loc>http://www.somrurals.com/ca/recursos-turistics-catalunya/<?php echo urls_amigables($rs['title'])."/p-".$rs['pvid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/es/recursos-turisticos-catalunya/<?php echo urls_amigables($rs['title'])."/p-".$rs['pvid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/en/attractions-catalonia/<?php echo urls_amigables($rs['title'])."/p-".$rs['pvid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/fr/ressources-touristiques-catalogne/<?php echo urls_amigables($rs['title'])."/p-".$rs['pvid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>
<?php 
}
?>


<?php
// ------------------------------------ RECURSOS TURÍSTICOS COMARCAS ---------------------------------------------------------

//$query = mysql_query("SELECT comid, pvid, title FROM comarques ORDER BY title ASC") or die(mysql_error());
$db->orderBy('title','ASC');
$query=$db->get('comarques',null,'comid, pvid, title');
//while ($rs = mysql_fetch_array($query)) { 
foreach($query as $rs){ 
?>
<url>
    <loc>http://www.somrurals.com/ca/recursos-turistics-catalunya/<?php echo urls_amigables($rs['title'])."/c-".$rs['comid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/es/recursos-turisticos-catalunya/<?php echo urls_amigables($rs['title'])."/c-".$rs['comid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/en/attractions-catalonia/<?php echo urls_amigables($rs['title'])."/c-".$rs['comid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>

<url>
    <loc>http://www.somrurals.com/fr/ressources-touristiques-catalogne/<?php echo urls_amigables($rs['title'])."/c-".$rs['comid']; ?></loc>
    <changefreq>weekly</changefreq>
</url>
<?php 
}
?>

</urlset>