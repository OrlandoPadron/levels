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
</script> 