<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
<form method="post" action="<?= base_url() ?>admin/images/submit" enctype="multipart/form-data">
                        <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>" />
            <label>Image type</label>
            <div class="row">
                <?php foreach ($options as $option) { ?>
                <div class="col-xl-4 col-sm-6">
                  <div class="mb-3">
                    <label class="card-radio-label mb-2">
                      <input type="radio" name="type" value="<?= $option['type'] ?>" class="card-radio-input" required>
                      <div class="card-radio">
                        <div>
                        <?php if($option['type'] == 'favicon') { ?>
                          <span><?= $option['type'] ?> 64x64 Pixel</span>
                        <?php }else if($option['type'] == 'hero_image') { ?>
                          <span><?= $option['type'] ?> 1920x1053 Pixel</span>
                        <?php }else if($option['type'] == 'logo') { ?>
                          <span><?= $option['type'] ?> 500x500 Pixel</span>
                        <?php } ?>
                        </div>
                      </div>
                    </label>
                  </div>
                </div>
              <?php } ?>
            </div>
    <div class="form-group">
        <label><b>Upload only 1 image per type, delete old image before UPLOAD new one, supported image files (.jpg|.JPG|.jpeg|.JPEG|.png|.PNG).<br> CLICK HERE TO ADD</b></label>
        <input class="form-control" type="file" name="files[]" multiple id="imgInp"/>

  <img id="blah" src="#" alt="your image" style="display:none;" width="200"/>

    </div>
<script>
imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file);
    blah.style = 'display:block;'
  }
}
</script>
<input class="btn btn-primary" type="submit" name="fileSubmit"/>
</form>
    <h3 class="mt-3">My images</h3>
    <div class="row">
        <?php if(!empty($files)){ foreach($files as $file){ ?>
        <div class="col-md-6">
            <label style="text-transform: uppercase;">Type: <?= $file['type']; ?></label><br>
            <img src="<?= base_url('assets/upload/'.$file['type'].'/'.$file['file_name']); ?>" width="100"><a href="<?= base_url() ?>admin/images/delete/<?= $file['id']; ?>/<?= $file['type']; ?>/<?= $file['file_name']; ?>" class="btn btn-sm btn-danger">delete</a>
            <p>Uploaded on <?php echo date("j M Y",strtotime($file['uploaded_on'])); ?></p>
<br>
        </div>
        <?php } }else{ ?>

        <?php } ?>
    </div>
            </div>
        </div>
    </div>
</div>
