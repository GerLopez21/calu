<?php 
    headerAdmin($data); 
    getModal('modalStock',$data);
?>
    <div id="contentAjax"></div> 

    <main class="app-content">
      <div class="app-title">
        <div>
            <h1><i class="fas fa-box"></i> <?= $data['page_title'] ?>
              <?php if($_SESSION['permisosMod']['w']){ ?>
                <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Nuevo</button>
              <?php } ?> 
            </h1>
        </div>

        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/productos"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                              <input type="hidden" id="idProducto" name="idProducto" value=<?= $_SESSION['producto'] ?>>

                    <table class="table table-hover table-bordered" id="tableStock">
                      <thead>
                        <tr>


                          <th>Talle</th>
                          <th>Color</th>
                          <th>Stock</th>
                          <th>Foto referencia</th>

                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr></tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </main>
<?php footerAdmin($data); ?>
    