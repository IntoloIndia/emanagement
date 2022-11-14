@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
   <div class="row">
    <div class="col-lg-7 col-md-12 col-sm-12">
        <div class="card"style="height: 85vh;">
            <div class="card-header">
                <b>Billing</b>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="moblie_no" class="form-label">moblie no</label>
                            <input type="number" class="form-control" id="moblie_no" placeholder="Enter mobile number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <b>Items</b>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm " id="addItemBtn"> Add item</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body"style="max-height:400px;">
                       <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Sno</th>
                                        <th scope="col">Item</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Pic</th>
                                        <th scope="col">Size</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Delete</th>

                                    </tr>
                                </thead>
                                <tbody id="item_list">
                                    {{-- <tr>
                                        <td>1</td>
                                        <td style="width: 200px;">
                                            <select class="form-select form-select-sm form-control sm" aria-label="Default select example">
                                                <option selected>choose</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                              </select>
                                        </td>
                                        <td style="width: 100px;">
                                            <input type="text" name="qty[]" value="101" disabled
                                                class="form-control form-control-sm qty">
                                        </td>
                                        <td style="width: 100px;">
                                            <input type="number" name="qty[]" value="1"
                                                class="form-control form-control-sm qty">
                                        </td>
                                        <td style="width: 170px;">
                                            <select class="form-select  form-select-sm form-control sm" aria-label="Default select example">
                                                <option selected>size</option>
                                                <option value="1">l</option>
                                                <option value="2">xl</option>
                                                <option value="3">xll</option>
                                              </select>
                                        </td>
                                        <td style="width: 100px;">
                                            <input type="text" name="qty[]"
                                                class="form-control form-control-sm qty">
                                        </td>
                                        <td style="width: 100px;">
                                            <input type="text" name="qty[]"
                                                class="form-control form-control-sm qty">
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-danger btn-flat btn-sm delete_item"><i
                                                    class="far fa-window-close"></i></button>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>  
                        </div>
                       </div>
                       <div class="footer">
                        <div class="row">
                            {{-- <b>Gst :-{{300}}</b> --}}
                        </div>
                        <div class="row">
                            <b class="float-right">Total :-{{300}}</b>
                        </div>
                       </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success float-right ">save</button>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <b>Table</b>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Sno</th>
                            <th scope="col">Item</th>
                            <th scope="col">Code</th>
                            <th scope="col">Pic</th>
                            <th scope="col">Size</th>
                            <th scope="col">Price</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="item_list">
                        <tr>
                            <td>1</td>
                            <td>T-Shart</td>
                            <td>101</td>
                            <td>1</td>
                            <td>xl</td>
                            <td>300</td>
                            <td>300</td>
                        </tr>
                    </tbody>
                </table>  
            </div>
        </div>
    </div>
   </div>

   <table class="hide">
    <tbody id="item_row">
        <tr>
            <td id="count_item"></td>
            
            <td style="width: 200px;">
                <select name="item_id[]" class=" form-select form-select-sm item">
                    <option selected disabled>Choose..</option>
                    <option value="1">Man</option>
                    <option value="2">Women</option>
                    <option value="3">Kids</option>
                    {{-- @foreach ($items as $item)
                        <option value="{{$item->id}}">{{ucwords($item->item_name)}}</option>
                    @endforeach --}}
                </select>
            </td>
            <td style="width: 100px;">
                <input type="text" name="item_code[]" class="form-control form-control-sm qty">
            </td>
            <td style="width: 100px;">
                <input type="text" name="qty[]" class="form-control form-control-sm qty">
            </td>
            <td style="width: 200px;">
                <select name="size_id[]" class=" form-select form-select-sm item">
                    <option selected disabled>Choose..</option>
                    <option selected>size</option>
                    <option value="1">l</option>
                    <option value="2">xl</option>
                    <option value="3">xll</option>
                    {{-- @foreach ($items as $item)
                        <option value="{{$item->id}}">{{ucwords($item->item_name)}}</option>
                    @endforeach --}}
                </select>
            </td>
            <td style="width: 100px;">
                <input type="text" name="price[]" class="form-control form-control-sm price" readonly>
            </td>
            <td style="width: 150px;">
                <input type="text" name="amount[]" class="form-control form-control-sm amount" readonly>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-flat btn-sm delete_item"><i class="far fa-window-close"></i></button>
            </td>
        </tr>
    </tbody>
</table> 
    @endsection


@section('script')
{{-- <script src="{{asset('public/sdpl-assets/user/js/slider.js')}}"></script> --}}

<script>
        $(document).ready(function () {
            $(document).on('click','#addItemBtn', function (e) {
                e.preventDefault();
                // alert("call")
                addItem();
            });

            function addItem() {
            $('#item_list').append($('#item_row').html());
            // $("#item_list tr").find(".item").chosen();
        }
        $(document).on("click",".delete_item", function(){
                if($("#item_list tr").length == 1)
                {
                    alert("Order must have at least 1 item.");
                    return false;
                }
                $(this).parent().parent().remove();
                calculateTotalAmount();
            });
        })
        

           
    </script>

@endsection

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script> -->
    <!-- <script>
        $(document).ready(function () {
         $(document).on('click','#addItemBtn', function (e) {
                e.preventDefault();
                // addItem();
                alert("hello");
            });
        })
    </script> -->
