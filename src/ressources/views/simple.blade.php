<div class="row">
	<md-grid-list md-cols="1" md-cols-sm="2" md-cols-md="3" md-cols-gt-md="6" md-row-height-gt-md="1:1" md-row-height="1:1" md-gutter="8px" md-gutter-gt-sm="4px">
		<md-grid-tile ng-repeat="item in data.uploader.queue"
			                  md-rowspan="1"
			                  md-colspan="1"
			                  md-colspan-sm="1"
			                  md-colspan-xs="1"
			                  style="background: #000;">
      		<md-grid-tile-header><h3>@{{ item.file.name }}</h3>
      			@{{ item.file.size/1024/1024|number:2 }} MB
      		</md-grid-tile-header>
      		<img ng-thumb="item" style="max-width: 100%; max-height:100%; "/>
			<md-progress-circular ng-show="item.progress<100" md-mode="determinate" value="@{{item.progress}}"></md-progress-circular>
			<md-grid-tile-footer>
				<span ng-show="item.isSuccess">Envoy&eacute;</span>
				<span ng-show="item.isCancel">Annul&eacute;</span>
				<span ng-show="item.isError">Erreur</span>
		        <md-button ng-click="item.upload()" ng-disabled="item.isReady || item.isUploading || item.isSuccess">Envoyer</md-button>
		        <md-button ng-click="item.cancel()" ng-disabled="!item.isUploading">Annuler</md-button>
		        <md-button ng-click="item.remove()" ng-disabled="item.isUploaded">Supprimer</md-button>
			</md-grid-tile-footer>
		</md-grid-tile>
	</md-grid-list>
	<md-input-container>
		<input type="file" name="file" aria-label="Ajouter des photos" nv-file-select uploader="data.uploader" filters="filesizelimit"/>
	</md-input-container>	
</div>