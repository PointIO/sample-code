<?php $title = 'List'; include("header.php"); ?>
	<div class="container">
		<div class="row">
		<table class="table table-striped table-bordered">
			<tr>
				<th>Name</th>
				<th>Location</th>
				<th>Modified</th>
				<th>Size</th>
				<th></th>
			</tr>
		<?php
			include('controllers/pio.php');
			$rules = pio_list_access_rules($_SESSION["sessionKey"])["RESULT"]["DATA"];

			foreach($rules as $rule){

				$list = pio_list_folders($_SESSION["sessionKey"], $rule[1]);
				$folders = $list["RESULT"]["DATA"];
				aasort($folders, 2);

				foreach($folders as $f){
		?>				
			<tr>
				<td>
					<?php 
						if($f[2] == "DIR"){
							echo '<i class="fa fa-folder-open"></i> ';
						}else{
							echo '<i class="fa fa-file-text"></i> ';
						}
						echo $f[1]; 
					?>
				</td>
				<td><?php echo $rule[5]; ?></td>
				<td><?php echo substr($f[7], 5, strlen($f[7]) - 7); ?></td>
				<td><?php echo $f[8]; ?></td>
				<td>
					<?php if($f[2] == "FILE"){ ?>
						<button class="btn" onclick="preview('<?php echo $f[16] ?>', '<?php echo $f[0] ?>', '<?php echo $f[1] ?>');">Preview</button>
						<button class="btn" onclick="download('<?php echo $f[16] ?>', '<?php echo $f[0] ?>', '<?php echo $f[1] ?>');">Download</button>
						<button class="btn" onclick="createLink('<?php echo $f[16] ?>', '<?php echo $f[0] ?>', '<?php echo $f[1] ?>', '<?php echo $f[4] ?>', '<?php echo $f[3] ?>');">Create Link</button>
						<button class="btn" onclick="checkout('<?php echo $f[16] ?>', '<?php echo $f[0] ?>', '<?php echo $f[1] ?>', '<?php echo $f[4] ?>', '<?php echo $f[3] ?>');">Check Out</button>
					<?php } ?>
				</td>
			</tr>
		<?php 
			}
		}
		?>
		</table>
	</div>
	<div class="modal fade">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">Here's your link</h4>
	      </div>
	      <div class="modal-body">
	        <a target="_blank" class="createdLink"></a>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<script>
		function preview(folderid, fileid, filename){
			$.ajax({ 
				url: '/controllers/file_preview.php',
				data: {
					folderid: folderid, 
					fileid: fileid, 
					filename: filename
				},
		        type: 'post',
		        success: function(url) {
		        	location.href = url;
		        }
			});
		}
		
		function download(folderid, fileid, filename){
			$.ajax({ 
				url: '/controllers/file_download.php',
				data: {
					folderid: folderid, 
					fileid: fileid, 
					filename: filename
				},
		        type: 'post',
		        success: function(url) {
		        	location.href = url;
		        }
			});
		}

		function createLink(shareid, fileid, filename, remotepath, containerid){
			$.ajax({ 
				url: '/controllers/file_create_link.php',
				data: {
					shareid: shareid, 
					fileid: fileid, 
					filename: filename,
					remotepath: remotepath,
					containerid: containerid
				},
		        type: 'post',
		        success: function(url) {
		        	console.log(url);
		        	$('.createdLink').attr('href', url);
		        	$('.createdLink').html(url);
		        	$('.modal').modal();
		        }
			});
		}

		function checkout(folderid, fileid, filename){
			$.ajax({ 
				url: '/controllers/file_checkout.php',
				data: {
					folderid: folderid, 
					fileid: fileid, 
					filename: filename
				},
		        type: 'post',
		        success: function(response) {
		        	console.log(response);
		        }
			});
		}
	</script>
<?php include("footer.php"); ?>