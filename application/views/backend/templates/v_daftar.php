<?php $this->load->view('backend/top')?>
<?php $this->load->view('backend/menu')?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Daftar Produk</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url()?>">Home</a></li>
            <li class="breadcrumb-item active">Daftar Produk</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
            <a class="btn btn-success btn-sm" title="Tambah Data" href="<?php echo base_url()?>aspanel/produks_tambahkan"><i class="fas fa-plus-circle"></i> Tambah</a>

              <a class="btn btn-success btn-sm" title="Edit Data" href="<?php echo base_url()?>aspanel/produks_cat"><i class="fas fa-plus-circle"></i> Kategori</a></h3>

              <h3 class="text-right"><a class="btn btn-danger btn-sm" title="Sampah" href="<?php echo base_url()?>aspanel/produks_storage_bin"><i class="fas fa-trash"></i> Sampah</a></h3>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Kategori</th>
                  <th>Judul</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                foreach ($record as $row){
                  $tgl_posting = $this->mylibrary->tgl_indo($row['templates_post_tanggal']);
                  ?>

                <tr>
                  <td><?=$tgl_posting?></td>
                  <td><?=$row['templates_cat_judul']?></td>
                  <td><?=$row['templates_judul']?></td>
                  <td>
                    <?php
                    echo"
                    <a class='btn btn-primary btn-sm' title='Edit Data' href='".base_url()."aspanel/produks_update/$row[templates_judul_seo]'><i class='fas fa-edit'></i></a>
                    <a class='btn btn-danger btn-sm' title='Delete Data' href='".base_url()."aspanel/produks_delete_temp/$row[templates_id]' onclick=\"return confirm('Are you sure want to delete this data?')\"><i class='fas fa-trash-alt'></i></a>";
                    ?>
                  </td>
                </tr>
              <?php } ?>

                </tbody>
                <tfoot>
                <tr>
                  <th>Tanggal</th>
                  <th>Kategori</th>
                  <th>Judul</th>
                  <th>Aksi</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
    </section>
</div>

<?php $this->load->view('backend/bottom')?>
