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
<meta name="site_url" content="<?php echo base_url()?><?=$menu?>/<?php echo $posts->templates_judul_seo ?>">
<meta name="description" content="<?php echo $posts->templates_meta_desk ?>">
<meta name="keywords" content="<?php echo $posts->templates_keyword ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="alternate" href="<?php echo base_url()?><?=$menu?>/<?php echo $posts->templates_judul_seo ?>" hreflang="id" />
<link href='<?php echo base_url()?><?=$menu?>/<?php echo $posts->templates_judul_seo ?>' rel='canonical'/>
<meta property="og:site_name" content="<?php echo $identitas->nama_website?>">
<meta property="og:description" content="<?php echo $posts->templates_meta_desk ?>">
<meta property="og:url" content="<?php echo base_url()?><?=$menu?>/<?php echo $posts->templates_judul_seo ?>">
<meta property="og:image" content="<?php echo base_url()?>assets/frontend/produk/<?php echo $posts->templates_gambar ?>">
<meta property="og:image:url" content="<?php echo base_url()?>assets/frontend/produk/<?php echo $posts->templates_gambar ?>">
<meta property="og:type" content="article">
<link rel="shortcut icon" href="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->favicon?>" type="image/x-icon">
<?php $this->load->view('fronts/analytics')?>
<?php $this->load->view('fronts/css')?>
</head>

<body>

  <div class="ajax_quick_view">
          <div class="row">
            <div class="col-lg-5 col-md-5">
              <div class="product-image">
                <?php
                if(empty($posts->templates_gambar)) {
                  echo "";
                }else{
                  echo "<img id='product_img' src='".base_url()."assets/frontend/produk/".$posts->templates_gambar."' data-zoom-image='".base_url()."assets/frontend/produk/".$posts->templates_gambar."'> ";}
                ?>
                <div id="pr_item_gallery" class="product_gallery_item owl-thumbs-slider owl-carousel owl-theme">
                       <?php
                       if(empty($posts->templates_gambar)) {
                         echo "";
                       }else{
                         echo "
                         <div class='item' height='100px' width='100px'>
                          <a href='#' class='active' data-image='".base_url()."assets/frontend/produk/".$posts->templates_gambar."' data-zoom-image='".base_url()."assets/frontend/produk/".$posts->templates_gambar."'>
                          <img  src='".base_url()."assets/frontend/produk/".$posts->templates_gambar."' />
                         </div>
                         ";
                       }
                       ?>
                  </div>

                </div>
              </div>
            <div class="col-lg-7 col-md-7">
                  <div class="pr_detail">
                    <div class="product-description">
                      <div class="product-title">
                        <h4><?php echo $posts->templates_judul; ?></h4>
                      </div>
                      <div class="product_price float-left">
                        <?php
                        if(empty($posts->templates_harga_diskon)) { ?>
                        <ins>Rp<?php echo number_format($posts->templates_harga,0,',','.')?></ins>

                        <?php }else if($a = $posts->templates_harga - ($posts->templates_harga * ($posts->templates_harga_diskon/100))){?>
                          <del>Rp<?php echo number_format($posts->templates_harga,0,',','.') ?></del><ins>Rp<?php echo number_format($a,0,',','.')?></ins>
                        <?php }?>

                      </div>
                      <div class="clearfix"></div>
                      <div align="left">
                          <span><?php echo $posts->templates_dibeli; ?> Terjual</span>
                      </div>
                      <div class="clearfix"></div>
                      <hr />
                      <p><?php echo $posts->templates_desk; ?></p>
                    </div>
                    <hr />
                    <div>
                      <div class="cart_btn">
                        <a href="https://api.whatsapp.com/send?phone=<?php echo $identitas->whatsapp?>&text= Halo Seserahant ! Aku mau <?php echo $posts->templates_judul; ?> | <?php echo base_url(); ?>produk/<?php echo $posts->templates_judul_seo ?>" class="btn btn-primary"><i class="ion-android-cart mr-2 ml-0"></i>Pesan Sekarang</a>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr />
                    <div class="product_share d-block d-sm-flex align-items-center">
                      <span>Bagikan ke:</span>
                        <ul class="list_none social_icons">
                              <li><a href="http://www.facebook.com/sharer.php?u=<?php echo base_url("produk/$posts->templates_judul_seo ") ?>" onclick="window.open('https://www.facebook.com/sharer.php?u=<?php echo base_url("produk/$posts->templates_judul_seo ") ?>','newwindow','width=400,height=350');  return false;" title="Facebook" target="_blank"><i class="ion-social-facebook"></i></a></li>
                              <li><a href="whatsapp://send?text=<?php echo $posts->templates_judul ?> | <?php echo base_url("produk/$posts->templates_judul_seo ") ?>"><i class="ion-social-whatsapp"></i></a></li>

                        </ul>
                    </div>
                  </div>
              </div>
          </div>

      </div>
  </div>

<script src="<?php echo base_url()?>assets/js/shop-quick-view.js"></script>
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
