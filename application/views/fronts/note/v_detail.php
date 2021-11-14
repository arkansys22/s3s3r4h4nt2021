<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta content="crudbiz" name="author">
<meta NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
<title><?php echo $posts->note_judul ?> - <?php echo $posts->note_keyword ?> - <?php echo $identitas->slogan?></title>
<meta name="title" content="<?php echo $posts->note_judul ?> - <?php echo $posts->note_keyword ?> | <?php echo $identitas->nama_website?>">
<meta property="og:title" content="<?php echo $posts->note_judul ?> - <?php echo $posts->note_keyword ?> | <?php echo $identitas->nama_website?>">
<meta name="site_url" content="<?php echo base_url()?><?=$menu?>/<?php echo $posts->note_judul_seo ?>">
<meta name="description" content="<?php echo $posts->note_meta_desk ?>">
<meta name="keywords" content="<?php echo $posts->note_keyword ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="alternate" href="<?php echo base_url()?><?=$menu?>/<?php echo $posts->note_judul_seo ?>" hreflang="id" />
<link href='<?php echo base_url()?><?=$menu?>/<?php echo $posts->note_judul_seo ?>' rel='canonical'/>
<meta property="og:site_name" content="<?php echo $identitas->nama_website?>">
<meta property="og:description" content="<?php echo $posts->note_meta_desk ?>">
<meta property="og:url" content="<?php echo base_url()?><?=$menu?>/<?php echo $posts->note_judul_seo ?>">
<meta property="og:image" content="<?php echo base_url()?>assets/frontend/lininote/<?php echo $posts->note_gambar ?>">
<meta property="og:image:url" content="<?php echo base_url()?>assets/frontend/lininote/<?php echo $posts->note_gambar ?>">
<meta property="og:type" content="article">
<link rel="shortcut icon" href="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->favicon?>" type="image/x-icon">
<?php $this->load->view('fronts/analytics')?>
<?php $this->load->view('fronts/css')?>
</head>

<body>
  <?php $this->load->view('fronts/header.php')?>
<br><br>
<section>
  <div class="container">
      <div class="row">
          <div class="col-lg-9">
              <div class="single_post">
                    <div class="blog_content bg-white">
                        <div class="blog_text">
                            <h2><?php echo $posts->note_judul; ?></h2>
                            <p><?php echo $posts->note_desk ?></p>
                            <div class="py-4 blog_post_footer">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-md-8 mb-3 mb-md-0">
                                      <span>Bagikan ke:</span>
                                        <ul class="list_none social_icons border_social rounded_social">
                                          <li><a href="http://www.facebook.com/sharer.php?u=<?php echo base_url("syarat-ketentuan/$posts->note_judul_seo ") ?>" onclick="window.open('https://www.facebook.com/sharer.php?u=<?php echo base_url("syarat-ketentuan/$posts->note_judul_seo ") ?>','newwindow','width=400,height=350');  return false;" title="Facebook" target="_blank"><i class="ion-social-facebook"></i></a></li>
                                          <li><a href="whatsapp://send?text=<?php echo $posts->note_judul ?> | <?php echo base_url("syarat-ketentuan/$posts->note_judul_seo ") ?>"><i class="ion-social-whatsapp"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="related_post border-top">
                  <div class="comment-title mb-2 mb-sm-4">
                      <h5>Tips Pernikahan</h5>
                  </div>
                  <div class="row">
                    <?php foreach ($posts_blogs as $post_new){
                        $isi = character_limiter($post_new->blogs_desk,150);
                      ?>
                      <div class="col-md-4 mb-md-4 mb-2 pb-2">
                        <div class="blog_post blog_style1">
                            <div class="blog_img">
                                  <?php
                                  if(empty($post_new->blogs_gambar)) {
                                    echo "";
                                  }else{
                                    echo "<img src='".base_url()."assets/frontend/blogs/".$post_new->blogs_gambar."'> ";}
                                  ?>
                            </div>
                            <div class="blog_content bg-white">
                                <div class="blog_text">
                                    <h6 class="blog_title"><a href="<?php echo base_url() ?>tips/<?php echo $post_new->blogs_judul_seo ?>"><?php echo $post_new->blogs_judul; ?></a></h6>
                                    <ul class="list_none blog_meta">
                                        <li><i class="ion-calendar"></i> <?php echo $post_new->blogs_post_tanggal ?></li>
                                        <li>by <?php
                                        if(empty($post_new->blogs_update_oleh)) {
                                          echo "$post_new->blogs_post_oleh";
                                        }else {
                                          echo "$post_new->blogs_update_oleh";}
                                        ?></li>
                                    </ul>
                                    <?php echo $isi?>
                                    <a href="<?php echo base_url() ?>tips/<?php echo $post_new->blogs_judul_seo ?>" >...Lanjutkan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                  </div>
                </div>
            </div>
            <div class="col-lg-3 mt-lg-0 mt-4 pt-3 pt-lg-0">
              <div class="sidebar">
                  <div class="widget">
                      <h5 class="widget_title">Produk</h5>
                        <ul class="recent_post border_bottom_dash list_none">
                          <?php foreach ($posts_produk as $post_new){ ?>
                            <li>
                                <div class="post_footer">
                                    <div class="post_img">
                                      <?php
                                      if(empty($post_new->templates_gambar)) {
                                        echo "";
                                      }else{
                                        echo "<img height='60px' width='60px' src='".base_url()."assets/frontend/produk/".$post_new->templates_gambar."'> ";}
                                      ?>
                                    </div>
                                    <div class="post_content">
                                        <h6><a href="<?php echo base_url() ?>produk/<?php echo $post_new->templates_judul_seo ?>"><?php echo $post_new->templates_judul; ?></a></h6>
                                        <p class="small m-0"><?php echo $post_new->templates_dibeli; ?> Terjual</p>
                                    </div>
                                </div>
                            </li>
                          <?php } ?>
                      </ul>
                    </div>
                </div>
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
