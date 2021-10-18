<?php $this->load->view('backend/top')?>
<?php $this->load->view('backend/menu')?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Sampah Kategori Produk</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"><a href="<?php echo base_url()?>aspanel/produks_cat">Kategori Produk</a></li>
            <li class="breadcrumb-item active">Sampah Kategori Produk</li>
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
              <h3 class="card-title"><a class="btn btn-success btn-sm" title="Edit Data" href="<?php echo base_url()?>aspanel/produks_cat">Kembali</a></h3>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Judul</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                foreach ($record as $row){
                  $tgl_posting = $this->mylibrary->tgl_indo($row['templates_cat_post_tanggal']);
                  ?>

                <tr>
                  <td><?=$tgl_posting?></td>
                  <td><?=$row['templates_cat_judul']?></td>
                  <td>
                    <?php
                    echo"<a class='btn btn-primary btn-sm' title='Edit Data' href='".base_url()."aspanel/produks_cat_restore/$row[templates_cat_id]'>Restore</a>
                    <a class='btn btn-danger btn-sm' title='Permanently Delete' href='".base_url()."aspanel/produks_cat_delete/$row[templates_cat_id]' onclick=\"return confirm('Anda yakin ingin menghapus secara permanen?')\"><i class='fas fa-trash-alt'></i></a>";
                    ?>
                  </td>
                </tr>
              <?php } ?>

                </tbody>
                <tfoot>
                <tr>
                  <th>Tanggal</th>
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
