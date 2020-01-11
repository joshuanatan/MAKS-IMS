<script>
function addCategoryRow(){
    var counter = $(".new_row").length;
    var option = "<option value = 'INTENT'>INTENT</option><option value = 'ENTITY'>ENTITY</option>";
    var html = "<tr class = 'new_row'><td><div class = 'checkbox-custom checkbox-primary'><input checked type = 'checkbox' value = '"+counter+"' name ='checks[]'><label></label></div></td><td><input type = 'text' class = 'form-control' name = 'entity"+counter+"'></td><td><select class = 'form-control' name = 'entity_category"+counter+"'>"+option+"</select></td></tr>";
    $("#addButtonContainer").before(html);
}
</script>