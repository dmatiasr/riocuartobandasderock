 angular.module('app')
 .controller('BandsController', ['$scope', '$http', '$location','$routeParams', function($scope, $http, $location, $routeParams) {

// 	$scope.bands = [
// {
//     "BandID": "1",
//     "name": "Banda-1",
//     "genre": "Rock",
//     "albums": [
//       {
//         "AlbumID": "1",
// 	"title": "Perdido",
// 	"releaseDate": "2012-01-01",
//       },
//       {
// 	"AlbumID": "2",
// 	"title": "Mañana",
// 	"releaseDate": "2013-01-01",
//       }
//     ]
// },
// {
//     "BandID": "2",
//     "name": "Banda-2",
//     "genre": "Blues",
//     "albums": [
//       {
// 	"AlbumID": "9",
// 	"title": "Noche",
// 	"releaseDate": "2013-01-01",
//       },
//       {
// 	"AlbumID": "8",
// 	"title": "Eye in the sky",
// 	"releaseDate": "2013-01-01",
//       }
//     ]
// },

// ];
// 	$scope.band = $scope.bands[0];

	function load_albums() {
		$http.get("https://private-53163-riocuartobandasderock.apiary-mock.com/albums").then(function callback(response){
			if (response.status == 200){
				$scope.albums = response.data;
			} else {
				alert("Oops, something went wrong, try again later!")
			}
		});
	}
	
	load_albums();

	$scope.create = function createArtist(data) {
		alert("Creación de banda correcta.");
	}

	/*$scope.bands = [];
	$scope.band = '';

	function load_bands() {
		$http.get("https://private-53163-riocuartobandasderock.apiary-mock.com/bands").then(function callback(response) {
			if (response.status == 200) {
				$scope.bands = response.data;
			} else {
				alert("Oops, something went wrong, try again later!")
			}
		});
	}

	function load_band(id) {
		$http.get("https://private-53163-riocuartobandasderock.apiary-mock.com/bands/"+id).then(function callback(response) {
			if (response.status == 200) {
				$scope.band = response.data[0];
				load_band_members($scope.band.BandID);
			} else {
				alert("Oops, something went wrong, try again later!");
			}
		});
	}

	function load_band_members(id) {
		$http.get("https://private-53163-riocuartobandasderock.apiary-mock.com/bands/getbandmembers/"+id).then(function callback(response) {
			if (response.status == 200) {
				$scope.band.members = response.data;
			} else {
				$scope.band.members = "Placeholder name";
			}
		});
	}*/

	$scope.bands = [];
	function load_bands() {
		/*$http.get("https://private-53163-riocuartobandasderock.apiary-mock.com/albums").then(function callback(response){
			if (response.status == 200){
				$scope.albums = response.data;
			} else {
				alert("Oops, something went wrong, try again later!")
			}
		});*/
		$http.get("http://localhost:4567/bands").then(function callback(response){
			if (response.status == 200){
				$scope.bands = response.data;
			}else{
				alert("Oops, something went wrong, try again later!")
			}
		});
	}

	$scope.go_to = function(id) {
		$location.path("/bands/"+id);
	}
	if ($location.path() == "/bands"){
		load_bands();
	}

	/*if ($location.path() == "/bands"){
		load_bands();
	} else {
		load_bands($routeParams.id);
	}*/


}]);