@extends('layouts.base')
@section('body')
    <style>
        * {
            margin-top: 10px;
        }

        .left-col {
            float: left;
            width: 25%;
        }

        .center-col {
            float: left;
            width: 50%;
        }

        .right-col {
            float: left;
            width: 25%;
        }
    </style>

    <div class="container">

        {{-- <button type="button" class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#itemModal">New
            Item
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>

        <button type="button" class="btn btn-info btn-lg" id="customerbtn" style="float: right">Show
            Customers<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
        <div class="table-responsive"> --}}

        <table id="itable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Description</th>
                    <th>Sell price</th>
                    <th>Cost price</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ibody">
            </tbody>
        </table>
    </div>
    </div>

    <div class="modal fade" id="itemModal" role="dialog" style="display:none">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create New Item</h4>

                    <div class="modal-body">
                        <form id="iform" action="#" method="#" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title" class="control-label">Description</label>
                                <input type="text" class="form-control" id="description" name="description">
                            </div>
                            <div class="form-group">
                                <label for="title" class="control-label">CostPrice</label>
                                <input type="text" class="form-control" id="cost_price" name="cost_price">
                            </div>
                            <div class="form-group">
                                <label for="lname" class="control-label">SellPrice</label>
                                <input type="text" class="form-control " id="sell_price" name="sell_price"></text>
                            </div>
                            <div class="form-group">
                                <label for="fname" class="control-label">Title</label>
                                <input type="text" class="form-control " id="title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="address" class="control-label">Item Image</label>
                                <input type="file" class="form-control" id="imagePath" name="uploads">
                            </div>
                        </form>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button id="updatebtn" type="submit" class="btn btn-primary">Save</button>
                </div>

            </div>
        </div>
    </div>
@endsection
