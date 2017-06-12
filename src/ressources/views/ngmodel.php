<h3>Medias</h3>
<md-radio-group ng-model="main">
	<ng-form ng-repeat="media in data" ng-if="!media.deleted">
		<div layout="row">
			<md-input-container>
				<md-button ng-click="media.path=$root.selectedText" class="md-icon-button" aria-label="Assign"><md-icon md-font-icon="fa fa-long-arrow-right"></md-icon></md-button>
			</md-input-container>
			<md-input-container>
				<label>Chemin</label>
				<input type="text" name="immobilier_media" ng-model="media.path"/>
			</md-input-container>
			<md-input-container>
				<md-radio-button ng-value="media" aria-label="{{media.path}}">A la une</md-radio-button>
			</md-input-container>
			<md-input-container>
				<md-button class="md-icon-button" ng-click="rediger('media['+$index+'].path')" aria-label="Questionner l'auteur"><md-icon md-font-icon="fa fa-send"></md-icon></md-button>
			</md-input-container>
			<md-input-container>
				<md-button class="md-icon-button" ng-if="(data|filter:{deleted:'!true'}).length>1" ng-click="media.deleted=true" aria-label="remove"><md-icon md-font-icon="fa fa-minus-circle"></md-icon></md-button>
			</md-input-container>
		</div>
	</ng-form>
</md-radio-group>
<md-button ng-click="data.push({path : ''})" aria-label="add" class="md-raised md-accent"><md-icon md-font-icon="fa fa-plus-circle"></md-icon> media</md-button>
