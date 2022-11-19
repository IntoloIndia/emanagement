@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')

<div class="modal fade" id="sizeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Size color</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="sizeForm">
      <div class="modal-body">
          <div class="size_err"></div>
              <div class="mb-3">
                <label for="size" class="form-label">Size</label>
                <input type="text" name="size" class="form-control" id="size"placeholder="size" >
            </div>
          
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="sizeBtn">save</button>
          <button type="submit" class="btn btn-primary" id="updateSizeBtn">update</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- size modal end  --}}

{{-- color modal start  --}}

<div class="modal fade" id="colorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Color</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="colorForm">
          <div class="color_err"></div>
              <div class="mb-3">
                <label for="color" class="form-label">color</label>
                <input type="color" name="color" class="form-control" id="color">
                <p id="color_code">#000000</p>
              </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="colorBtn">save</button>
      </form>
      </div>
    </div>
  </div>
</div>

{{-- color modal end  --}}


<div class="row">
<div class="col-lg-6 col-md-6 col-sm-12">
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-6">
          <b>Size</b>
        </div>
        <div class="col-6">
          <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#sizeModal">
            Add size
          </button>
        </div>
      </div>
    </div>
        <div class="card-body">
          <div>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Sno</th>
                  <th scope="col">Size</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                $count = 0;
                @endphp
              @foreach($allSize as $list)
                <tr>
                  <td>{{++$count}}</td>
                  <td>{{$list->size}}</td>
                  <td><Button class="btn btn-info btn-sm" id="updateSize">edit</Button>
                    <Button class="btn btn-danger btn-sm">Delete</Button>
                    </td> 
                </tr>
                @endforeach
              </tbody> 
              
            </table>
          </div>
    </div>
  </div>
</div>
{{-- start color div  --}}
<div class="col-lg-6 col-md-6 col-sm-12">
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-6">
          <b>Color</b>
        </div>
        <div class="col-6">
          <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#colorModal">
            Add color
          </button>
        </div>
      </div>
    </div>
        <div class="card-body">
          <div>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Sno</th>
                  <th scope="col">Color</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                $count = 0;
                @endphp
              @foreach($allColor as $list)
                <tr>
                  <td>{{++$count}}</td>
                  <td>{{$list->color}}</td>
                  <td>
                    <i class="fas fa-pen" style="width:30px;color:blue" id="updateBtn"></i>
                    <i class=" fa fa-trash" style="width:30px;color:red"></i>
                     </td> 
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
    </div>
  </div>
  
</div>
<div class="row">
  
</div>

</div>
@endsection

@section('script')
<script>
  





function saveSize() {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  var formData = new FormData($("#sizeForm")[0]);
  $.ajax({
      type: "post",
      url: "save-size",
      data: formData,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
          // console.log(response);
          if (response.status === 400) {
              $('#size_err').html('');
              $('#size_err').addClass('alert alert-danger');
              var count = 1;
              $.each(response.errors, function (key, err_value) {
                  $('#size_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
              });

          } else {
              $('#size_err').html('');
              $('#sizeModal').modal('hide');
              window.location.reload();
          }
      }
  });
}
// save color code start
function saveColor() {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  var formData = new FormData($("#colorForm")[0]);
  $.ajax({
      type: "post",
      url: "save-color",
      data: formData,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
          // console.log(response);
          if (response.status === 400) {
              $('#color_err').html('');
              $('#color_err').addClass('alert alert-danger');
              var count = 1;
              $.each(response.errors, function (key, err_value) {
                  $('#color_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
              });

          } else {
              $('#color_err').html('');
              $('#colorModal').modal('hide');
              window.location.reload();
          }
      }
  });
}

$(document).ready(function(){
    $(document).on('click','#sizeBtn',function(){
      // alert("sizeBtn")
      saveSize();

    })
    $(document).on('click','#colorBtn',function(){
      // alert("submitcolor");
      saveColor();
    })

    $(document).on('click','#updateSize',function(){
      alert("submitcolor");
      // saveColor();
      editSize()
    })


    $(document).on('click','#colorBtn', function (e) {
                e.preventDefault();
                $('#colorModal').modal('show');
                $('#color_err').html('');
                $('#color_err').removeClass('alert alert-danger');
                $("#colorForm").trigger( "reset"); 
                // $("#project_id").chosen({ width: '100%' });
                 $('#saveSizeBtn').removeClass('hide');
                 $('#updateSizeBtn').addClass('hide');
                
            });

            $(document).on('click','#sizeBtn', function (e) {
                e.preventDefault();
                $('#sizeModal').modal('show');
                $('#size_err').html('');
                $('#size_err').removeClass('alert alert-danger');
                $("#sizeForm").trigger( "reset"); 
                // $("#project_id").chosen({ width: '100%' });
                 $('#saveSizeBtn').removeClass('hide');
                 $('#updateSizeBtn').addClass('hide');
                
            });


            // edit size 

//   function editSize(size_id) {
//     $.ajax({
//         type: "get",
//         url: "edit-size/" + size_id,
//         dataType: "json",
//         success: function (response) {
//             if (response.status == 200) {
//                 $('#sizeModal').modal('show');
//                 $('#size_err').html('');
//                 $('#size_err').removeClass('alert alert-danger');
//                 $("#sizeForm").trigger("reset");
//                 $('#sizeBtn').addClass('hide');
//                 $('#updateSizeBtn').removeClass('hide');
               
//                 // $('#total_cl').val(response.employee.total_cl);
//                 // // $('#pf_deduction').val(response.employee.pf_deduction);
//                 // if (response.employee.pf_deduction == 1) {
//                 //     $('#pf_deduction_agree').prop('checked', true);
//                 // }else{
//                 //     $('#pf_deduction_disagree').prop('checked', true);
//                 // }
//                 // if (response.employee.payment_mode > 1) {
//                 //     $('#payment_by_cheque').prop('checked', true);
//                 // }else{
//                 //     $('#payment_by_cash').prop('checked', true);
//                 // }
//                 // // $('#payment_mode').val(response.employee.payment_mode);
                
//                 // $('#updateEmployeeBtn').val(response.employee.id);
//             }
//         }
//     });
// }


  })


  

</script>
@endsection