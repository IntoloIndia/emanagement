@extends('layouts.app')
@section('page_title','Style No')

@section('content-header')
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="m-0"><b>Style No</b></h3>
            </div>
            <div class="col-sm-6">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                    <button type="button" id="addStyleNo" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-plus"></i> Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection
    
@section('content')

    <div class="modal fade" id="styleNoModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Style No</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="styleNoForm">
                        @csrf
                        <div class="modal-body">
                            <div id="style_no_err"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="Supplier" class="form-label">Supplier</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="supplier_id" name="supplier_id" class="form-select form-select-sm">
                                        <option selected disabled >Select...</option>
                                        @foreach ($suppliers as $list)
                                            <option value="{{$list->id}}">{{ucwords($list->supplier_name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-4">
                                    <label for="styleNo" class="form-label">Style No</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="style_no" id="style_no" class="form-control form-control-sm">
                                </div>
                            </div>
                            
                        </div>
                        <input type="hidden" name="style_id" id="style_id" value="">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="saveStyleNoBtn" class="btn btn-primary btn-sm ">Save</button>
                            <button type="button" id="updateStyleNoBtn" class="btn btn-primary btn-sm hide">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteStyleNoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete Style No </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                        <h5>Are you sure?</h5>
                            <button type="button" id="yesDeleteStyleNoBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                            <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                        <hr>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Styles</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0" style="height: 450px;">
                    <div class="col-md-12 mt-2">
                        <select class="form-select form-select-sm select_chosen" name="supplier_id" id="supplier_id" >
                            <option selected="" disabled=""> Supplier </option>
                            @foreach ($suppliers as $item)
                                <option value="{{$item->id}}">{{$item->supplier_name}}</option> 
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 table-responsive" style="height: 300px;">
                            <table class="table table-striped table-head-fixed" id="style_no_list" >
                                
                            </table>    
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $(".select_chosen").chosen({ width: '100%' });
            $(document).on('click','#addStyleNo', function (e) {
                e.preventDefault();
                $('#styleNoModal').modal('show');
                $('#style_no_err').html('');
                $('#style_no_err').removeClass('alert alert-danger');
                $("#styleNoForm").trigger("reset"); 
                $('#saveStyleNoBtn').removeClass('hide');
                $('#updateStyleNoBtn').addClass('hide');
            });

            $(document).on('click','#saveStyleNoBtn', function (e) {
                e.preventDefault();
                manageStyleNo();
            });
            
            $(document).on('click','.editStyleNoBtn', function (e) {
                e.preventDefault();
                // alert("call")
                const style_id = $(this).val();
                editStyleNo(style_id);
            });

            $(document).on('click','#updateStyleNoBtn', function (e) {
                e.preventDefault();
                const style_id = $(this).val();
                manageStyleNo(style_id);
            });
            
            // $(document).on('click','.deleteStyleNoBtn', function (e) {
            //     e.preventDefault();
            //     // alert("gdg");
            //     const style_no_id = $(this).val();
            //     $('#deleteStyleNoModal').modal('show');
            //     $('#yesDeleteStyleNoBtn').val(style_no_id);
            // });

            // $(document).on('click','#yesDeleteStyleNoBtn', function (e) {
            //     e.preventDefault();
            //     const style_no_id = $(this).val();
            //     deleteStyleNo(style_no_id);
            // });

            $(document).on('change','#supplier_id', function(e){
            e.preventDefault();
            var supplier_id = $(this).val();
            styleNoBySupplier(supplier_id);
           
        });


        });

        function manageStyleNo(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#styleNoForm")[0]);
            $.ajax({
                type: "post",
                url: "save-style-no",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#style_no_err').html('');
                        $('#style_no_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#style_no_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#style_no_err').html('');
                        $('#styleNoModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function editStyleNo(style_id){
            $.ajax({
                type: "get",
                url: "edit-style-no/"+style_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#styleNoModal').modal('show');
                        $('#style_no_err').html('');
                        $('#style_no_err').removeClass('alert alert-danger');
                        $("#styleNoForm").trigger( "reset" ); 
                        $('#saveStyleNoBtn').addClass('hide');
                        $('#updateStyleNoBtn').removeClass('hide');
                        $('#supplier_id').val(response.style_no.supplier_id);
                        $('#style_no').val(response.style_no.style_no);

                        $('#style_id').val(response.style_no.id);
                    }
                }
            });
        }

        

        function deleteStyleNo(style_no_id){
            $.ajax({
                type: "get",
                url: "delete-style-no/"+style_no_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){

                        window.location.reload();
                    }
                }
            });
        }


        function styleNoBySupplier(supplier_id) {
        $.ajax({
            type: "get",
            url: `style-no-by-supplier/${supplier_id}`,
            dataType: "json",
            success: function (response) {
                if(response.status == 200){
                    $('#style_no_list').html("");
                    $('#style_no_list').append(response.html);
                }
            }
        });
    } 

        
    </script>
@endsection