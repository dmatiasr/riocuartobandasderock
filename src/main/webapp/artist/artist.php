<!DOCTYPE html>
<html lang="en">
<head>
<title>Mostrar Artista</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<style type="text/css">
    table tr th, table tr td{font-size: 1.2rem;}
    .row{ margin:20px 20px 20px 20px;width: 100%;}
    .glyphicon{font-size: 25px;}
    .glyphicon-plus{float: right;}
    a.glyphicon{text-decoration: none;}
    a.glyphicon-trash{margin-left: 10px;}
    .none{display: none;}
    .table td{
        text-align: center;   
    }
    .table th{
        text-align: center;   
    }
    .table-row{
        cursor:pointer;
    }
    /*.glyphicon-trash{
        pointer-events: none;
        cursor: default;
        color: gray;
    }
    .glyphicon-edit{
        pointer-events: none;
        cursor: default;
        color: gray;
    }*/

</style>

<script>
    
    var findResourceTag = '/artists/findbynickname/'; // Default value

    function showArtists(resourcelocation){
        $("#userData").html('<table></table>'); // Clean table, need to refresh with non elements in db

        //resourcelocation='/artists';
         $.get(resourcelocation, function(data, status){
            if (typeof data === "undefined") {
                response = '<tr><td colspan="5"> No Artists found...</td></tr>'
            }else{
                var request = JSON.parse(data);
                response = '<table>';
                itemindex = 1;
                $.each(request, function(i, item) {
                       response += '<tr onclick="showBandMInDialog(\''+item.artistID+'\')">'+'<td>'+itemindex+'</td>'+'<td>'+item.name+'</td>'+'<td>'+item.surname+'</td>'+'<td>'+item.nickname+'</td>' + '<td> <a href="javascript:void(0);" class="glyphicon glyphicon-edit" onclick="showInEdit(\''+item.artistID+'\'); event.stopImmediatePropagation();"</a> <a href="javascript:void(0);" class="glyphicon glyphicon-trash" onclick="deleteArtist(\''+item.artistID+'\'); event.stopImmediatePropagation();"</a> </td> </tr>';
                        ++itemindex;
                });           
                response += '</table>';
            }
            
            $("#userData").html(response);
 
          });
    }

    function showBandMInDialog(id){
        $("#bandMModal").modal() 
        $("#bandMData").html('<table></table>'); // Clean table, need to refresh with non elements in db

        resourcelocation='/artists/getbandsbyId/'+id;
         $.get(resourcelocation, function(data, status){
            if (typeof data === "undefined") {
                response = '<tr><td colspan="5"> No Bands found...</td></tr>'
            }else{
                var request = JSON.parse(data);
                response = '<table>';
                itemindex = 1;
                $.each(request, function(i, item) {
                       response += '<tr>'+'<td>'+itemindex+'</td>'+'<td>'+item.name+'</td>'+'<td>'+item.surname+'</td> </tr>';
                        ++itemindex;
                });           
                response += '</table>';    
            }

            $("#bandMData").html(response);
 
          });
    }

    function showInEdit(id){
            
        var resourcelocation ='/artists/'+id;
        $.ajax({
            type: 'GET',
            url: resourcelocation,
            data: '',
            success:function(res){
                var request = JSON.parse(res);
            
                $.each(request, function(i, item) {
                    $('#nameEdit').val(item.name);
                    $('#surnameEdit').val(item.surname);
                    $('#nicknameEdit').val(item.nickname);
                    $('#idEdit').val(item.artistID);
                });
                    
                $('#editForm').slideDown();
            }
        });
    }

    function addArtist() {
        name=$('#name').val();
        surname=$('#surname').val();
        nickname=$('#nickname').val();
            
        if (name+surname+nickname=='') {
            alert("Al menos debe rellenar un campo");
        } else {
         
            var url = '/artists'; 
            $.ajax({
                type: "POST",
                url: url,
                data: $("#addForm").find('.form').serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data)
                {
                    showArtists('/artists'); //optional refresh list
                    $('.form')[0].reset();
                    $('.formData').slideUp();
                 },
                 error: function(x, e) {

                 }
            });
        }
    }

    function updateArtist() {            
            
        id=$('#idEdit').val();
        var resourcelocation ='/artists/'+id;

        name=$('#nameEdit').val();
        surname=$('#surnameEdit').val();
        nickname=$('#nicknameEdit').val();
            
        if (name+surname+nickname=='') {
            alert("Al menos debe rellenar un campo");
        } else {
            $.ajax({
                type: "PUT",
                url: resourcelocation,
                data: $("#editForm").find('.form').serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data)
                {
                   showArtists('/artists'); //optional refresh list
                   $('.form')[1].reset();
                   $('.formData').slideUp();
                },
                error: function(x, e) {
                    //$("#dataartisaddformstatus").html('<font color="red">Result: Error</font>'); //  Show response Api Rest
                    alert('No ha realizado ninguna modificación en el registro');
                    $('.form')[1].reset();
                    $('.formData').slideUp();
                }
            });
        }
    }

    function deleteArtist(id) {            
            
        resourcelocation ='/artists/'+id;
            
        $.ajax({
            type: "DELETE",
            url: resourcelocation,
            data: '', 
            success: function(data)
            {
                showArtists('/artists'); //optional refresh list
            },
            error: function(x, e) {
                     
            }
        });

    }

   function showSearchMenu(by) {            
        $('.form')[2].reset();
        $('#searchForm').slideToggle();        
        switch(by){
            case "name": 
                document.getElementById("nameSearch").disabled = false;
                document.getElementById("surnameSearch").disabled = true;
                document.getElementById("nicknameSearch").disabled = true;
                findResourceTag = '/artists/findbyname/';
                break;
            case "surname":
                document.getElementById("nameSearch").disabled = true;
                document.getElementById("surnameSearch").disabled = false;
                document.getElementById("nicknameSearch").disabled = true;
                findResourceTag = '/artists/findbysurname/';
                break;
            case "nickname":
                document.getElementById("nameSearch").disabled = true;
                document.getElementById("surnameSearch").disabled = true;
                document.getElementById("nicknameSearch").disabled = false;
                findResourceTag = '/artists/findbynickname/';
                break;
            case "all":
                document.getElementById("nameSearch").disabled = false;
                document.getElementById("surnameSearch").disabled = false;
                document.getElementById("nicknameSearch").disabled = false;
                findResourceTag = '/artists/findbyallattributes/';
        }
        
   }

   function executeSearch() {            
        
        switch(findResourceTag){
            case "/artists/findbyname/": 
                var resourcelocation = findResourceTag+$('#nameSearch').val();
                showArtists(resourcelocation);
                break;
            case "/artists/findbysurname/":
                var resourcelocation = findResourceTag+$('#surnameSearch').val();
                showArtists(resourcelocation);
                break;
            case "/artists/findbynickname/":
                var resourcelocation = findResourceTag+$('#nicknameSearch').val();
                showArtists(resourcelocation);
                break;
            case "/artists/findbyallattributes/":
                $.ajax({
                    type: "GET",
                    url: findResourceTag,
                    data: $("#searchForm").find('.form').serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data)
                    {
                        if (typeof data === "undefined") {
                            response = '<tr><td colspan="5"> No Artists found...</td></tr>'
                        }else{
                            var request = JSON.parse(data);
                            response = '<table>';
                            itemindex = 1;
                            $.each(request, function(i, item) {
                                   response += '<tr onclick="showBandMInDialog(\''+item.artistID+'\')">'+'<td>'+itemindex+'</td>'+'<td>'+item.name+'</td>'+'<td>'+item.surname+'</td>'+'<td>'+item.nickname+'</td>' + '<td> <a href="javascript:void(0);" class="glyphicon glyphicon-edit" onclick="showInEdit(\''+item.artistID+'\'); event.stopImmediatePropagation();"</a> <a href="javascript:void(0);" class="glyphicon glyphicon-trash" onclick="deleteArtist(\''+item.artistID+'\'); event.stopImmediatePropagation();"</a> </td> </tr>';
                                    ++itemindex;
                            });           
                            response += '</table>';
                        }
                        
                        $("#userData").html(response);
                     },
                     error: function(x, e) {
                        alert("Se ha producido un error");
                     }
                });
        }

        $('.form')[2].reset();
        $('#searchForm').slideToggle(); 
   }

    /**
     * Vertically center Bootstrap 3 modals so they aren't always stuck at the top
     */

    $(function() {
        function reposition() {
            var modal = $(this),
                dialog = modal.find('.modal-dialog');
            modal.css('display', 'block');
            
            // Dividing by two centers the modal exactly, but dividing by three 
            // or four works better for larger screens.
            dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
        }
        // Reposition when a modal is shown
        $('.modal').on('show.bs.modal', reposition);
        // Reposition when the window is resized
        $(window).on('resize', function() {
            $('.modal:visible').each(reposition);
        });
    });

    $(document).ready(function() {
        showArtists('/artists');
    });
        
