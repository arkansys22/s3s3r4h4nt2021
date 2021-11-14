<section class="small_pt small_pb">
    <div class="container">
    	<div class="row">
        	<div class="col-md-12">
            	<div class="heading_s1 heading_uppercase">
                	<h2>Popular Product</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="carousel_slide4 owl-carousel owl-theme nav_top" data-margin="30" data-nav="true" data-dots="false">
                  <?php foreach ($posts_popular as $post_new){  ?>
                    <div class="item">
                        <div class="shop-item">
                            <div class="product ">
                                <div class="product_img">
                                    <img src="<?php echo base_url()?>assets/frontend/produk/<?php echo $post_new->templates_gambar; ?>" alt="image">
                                    <?php
                                    if(empty($post_new->templates_harga_diskon)) {
                                      echo "";
                                    }else{
                                      echo "<span class='flash'>$post_new->templates_harga_diskon%</span>";}
                                    ?>
                                    <div class="product_action_box">
                                        <ul class="list_none pr_action_btn">
                                            <li><a href="<?php echo base_url("quick/$post_new->templates_judul_seo ") ?>" class="popup-ajax"><i class="ion-eye"></i></a></li>
                                            <li class="add-to-cart"><a href="https://api.whatsapp.com/send?phone=<?php echo $identitas->whatsapp?>&text= Halo Seserahant ! Aku mau <?php echo $post_new->templates_judul; ?> | <?php echo base_url(); ?>produk/<?php echo $post_new->templates_judul_seo ?>"><i class="ion-android-cart"></i></a></li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="product_info">
                                    <div class="product_title">
                                        <h5><?php echo $post_new->templates_judul; ?></h5>
                                    </div>
                                    <div class="product_price">
                                      <?php
                                      if(empty($post_new->templates_harga_diskon)) { ?>
                                      <ins>Rp<?php echo number_format($post_new->templates_harga,0,',','.')?></ins>

                                      <?php }else if($a = $post_new->templates_harga - ($post_new->templates_harga * ($post_new->templates_harga_diskon/100))){?>
                                        <del>Rp<?php echo number_format($post_new->templates_harga,0,',','.') ?></del><ins>Rp<?php echo number_format($a,0,',','.')?></ins>
                                      <?php }?>
                                    </div>
                                    <div align="left">
                                        <span><?php echo $post_new->templates_dibeli; ?> Terjual</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                  <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
