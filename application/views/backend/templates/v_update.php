
<?php $this->load->view('backend/top')?>
<?php $this->load->view('backend/menu')?>



<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Update templates</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url()?>aspanel/templates">templates</a></li>
            <li class="breadcrumb-item active">Update templates</li>
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
            echo form_open_multipart('aspanel/templates_update',$attributes); ?>


              <div class="card-body">
                <div class="form-group">
                  <input type="hidden" name="templates_id" value="<?php echo $rows['templates_id'] ?>">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="templates_judul" value="<?php echo $rows['templates_judul'] ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                  <div class="col-sm-12">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 col-form-label">Category</label>
                    <div class="col-sm-12">
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
                </div></div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Template Feature</label>
                      <input type="text" class="form-control" name="templates_fitur" value="<?php echo $rows['templates_fitur'] ?>">

                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Template Url</label>
                      <input type="text" class="form-control" name="templates_url" value="<?php echo $rows['templates_url'] ?>">
                    </div>
                  </div>
                </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Description</label>
                        <textarea class="textarea"  name ="templates_desk" style="width: 100%; height: 100px;"><?php echo $rows['templates_desk'] ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Meta Description</label>
                        <input type="text" class="form-control" name="templates_meta_desk" value="<?php echo $rows['templates_meta_desk'] ?>">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Keyword</label>
                        <input type="text" class="form-control tags" id="templates_keyword" name="templates_keyword" value="<?php echo $rows['templates_keyword'] ?>">
                      <?php   $_arrNilai = explode(',', $rows['templates_keyword']);
                        foreach ($tag as $tag){
                            $_ck = (array_search($tag['keyword_nama_seo'], $_arrNilai) === false)? '' : 'checked';
                         } ?>
                      </div>
                    </div>

                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>Gambar saat ini</label>
                          <div class="row">
                            <img class="img-fluid mb-3" src="<?php echo base_url()?>assets/frontend/produk/<?php echo $rows['templates_gambar'] ?>" alt="Photo">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Ubah gambar</label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="gambar">
                            <label class="custom-file-label" for="exampleInputFile"><?php echo $rows['templates_gambar'] ?></label>
                          </div>
                        </div>
                      </div>
                  </div>

                </div>
              </div>
              <div class="card-footer">
                <button type="submit" name ="submit" class="btn btn-success" title="Update Blog"><i class="fas fa-file-upload"></i> Update</button>
                <a class="btn btn-primary" title="Batal" href="<?php echo base_url()?>aspanel/templates"><i class="fab fa-creative-commons-sa"></i> Cancel</a>

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
