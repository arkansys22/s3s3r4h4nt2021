<header class="header_wrap dark_skin hover_menu_style1" >
  <div class="top-header bg_blue light_skin d-none d-md-block border-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                      <ul class="list_none social_icons rounded_social social_white mt-2 mt-md-0">
                          <li><a href="#"><i class="ion-social-youtube-outline"></i></a></li>
                          <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                          <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                           <li><a href="#"><i class="ion-social-linkedin"></i></a></li>
                      </ul>
                </div>
            </div>
        </div>
    </div>
  <div class="container " >
    <nav class="navbar navbar-expand-lg">
    	<a class="navbar-brand" href="<?php echo base_url()?>">
			<img class="logo_light" src="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->logo?>" alt="logo" />
            <img class="logo_dark" src="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->logo?>" alt="logo" />
            <img class="logo_default" src="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->logo?>" alt="logo" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="ion-android-menu"></span> </button>
      	<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Bikin Website</a>
                        <div class="dropdown-menu">
                            <ul>
                              <?php  foreach ($posts_paketharga as $post_new){ ?>
                                <li><a class="dropdown-item nav-link nav_item" href="<?php echo base_url("harga/$post_new->paketharga_judul_seo") ?>"><?php echo $post_new->paketharga_judul?></a></li>
                            <?php } ?>
                            </ul>
                        </div>
                </li>
                <li class="dropdown dropdown-mega-menu">
                    <a class="nav-link " href="<?php echo base_url()?>">Promo</a>
                </li>
                <!--<li class="dropdown dropdown-mega-menu">
                    <a class="nav-link " href="<?php echo base_url()?>">Crudbiz VCLASS</a>
                </li>-->
            </ul>
        </div>
        <ul class="navbar-nav attr-nav align-items-center">
                <li class="dropdown"><a class=" nav-link" href="#" data-toggle="dropdown"><i class="ion-person"></i></a>
                	<div class="cart_box dropdown-menu dropdown-menu-right">
                    <div class="field_form form_style4">
                      <br>
                      <?php echo form_open('login'); ?>
                        <div class="form-group col-md-12">
                            <input required placeholder="Username" class="form-control" name="username" type="text">
                            <label>Username:</label>
                        </div>
                        <div class="form-group col-md-12">
                            <input required placeholder="Password" class="form-control" name="password" type="text">
                            <label>Password:</label>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-default btn-aylen col-md-12">Masuk</button>
                            <p><center><a href="">Lupa kata sandi?</a></center></p>
                            <p><span>atau <a href="<?php echo base_url()?>daftar">daftar baru</a> hanya 20 detik untuk akun baru Anda.</span></p>
                        </div>
                      </form>
                      <?php echo form_close(); ?>
                    </div>
                    </div>
                </li>
                <li><a href="https://api.whatsapp.com/send?phone=<?php echo $identitas->whatsapp?>&text= Halo Crudbiz, mau konsultasi untuk bisnis saya." class="nav-link "><i class="ion-social-whatsapp-outline"></i></a>
            </ul>
    </nav>
  </div>
</header>
