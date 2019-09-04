<div class="cbw-regenerate">
	<div class="cbw-body__title"><?php
		_e( 'Regenerating thumbnails', 'croco-mki' );
	?></div>
	<cbw-progress :value="progress"></cbw-progress>
	<p v-if="!progress"><?php
		_e( 'Starting process, please wait few seconds...', 'crcoblock-wizard' );
	?></p>
</div>