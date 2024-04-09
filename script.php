<script src="scripts/jquery.js"></script>
<script type="text/javascript">

function submitData(){
    $(document).ready(function (){
        let data = {
            user_name: $("#user_name").val(),
            user_password: $("#user_password").val(),
            user_password_confirm: $("#user_password_confirm").val(),
            user_email: $("#user_email").val(),
            action: $("#action").val()
        };
        
        $.ajax({
            url: 'user_authentification.php',
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
</script>
