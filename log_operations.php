
<script src="scripts/jquery.js"></script>
<script type="text/javascript">
function submitLogData(user_id){
    $(document).ready(function (){
        let data = {
            user_id: user_id,
            log_type: $("#log_type").val(),
            log_severity: $("#log_severity").val(),
            log_date: $("#log_date").val(),
            log_description: $("#log_description").val(),
            action: $("#action").val()
        };
        
        $.ajax({
            url: 'log_registration.php',
            type: 'post',
            data: data,
            success: function(response){
                response = response.replace(/(\r\n|\n|\r)/gm, "");

                if(response == "Successfully logged in!"){
                    location.reload(true);
                
                }else if(response == "User registered successfully."){
                    window.location.replace("login_page.php");
                
                }else $(".responseLabel").html(response);

                
            }
        })
    });
}

function deleteLog(identifier){
    $(document).ready(function (){
        let data = {
            log_id: identifier
        };
        
        $.ajax({
            url: 'log_deletion.php',
            type: 'post',
            data: data,
            success: function(response){
                loadPage($("#currentPageIndex").html());
            }
        })
    });
}

function updateLog(identifier){
    $(document).ready(function (){
        let data = {
            log_id: identifier,
            log_type: $("#log_type").val(),
            log_severity: $("#log_severity").val(),
            log_date: $("#log_date").val(),
            log_description: $("#log_description").val(),
            action: $("#action").val()
        };
        
        $.ajax({
            url: 'log_update.php',
            type: 'post',
            data: data,
            success: function(response){
                response = response.replace(/(\r\n|\n|\r)/gm, "");

                if(response == "Log successfully updated")
                    loadPage(1);

                else $(".responseLabel").html(response)
            }
        })
    });
}
</script>