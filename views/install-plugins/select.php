<div class="cbw-select-plugins">
	<div class="cbw-block">
		<div class="cbw-body__title"><?php
			_e( 'Configure plugins', 'croco-mki' );
		?></div>
		<div class="cbw-block__top">
			<div class="cbw-plugins-group">
				<div
					:class="{
						'cbw-plugins-group__heading': true,
						'cbw-plugins-group__heading--active': showRec,
					}"
					@click="showRec = !showRec"
				>
					<div
						class="cbw-plugins-group__heading-title"
						v-if="'full' === action"
					><?php
						_e( 'Required plugins', 'croco-mki' );
					?></div>
					<div v-else class="cbw-plugins-group__heading-title"><?php
						_e( 'Choose the plugins to install', 'croco-mki' );
					?></div>
					<div class="cbw-plugins-group__heading-desc" v-if="showRec">
						<span v-if="'full' === action"><?php
						_e( 'The required set of basic plugins which are necessary for the landing page to work smoothly. If you don’t install one or more plugins from this list, the specific sections of this landing page, that are displayed with this plugin’s functionality, will be missing. ', 'croco-mki' );

						?></span>
						<span v-else><?php
							_e( 'You can find the full list of the Crocoblock plugins available for your license key below. Choose the ones you want to install and clock “Continue”', 'croco-mki' );
						?></span>
					</div>
				</div>
				<div
					class="cbw-plugins-group__body"
					v-if="showRec"
				>
					<cx-vui-checkbox
						name="recommended"
						return-type="array"
						:wrapper-css="[ 'check-group' ]"
						:options-list="skinPlugins"
						v-model="selectedSkinPlugins"
						@on-change="emitPluginsToInstall"
					></cx-vui-checkbox>
				</div>
			</div>
		</div>
	</div>
	<div class="cbw-footer">
		<cx-vui-button
			@click="goToPrevStep"
		>
			<svg slot="label" width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.67089 0L-4.76837e-07 6L5.67089 12L7 10.5938L2.65823 6L7 1.40625L5.67089 0Z" fill="#007CBA"/></svg>
			<span slot="label"><?php _e( 'Back', 'croco-mki' ); ?></span>
		</cx-vui-button>
		<cx-vui-button
			:button-style="'accent'"
			@click="goToNextStep"
		>
			<span slot="label"><?php _e( 'Continue', 'croco-mki' ); ?></span>
			<svg slot="label" width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.32911 0L7 6L1.32911 12L0 10.5938L4.34177 6L0 1.40625L1.32911 0Z" fill="white"/></svg>
		</cx-vui-button>
		<cx-vui-button
			@click="skipPlugins"
			v-if="'full' === action"
		>
			<span slot="label"><?php _e( 'Skip', 'croco-mki' ); ?></span>
			<svg slot="label" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.32911 1L14 7L8.32911 13L7 11.5938L11.3418 7L7 2.40625L8.32911 1Z" fill="#007CBA"/><path d="M1.32911 1L7 7L1.32911 13L0 11.5938L4.34177 7L0 2.40625L1.32911 1Z" fill="#007CBA"/></svg>
		</cx-vui-button>
	</div>
</div>