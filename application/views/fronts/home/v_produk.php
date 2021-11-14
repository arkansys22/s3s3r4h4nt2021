<section class="small_pt">
    <div class="container">
    	<div class="row justify-content-center">
            <div class="col-lg-6 col-md-9">
                <div class="heading_s1 text-center">
                    <h2>Produk</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            	<div class="tab-style3">
                    <ul class="nav nav-tabs justify-content-center" role="tablist">
                      <?php foreach ($posts_templates_category as $post_new){  ?>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#<?php echo $post_new->templates_cat_judul_seo ?>" role="tab" aria-controls="<?php echo $post_new->templates_cat_judul_seo ?>"><?php echo $post_new->templates_cat_judul ?></a>
                      </li>
                    <?php } ?>
                    </ul>
                    <div class="tab-content tab_content_slider  mt-4 pt-2">
                          <?php foreach ($posts_templates_category as $post_new){  ?>
                            <div class="tab-pane fade" id="<?php echo $post_new->templates_cat_judul_seo ?>" role="tabpanel">
        						            <div class="carousel_slide4 owl-carousel owl-theme" data-margin="30">
                                  <?php $posts_templates = $this->Crud_m->view_where_order('templates',array('templates_status'=>'publish', 'templates_cat_id'=>$post_new->templates_cat_id),'templates_id','desc'); ?>
                                  <?php foreach ($posts_templates as $post_new2){  ?>

                                    <a href="<?php echo base_url("produk/$post_new2->templates_judul_seo ") ?>"><div class="item">
                                        <div class="shop-item">

                                            <div class="product">
                                                <div class="product_img">
                                                        <img src="<?php echo base_url()?>assets/frontend/produk/<?php echo $post_new2->templates_gambar; ?>" alt="image">
                                                        <?php
                                                        if(empty($post_new2->templates_harga_diskon)) {
                                                          echo "";
                                                        }else{
                                                          echo "<span class='flash'>$post_new2->templates_harga_diskon%</span>";}
                                                        ?>
                                                </div>
                                                <div class="product_info">
                                                    <div class="product_title">
                                                        <h5><?php echo $post_new2->templates_judul; ?></h5>
                                                    </div>
                                                    <div class="product_price">

                                                        <?php
                      																	if(empty($post_new2->templates_harga_diskon)) { ?>
                      																		<ins>Rp<?php echo number_format($post_new2->templates_harga,0,',','.')?></ins>
                      																	<?php
                                                      }else if($a = $post_new2->templates_harga - ($post_new2->templates_harga * ($post_new2->templates_harga_diskon/100))){?>
                      																	<del>Rp<?php echo number_format($post_new2->templates_harga,0,',','.')?></del><ins>Rp<?php echo number_format($a,0,',','.')?></ins>
                                                      <?php }?>


                                                    </div>
                                                    <div align="left">
                                                        <span><?php echo $post_new2->templates_dibeli; ?> Terjual</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>  </a>
                                  <?php } ?>
                                </div>
                            </div>
                          <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
