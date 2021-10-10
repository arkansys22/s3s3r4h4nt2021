<?php header('Content-type: application/xml; charset="ISO-8859-1"',true);  ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
     <loc><?php echo base_url();?></loc>
     <priority>1.0</priority>
  </url>
  <?php foreach($klien as $data) { ?>
  <url>
     <loc><?php echo base_url("klien/").$data->bisnis_judul_seo;?></loc>
     <priority>0.5</priority>
  </url>
  <?php } ?>
  <?php foreach($templates as $data) { ?>
  <url>
     <loc><?php echo base_url("templates/").$data->templates_judul_seo;?></loc>
     <priority>0.5</priority>
  </url>
  <?php } ?>
  <?php foreach($paketharga as $data) { ?>
  <url>
     <loc><?php echo base_url("harga/").$data->paketharga_judul_seo;?></loc>
     <priority>0.5</priority>
  </url>
  <?php } ?>



</urlset>
