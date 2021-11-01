<?php $this->load->view('backend/top')?>
<?php $this->load->view('backend/menu')?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Daftar promo</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php base_url()?>home">Beranda</a></li>
            <li class="breadcrumb-item active">Daftar promo</li>
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
              <h3 class="card-title"><a class="btn btn-success btn-sm" title="Tambahkan" href="<?php echo base_url()?>aspanel/promo_tambahkan"><i class="fas fa-plus-circle"></i></a></h3>
              <h3 class="text-right"><a class="btn btn-outline-warning btn-sm" title="Sampah" href="<?php echo base_url()?>aspanel/promo_storage_bin"><i class="fas fa-trash"></i></a></h3>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Berakhir Pada</th>
                  <th>Judul</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                foreach ($record as $row){
                  $tgl_posting = $this->mylibrary->tgl_indo($row['promo_post_tanggal']);
                  ?>

                <tr>
                  <td><?=$row['promo_selesai_tanggal']?> <?=$row['promo_selesai_jam']?></td>
                  <td><?=$row['promo_judul']?></td>
                  <td>
                    <?php
                    echo"<a class='btn btn-primary btn-sm' title='Edit Data' href='".base_url()."aspanel/promo_update/$row[promo_id]'><i class='fas fa-edit'></i></a>
                    <a class='btn btn-danger btn-sm' title='Delete Data' href='".base_url()."aspanel/promo_delete_temp/$row[promo_id]' onclick=\"return confirm('Are you sure want to delete this data?')\"><i class='fas fa-trash-alt'></i></a>";
                    ?>
                  </td>
                </tr>
              <?php } ?>

                </tbody>
                <tfoot>
                <tr>
                  <th>Berakhir Pada</th>
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
