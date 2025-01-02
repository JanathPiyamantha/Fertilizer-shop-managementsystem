<?php
    // Start the session
    session_start();
    if (!isset($_SESSION['user'])) header('location: login.php');

    // Get all products
    $show_table = 'products';
    $products = include('database/show.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Products - Fertilizer Shop Management System</title>
    <?php include('partials/app-header-scripts.php'); ?>
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('partials/app-topnav.php') ?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section_header"><i class="fa fa-list"></i>List Of Products</h1>
                            <div class="section_content">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th width="40%">Description</th>
                                                <th width="15%">Suppliers</th>
                                                <th>Created By</th>
                                                <th>Quantity</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($products as $index => $product) { ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td class="firstName">
                                                        <img class="productImages" src="uploads/products/<?= $product['img'] ?>" alt="" />
                                                    </td>
                                                    <td class="lastName"><?= $product['product_name'] ?></td>
                                                    <td class="email"><?= $product['description'] ?></td>
                                                    <td class="suppliers">
                                                        <?php
                                                        $supplier_list = '-';
                                                        $pid = $product['id'];
                                                        $stmt = $conn->prepare("
                                                            SELECT supplier_name
                                                            FROM suppliers, productsuppliers
                                                            WHERE 
                                                                productsuppliers.product=:pid
                                                                AND
                                                                productsuppliers.supplier = suppliers.id   
                                                        ");
                                                        $stmt->bindParam(':pid', $pid);
                                                        $stmt->execute();
                                                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        if ($rows) {
                                                            $supplier_arr = array_column($rows, 'supplier_name');
                                                            $supplier_list = '<li>' . implode("</li><li>", $supplier_arr);
                                                        }

                                                        echo $supplier_list;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $uid = $product['created_by'];
                                                        $stmt = $conn->prepare("SELECT * FROM users WHERE id=:uid");
                                                        $stmt->bindParam(':uid', $uid);
                                                        $stmt->execute();
                                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                        if ($row) {
                                                            $created_by_name = $row['first_name'] . ' ' . $row['last_name'];
                                                            echo $created_by_name;
                                                        } else {
                                                            echo "No user found with the specified ID.";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="quantity"><?= $product['Quantity'] ?></td>
                                                    <td><?= date('M d, Y @ h:i:s A', strtotime($product['created_at'])) ?></td>
                                                    <td><?= date('M d, Y @ h:i:s A', strtotime($product['updated_at'])) ?></td>
                                                    <td>
                                                        <a href="#" class="updateProduct" data-pid="<?= $product['id'] ?>"><i class="fa fa-pencil"></i>Edit</a>
                                                        <a href="#" class="deleteProduct" data-name="<?= $product['product_name'] ?>" data-pid="<?= $product['id'] ?>"><i class="fa fa-trash"></i>Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <p class="userCount"><?= count($products) ?> Products </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('partials/app-scripts.php');

    $show_table = 'suppliers';
    $suppliers = include('database/show.php');

    $suppliers_arr = [];

    foreach ($suppliers as $supplier) {
        $suppliers_arr[$supplier['id']] = $supplier['supplier_name'];
    }

    $suppliers_arr = json_encode($suppliers_arr);
    ?>

    <script>
        var suppliersList = <?= $suppliers_arr ?>;

        function script() {

            this.initialize = function() {
                this.registerEvents();
            };
            
            var vm = this;

            this.registerEvents = function() {
                document.addEventListener('click', function(e) {
                    targetElement = e.target; //Target element
                    classList = targetElement.classList;

                    if (classList.contains('deleteProduct')) {
                        e.preventDefault(); //This prevents the default mechanism.

                        pId = targetElement.dataset.pid;
                        pName = targetElement.dataset.name;

                        BootstrapDialog.confirm({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Delete Product',
                            message: 'Are you sure to delete <strong>' + pName + '</strong>?',
                            callback: function(isDelete) {
                                if (isDelete) {
                                    $.ajax({
                                        method: 'POST',
                                        data: {
                                            id: pId,
                                            table: 'products'
                                        },
                                        url: 'database/delete.php',
                                        dataType: 'json',
                                        success: function(data) {
                                            message = data.success ?
                                                pName + ' successfully deleted!' : 'Error processing your request!';

                                            BootstrapDialog.alert({
                                                type: data.success ? BootstrapDialog.Type_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                                message: message,
                                                callback: function() {
                                                    if (data.success) location.reload();
                                                }
                                            });
                                        }
                                    });
                                }
                            }
                        });
                    }

                    /*
                    if (classList.contains('updateProduct')) {
                        e.preventDefault(); //This prevents the default mechanism.

                        pId = targetElement.dataset.pid;
                        vm.showEditDialog(pId);
                    }
                });

                document.addEventListener('submit', function(e) {
                    e.preventDefault();
                    targetElement = e.target;

                    if (targetElement.id === 'editProductForm') {
                        vm.saveUpdateData(targetElement);
                    }
                });
            };

            this.saveUpdateData = function(form) {
                $.ajax({
                    method: 'POST',
                    data: new FormData(form),
                    url: 'database/update-product.php',
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(data) {
              BootstrapDialog.alert({
                type: data.success ?BootstrapDialog.Type_SUCCESS :BootstrapDialog.TYPE_DANGER,
                message:data.message,
                callback:function(){
                    if(data.success)location.reload();
                }
              });
               }
            });
        },

            this.showEditDialog = function(id) {
                $.get('database/get-product.php', {
                    id: id
                }, function(productDetails) {
                    let curSuppliers = productDetails['suplliers'];
                    let supplierOption = '';

                    for (const [supId, supName] of Object.entries(suppliersList)) {
                        selected = curSuppliers.indexOf(supId) > -1 ? 'selected' : '';
                        supplierOption += "<option " + selected + " value='" + supId + "'> " + supName + "</option>";
                    }

                    BootstrapDialog.confirm({
                        title: 'Update ' + '<strong>' + productDetails.product_name + '</strong>',
                        message: '<form action="database/add.php" method="POST" enctype="multipart/form-data" id="editProductForm">\
                                    <div class="appFormInputContainer">\
                                        <label for="product_name">Product Name</label>\
                                        <input type="text" class="appFormInput" id="product_name" value="' + productDetails.product_name + '" placeholder="Enter product name..." name="product_name" />\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="description">Suppliers</label>\
                                        <select name="suppliers[]" id="suppliersSelect" multiple="">\
                                            <option value="">Select Supplier</option>\
                                            ' + supplierOption + '\
                                        </select>\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="description">Description</label>\
                                        <textarea class="appFormInput productTextAreaInput"  placeholder="Enter product description..." id="description" name="description"> ' + productDetails.description + '</textarea>\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="product_name">Product Image</label>\
                                        <input type="file" name="img" />\
                                    </div>\
                                    <input type="hidden" name="pid" value="' + productDetails.id + '" />\
                                    <input type="submit" value="submit" id="editProductSubmitBtn" class="hidden"/>\
                                  </form>',
                        callback: function(isUpdate) {
                            if (isUpdate) {
                                $('#editProductForm').submit();
                                return;
                            }
                        }
                    });
                }, 'json');
            };

           

            
        }
        */


        if(classList.contains('updateProduct')){
				  e.preventDefault(); //prevent loading
				  
				  //Get data
				  prodName = targetElement.closest('tr').querySelector('td.lastName').innerHTML;
				  prodDesc = targetElement.closest('tr').querySelector('td.email').innerHTML;
				  quantity = targetElement.closest('tr').querySelector('td.quantity').innerHTML;
				  pId = targetElement.dataset.pid;
				  
				  BootstrapDialog.confirm({
					 title: 'Update ' + prodName + ' ' + prodDesc,
					 message: '<form>\
					     <div class="form-group">\
					     <label for="prodName">Product Name:</label>\
						 <input type="text" class="form-control" id="prodName" value="'+ prodName +'">\
						 </div>\
						 <div class="form-group">\
					     <label for="prodDesc">Description:</label>\
						 <input type="text" class="form-control" id="prodDesc" value="'+ prodDesc +'">\
						 </div>\
					     <div class="form-group">\
					     <label for="email">Quantity:</label>\
						 <input type="email" class="form-control" id="quantity" value="'+ quantity +'">\
						 </div>\
						 </form>',
					  callback: function(isUpdate){
						  if(isUpdate){//if user click 'Ok' button.
						    $.ajax({
						 method: 'POST',
						 data: {
                             pid: pId,
							 p_name: document.getElementById('prodName').value,
							 desc: document.getElementById('prodDesc').value,
							 quantity: document.getElementById('quantity').value,
						 },
						 
						 url: 'database/update-product.php',
						 dataType: 'json',
						 success: function(data){
							 if(data.success){
								 BootstrapDialog.alert({
									type: BootstrapDialog.Type_SUCCESS,
									message: data.message,
									callback: function(){
										location.reload();
									}
								 });
							 }else BootstrapDialog.alert({
									type: BootstrapDialog.Type_SUCCESS,
									message: data.message,
								 });
						 }
					   });	  
					  }
					 }
				  });
			  }




		  });
	  }
  }

        var script = new script();
        script.initialize();
    </script>
</body>

</html>