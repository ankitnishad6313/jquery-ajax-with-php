<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Task</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <style>
        input,
        select {
            border: 1px solid rgb(85, 85, 254) !important;
        }
    </style>
</head>

<body>
    <div class="row">
        <h2 class="text-center">Product Form</h2>
    </div>
    <div class="container" id="field-container">
        <div class="row g-4 my-2 fields-row">
            <div class="col-12 col-md-6 col-lg-3">
                <select name="category[]" id="" class="form-select category">
                    <option value="">Select Category</option>
                    <option value="Pen">Pen</option>
                    <option value="Ball">Ball</option>
                    <option value="Pencil">Pencil</option>
                    <option value="Book">Book</option>
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <select name="subcategory[]" id="" class="form-select subcategory">
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <input type="text" name="product_name[]" id="" class="form-control" placeholder="Product Name" />
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <input type="number" name="price[]" class="form-control price" placeholder="Price" />
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <input type="number" name="discount[]" id="" class="form-control discount" placeholder="Discount" />
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <input type="number" name="final_amount[]" id="" class="form-control final_amount"
                    placeholder="Final Amount" />
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <button class="btn btn-outline-primary w-100" id="add-new">
                    Add New
                </button>
            </div>
        </div>
    </div>
    <script src="./js/bootstrap.bundle.js"></script>
    <script src="./js/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function () {
            // Adding new fields row
            $("#add-new").click(function () {
                var allFilled = true;
                $(".fields-row").last().find('select, input').each(function () {
                    if ($(this).val() === '') {
                        allFilled = false;
                        return false; // break out of each loop
                    }
                });

                if (allFilled) {
                    var newFields = $(".fields-row").first().clone();
                    newFields.find('select, input').val('');
                    newFields.find("#add-new").parent().remove();
                    newFields.append(`<div class="col-12 col-md-6 col-lg-3">
                                        <button class="btn btn-outline-danger w-100 remove-btn">Remove</button>
                                    </div>`);
                    $("#field-container").append(newFields);
                } else {
                    alert("Please fill all fields before adding a new row.");
                }
            });


            $(document).on('click', '.remove-btn', function () {
                $(this).closest('.fields-row').remove();
            });

            $(document).on('keyup', '.discount', function () {
                var discount = parseFloat($(this).val());
                var price = parseFloat($(this).closest('.fields-row').find('.price').val());
                var final_amount = (price - (price * discount) / 100);
                $(this).closest('.fields-row').find('.final_amount').val(final_amount);
            });

            $(document).on('change', '.category', function () {
                var category = $(this).val();
                var subcategorySelect = $(this).closest('.fields-row').find('.subcategory')

                $.ajax({
                    url: "code/sub-category.php",
                    type: "POST",
                    data: { category: category },
                    dataType: 'json',
                    success: function (response) {
                        subcategorySelect.empty();
                        subcategorySelect.append('<option value="">Select Sub Category</option>')
                        response.forEach(function (subcategory) {
                            subcategorySelect.append(`<option value="${subcategory}">${subcategory}</option>`)
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error: ', status, error);
                    },
                    complete: function (xhr, status) {
                        console.log('AJAX Request completed with status:', status);
                    },
                    beforeSend: function (xhr) {
                        console.log('AJAX Request about to be sent');
                    }
                });
            });
        });
    </script>
</body>

</html>