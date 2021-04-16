<?php
$i = 1; ?>
<script src="{{ asset('js/purchaseorder.js') }}"></script>

<nav class="navbar navbar-expand-lg navbar-light bg-light" style="justify-content: space-between;">
    <div class="container-fluid">
        <h2 class="navbar-brand tab-list-title">
            <a href='javascript:onclick=loadPurchaseOrder();' class="fas fa-arrow-left back-button"><span></span></a>
            <h2 class="navbar-brand" style="font-size: 35px;">{{ $purchase_order->purchase_id }}</h2>
            <p id="mp_status">{{ $purchase_order->mp_status }}</p>
        </h2>
        @if($purchase_order->mp_status === 'Draft')
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown li-bom">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Get items from
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <!--<li><a class="dropdown-item" href="#">Product Bundle</a></li>-->
                        <li><a class="dropdown-item" data-toggle="modal" data-target="#sq_modal">Supplier Quotation</a></li>
                        <!--<li><a class="dropdown-item" href="#">Supplier Quotation</a></li>-->
                    </ul>
                </li>
                <li class="nav-item dropdown li-bom">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Tools
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Update rate as per last purchase</a></li>
                        <li><a class="dropdown-item" href="#">Link to Material</a></li>
                    </ul>
                </li>
                <li class="nav-item li-bom">
                    <button class="btn btn-primary" id="submitOrder" type="button">Submit</button>
                </li>
            </ul>
        </div>
        @endif
    </div>
</nav>

