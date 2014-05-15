<?php $title = 'Upload'; include("header.php"); ?>
	<div class="container">
		<form action="/controllers/file_upload.php" method="post" enctype="multipart/form-data" role="form" class="form-horizontal col-md-3" />
			<input type="hidden" name="folderid" value="CCB166CB-8A3E-45D8-A87C1A3A875E0714" />
			<div class="form-group">
                <input id="upload" type="file" name="filecontents" />
            </div>
            <div class="form-group">
                <input id="filename" type="text" class="form-control" name="filename" required placeholder="Name of file" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Upload</button>
            </div>
		</form>				
	</div>
<?php include("footer.php"); ?>

<script>
$("document").ready(function(){
    $("#upload").change(function() {
        $("#filename").val($('#upload').prop("files")[0].name);
    });
});
</script>