<script>

    /*
    * Calls the method that will update user's notification file.
    */
    function updateNotificationLogJson(id, method){
        console.log("Nos ha llamado desde " + id + ' ' + method) 
        $.ajax({
            url: "{{route("user.updateAccess")}}",
            type: "POST",
            data: {
                id: id,
                method: method, 
                _token: "{{csrf_token()}}",
            },
            success: function(){
                console.log('Log updated'); 
                
            },
            error: function(){
                console.log('Error on ajax call "updateNotificationLogJson" function');
            }  
        });
    }   

    /**
     * Shares an already uploaded file to a specific user's profile. 
     * @params userId -> user who is receiving the shared file.
    */

    function shareFile(userId){

        var fileId = $("#filesNotShared").children("option:selected").val();
        var fileName = $("#filesNotShared").children("option:selected").text();

        $.ajax({
            url: "{{route("userFile.update")}}",
            type: "POST",
            data: {
                fileId: fileId,
                userId: userId,
                method: 'shareFile',

                _token: "{{csrf_token()}}",
            },
            success: function(){
                alert("Ha compartido su archivo '" + fileName +"'."); 
                location.reload();
                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "shareFile" function');
            }  
        });
    }

    function shareFileWithGroup(groupId){

        var fileId = $("#filesNotShared").children("option:selected").val();
        var fileName = $("#filesNotShared").children("option:selected").text();

        $.ajax({
            url: "{{route("userFile.update")}}",
            type: "POST",
            data: {
                fileId: fileId,
                groupId: groupId,
                method: 'shareFileWithGroup',

                _token: "{{csrf_token()}}",
            },
            success: function(){
                alert("Ha compartido su archivo '" + fileName +"'."); 
                location.reload();
                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "shareFileWithGroup" function');
            }  
        });
    }


    /**
    * Stops sharing a given file with a given user. 
    * @params fileId -> file's id
    * @params userId -> user who has the shared file.
    * @params fileName -> file's name
    */
    function stopSharingFile(fileId, userId, fileName){
        $.ajax({
            url: "{{route("userFile.update")}}",
            type: "POST",
            data: {
                fileId: fileId,
                userId: userId,
                method: 'stopSharing',

                _token: "{{csrf_token()}}",
            },
            success: function(){
                alert("Su archivo '" + fileName +"' se ha dejado de compartir."); 
                location.reload();
                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "stopSharingFile" function');
            }  
        });
    }  

    function stopSharingGroupFile(groupId, fileId, fileName){
        $.ajax({
            url: "{{route("userFile.update")}}",
            type: "POST",
            data: {
                fileId: fileId,
                groupId: groupId,
                method: 'groupStopSharing',

                _token: "{{csrf_token()}}",
            },
            success: function(){
                alert("Su archivo '" + fileName +"' se ha dejado de compartir."); 
                location.reload();
                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "stopSharingFile" function');
            }  
        });
    }


    /*UPLOAD FILE AND SHARE FILE SCRIPTS */
    
    function changeUI(method, optionalId = 0){
        switch (method){
            case 'upload':
                var file = document.getElementById("file-upload").files[0];
                var validFile = true; 
                if((file.size/1024/1024).toFixed(2) >= 25){
                    alert("El archivo excede el tamaño límite. Seleccione un archivo con un tamaño inferior o igual a 25 MB.");
                    validFile = false;  
                }
                if (file != undefined && validFile){
                    var filename = file.name.split('.').slice(0, -1).join('.');
                    $('#upload-btn').prop('disabled', false);
                    $('#selected-file-name').text(file.name);
                    $('#file-name-input').val(filename);
                    $('#file-load-status-icon').addClass("input-active");
                }else{
                    $('#upload-btn').prop('disabled', true);
                    $('#selected-file-name').text('Ningún archivo seleccionado');
                    $('#file-name-input').val('');
                    $('#file-load-status-icon').removeClass("input-active");
                }            
                break;
            case 'share':
                var valueSelect = ($("#filesNotShared").val()); 
                if (valueSelect == 0){
                    $('#share-btn').prop('disabled', true);
                }else{
                    $('#share-btn').prop('disabled', false);
                }
                break;

            case 'uploadToTrainingPlan':
                var file = document.getElementById("file-upload-".concat(optionalId)).files[0];
                var validFile = true; 
                if((file.size/1024/1024).toFixed(2) >= 25){
                    alert("El archivo excede el tamaño límite. Seleccione un archivo con un tamaño inferior o igual a 25 MB.");
                    validFile = false;  
                }
                if (file != undefined && validFile){
                    var filename = file.name.split('.').slice(0, -1).join('.');
                    $('#upload-btn-'.concat(optionalId)).prop('disabled', false);
                    $('#selected-file-name-'.concat(optionalId)).text(file.name);
                    $('#file-name-input-'.concat(optionalId)).val(filename);
                    $('#file-load-status-icon-'.concat(optionalId)).addClass("input-active");
                }else{
                    $('#upload-btn-'.concat(optionalId)).prop('disabled', true);
                    $('#selected-file-name-'.concat(optionalId)).text('Ningún archivo seleccionado');
                    $('#file-name-input-'.concat(optionalId)).val('');
                    $('#file-load-status-icon-'.concat(optionalId)).removeClass("input-active");
                }            
                break;
            
            case 'updateFileFromTrainingPlan':
                var file = document.getElementById("file-plan-update-".concat(optionalId)).files[0];
                var validFile = true; 
                if((file.size/1024/1024).toFixed(2) >= 25){
                    alert("El archivo excede el tamaño límite. Seleccione un archivo con un tamaño inferior o igual a 25 MB.");
                    validFile = false;  
                }
                
                if (file != undefined && validFile){
                    var filename = file.name.split('.').slice(0, -1).join('.');
                   
                    $('#upload-error-'.concat(optionalId)).hide();
                    $('#update-plan-file-btn-'.concat(optionalId)).prop('disabled', false);
                    $('#update-file-load-status-icon-'.concat(optionalId)).addClass("input-active");
                    $('#selected-update-file-name-'.concat(optionalId)).text(filename);
                
                }else{
                    $('#upload-error-'.concat(optionalId)).hide();
                    $('#update-plan-file-btn-'.concat(optionalId)).prop('disabled', true);
                    $('#update-file-load-status-icon-'.concat(optionalId)).removeClass("input-active");
                    $('#selected-update-file-name-'.concat(optionalId)).text('Ningún archivo seleccionado');
                    $('#file-load-status-icon-'.concat(optionalId)).removeClass("input-active");
                }    
                break;

            case 'groupUpload':
                var file = document.getElementById("group-file-upload").files[0];
                var validFile = true; 
                if((file.size/1024/1024).toFixed(2) >= 25){
                    alert("El archivo excede el tamaño límite. Seleccione un archivo con un tamaño inferior o igual a 25 MB.");
                    validFile = false;  
                }
                if (file != undefined && validFile){
                    var filename = file.name.split('.').slice(0, -1).join('.');
                    $('#group-upload-btn').prop('disabled', false);
                    $('#group-selected-file-name').text(file.name);
                    $('#group-file-name-input').val(filename);
                    $('#group-file-load-status-icon').addClass("input-active");
                }else{
                    $('#group-upload-btn').prop('disabled', true);
                    $('#group-selected-file-name').text('Ningún archivo seleccionado');
                    $('#group-file-name-input').val('');
                    $('#group-file-load-status-icon').removeClass("input-active");
                }            
                break;

            case 'addMembersToGroup':
                var total=$(document).find('input[name="usersId[]"]:checked').length;
                if (total > 0){
                    $('#upload-btn').prop('disabled', false);
                }else{
                    $('#upload-btn').prop('disabled', true);
                }

                //Transform Add button to Remove button
                var buttonText = $("#addLabelGroup_".concat(optionalId)).text().trim();
                if (buttonText == 'Añadir'){
                    $("#addLabelGroup_".concat(optionalId)).text('No añadir');
                    $("#addLabelGroup_".concat(optionalId)).addClass('col-red');

                }else{
                    $("#addLabelGroup_".concat(optionalId)).text('Añadir');
                    $("#addLabelGroup_".concat(optionalId)).removeClass('col-red');
                }

                break;

        }

    }   
</script> 