<!-- Modal Purchase Order-->
<div class="modal fade" id="sq_modal" tabindex="-1" role="dialog" aria-labelledby="sq_modal"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Supplier Quotations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="purchaseReceiptTable" class="table table-striped table-bordered hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Supplier Quotation ID</th>
                            <th>Supplier ID</th>
                            <th>Item List</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supplier_quotations as $quotation)
                            <tr>
                                <td class="text-bold">{{ $quotation->supp_quotation_id }}</td>
                                <td>{{ $quotation->supplier_id }}</td>
                                <td class="text-bold text-center"><button type="button" class="btn-sm btn-primary"
                                        data-toggle="modal" data-target="#npr_itemListView">View</button></td>
                                <td class="text-bold text-center"><button type="button" class="btn-sm btn-primary"
                                        data-dismiss="modal" onclick="loadQuotation({{ $quotation->id }})">Select</button></td>   
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<div class="container">
    <form id="newpurchaseorderForm" name="newpurchaseForm" role="form" method="POST">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="input-group">
                    <label class="label">Series</label>
                    <select class="form-control" id="purch_id" type="text" name="series" style="width:512px;height:38px;" readonly>
                        <option value="{{ $purchase_order->purchase_id }}" selected>{{ $purchase_order->purchase_id }}</option>
                    </select>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="date">Date</label>

                    <input type="date" id="transDate" name="date"
                        value="{{ $purchase_order->purchase_date }}" class="form-control" readonly>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="supplier">Supplier</label>
                    <input type="text" id="supplierField" value="{{ $supplier['company_name'] }}" name="supplier" class="form-control" readonly>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="reqdbydate">Reqd by Date</label>
                    <input type="date" name="reqdbydate" id="reqDate" value="{{ $req_date }}" class="form-control" @if($purchase_order->mp_status !== 'Draft') readonly @else onchange="onChangeFunction();" @endif>
                </div>
            </div>

        </div>



        <!---Address and Contacts-->
        <a href="#submenuAddressandContacts" data-toggle="collapse" aria-expanded="false"
            class="bg-white list-group-item list-group-item-action">

            <span class="menu-collapsed align-middle smaller menu"> ADDRESS AND CONTACTS</span>
            <i class="fa fa-caret-down" aria-hidden="true"></i>

        </a>

        <div id='submenuAddressandContacts' class="collapse sidebar-submenu">
            <br>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="selectsuppadd">Select Supplier Address</label>
                        <input type="text" id="suppAddress" value="{{ $supplier['supplier_address'] }}" readonly class="form-control">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="selectshipadd">Select Shipping Address</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="contactperson">Contact Person</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <!----End of Address and Contacts-->
        <!---Currency and Price List-->
        <a href="#submenuCurrencyandPriceList" data-toggle="collapse" aria-expanded="false"
            class="bg-white list-group-item list-group-item-action">

            <span class="menu-collapsed align-middle smaller menu">PRICE LIST</span>
            <i class="fa fa-caret-down" aria-hidden="true"></i>

        </a>
        <div id='submenuCurrencyandPriceList' class="collapse sidebar-submenu">
            <br>
            <div class="row">
          
                <div class="col-6">
                    <div class="form-group">
                        <label for="settargetWh">Set Target Warehouse</label>
                        <input type="text" class="form-control">
                    </div>
                </div>

                <br>

                <table class="table table-bom border-bottom" id="itemTable">
                    <thead class="border-top border-bottom bg-light">
                        <tr class="text-muted">
                            <td>
                                <div class="form-check">
                                    <input type="checkbox" id="masterChk" class="form-check-input" @if($purchase_order->mp_status !== 'Draft') disabled @else onchange="onChangeFunction();" @endif>
                                </div>
                            </td>
                            <td>Item Code</td>
                            <td>Reqd By Date</td>
                            <td>Quantity</td>
                            <td>Rate</td>
                            <td>Amount</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody class="" id="itemTable-content">
                        @foreach ($items_purchased as $item)
                            <tr id="item-<?= $i ?>">
                            <td>
                                <div class="form-check">
                                    <input type="checkbox" name="item-chk" id="chk<?= $i ?>" class="form-check-input" @if($purchase_order->mp_status !== 'Draft') disabled @else onchange="onChangeFunction();" @endif>
                                </div>
                            </td>
                            <td class="text-black-50">
                                <input class="form-control" type="text" name="item<?= $i ?>" id="item<?= $i ?>" value="{{ $item['item_code'] }}" @if($purchase_order->mp_status !== 'Draft') readonly @else onkeyup="fieldFunction(<?= $i ?>); onChangeFunction();" @endif>
                            </td>
                            <td class="text-black-50">
                                <input class="form-control" type="date" name="date<?= $i ?>" id="date<?= $i ?>" value="{{ $item['req_date'] }}" @if($purchase_order->mp_status !== 'Draft') readonly @else onchange="onChangeFunction();" @endif>
                            </td>
                            <td class="text-black-50">
                                <input class="form-control" type="number" name="qty<?= $i ?>" id="qty<?= $i ?>" value="{{ $item['qty'] }}" min="1" @if($purchase_order->mp_status !== 'Draft') readonly @else onchange="calcPrice(1); onChangeFunction();" @endif>
                            </td>
                            <td class="text-black-50">
                                <input class="form-control" type="number" name="rate<?= $i ?>" id="rate<?= $i ?>" value="{{ $item['rate'] }}" min="1" @if($purchase_order->mp_status !== 'Draft') readonly @else onchange="calcPrice(1); onChangeFunction();" @endif>
                            </td>
                            <td class="text-black-50">
                                <input class="form-control" type="text" name="price<?= $i ?>" id="price<?= $i ?>" value="₱ {{ $item['subtotal'] }}" readonly>
                            </td>
                            <td class="text-black-50">
                                <select class="input--style-4" type="text" name="sampleOne"
                                    style="width:50px;height:30px;">
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </td>
                        </tr>
                        <?php ++$i; ?>
                        @endforeach
                    </tbody>
                    
                    <tfoot>
                        <tr>
                        @if($purchase_order->mp_status === 'Draft')
                            <td><button type="button" id="multBtn" style="background-color: #007bff;" onclick="onChangeFunction();">Add
                                    Multiple</button></td>
                            <td><button type="button" id="rowBtn" style="background-color: #007bff;" onclick="onChangeFunction();">Add Row</button>
                            </td>
                            <td><button type="button" id="deleteRow"
                                    style="background-color: red; display:none;">Delete</button></td>
                            <td></td>
                            <td><button id="button1">Download</button></td>
                            <td><button id="button1">Upload</button></td>
                        @endif
                        </tr>
                    </tfoot>

                    <style>
                        #multBtn,
                        #rowBtn,
                        #deleteRow {
                            border-radius: 4px;
                            padding: 5px;
                            color: white;
                        }
                    </style>
                </table>
                <hr>
                <br>

                <div class="col-6">
                    <div class="form-group">
                        <label for="totalphp">Total (PHP)</label>
                        <input type="text" class="form-control" id="totalPrice" value="₱ 0.00" readonly>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                    </div>
                </div>

            </div>

        </div>
        <a href="#submenuMoreInfo" data-toggle="collapse" aria-expanded="false"
            class="bg-white list-group-item list-group-item-action">

            <span class="menu-collapsed align-middle smaller menu"> MORE INFORMATION</span>
            <i class="fa fa-caret-down" aria-hidden="true"></i>

        </a>
        <div id='submenuMoreInfo' class="collapse sidebar-submenu">
            <br>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                    </div>
                </div>
            </div>


        </div>
    </form>
</div>
