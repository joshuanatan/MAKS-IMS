<script>
function getDatasetDetail(){
    var id_entity_combination = $("#id_dataset").val();
    $.ajax({
        url:"<?php echo base_url();?>interface/dataset/get_detail_dataset",
        data:{id_entity_combination:id_entity_combination},
        dataType:"JSON",
        type:"POST",
        success:function(respond){
            var html = "";
            for(var a = 0;a<respond["entity_list"].length; a++){
                html += respond["entity_list"][a]["entity"]+" <i>"+respond["entity_list"][a]["entity_category"]+"</i><br/>";
            }
            $("#dataset_entity_list").html(html);
            $("#dataset_query").html(respond["query"][0]["dataset_query"]);
            $("#id_submit_dataset").html(respond["query"][0]["id_submit_dataset"]);
        }
    });
}
</script>
<script>
function addToList(){
    var dataset_name = $("#id_dataset option:selected").html();
    
    var id_dataset = $("#id_submit_dataset").text();
    $("#id_submit_dataset").html("");

    var dataset_entity_list = $("#dataset_entity_list").html();
    $("#dataset_entity_list").html("");

    var dataset_query = $("#dataset_query").html();
    $("#dataset_query").html("");

    var counter = $(".new_row").length;
    var html = "<tr class = 'new_row'><td><div class = 'checkbox-custom checkbox-primary'><input type = 'checkbox' name = 'checks[]' checked value = '"+counter+"'><label></label></div></td><td><input type = 'hidden' name = 'dataset_related"+counter+"' value = '"+id_dataset+"'>"+dataset_name+"</td><td>"+dataset_entity_list+"</td><td>"+dataset_query+"</td></tr>";
    $("#tableListContainer").append(html);
}
</script>