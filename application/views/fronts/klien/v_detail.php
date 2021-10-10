<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta content="crudbiz" name="author">
<meta NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
<title><?php echo $posts->bisnis_judul ?> - <?php echo $posts->bisnis_keyword ?> - <?php echo $identitas->slogan?></title>
<meta name="title" content="<?php echo $posts->bisnis_judul ?> - <?php echo $posts->bisnis_keyword ?> | <?php echo $identitas->nama_website?>">
<meta property="og:title" content="<?php echo $posts->bisnis_judul ?> - <?php echo $posts->bisnis_keyword ?> | <?php echo $identitas->nama_website?>">
<meta name="site_url" content="<?php echo base_url()?>bisnis/<?php echo $posts->bisnis_judul_seo ?>">
<meta name="description" content="<?php echo $posts->bisnis_meta_desk ?>">
<meta name="keywords" content="<?php echo $posts->bisnis_keyword ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="alternate" href="<?php echo base_url()?>bisnis/<?php echo $posts->bisnis_judul_seo ?>" hreflang="id" />
<link href='<?php echo base_url()?>bisnis/<?php echo $posts->bisnis_judul_seo ?>' rel='canonical'/>
<meta property="og:site_name" content="<?php echo $identitas->nama_website?>">
<meta property="og:description" content="<?php echo $posts->bisnis_meta_desk ?>">
<meta property="og:url" content="<?php echo base_url()?>klien/<?php echo $posts->bisnis_judul_seo ?>">
<meta property="og:image" content="<?php echo base_url()?>assets/frontend/linibisnis/<?php echo $posts->bisnis_gambar ?>">
<meta property="og:image:url" content="<?php echo base_url()?>assets/frontend/linibisnis/<?php echo $posts->bisnis_gambar ?>">
<meta property="og:type" content="article">
<link rel="shortcut icon" href="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->favicon?>" type="image/x-icon">
<?php $this->load->view('fronts/analytics')?>
<?php $this->load->view('fronts/css')?>
</head>

<body>



<!-- START HEADER -->
<?php $this->load->view('fronts/header.php')?>
<!-- END HEADER -->

<!-- START SECTION ABOUT US -->
<section class="small_pb overflow_hide">
    <div class="container">
        <div class="row align-items-center">
        	<div class="col-md-6 col-sm-12 mb-4 mb-lg-0 animation" data-animation="fadeInLeft" data-animation-delay="0.2s">
            	<div>
								<img <?php
                    if(empty($posts->bisnis_gambar)) {
                      echo "";
                    }else {
                      echo " <img src='".base_url()."assets/frontend/linibisnis/".$posts->bisnis_gambar."'> ";}
                    ?>

                </div>
            </div>
            <div class="col-md-6 col-sm-12 animation" data-animation="fadeInRight" data-animation-delay="0.4s">
                <div class="heading_s3 mb-3">
                  <h3><?php echo $posts->bisnis_judul ?></h3>
                </div>
                <p><?php echo $posts->bisnis_desk ?></p>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION ABOUT US -->
<section>
	   <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
                <div class="heading_s4 text-center">
                    <h2>pilih paket website Anda Sekarang!</h2>
                    <p><center>Mereka sudah membuktikan bikin website di CrudbiZ dengan harga termurah dan fitur lengkap serta mudah di pahami oleh pemula sekalipun.</center></p>

                </div>
					</div>
      </div>
      <div class="row">
          <div class="col-md-12">
              <ul class="portfolio_gallery portfolio_style4 carousel_slide4 owl-carousel owl-theme" data-margin="15" data-dots="false" data-autoplay="true" data-nav="true" data-loop="true" data-autoplay-timeout="2000">
								<?php  foreach ($posts_paketharga as $post_new){
									?>
                  <li class="portfolio-item">
                    <div class="portfolio_item">
                          <a href="<?php echo base_url("harga/$post_new->paketharga_judul_seo")?>" class="image_link">
														<?php
																											if(empty($post_new->paketharga_gambar)) {
																												echo "<img src='".base_url()."assets/frontend/campur/harga_22.jpg'>";
																											}else {
																												echo " <img src='".base_url()."assets/frontend/paketharga/".$post_new->paketharga_gambar."'> ";}
																											?>

                          </a>
                    </div>
                  </li>
								<?php } ?>
              </ul>
          </div>
      </div>
    </div>
</section>


<!-- START FOOTER SECTION -->
<?php $this->load->view('fronts/footer')?>
<!-- END FOOTER SECTION -->

<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

<!-- Latest jQuery -->
<script src="<?php echo base_url()?>assets/js/jquery-1.12.4.min.js"></script>
<!-- jquery-ui -->
<script src="<?php echo base_url()?>assets/js/jquery-ui.js"></script>
<!-- popper min js -->
<script src="<?php echo base_url()?>assets/js/popper.min.js"></script>
<!-- Latest compiled and minified Bootstrap -->
<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- owl-carousel min js  -->
<script src="<?php echo base_url()?>assets/owlcarousel/js/owl.carousel.min.js"></script>
<!-- magnific-popup min js  -->
<script src="<?php echo base_url()?>assets/js/magnific-popup.min.js"></script>
<!-- waypoints min js  -->
<script src="<?php echo base_url()?>assets/js/waypoints.min.js"></script>
<!-- parallax js  -->
<script src="<?php echo base_url()?>assets/js/parallax.js"></script>
<!-- countdown js  -->
<script src="<?php echo base_url()?>assets/js/jquery.countdown.min.js"></script>
<!-- fit video  -->
<script src="<?php echo base_url()?>assets/js/jquery.fitvids.js"></script>
<!-- jquery.counterup.min js -->
<script src="<?php echo base_url()?>assets/js/jquery.counterup.min.js"></script>
<!-- isotope min js -->
<script src="<?php echo base_url()?>assets/js/isotope.min.js"></script>
<!-- elevatezoom js -->
<script src='<?php echo base_url()?>assets/js/jquery.elevatezoom.js'></script>
<!-- scripts js -->
<script src="<?php echo base_url()?>assets/js/scripts.js"></script>

</body>
</html>
