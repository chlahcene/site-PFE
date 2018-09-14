    <?php if (isset($flash)){
        ?>
    <div class="messages">
        <?php
        foreach ($flash as $type => $messeges) {
			if (isset($messeges) && is_array($messeges)) {
			    ?>
                    <div class="alert alert-dismissible alert-<?= $type=='success' ? 'success': 'danger' ?>" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
				<?php
				foreach ($messeges as $msg) {
				    echo $msg.'<br>' ;
				}
				?>
                    </div>
				<?php
			}
		}
		?>
    </div>
    <?php
    }
	?>