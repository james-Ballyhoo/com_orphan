<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<div id="editcell">
		Total files: <?=$this->sumTable["ttl_files"]?><br />
		Orphaned files: <?=$this->sumTable["ttl_orphans"]?><br />
		Total size : <?=$this->sumTable["ttl_size"]?><br />
		Total wasted size: <?=$this->sumTable["ttl_wasted_size"]?><br />
		<div class="container">
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