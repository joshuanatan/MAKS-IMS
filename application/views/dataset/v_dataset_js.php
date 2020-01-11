
<script>
var is_first = 1;
function loadViewList(){
    
    var id_db_connection = $("#id_db_connection").val();
    if(id_db_connection){
        if(is_first == 1){
            var id_db_connection = $("#id_db_connection").val();
            $.ajax({
                url:"<?php echo base_url();?>interface/database/get_table_list",
                type:"POST",
                dataType:"JSON",
                data:{id_db_connection:id_db_connection},
                success:function(respond){
                    var html = "";
                    for(var a= 0; a<respond.length; a++){
                        html += "<tr><td>"+(a+1)+"</td><td id = 'table_name_"+a+"'>"+respond[a]["nama_table"]+"</td><td><button id = 'button"+a+"' type = 'button' class = 'btn btn-primary btn-sm col-lg-12 tbl_button_control' onclick = 'load_columns(\""+respond[a]["nama_table"]+"-"+a+"\")'>LOAD COLUMNS</button></td></tr>";
                    }
                    $("#tableListContainer").html(html);
                } 
            });
            is_first = 0;
        }
    }
}
</script>
<script>
function addCustomField(){
    var counter = $(".db_field").length;
    var html = "<tr class = 'db_field' id = 'db_field_custom_"+(counter+1)+"'><td><div class = 'checkbox-custom checkbox-primary'><input type = 'checkbox' name = 'db_field_checks[]' value = '"+(counter+1)+"'><label></label></div></td><button type = 'button' class = 'btn btn-danger btn-sm col-lg-12' onclick = 'removeCustomRow("+(counter+1)+")'><i class = 'icon wb-close'></i></button></td><td><input type = 'text' class = 'form-control' name = 'db_field"+(counter+1)+"'></td><td><input type = 'text' name = 'table_name"+(counter+1)+"' class = 'form-control'></td><td><input type ='text' class = 'form-control' name = 'db_field_alias"+(counter+1)+"'></td></tr>";
    $("#tableEntity").append(html);
}
</script>
<script>
function activate_mapping_container(){
    var id_db_connection = $("#id_db_connection").val();
    if(parseInt(id_db_connection) == 0 ){
        $("#dbfield_mapping_container").css("display","none");
    }
    else{
        $("#dbfield_mapping_container").css("display","block");
            $("#tableEntity").html("");
    }
}
</script>
<script>
function removeCustomRow(row){
    $("[name='db_field_checks[]']").attr("disabled",true);
    $("[name='db_field"+row+"']").attr("disabled",true);
    $("[name='table_name"+row+"']").attr("disabled",true);
    $("[name='table_alias"+row+"']").attr("disabled",true);
}
</script>
<script>
function load_columns(table_name){
    var variable = table_name.split("-");
    var counter = $(".db_field").length;
    var id_db_connection = $("#id_db_connection").val();
    
    $.ajax({
        url:"<?php echo base_url();?>interface/database/get_list_kolom",
        type:"POST",
        dataType:"JSON",
        data:{table_name:variable[0],id_db_connection:id_db_connection},
        success:function(respond){
            var html = "";
            for(var a = 0; a<respond.length; a++){
                html += "<tr class = 'db_field db_field_"+variable[0]+"'><td><div class = 'checkbox-custom checkbox-primary'><input type = 'checkbox' name = 'db_field_checks[]' value = '"+(counter+a+1)+"'><label></label></div></td><td><input type = 'hidden' name = 'db_field"+(counter+a+1)+"' value = '"+respond[a]["column_name"]+"' >"+respond[a]["column_name"]+"</td><td><input type = 'hidden' name = 'table_name"+(counter+a+1)+"' value = '"+variable[0]+"'>"+variable[0]+"</td><td><input type ='text' class = 'form-control' name = 'db_field_alias"+(counter+a+1)+"'></td></tr>";
            }
            $("#tableEntity").append(html);
            $("#button"+variable[1]).attr('class','btn btn-light btn-sm col-lg-12');
            $("#button"+variable[1]).attr('onclick','remove_columns(\"'+table_name+'\")');
            $("#button"+variable[1]).html('COLOUMNS LOADED');
            $('.dataTables_empty').remove();
            $('.tagsinput').select2();
        }
    });
    
}
</script>
<script>
function remove_columns(table_name){
    var variable = table_name.split("-");
    $('.db_field_'+variable[0]).remove();
    $("#button"+variable[1]).attr('class','btn btn-primary btn-sm col-lg-12');
    $("#button"+variable[1]).attr('onclick','load_columns(\"'+table_name+'\")');
    $("#button"+variable[1]).html('LOAD COLUMNS');
}
</script>
<script>
function loadViewList_edit(){
    var id_db_connection = $("#id_db_connection").val();
    $.ajax({
        url:"<?php echo base_url();?>interface/database/get_table_list",
        type:"POST",
        dataType:"JSON",
        data:{id_db_connection:id_db_connection},
        success:function(respond){
            var html = "";
            for(var a= 0; a<respond.length; a++){
                if($(".db_field_"+respond[a]["nama_table"]).length > 0){
                    html += "<tr><td>"+(a+1)+"</td><td id = 'table_name_"+a+"'>"+respond[a]["nama_table"]+"</td><td><button id = 'button"+a+"' type = 'button' class = 'btn btn-light btn-sm col-lg-12 tbl_button_control' onclick = 'remove_columns(\""+respond[a]["nama_table"]+"-"+a+"\")'>COLOUMNS LOADED</button></td></tr>";
                }
                else{
                    html += "<tr><td>"+(a+1)+"</td><td id = 'table_name_"+a+"'>"+respond[a]["nama_table"]+"</td><td><button id = 'button"+a+"' type = 'button' class = 'btn btn-primary btn-sm col-lg-12 tbl_button_control' onclick = 'load_columns(\""+respond[a]["nama_table"]+"-"+a+"\")'>LOAD COLUMNS</button></td></tr>";
                }
            }
            $("#tableListContainer").html(html);
        } 
    });
}
</script>
<script>
function new_entity_row(){
    var opsi = "<option>Choose Entity</option>";
    <?php for($a =0 ; $a<count($entity); $a++):?>
    opsi += "<option value ='<?php echo $entity[$a]["id_submit_entity"];?>'><?php echo $entity[$a]["entity"];?></option>";
    <?php endfor;?>

    var counter = $(".new_row").length;
    html = '<tr class = "new_row"><td><div class = "checkbox-custom checkbox-primary"><input type = "checkbox" name = "checks[]" value = '+counter+'><label></label></div></td><td><select class = "form-control col-lg-12" name = "entity'+counter+'">'+opsi+'</select></td></tr>';
    $("#entity_button_container").before(html);
}
</script>