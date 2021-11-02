<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta content="crudbiz" name="author">
<meta NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
<title><?php echo $posts->templates_judul ?> - <?php echo $posts->templates_keyword ?> - <?php echo $identitas->slogan?></title>
<meta name="title" content="<?php echo $posts->templates_judul ?> - <?php echo $posts->templates_keyword ?> | <?php echo $identitas->nama_website?>">
<meta property="og:title" content="<?php echo $posts->templates_judul ?> - <?php echo $posts->templates_keyword ?> | <?php echo $identitas->nama_website?>">
<meta name="site_url" content="<?php echo base_url()?>templates/<?php echo $posts->templates_judul_seo ?>">
<meta name="description" content="<?php echo $posts->templates_meta_desk ?>">
<meta name="keywords" content="<?php echo $posts->templates_keyword ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="alternate" href="<?php echo base_url()?>templates/<?php echo $posts->templates_judul_seo ?>" hreflang="id" />
<link href='<?php echo base_url()?>templates/<?php echo $posts->templates_judul_seo ?>' rel='canonical'/>
<meta property="og:site_name" content="<?php echo $identitas->nama_website?>">
<meta property="og:description" content="<?php echo $posts->templates_meta_desk ?>">
<meta property="og:url" content="<?php echo base_url()?>templates/<?php echo $posts->templates_judul_seo ?>">
<meta property="og:image" content="<?php echo base_url()?>assets/frontend/produk/<?php echo $posts->templates_gambar ?>">
<meta property="og:image:url" content="<?php echo base_url()?>assets/frontend/produk/<?php echo $posts->templates_gambar ?>">
<meta property="og:type" content="article">
<link rel="shortcut icon" href="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->favicon?>" type="image/x-icon">
<?php $this->load->view('fronts/analytics')?>
<?php $this->load->view('fronts/css')?>
</head>

<body>



<!-- START HEADER -->
<?php $this->load->view('fronts/header.php')?>
<!-- END HEADER -->
<section class="small_pb">
	<div class="container">
    	<div class="row">
        	<div class="col-md-12 animation" data-animation="fadeInUp" data-animation-delay="0.2s">
            <img <?php
                if(empty($posts->templates_gambar)) {
                  echo "";
                }else {
                  echo " <img src='".base_url()."assets/frontend/produk/".$posts->templates_gambar."'> ";}
                ?>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-12">
            	<div class="clearfix medium_divider"></div>
            </div>
        </div>
    	<div class="row">
        	<div class="col-lg-8 col-md-7 mb-4 mb-md-0 animation" data-animation="fadeInUp" data-animation-delay="0.4s">
            	<h5><?php echo $posts->templates_judul ?></h5>
                <?php echo $posts->templates_desk ?>
								<p>Tekan tombol “Lihat Demo” dan nikmati secara langsung pengalaman menggunakan websitenya.
                <a href="<?php echo $posts->templates_url ?>" target="_blank"class="btn btn-outline-primary btn-sm">Lihat Demo</a>
            </div>
            <div class="col-lg-4 col-md-5 animation" data-animation="fadeInUp" data-animation-delay="0.6s">
            	<div class="gray_bg p-3 p-md-4">
                    <ul class="list_none portfolio_info_box">
												<?php $category = $this->Crud_m->view_join_where_array('templates_category','templates','templates_cat_id',array ('templates.templates_cat_id' => $posts->templates_cat_id))->row_array(); ?>
                        <li><span class="text-uppercase">Untuk Bisnis</span><?php echo $category['templates_cat_judul']?></li>
                        <li><span class="text-uppercase">Fitur Unggulan</span><?php echo $posts->templates_fitur ?></li>
												<li><span class="text-uppercase">Sudah Sesuai</span><a href="https://api.whatsapp.com/send?phone=<?php echo $identitas->whatsapp?>&text=Hai,%20Crudbiz.%20Saya%20mau%20bikin%20website%20dengan%20memilih%20<?php echo $posts->templates_judul ?>.%20Bagaimana%20cara%20memesannya%20?" class="btn btn-success btn-sm">Pilih Website Ini</a></li>
												<li><span class="text-uppercase">Bagikan </span>
                        	<ul class="list_none social_icons border_social rounded_social">
                            	<li><a href="http://www.facebook.com/sharer.php?u=<?php echo base_url("templates/$posts->templates_judul_seo ") ?>" onclick="window.open('https://www.facebook.com/sharer.php?u=<?php echo base_url("templates/$posts->templates_judul_seo ") ?>','newwindow','width=400,height=350');  return false;" title="Facebook" target="_blank" title="Facebook"><i class="ion-social-facebook"></i></a></li>
                            	<li><a href="whatsapp://send?text=<?php echo $posts->templates_judul ?> | <?php echo base_url("$posts->templates_judul_seo ") ?>" title="Whatsapp" target="_blank"><i class="ion-social-whatsapp"></i></a></li>
                        	</ul>
                        </li>
                    </ul>
                </div>
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
                    <h3>Ingin Lihat Tampilan Website Yang Lainnya ?</h3>
                    <p><center>Kami memiliki beragam tampilan website yang tepat untuk meningkatkan pemasaran produk Anda</center></p>

                </div>
					</div>
      </div>
			<div class="row">
					<div class="col-12">
							<div class="cleafix small_divider"></div>
					</div>
			</div>
			<div class="row">
					<div class="col-md-12">
							<ul class="list_none carousel_slide4 owl-carousel owl-theme" data-margin="15" data-dots="false" data-autoplay="false" data-nav="true" data-loop="true">
								<?php  foreach ($posts_templates as $post_new){
									?>
									<a href="<?php echo base_url("templates/$post_new->templates_judul_seo")?>">
									<li>
										<?php
																							if(empty($post_new->templates_gambar)) {
																								echo "<img style='height:210px' src='".base_url()."assets/frontend/campur/template_blank.jpg'>";
																							}else {
																								echo " <img style='height:210px' src='".base_url()."assets/frontend/produk/".$post_new->templates_gambar."'> ";}
																							?>

									</li>
									</a>
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
