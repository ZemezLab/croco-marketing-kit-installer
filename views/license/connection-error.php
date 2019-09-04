<div class="cbw-block cbw-connection-error">
	<div class="cbw-body__title"><?php
		_e( 'Oops!', 'croco-mki' );
	?></div>
	<div class="cbw-body__subtitle"><?php
		_e( 'The connection between Crocoblock library and your server wasn’t established.', 'croco-mki' );
	?></div>
	<p><?php
		_e( 'In case you need to install the plugins, you can do it manually. Please, follow these instructions to proceed with the installation process. In case you want to install the pre-made website, please, contact our support team for more details.', 'croco-mki' );
	?></p>
	<cx-vui-button
		button-style="accent"
		@click="downloadReport"
	>
		<span slot="label"><?php _e( 'Download error report', 'croco-mki' ); ?></span>
	</cx-vui-button>
</div>