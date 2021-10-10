<section class="small_pb">
    <div class="container">
    	<div class="row">
            <div class="col-sm-12" >
                <div class="heading_s4 text-center">
                	<span class="sub_title">Model Template</span>
                    <h2>Model Template</h2>
                </div>
                <p><center>Pilihan template yang tepat dan bisa di kustom sesuai dengan karakter bisnis Anda</center></p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="cleafix small_divider"></div>
            </div>
        </div>
        <div class="row mb-3 mb-sm-5" >
            <div class="col-md-12 text-center">
                <ul class="list_none portfolio_filter filter_tab2">
                  <?php  foreach ($posts_templates_category as $post_new){
  									?>
                    <li><a href="#" data-filter=".<?php echo $post_new->templates_cat_judul_seo?>"><?php echo $post_new->templates_cat_judul?></a></li>

                  <?php }?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="portfolio_container gutter_small work_col3 portfolio_gallery portfolio_style2" >
                	<li class="grid-sizer"></li>
                  <?php  foreach ($posts_templates as $post_new){
                    ?>
                    <li class="portfolio-item <?php echo $post_new->templates_cat_judul_seo?>">
                        <div class="portfolio_item">
                            <a href="<?php echo base_url("templates/$post_new->templates_judul_seo")?>" class="image_link">
                              <?php
                                                        if(empty($post_new->templates_gambar)) {
                                                          echo "<img style='height:400px' src='".base_url()."assets/frontend/campur/template_blank.jpg'>";
                                                        }else {
                                                          echo " <img style='height:400px' src='".base_url()."assets/frontend/produk/".$post_new->templates_gambar."'> ";}
                                                        ?>
                            </a>
                                <div class="portfolio_content">
                                  <div class="link_container">
                                      <a href="<?php echo base_url()?>assets/frontend/produk/<?php echo $post_new->templates_gambar?> " class="image_popup"><i class="ion-image"></i></a>
                                      <a href="<?php echo base_url("templates/$post_new->templates_judul_seo")?>"><i class="ion-plus"></i></a>
                                  </div>
                              </div>
                        </div>
                    </li>
                  <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</section>
