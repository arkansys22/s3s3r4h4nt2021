<header class="header_wrap light_skin bg-dark sticky_light_skin hover_menu_style3">
	<div class="top-header dark_skin bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-5">

                </div>
                <div class="col-sm-7">
                	<ul class="list_none header_list list_menu justify-content-center justify-content-sm-end">
                    <a href="https://api.whatsapp.com/send?phone=<?php echo $identitas->whatsapp?>&text= Halo Seserahant, mau konsultasi untuk pernikahan saya.">Gratis Konsultasi Pernikahan</a>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
     <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand m-auto" href="<?php echo base_url()?>">
            <img class="logo_light" src="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->logo?>" alt="logo">

        </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="ion-android-menu"></span> </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
              <ul class="navbar-nav">
                  <li class="dropdown">
                      <a class="nav-link" href="<?php echo base_url()?>">Home</a>
                  </li>
									<?php foreach ($posts_templates_category as $post_new){  ?>
                  <li class="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><?php echo $post_new->templates_cat_judul ?></a>
                        <div class="dropdown-menu">
                            <ul>
															<?php $posts_templates = $this->Crud_m->view_where_order('templates',array('templates_status'=>'publish', 'templates_cat_id'=>$post_new->templates_cat_id),'templates_id','desc'); ?>
															<?php foreach ($posts_templates as $post_new2){  ?>
                            	<li>
																<a class="dropdown-item menu-link" href="<?php echo base_url()?>produk/<?php echo $post_new2->templates_judul_seo; ?>"><?php echo $post_new2->templates_judul; ?></a>
                              </li>
														<?php } ?>
                            </ul>
                        </div>
                	</li>
									<?php } ?>
									<li class="dropdown">
                      <a class="nav-link" href="<?php echo base_url()?>">Tips</a>
                  </li>
              </ul>
            </div>

        </nav>
</div>
</header>