</script>
</head>

<body>

<nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">Artist TEAM</a>
        </div>
        <ul class="nav navbar-nav">
          <li><a href="http://localhost:4567/artistadmin/index.php">Home</a></li>
          <li class="active"><a href="http://localhost:4567/artistadmin/artist.php">Artist</a></li>
          <li><a href="http://localhost:4567/artistadmin/album.php">Album</a></li>
          <li><a href="http://localhost:4567/artistadmin/band.php">Band</a></li>
          <li><a href="http://localhost:4567/artistadmin/song.php">Song</a></li>
        </ul>
      </div>
    </nav>

<div class="container">
    <div align="center">
        <h2>
            <i class="glyphicon glyphicon-th-list"></i> Admin - Artists
            <span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
        </h2>
    </div>    
    <div class="row">
        <div class="panel panel-default users-content">
            <div class="panel-heading"><i class="glyphicon glyphicon-th-list"></i>  Artists list
	<div class="btn-group pull-right" role="group">
    <button type="button" class="btn btn-default" href="javascript:void(0);" onclick="javascript:showArtists('/artists')">Show all</button>
	<button type="button" class="btn btn-default" href="javascript:void(0);" onclick="javascript:$('#addForm').slideToggle(); $('.form')[0].reset();">Add</button>
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Search <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a href="javascript:void(0);" onclick="javascript:$(showSearchMenu('name'));">By name</a></li>
	    <li><a href="javascript:void(0);" onclick="javascript:$(showSearchMenu('surname'));">By surname</a></li>
	    <li><a href="javascript:void(0);" onclick="javascript:$(showSearchMenu('nickname'));">By nickname</a></li>
	    <li role="separator" class="divider"></li>
	    <li><a href="javascript:void(0);" onclick="javascript:$(showSearchMenu('all'));">By all fields</a></li>
	  </ul>

	</div>

	    </div>
            <div class="panel-body none formData" id="addForm">
                <h2 id="actionLabel">Add Artist</h2>
                <form class="form" id="userForm">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="name"/>
                    </div>
                    <div class="form-group">
                        <label>Surname</label>
                        <input type="text" class="form-control" name="surname" id="surname"/>
                    </div>
                    <div class="form-group">
                        <label>Nickname</label>
                        <input type="text" class="form-control" name="nickname" id="nickname"/>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-warning" onclick="$('#addForm').slideUp();">Cancel</a>
                    <a href="javascript:void(0);" class="btn btn-success" onclick="addArtist()">Add Artist</a>
                </form>
            </div>

            <div class="panel-body none formData" id="editForm">
                <h2 id="actionLabel">Edit Artist</h2>
                <form class="form" id="userForm">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="nameEdit"/>
                    </div>
                    <div class="form-group">
                        <label>Surname</label>
                        <input type="text" class="form-control" name="surname" id="surnameEdit"/>
                    </div>
                    <div class="form-group">
                        <label>Nickname</label>
                        <input type="text" class="form-control" name="nickname" id="nicknameEdit"/>
                    </div>
                    <input type="hidden" class="form-control" name="id" id="idEdit"/>
                    <a href="javascript:void(0);" class="btn btn-warning" onclick="$('#editForm').slideUp(); ; $('.form')[1].reset();">Cancel</a>
                    <a href="javascript:void(0);" class="btn btn-success" onclick="updateArtist() ; $('.form')[1].reset();">Update Artist</a>
                </form>
            </div>

	    <div class="panel-body none formData" id="searchForm">
                <h2 id="actionLabel">Search Artist</h2>
                <form class="form" id="userForm">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="nameSearch"/>
                    </div>
                    <div class="form-group">
                        <label>Surname</label>
                        <input type="text" class="form-control" name="surname" id="surnameSearch"/>
                    </div>
                    <div class="form-group">
                        <label>Nickname</label>
                        <input type="text" class="form-control" name="nickname" id="nicknameSearch"/>
                    </div>
                    <input type="hidden" class="form-control" name="id" id="idSearch"/>
                    <a href="javascript:void(0);" class="btn btn-warning" onclick="$('#searchForm').slideUp();">Cancel</a>
                    <a href="javascript:void(0);" class="btn btn-success" onclick="executeSearch()">Search Artist</a>
                </form>
            </div>
            <table class="table collection table table-bordered table-striped table-hover" id="mainTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Nickname</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="userData" class="table-row"></tbody>
            </table>

        </div>
    </div>
</div>

<!-- Modal -->
<div id="bandMModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Band Member</h4>
      </div>
      <div class="modal-body">
        <table class="table collection table table-bordered table-striped table-hover" id="bandMTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Genre</th>
                    </tr>
                </thead>
                <tbody id="bandMData"></tbody>
            </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

</body>
</html>
