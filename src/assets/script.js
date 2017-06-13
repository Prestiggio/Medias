(function(window, angular, $, appApp, undefined){
	
	var UploadService = function(conf){
		this.conf = conf;		
		this.url = "/upload.php";
		if(this.conf.url)
			this.url = this.conf.url;
		this.upload = {
			onDone : function(item, response){},
			onQueue : function(item){},
			onCancel : function(item){}
		};
		this.setUploadEndpoint = function(url){
			this.uploader.url = url;
		};
		this.setUploadAuto = function(auto){
			this.uploader.autoUpload = auto;
		};
		this.initUploader = function(uploader){
			if(!this.uploader) {
				this.uploader = new uploader({
					url : this.url,
					headers : {
						"X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')
					},
					alias: "file",
					removeAfterUpload: false,
					filters: [{
						name : "allmedias",
						fn : function(item){
							return item.type.startsWith("image/") || item.type.startsWith("video/");
						}
					}]
				});
			}
		};
	};
	
	angular.module("rymedias", ["ngApp", "angularFileUpload"]).provider("$rymedias", function $rymediasProvider(){
		
		
		
	}).directive("upload", function(){
		return {
			restrict : "A",
			require : "ngModel",
			scope : {
				data : "=ngModel"
			},
			controller : ["$scope", "$appSetup", function($scope, $app){
				$app.uploader.autoUpload = true;
				$app.uploader.onCompleteItem = function(item, response){
					$scope.data.push(response);
				};
				$app.uploader.onAfterAddingFile = function(item){
					var data = item.file;
					data.title = data.name;
					item.formData = [data];
				};
				
				if(upload) {
					input[k].item.uploader = {
						formData : [input[k].item]
					};
				}
			}]
		};
	}).directive('ngThumb', function(){
		return {
			restrict: 'A',
            link: function(scope, element, attributes) {
            	var fileItem = scope.$eval(attributes.ngThumb);
            	
            	var reader = new FileReader();
				
				reader.onloadstart = reader.onprogress = function(){
					$(element).attr("src", "/vendor/rymd/img/ring.svg");			
				};
				
				reader.onload = function(e) {
					$(element).attr("src", e.target.result);
				};
				
				reader.readAsDataURL(fileItem._file);
            }
		};
	});
	
})(window, window.angular, window.jQuery, window.appApp);

window.rymedias = {version:{full: "1.0.0"}};