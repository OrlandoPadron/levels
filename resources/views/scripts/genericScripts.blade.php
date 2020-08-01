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
</script> 