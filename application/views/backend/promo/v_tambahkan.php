
<?php $this->load->view('backend/top')?>
<?php $this->load->view('backend/menu')?>



<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Tambah Promo</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url()?>aspanel/promo">Promo</a></li>
            <li class="breadcrumb-item active">Tambah Promo</li>
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
            echo form_open_multipart('aspanel/promo_tambahkan',$attributes); ?>
              <div class="card-body">
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Produk</label>
                          <select name='templates_id' class="form-control select2" style="width: 100%;">
                            <?php foreach ($records as $row) {
                              if ($rows['templates_id'] == $row['templates_id']){
                                echo"<option selected='selected' value='$row[templates_id]'>$row[templates_judul]</option>";
                              }else{
                                echo"<option value='$row[templates_id]'>$row[templates_judul]</option>";
                           }
                         } ?>
                        </select>

                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Judul</label>
                        <input type="text" class="form-control" name="promo_judul">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Diskon Flash Sale</label>
                        <div class="input-group mb-3">
                          <input type="number" class="form-control" name="promo_harga">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Limit</label>
                        <input type="number" class="form-control" name="promo_limit">
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Berakhir Tanggal</label>
                        <input type="date" class="form-control" name="promo_selesai_tanggal">
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Berakhir Jam</label>
                        <input type="time" class="form-control" name="promo_selesai_jam">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Gambar</label>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="gambar" id="exampleInputFile">
                          <label class="custom-file-label" for="exampleInputFile">Tambah Gambar</label>
                          <p> Dimensi foto Landscape 1080px x 1080px & maksimal ukuran file 2 Mb </p>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <div class="card-footer">
                <button type="submit" name ="submit" class="btn btn-success" title="Add Products"><i class="fas fa-file-upload"></i> Add</button>
                <a class="btn btn-outline-info" title="Cancel" href="<?php echo base_url()?>aspanel/promo"><i class="fab fa-creative-commons-sa"></i> Cancel</a>

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
