<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta content="crudbiz" name="author">
<meta NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
<title><?php echo $identitas->nama_website?> - <?php echo $identitas->slogan?></title>
<meta name="title" content="<?php echo $identitas->nama_website?> - <?php echo $identitas->slogan?>">
<meta property="og:title" content="<?php echo $identitas->nama_website?> - <?php echo $identitas->slogan?>">
<meta name="site_url" content="<?php echo base_url()?>">
<meta name="description" content="<?php echo $identitas->meta_deskripsi?>">
<meta name="keywords" content="<?php echo $identitas->meta_keyword?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="alternate" href="<?php echo base_url()?>" hreflang="id" />
<link href='<?php echo base_url()?>' rel='canonical'/>
<meta property="og:site_name" content="<?php echo $identitas->nama_website?>">
<meta property="og:description" content="<?php echo $identitas->meta_deskripsi?>">
<meta property="og:url" content="<?php echo base_url()?>">
<meta property="og:image" content="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->logo?>">
<meta property="og:image:url" content="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->logo?>">
<meta property="og:type" content="article">
<link rel="shortcut icon" href="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->favicon?>" type="image/x-icon">
<?php $this->load->view('fronts/analytics')?>
<?php $this->load->view('fronts/css')?>
</head>
<body>
<?php $this->load->view('fronts/loader.php')?>
<?php $this->load->view('fronts/header.php')?>
<?php $this->load->view('fronts/home/v_slider')?>
<?php $this->load->view('fronts/home/v_about')?>
<?php $this->load->view('fronts/home/v_daftar_klien')?>
<?php $this->load->view('fronts/home/v_counter')?>
<?php $this->load->view('fronts/home/v_testimonial')?>
<?php $this->load->view('fronts/home/v_harga')?>

<section class="cta_section_small bg_blue px-0">
	<div class="container">
    	<div class="row align-items-center animation" data-animation="fadeInUp" data-animation-delay="0.2s">
        	<div class="col-md-8 text_white">
                <h3>Layanan Gratis Konsultasi Kebutuhan Website Bisnis Anda</h3>

            </div>
            <div class="col-md-4 text-md-right">
            	<a href="https://api.whatsapp.com/send?phone=<?php echo $identitas->whatsapp?>&text= Halo Crudbiz, mau tanya - tanya tentang bikin website untuk bisnis saya." class="btn btn-outline-white">Chat WhatsApp</a>
            </div>
        </div>
    </div>
</section>
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
