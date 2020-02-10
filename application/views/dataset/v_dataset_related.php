<div class="page-header">
    <h1 class="page-title">MASTER DATASET</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dataset</a></li>
        <li class="breadcrumb-item">Related</li>
    </ol>
</div>
<div class="page-body col-lg-10 offset-lg-1">
    <h5>Related Dataset</h5>
    <button type = "button" data-toggle = "modal" data-target = "#addRelatedDataset" class = "btn btn-primary btn-sm">+ADD RELATED DATASET</button>
    <br/><br/>
    <form action = "<?php echo base_url();?>dataset/remove_related" method = "POST">
        <table class = "table table-stripped table-hover table-bordered" data-plugin = "dataTable">
            <thead>
                <th style = "width:5%">Delete</th>
                <th style = "width:40%">Dataset Key / Dataset Name</th>
                <th>Dataset Query</th>
            </thead>
            <tbody>
                <?php for($a = 0; $a<count($registered_related); $a++):?>
                <tr>
                    <td>
                        <div class = "checkbox-custom checkbox-primary">
                            <input type = "checkbox" name = "checks[]" value = "<?php echo $registered_related[$a]["id_submit_dataset_related"];?>">
                            <label></label>
                        </div>
                    </td>
                    <td>
                        <?php echo $registered_related[$a]["dataset_key"];?><br/>
                        <?php echo $registered_related[$a]["dataset_name"];?>
                    </td>
                    <td><?php echo $registered_related[$a]["dataset_query"];?></td>
                </tr>
                <?php endfor;?>
            </tbody>
        </table>
        <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
        <a href = "<?php echo base_url();?>dataset" class = "btn btn-primary btn-sm">BACK</a>
    </form>
</div>

<div class = "modal fade" id = "addRelatedDataset">
    <div class = "modal-dialog modal-center modal-lg">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>Dataset Repository</h4>
            </div>
            <div class = "modal-body" style = 'max-height: calc(100vh - 210px);overflow-y: auto;'>
                <div class = "form-group">
                    <h5>Dataset Option</h5>
                    <select class = "form-control" id = "id_dataset" onchange = "getDatasetDetail()" data-plugin = "select2">
                        <option value = "0">Choose Dataset</option>
                        <?php for($a = 0; $a<count($dataset_list); $a++):?>
                            <option value = "<?php echo $dataset_list[$a]["id_entity_combination"];?>"><?php echo $dataset_list[$a]["dataset_name"];?> / <?php echo $dataset_list[$a]["dataset_key"];?></option>
                        <?php endfor;?>
                    </select>
                </div>
                <div class = "form-group">
                    <h5>Selected Dataset Detail</h5>
                    <table class = "table table-stripped table-hover table-bordered">
                        <tr>
                            <th style = "width:20%">ID Dataset</th>
                            <td id = "id_submit_dataset"></td>
                        </tr>
                        <tr>
                            <th style = "width:20%">Entity List</th>
                            <td id = "dataset_entity_list"></td>
                        </tr>
                        <tr>
                            <th>Query</th>
                            <td id = "dataset_query"></td>
                        </tr>
                    </table>
                </div>
                <button type = "button" class = "btn btn-primary btn-sm col-lg-12" onclick = "addToList()">ADD TO LIST</button>
                <h5>Selected Dataset</h5>
                <form action = "<?php echo base_url();?>dataset/insert_related" method = "POST">
                    <table class = "table table-striped table-hover table-bordered" style = 'width:100%'>
                        <thead>
                            <th>#</th>
                            <th>Dataset Name</th>
                            <th>Entity List</th>
                            <th>Query</th>
                        </thead>
                        <tbody id = "tableListContainer">

                        </tbody>
                    </table>
                    <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>