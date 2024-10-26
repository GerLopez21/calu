<?php 
    headerAdmin($data); 
?>
<style>
table {

  overflow-x:auto;
}
table td {
  word-wrap: break-word;
  max-width: 400px;
}
#tableMovimientos td {
  white-space:inherit;
}
</style>
    <div id="contentAjax"></div> 
    <main class="app-content">
      <div class="app-title">
        <div>
            <h1><i class="fas fa-user-tag"></i> <?= $data['page_title'] ?>
              <?php if($_SESSION['permisosMod']['w']){ ?>
                <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Nuevo</button>
              <?php } ?> 
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/movimientos"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>

        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped dt-responsive nowrap" id="tableMovimientos">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Tipo movimiento</th>
                          <th>Procedencia</th>
                          <th>Producto</th>
                          <th>Fecha</th>
                          <th>Observacion</th>
                          <th>Cantidad</th>
                          <th>General/Individual</th>

                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </main>
<?php footerAdmin($data); ?>
    