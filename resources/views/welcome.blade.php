<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>eMangement</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Styles -->
    <style>
    /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
    
    </style>

    <!-- <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style> -->
</head>

<body class="antialiased">

    <div class="container">
        <div class="row">
            <div class="col-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Category
                </button>

                <!-- Modal -->
                <form action="/">
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mb-3">
                                        <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                                        <input type="text" class="form-control" placeholder="category name"
                                            aria-label="Username" aria-describedby="basic-addon1">

                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#staticBackdropdata">
                    Sub Category
                </button>

                <!-- Modal -->
                <form action="/">
                    <div class="modal fade" id="staticBackdropdata" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"> Sub-Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- <div class="mb-2"> -->
                                    <select class="form-select mb-2" aria-label="Default select example">
                                        <option selected>Select Category</option>
                                        <option value="1">Mans</option>
                                        <option value="2">Kids</option>
                                        <option value="3">Womens</option>
                                    </select>
                                    <!-- </div> -->


                                    <div class="input-group mb-3">
                                        <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                                        <input type="text" class="form-control" placeholder=" sub category name"
                                            aria-label="Username" aria-describedby="basic-addon1">

                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#staticBackdropcolor">
                    Color
                </button>

                <!-- Modal -->
                <form action="/">
                    <div class="modal fade" id="staticBackdropcolor" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Color</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mb-3">
                                        <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                                        <div class="container">

                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="color" class="form-control">
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" class="form-control" placeholder="color name"
                                                        aria-label="Username" aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#staticBackdropsize    ">
                    Size
                </button>

                <!-- Modal -->
                <form action="/">
                    <div class="modal fade" id="staticBackdropsize" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Size</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mb-3">
                                        <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                                        <input type="text" class="form-control" placeholder="size" aria-label="Username"
                                            aria-describedby="basic-addon1">

                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
      
    </script>
</body>

</html>