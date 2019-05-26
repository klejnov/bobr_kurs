<?php
header("Content-type: text/xml");
$date = date('Y-m-d\TH:i:00P', time());

print <<<HTML_BLOCK
<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

   <url>
      <loc>https://kurs.bobr.by/</loc>
      <lastmod>$date</lastmod>
      <changefreq>hourly</changefreq>
      <priority>1</priority>
   </url>
   <url>
      <loc>https://kurs.bobr.by/?classic=show</loc>
      <lastmod>$date</lastmod>
      <changefreq>hourly</changefreq>
      <priority>0.8</priority>
   </url>
   <url>
      <loc>http://wap.kurs.bobr.by/</loc>
      <lastmod>$date</lastmod>
      <changefreq>hourly</changefreq>
      <priority>0.6</priority>
   </url>

</urlset>
HTML_BLOCK;
