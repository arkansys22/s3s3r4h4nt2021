<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta content="crudbiz" name="author">
<meta NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
<title><?php echo $posts->paketharga_judul ?> - <?php echo $posts->paketharga_keyword ?> - <?php echo $identitas->slogan?></title>
<meta name="title" content="<?php echo $posts->paketharga_judul ?> - <?php echo $posts->paketharga_keyword ?> | <?php echo $identitas->nama_website?>">
<meta property="og:title" content="<?php echo $posts->paketharga_judul ?> - <?php echo $posts->paketharga_keyword ?> | <?php echo $identitas->nama_website?>">
<meta name="site_url" content="<?php echo base_url()?>harga/<?php echo $posts->paketharga_judul_seo ?>">
<meta name="description" content="<?php echo $posts->paketharga_meta_desk ?>">
<meta name="keywords" content="<?php echo $posts->paketharga_keyword ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="alternate" href="<?php echo base_url()?>harga/<?php echo $posts->paketharga_judul_seo ?>" hreflang="id" />
<link href='<?php echo base_url()?>harga/<?php echo $posts->paketharga_judul_seo ?>' rel='canonical'/>
<meta property="og:site_name" content="<?php echo $identitas->nama_website?>">
<meta property="og:description" content="<?php echo $posts->paketharga_meta_desk ?>">
<meta property="og:url" content="<?php echo base_url()?>harga/<?php echo $posts->paketharga_judul_seo ?>">
<meta property="og:image" content="<?php echo base_url()?>assets/frontend/paketharga/<?php echo $posts->paketharga_gambar ?>">
<meta property="og:image:url" content="<?php echo base_url()?>assets/frontend/paketharga/<?php echo $posts->paketharga_gambar ?>">
<meta property="og:type" content="article">
<link rel="shortcut icon" href="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->favicon?>" type="image/x-icon">
<?php $this->load->view('fronts/analytics')?>
<?php $this->load->view('fronts/css')?>
</head>

<body>



<!-- START HEADER -->
<?php $this->load->view('fronts/header.php')?>
<!-- END HEADER -->

<section class="small_pb overflow_hide">
	<div class="container">
    	<div class="row align-items-center">
        	<div class="col-lg-6 col-md-12 mb-4 mb-lg-0 animation" data-animation="fadeInLeft" data-animation-delay="0.2s">
            <img <?php
                if(empty($posts->paketharga_gambar)) {
                  echo "";
                }else {
                  echo " <img src='".base_url()."assets/frontend/paketharga/".$posts->paketharga_gambar."'> ";}
                ?>
            </div>
            <div class="col-lg-6 col-md-12 animation" data-animation="fadeInRight" data-animation-delay="0.2s">
            	<h5><?php echo $posts->paketharga_judul ?></h5>
                <?php echo $posts->paketharga_desk ?>
                <ul class="list_none portfolio_info_box">
                    <li><span class="text-uppercase">Harga</span>Rp. <?php echo number_format($posts->paketharga_harga,0,',','.') ?></li>
                    <li><span class="text-uppercase">Fitur Terbaik</span><?php echo $posts->paketharga_fitur ?></li>
                    <li><span class="text-uppercase">Cari Tampilan</span><a href="<?php echo base_url()?>" class="btn btn-success btn-sm">Pilih Tampilan</a></li>
                    <li><span class="text-uppercase">Bagikan </span>
                        <ul class="list_none social_icons border_social rounded_social">
													<li><a href="http://www.facebook.com/sharer.php?u=<?php echo base_url("harga/$posts->paketharga_judul_seo ") ?>" onclick="window.open('https://www.facebook.com/sharer.php?u=<?php echo base_url("harga/$posts->paketharga_judul_seo ") ?>','newwindow','width=400,height=350');  return false;" title="Facebook" target="_blank" title="Facebook"><i class="ion-social-facebook"></i></a></li>
													<li><a href="whatsapp://send?text=<?php echo $posts->paketharga_judul ?> | <?php echo base_url("harga/$posts->paketharga_judul_seo ") ?>" title="Whatsapp" target="_blank"><i class="ion-social-whatsapp"></i></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="small_pb">
    <div class="container-fluid">
    	<div class="row">
            <div class="col-sm-12" >
                <div class="heading_s4 text-center">
                    <h2>Bukan Website Ini Yang Anda Mau ?</h2>
                </div>
                <p><center>Kami memiliki beragam website menarik lain sesuai kebutuhan bisnis Anda.</center></p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="cleafix small_divider"></div>
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
<div id="fb-root"></div>
           <script>(function(d, s, id) {
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) return;
             js = d.createElement(s); js.id = id;
             js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.10&appId=129429343801925';
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));</script>
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
