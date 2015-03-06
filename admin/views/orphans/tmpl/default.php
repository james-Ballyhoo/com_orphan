<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<form method="post" name="adminForm" id="adminForm">
	<div id="editcell">
		<div class="container">
			<div class="row">
				<div class="span4 offset2">
					<table class="table table-striped table-hover">
						<tr><th>Total files:</th><td><?=$this->sumTable["ttl_files"]?></td></tr>
						<tr><th>Orphaned files:</th><td><?=$this->sumTable["ttl_orphans"]?></td></tr>
						<tr><th>Total size :</th><td><?=$this->sumTable["ttl_size"]?></td></tr>
						<tr><th>Total wasted size:</th><td><?=$this->sumTable["ttl_wasted_size"]?></td></tr>
					</table>
					<h4>Files</h4>
					<div class="progress">
						<div class="bar bar-success" title=">1 reference" style="width: <?=($this->graphs["good"]["files"]   / $this->graphs["total"]["files"])*100?>%"><?=$this->graphs["good"]["files"]?></div>
						<div class="bar bar-warning" title="1 reference"  style="width: <?=($this->graphs["single"]["files"] / $this->graphs["total"]["files"])*100?>%"><?=$this->graphs["single"]["files"]?></div>
						<div class="bar bar-danger"  title="0 references" style="width:  <?=($this->graphs["orphan"]["files"] / $this->graphs["total"]["files"])*100?>%"><?=$this->graphs["orphan"]["files"]?></div>
					</div>
					<h4>Disk space</h4>
					<div class="progress">
						<div class="bar bar-success" title=">1 reference" style="width: <?=($this->graphs["good"]["size"]   / $this->graphs["total"]["size"])*100?>%"><?=$this->getModel()->human_filesize($this->graphs["good"]["size"]);?></div>
						<div class="bar bar-warning" title="1 reference"  style="width: <?=($this->graphs["single"]["size"] / $this->graphs["total"]["size"])*100?>%"><?=$this->getModel()->human_filesize($this->graphs["single"]["size"]);?></div>
						<div class="bar bar-danger"  title="0 references" style="width:  <?=($this->graphs["orphan"]["size"] / $this->graphs["total"]["size"])*100?>%"><?=$this->getModel()->human_filesize($this->graphs["orphan"]["size"]);?></div>
					</div>
				</div>
				<div class="span4">
					<label class="checkbox"><input type="checkbox" id="chkUnused" /> Check unused</label>
					<script type="text/javascript">
					jQuery("#chkUnused").change(function(){
						jQuery(".orphanInput").attr("checked",jQuery("#chkUnused").attr("checked"));
					})
					</script>
					<button name="_orphanaction" value="zipIt" class="btn btn-primary">Zip selected items</button>
					<button name="_orphanaction" value="delete" class="btn btn-danger">Delete selected items</button>
					<pre><?php print_r($_POST); ?></pre>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th></th>
						<th>Media</th>
						<th>File size</th>
						<th>References</th>
						<th>Referenced in</th>

					</tr>
				</thead>
				<tbody>
					<?php
					$k = 0;
					foreach ($this->oTable as &$row)
					{
						?>
						<tr>
							<td><input type="checkbox" name="tozip[]" value="<?=$row["file"]?>" class="<?=$row["refs"] ? '':'orphanInput';?>"/></td>
							<td><a target="_blank" href="<?= JURI::root() . $row["file"]?>" ><?=$row["file"]?></a></td>
							<td><?=$row["human_filesize"]?></td>
							<td><?=sizeof($row["refs"]);?></td>
							<td><ul><?php
								foreach($row["refs"] as $r){
									echo "<li>" . $r . "</li>";
								}
								?></ul></td>
								<!--<?=print_r($row,true)?>-->
							</tr>
							<?php
							$k++;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</form>