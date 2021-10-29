
<?php $this->load->view('backend/top')?>
<?php $this->load->view('backend/menu')?>



<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Tambah Produk</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url()?>aspanel/produks">Produk</a></li>
            <li class="breadcrumb-item active">Tambah Produk</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12 col-xs-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"></h3>
            </div>
            <!-- /.card-header -->


            <!-- form start -->
            <?php $attributes = array('class'=>'form-horizontal','role'=>'form');
            echo form_open_multipart('aspanel/produks_tambahkan',$attributes); ?>
              <div class="card-body">
                <div class="form-group">

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Judul</label>
                        <input type="text" class="form-control" name="templates_judul">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                  <div class="form-group">
                    <label>Kategori</label>

                      <select name='templates_cat_id' class="form-control select2" style="width: 100%;">
                        <?php foreach ($records as $row) {
                          if ($rows['templates_cat_id'] == $row['templates_cat_id']){
                            echo"<option selected='selected' value='$row[templates_cat_id]'>$row[templates_cat_judul]</option>";
                          }else{
                            echo"<option value='$row[templates_cat_id]'>$row[templates_cat_judul]</option>";
                       }
                     } ?>
                    </select>

                  </div>
                </div>
              </div>
                <div class="row">
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label>Harga Normal</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" class="form-control" name="templates_harga" placeholder="Hanya nominal angka tanpa tanda titik">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Diskon Promo</label>
                      <div class="input-group mb-3">
                        <input type="number" class="form-control" name="templates_harga_diskon" placeholder="Kosongkan bila tidak diskon">
                        <div class="input-group-append">
                          <span class="input-group-text">%</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                      <label>URL Marketplace</label>
                    </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Shopee</span>
                      </div>
                      <input type="text" class="form-control" name="templates_url" >
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="input-group mb-6">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Tokopedia</span>
                      </div>
                      <input type="text" class="form-control" name="templates_url_tokped">
                    </div>
                  </div>
                </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="textarea"  name ="templates_desk" style="width: 100%; height: 100px;"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Meta Deskripsi</label>
                        <input type="text" class="form-control" name="templates_meta_desk">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Kata Kunci</label>
                        <input type="text" class="form-control tags" id="blogs_keyword" value="" name="templates_keyword"  data-role="tagsinput"/>
                          <?php foreach ($tag as $tag){    } ?>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Gambar</label>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="gambar" id="exampleInputFile">
                          <label class="custom-file-label" for="exampleInputFile">Add Image</label>
                          <p> Dimensi foto Landscape 1080px x 1080px & maksimal ukuran file 2 Mb </p>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <div class="card-footer">
                <button type="submit" name ="submit" class="btn btn-success" title="Tambahkan"><i class="fas fa-file-upload"></i> Tambahkan</button>
                <a class="btn btn-outline-info" title="Cancel" href="<?php echo base_url()?>aspanel/produks"><i class="fab fa-creative-commons-sa"></i> Batal</a>

              </div>
                <?php echo form_close(); ?>


          </div>


        </div>

      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>

</div>
  <!-- /.content-wrapper -->


<?php $this->load->view('backend/bottom')?>
