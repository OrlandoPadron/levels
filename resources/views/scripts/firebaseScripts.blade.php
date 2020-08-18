<script>
    
    /**
     * Upload the file to Firebase. Depending on the method value, 
     * different situations will be issued. 
     * @params fileOwnerUserId -> user who uploads the file
     * @params sharedWithUserId -> user target to share the file
     * @params method -> determines the type of entity is calling the function 
     * @params additionalContent -> auxiliar array to provide extra information to some cases
     *
    */
    function uploadFile(fileOwnerUserId, sharedWithUserId, method, additionalContent = []){
        // Auth
        firebase.auth().signInAnonymously().catch(function(error) {
            // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            console.log("Error " + errorCode + ' ' + errorMessage);
        });
        var file;
        var storageRef;
        var task;
        var uploader;
        var fileName = "sin nombre";

        switch (method){
            case 'AthleteFileSection':
                //Get file 
                file = document.getElementById("file-upload").files[0];
        
                fileName = $('#file-name-input').val().trim(); 
                firebaseFileName = fileName.concat('.'+file.name.split('.').pop());

                //Create storage ref
                storageRef = firebase.storage().ref('users/'+fileOwnerUserId+'/files/'+ firebaseFileName);
        
        
                //Upload file 
                task = storageRef.put(file);
        
                //Update progress bar
                uploader = document.getElementById("uploader");
                break;

            case 'GroupFileSection':
                //Get file 
                file = document.getElementById("group-file-upload").files[0];
                
                fileName = $('#group-file-name-input').val().trim(); 
                firebaseFileName = fileName.concat('.'+file.name.split('.').pop());
                
                //Create storage ref
                storageRef = firebase.storage().ref('users/'+fileOwnerUserId+'/files/'+ firebaseFileName);


                //Upload file 
                task = storageRef.put(file);

                //Update progress bar
                uploader = document.getElementById("group-uploader");
                break;

            case 'AddFileToTrainingPlan':
                //Get file 
                file = document.getElementById("file-upload-".concat(additionalContent['planId'])).files[0];
                
                fileName = $('#file-name-input-'.concat(additionalContent['planId'])).val().trim(); 
                firebaseFileName = fileName.concat('.'+file.name.split('.').pop());

        
                //Create storage ref
                storageRef = firebase.storage().ref('users/'+sharedWithUserId+'/trainingPlans/'+ additionalContent['planId'] +'/files/'+ firebaseFileName);
        
        
                //Upload file 
                task = storageRef.put(file);
        
                //Update progress bar
                uploader = document.getElementById("uploader-".concat(additionalContent['planId']));   
                console.log(additionalContent['planId']);        
                break;

        }

        task.on('state_changed', 
            function progress(snapshot){
                var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                console.log('Upload is ' + progress + '% done');
                uploader.value = progress;
            },

            function error(err){
                console.log(err.message_);

            },

            function complete(){
                task.snapshot.ref.getDownloadURL().then(function(downloadURL) {
                    console.log('File available at', downloadURL); 
                    switch(method){
                        case 'AthleteFileSection':
                            saveFileReferenceIntoDatabase(file, fileName, fileOwnerUserId, sharedWithUserId, downloadURL, {method:'fileSection'});
                            break;

                        case 'AddFileToTrainingPlan':
                            saveFileReferenceIntoDatabase(file, fileName, fileOwnerUserId, sharedWithUserId, downloadURL, {method: 'trainingPlanSection'}, {planId: additionalContent['planId']});
                            updateNotificationLogJson(additionalContent['planId'],'trainingPlans');
                            
                            break;

                        case 'GroupFileSection':
                            saveFileReferenceIntoDatabase(file, fileName, fileOwnerUserId, sharedWithUserId, downloadURL, {method: 'groupFileSection'});
                            // updateNotificationLogJson(additionalContent['planId'],'trainingPlans');
                            
                            break;
                    }
                });
            }
        );


    }
    
    /**
     * The method updates the file from a training plan. 
     * The update goes on cascade, first updating firebase data and then the database row.  
     * @params file -> file occurrence.
     * @params fileOwnerUserId -> user who uploads the file
     * @params sharedWithUserId -> user target to share the file
     * @params downloadURL -> firebase's URL linked to the file
     *
    */


    function updatePlanFile(fileId, userId, planId, fileName){
        // Auth
        firebase.auth().signInAnonymously().catch(function(error) {
            // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            console.log("Error " + errorCode + ' ' + errorMessage);
        });

        //Get file 
        file = document.getElementById("file-plan-update-".concat(planId)).files[0];
                
        //Create storage ref
        storageRef = firebase.storage().ref('users/'
        +userId+'/trainingPlans/'+ 
        planId +'/files/'+ 
        fileName);

        
        //Upload file 
        task = storageRef.put(file);

        //Update progress bar
        uploader = document.getElementById("uploader-update-".concat(planId));   
        console.log(planId + " updating file...");     
        task.on('state_changed', 
            function progress(snapshot){
                var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                console.log('Upload is ' + progress + '% done');
                uploader.value = progress;
            },

            function error(err){
                console.log(err.message_);

            },

            function complete(){
                task.snapshot.ref.getDownloadURL().then(function(downloadURL) {
                    console.log('File available at', downloadURL); 
                    console.log('Update file step 2...');
                    updateTrainingPlanFileReferenceFromDatabase(fileId, file.size, downloadURL, planId);

                });
            }
        );   
    }

    /**
     * The method saves the relation between the file in firebase and 
     * its database representation. 
     * @params file -> file occurrence.
     * @params fileOwnerUserId -> user who uploads the file
     * @params sharedWithUserId -> user target to share the file
     * @params downloadURL -> firebase's URL linked to the file
     *
    */
    function saveFileReferenceIntoDatabase(file,fileName, fileOwnerUserId, sharedWithUserId, downloadURL, method, additionalContent=[]){
        // var fileName = file.name.split('.').slice(0, -1).join('.');
        var fileExtension = file.name.split('.').pop();
        var data;
        switch(method['method']){
            case 'fileSection':
                data = {
                    file_name: fileName,
                    extension: fileExtension,
                    size: file.size,
                    url: downloadURL,
                    owned_by: fileOwnerUserId,
                    shared_with: sharedWithUserId,
                    method: 'userFile',

                    _token: "{{csrf_token()}}",
                };
                break;
            case 'trainingPlanSection':
                data = {
                    file_name: fileName,
                    extension: fileExtension,
                    size: file.size,
                    url: downloadURL,
                    owned_by: sharedWithUserId,
                    method: 'trainingFile',
                    
                    _token: "{{csrf_token()}}",
                };
                break;
            case 'groupFileSection':
                data = {
                    file_name: fileName,
                    extension: fileExtension,
                    size: file.size,
                    url: downloadURL,
                    owned_by: fileOwnerUserId,
                    shared_with: sharedWithUserId,
                    method: 'groupFile',
                    
                    _token: "{{csrf_token()}}",
                };
                break;
        }
        $.ajax({
            url: "{{route("userFile.store")}}",
            type: "POST",
            data: data,
            success: function(userFile){
                if (method['method'] == 'trainingPlanSection'){
                    console.log(JSON.stringify(userFile));
                    console.log( "Plan id " + additionalContent['planId']);
                    saveTrainingFileIntoTrainingPlan(userFile, additionalContent['planId']);
                }else{
                    alert("Su archivo '" + fileName +"' se ha subido correctamente."); 
                    location.reload();
                }

                
            },
            error: function(callback){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "saveFileReferenceIntoDatabase" function');
                console.log(callback);
            }  
        });
    }


    function saveTrainingFileIntoTrainingPlan(file, planId){
        $.ajax({
            url: "{{route("trainingPlan.update")}}",
            type: "POST",
            data: {
                planId: planId,
                fileId: file['id'],
                method: 'addFileToPlan',
                _token: "{{csrf_token()}}",
            },
            success: function(){
                alert("Su archivo '" + file['file_name'] +"' se ha subido correctamente."); 
                location.reload();
                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "saveTrainingFileIntoTrainingPlan" function');
            }  
        });
    }


    
    /**
     * Deletes user's file from firebase server. 
     * @params fileOwnerUserId -> user who uploads the file
     * @params fileName -> file's name
     * @params fileId -> file's id
     *
    */
    function deleteUserFile(fileOwnerUserId, fileName, fileId, method, additionalContent=[]){
        // Auth
        firebase.auth().signInAnonymously().catch(function(error) {
        // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            console.log("Error " + errorCode + ' ' + errorMessage);
        });
        var storageRef;
        
        switch(method){
            case 'AthleteFileSection':
                //Create storage ref
                storageRef = firebase.storage().ref('users/'+fileOwnerUserId+'/files/'+ fileName);
                break;

            case 'TrainingPlanSection':
                //Create storage ref
                console.log("estamos");
                storageRef = firebase.storage().ref('users/'+fileOwnerUserId+'/trainingPlans/'+ additionalContent['planId'] +'/files/'+ fileName);
                break;            


        }

        // Delete the file
        storageRef.delete().then(function() {
            // File deleted successfully
            switch(method){
                case 'AthleteFileSection':
                    deleteFileReferenceFromDatabase(fileId, fileName, method);
                break;

                case 'TrainingPlanSection':
                    deleteFileReferenceFromDatabase(fileId, fileName, method, {planId:additionalContent['planId']});
            }
        }).catch(function(error) {
            // Uh-oh, an error occurred!
            console.log("No tan guay");

        });
    }

    /**
     * Deletes user's file from database. 
     * @params fileId -> file's id
     * @params fileName -> file's name
     *
    */

    function deleteFileReferenceFromDatabase(fileId, fileName, method, additionalContent=[]){
        $.ajax({
            url: "{{route("userFile.destroy")}}",
            type: "POST",
            data: {
                fileId: fileId,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                switch(method){
                    case 'AthleteFileSection':
                        alert("Su archivo '" + fileName +"' se ha eliminado."); 
                        location.reload();
                    break;

                    case 'TrainingPlanSection':
                        deleteFileReferenceFromTrainingPlan(fileId, additionalContent['planId']); 
                    break;                       
                }

                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "deleteFileReferenceFromDatabase" function');
            }  
        });

    }

    function deleteFileReferenceFromTrainingPlan(fileId, planId){
        $.ajax({
            url: "{{route("trainingPlan.update")}}",
            type: "POST",
            data: {
                planId: planId,
                fileId: fileId,
                method: 'removeFileFromPlan',
                _token: "{{csrf_token()}}",
            },
            success: function(){
                alert("Su archivo se ha eliminado correctamente."); 
                location.reload();
                
            },
            error: function(callback){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "deleteFileReferenceFromTrainingPlan" function');
                console.log(callback);
            }  
        });
    }


    function updateTrainingPlanFileReferenceFromDatabase(fileId, fileSize, downloadURL, planId){
        $.ajax({
            url: "{{route("trainingPlan.update")}}",
            type: "POST",
            data: {
                fileId: fileId,
                size: fileSize,
                url: downloadURL,
                planId: planId,
                method: 'updateFile',
                _token: "{{csrf_token()}}",
            },
            success: function(){
                alert("Su archivo se ha actualizado correctamente."); 
                updateNotificationLogJson(planId, 'trainingPlans');
                location.reload();
                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "updateTrainingPlanFileReferenceFromDatabase" function');
            }  
        });
    }
</script>