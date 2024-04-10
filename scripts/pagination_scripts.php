<script src="scripts/jquery.js"></script>
<script type="text/javascript">
let author_id = 0, searched_type = "any", searched_severity = "any";

function initialPageLoad(){
    $(document).ready(function (){
        author_id = 0;
        searched_severity = "any";
        searched_type = "any";
        loadPage(1);
    });
}

function loadPreviousPage(){
    const previousPage = parseInt(($("#currentPageIndex").html())) - 1;

    if(previousPage < 1){
        console.log("No pages left");

    }else{
        loadPage(previousPage);
    }
}

function loadNextPage(){
    const nextPage = parseInt(($("#currentPageIndex").html())) + 1;

    if(nextPage > $("#totalPageCount").html()){
        console.log("No pages left");

    }else{
        loadPage(nextPage);
    }
}

function loadUserLogs(user_id){
    author_id = user_id;
    searched_severity = $("#searched_severity").val();
    searched_type = $("#searched_type").val();
    loadPage(1);
}

function loadAllLogs(){
    author_id = 0;
    searched_severity = $("#searched_severity").val();
    searched_type = $("#searched_type").val();
    loadPage(1);
}

function handleSelectChange(){
    searched_severity = $("#searched_severity").val();
    searched_type = $("#searched_type").val();
    loadPage(1);
}


function loadPage(page){
    $(document).ready(function (){
        let data = {
            page: page,
            author_id: author_id,
            searched_type: searched_type,
            searched_severity: searched_severity,
        };

        $.ajax({
            url: '../server/fetch_page.php',
            type: 'post',
            data: data,
            success: function(response){
                response = JSON.parse(response)

                $(".logTable > tbody").html(response.rows);
                $("#currentPageIndex").html(page);
                $("#totalPageCount").html(response.pages);

                if(page > $("#totalPageCount").html())
                    loadPage(page - 1);
            }
        })
    });
}
</script>