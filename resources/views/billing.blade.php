<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <div class="container">
        <h3>Billing</h3>
        <div class="row">
            <form action=""></form>
            <div class="col-lg-8 col-md-12 col-sm-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h5>Billing</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2 col-md-12 col-sm-12">
                                <label for="date" class="form-label">Date</label>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control" placeholder="date" id="date">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    <label for="mobile_no" class="form-label">Mobile no</label>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" placeholder="enter mobile no"
                                            id="mobile_no">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <label for="name" class="form-label">name</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="enter name" id="name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <b>Add Items</b>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                                                    <button type="button" id="addItemBtn"
                                                        class="btn btn-primary btn-flat btn-sm">Add Item</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cord-body">
                                        <div class="row">
                                            <div class="col-md-12">
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
                                                            <td style="width: 100px;">
                                                                <input type="text" name="qty[]"
                                                                    class="form-control form-control-sm qty">
                                                            </td>
                                                            <td style="width: 100px;">
                                                                <input type="text" name="qty[]"
                                                                    class="form-control form-control-sm qty">
                                                            </td>
                                                            <td style="width: 100px;">
                                                                <input type="text" name="qty[]"
                                                                    class="form-control form-control-sm qty">
                                                            </td>
                                                            <td style="width: 100px;">
                                                                <input type="text" name="qty[]"
                                                                    class="form-control form-control-sm qty">
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
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">save</button>

                        <!-- <a href="#" class="btn btn-primary">save</a> -->
                    </div>
                </div>
            </div>
            <div class="col-4">

            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function () {
         $(document).on('click','#addItemBtn', function (e) {
                e.preventDefault();
                // addItem();
                alert("hello");
            });
        })
    </script>
</body>

</html>