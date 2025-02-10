
@extends('back-end.master')

@section('admin-title')
Product
@endsection

@push('admin-styles')
<style>
	.card{
        border-radius: 0;
    }
    h4.card-title{
    font-size: 18px!important;
}
  .table thead tr th{
    background: #f5f5f5;
   }

   .table thead tr th, .table thead tr td{
      font-size: 14px;
   }

    .supplier-information {
        border: 1px solid rgba(0,0,0,.1);
        margin-bottom: 20px;
        padding: 5px 10px;
    }
    label {
    display: inline-block;
    margin-bottom: .5rem;
    font-size: 14px;
}

/* for select 2 */
<style>
/* Fix bottom border continuity */
.select2-container--default .select2-selection--multiple {
    border: 1px solid #ced4da !important;
    border-radius: 4px;
    min-height: 38px;
    width: 100%;
}

/* Ensure the container takes full width */
.select2-container {
    display: block;
    width: 100% !important;
}

/* Match the input style with form-control */
.select2-container .select2-selection {
    background-color: #fff;
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem;
    min-height: 38px;
}

/* Fix for the focus state */
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: 1px solid #80bdff !important;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

/* start style for multiimage form */
.remove-btn {
    position: absolute !important;
    top: -8px;
    right: -2px;
    width: 20px;
    height: 20px;
    padding: 0;
    line-height: 18px;
    font-size: 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border: none;
}

.position-relative {
    margin: 2px;
    display: inline-block;
}

#gallery-preview {
    display: flex;
    flex-wrap: wrap;
    gap: 2px;
}

#gallery-preview img {
    border: 1px solid #dee2e6;
}
</style>

@endpush

@section('admin-content')

  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Product</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

 <div class="row">
 	<div class="col-md-12">
 		<div class="card">
         <div class="card-header">
             <h4 class="card-title">Add New Product</h4>
         </div>

          <form class="form-horizontal" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
         @csrf
         
            <div class="card mb-3">
              <div class="card-header">
                  <h5 class="card-title mb-0">Basic Product Information</h5>
              </div>
              <div class="card-body">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Product Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="product_name" class="form-control" placeholder="Enter product name" />
                                        @error('product_name')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Category</label>
                                    <div class="col-sm-8">
                                        <select name="category_id" id="category" class="form-select form-control">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Subcategory</label>
                                    <div class="col-sm-8">
                                        <select name="subcategory_id" id="subcategory" class="form-select form-control">
                                            <option value="">Select Subcategory</option>
                                        </select>
                                    </div>
                                </div>
                
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-8">
                                        <textarea name="description" class="form-control" rows="3" placeholder="Enter product description"></textarea>
                                    </div>
                                </div>
                                {{-- <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Price</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="tags" class="form-control" id="price" placeholder="Price..." />
                                        @error('tags')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Tags(Optional)</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="tags" class="form-control" placeholder="Tags..." />
                                        @error('tags')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Additional Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Brand</label>
                                    <div class="col-sm-8">
                                        <select name="brand_id" class="form-select form-control">
                                            <option value="">Select Brand</option>
                                            @foreach($brand as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Unit</label>
                                    <div class="col-sm-8">
                                        <select name="unit_id" class="form-select form-control">
                                            <option value="">Select Unit</option>
                                            @foreach($unit as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Product Image</label>
                                    <div class="col-sm-8">
                                        <input type="file" name="product_image" class="form-control" accept="image/*" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Price</label>
                                    <div class="col-sm-8">
                                        <input type="number" name="price" id="price" class="form-control" placeholder="Price..." />
                                        @error('price')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Discount Type</label>
                                    <div class="col-sm-8">
                                        <select name="discount_type" id="discountType" class="form-control" onchange="toggleDiscountAmount()">
                                            <option value="">Select Discount Type</option>
                                            <option value="flat">Flat Amount</option>
                                            <option value="percentage">Percentage</option>
                                        </select>
                                        @error('discount_type')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Discount </label>
                                    <div class="col-sm-8">
                                        <input type="number" name="discount" id="discountAmount" class="form-control" placeholder="Enter discount..." oninput="calculateDiscount()">
                                        <small id="discountMessage" class="form-text text-muted"></small>
                                        @error('discount_amount')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                               
                                
                                <script>
                                    function toggleDiscountAmount() {
                                        const discountType = document.getElementById('discountType').value;
                                        const discountAmountInput = document.getElementById('discountAmount');
                                        const discountMessage = document.getElementById('discountMessage');
                                        const priceInput = document.getElementById('price').value;
                                
                                        if (discountType === 'flat') {
                                            discountAmountInput.placeholder = "Enter flat discount amount...";
                                            discountMessage.textContent = "";
                                        } else if (discountType === 'percentage') {
                                            discountAmountInput.placeholder = "Enter percentage (0-100)...";
                                            const discountAmount = discountAmountInput.value;
                                            if (discountAmount && priceInput) {
                                                const discountedPrice = (priceInput - (priceInput * discountAmount) / 100).toFixed(2);
                                                discountMessage.textContent = `Calculated price after discount: ${discountedPrice}`;
                                            } else {
                                                discountMessage.textContent = "";
                                            }
                                        } else {
                                            discountAmountInput.placeholder = "Enter discount amount...";
                                            discountMessage.textContent = "";
                                        }
                                    }
                                
                                    function calculateDiscount() {
                                        const discountType = document.getElementById('discountType').value;
                                        const discountAmount = document.getElementById('discountAmount').value;
                                        const priceInput = document.getElementById('price').value;
                                        const discountMessage = document.getElementById('discountMessage');
                                
                                        if (discountType === 'percentage' && discountAmount && priceInput) {
                                            if (discountAmount >= 0 && discountAmount <= 100) {
                                                const discountedPrice = (priceInput - (priceInput * discountAmount) / 100).toFixed(2);
                                                discountMessage.textContent = `Calculated price after discount: ${discountedPrice}`;
                                            } else {
                                                discountMessage.textContent = "Please enter a percentage between 0 and 100.";
                                            }
                                        } else if (discountType === 'flat' && discountAmount && priceInput) {
                                            const discountedPrice = (priceInput - discountAmount).toFixed(2);
                                            discountMessage.textContent = `Calculated price after discount: ${discountedPrice}`;
                                        } else {
                                            discountMessage.textContent = "";
                                        }
                                    }
                                </script>
                                
                               
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
  
         <!-- Product Variants Section -->
<!-- Product Variants Section -->
<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Product Variants</h5>
        <button type="button" class="btn btn-primary btn-sm" id="add-variant">
            Add Variant <i class="fas fa-plus"></i>
        </button>
    </div>
    <div class="card-body">
        <div id="variants-container">
            <div class="variant-row mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <select name="colors[]" class="form-select form-control">
                            <option value="">Select Color</option>
                            @foreach($color as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sizes[]" class="form-select form-control">
                            <option value="">Select Size</option>
                            @foreach($size as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="stock_quantity[]" class="form-control" placeholder="Stock">
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="variant_price[]" class="form-control" step="0.01" placeholder="Price">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-variant">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  <!-- Gallery Images Section -->
<div class="card mb-3">
  <div class="card-header">
      <h5 class="card-title mb-0">Gallery Images</h5>
  </div>
  <div class="card-body">
      <div class="form-group row">
          <label class="col-sm-2 text-end control-label col-form-label">Gallery Images</label>
          <div class="col-sm-10">
              <input type="file" name="gallery[]" id="gallery-input" class="form-control" multiple accept="image/*" />
              <div id="gallery-preview" class="row mt-3"></div>
          </div>
      </div>
  </div>
</div>
  
          <!-- Submit Button -->
          <div class="text-center mb-4">
              <button type="submit" class="btn btn-primary">Save Product</button>
          </div>
        </form>

      </div>
 	</div>
 </div>

 

<script>

document.addEventListener('DOMContentLoaded', function() {
    const variantsContainer = document.getElementById('variants-container');
    const addVariantButton = document.getElementById('add-variant');
// <div class="col-md-3">
                //     <select name="sizes[]" class="form-select form-control">
                //         <option value="">Select Size</option>
                //         @foreach($size as $item)
                //             <option value="{{ $item->id }}">{{ $item->name }}</option>
                //         @endforeach
                //     </select>
                // </div>
    // Function to create new variant row
    function createVariantRow() {
        const newRow = document.createElement('div');
        newRow.className = 'variant-row mb-3';
        newRow.innerHTML = `
            <div class="row">
                <div class="col-md-3">
                    <select name="colors[]" class="form-select form-control">
                        <option value="">Select Color</option>
                        @foreach($color as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
               <div class="col-md-3">
                  <select name="sizes[]" class="form-select form-control">
                         <option value="">Select Size</option>
                         @foreach($size as $item)
                             <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                     </select>
                 </div>
                <div class="col-md-2">
                    <input type="number" name="stock_quantity[]" class="form-control" placeholder="Stock">
                </div>
                <div class="col-md-3">
                    <input type="number" name="variant_price[]" class="form-control" step="0.01" placeholder="Price">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-variant">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        return newRow;
    }

    // Add new variant row
    addVariantButton.addEventListener('click', function() {
        const newRow = createVariantRow();
        variantsContainer.appendChild(newRow);
    });

    // Remove variant row
    variantsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-variant') || 
            e.target.closest('.remove-variant')) {
            const row = e.target.closest('.variant-row');
            if (variantsContainer.children.length > 1) {
                row.remove();
            } else {
                alert('At least one variant is required');
            }
        }
    });
});































// start js for selecting subcategory for the category



   document.addEventListener('DOMContentLoaded', function () {
    const categoryDropdown = document.getElementById('category');
    const subcategoryDropdown = document.getElementById('subcategory');
    

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    categoryDropdown.addEventListener('change', function () {
        const categoryId = this.value;
        
        subcategoryDropdown.innerHTML = '<option  name="subcategory_id" id="subcategory" value="">Select Subcategory</option>';

        if (categoryId) {
            fetch(`/product/get-subcategories/${categoryId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (Array.isArray(data)) {
                    data.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = subcategory.name;
                        subcategoryDropdown.appendChild(option);
                    });
                } else {
                    throw new Error('Data is not in expected format');
                }
            })
            .catch(error => {
                console.error('Error details:', error);
                alert('Unable to fetch subcategories. Please try again later.');
            });
        }
    });
});


// end js code for populate subcategory


















// start js code for preview multiimage
document.addEventListener('DOMContentLoaded', function() {
    const galleryInput = document.getElementById('gallery-input');
    const galleryPreview = document.getElementById('gallery-preview');
    let existingFiles = [];

    galleryInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        existingFiles = [...existingFiles, ...files];
        galleryPreview.innerHTML = '';
        
        existingFiles.forEach((file, index) => {
            const col = document.createElement('div');
            col.className = 'col-auto mb-3';
            
            const imageContainer = document.createElement('div');
            imageContainer.className = 'position-relative';
            imageContainer.style.width = '80px';
            imageContainer.style.height = '80px';
            
            const img = document.createElement('img');
            img.className = 'rounded';
            img.style.width = '80px';
            img.style.height = '80px';
            img.style.objectFit = 'cover';
            
            // Create remove button with cross icon
            const removeBtn = document.createElement('button');
            removeBtn.className = 'btn btn-danger btn-sm position-absolute remove-btn';
            removeBtn.innerHTML = '×'; // Cross symbol
            removeBtn.type = 'button';
            
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
            
            removeBtn.addEventListener('click', function() {
                col.remove();
                existingFiles = existingFiles.filter((_, i) => i !== index);
                
                const dt = new DataTransfer();
                existingFiles.forEach(file => dt.items.add(file));
                galleryInput.files = dt.files;
            });
            
            imageContainer.appendChild(img);
            imageContainer.appendChild(removeBtn);
            col.appendChild(imageContainer);
            galleryPreview.appendChild(col);
        });
    });

    galleryInput.closest('form').addEventListener('reset', function() {
        existingFiles = [];
        galleryPreview.innerHTML = '';
    });
});


// start js code for preview single product image

document.addEventListener('DOMContentLoaded', function() {
    const productImageInput = document.querySelector('input[name="product_image"]');
    
    // Create preview container
    const previewContainer = document.createElement('div');
    previewContainer.className = 'mt-2';
    previewContainer.id = 'product-image-preview';
    productImageInput.parentElement.appendChild(previewContainer);

    productImageInput.addEventListener('change', function(e) {
        const file = this.files[0]; // Only get the first file
        previewContainer.innerHTML = ''; // Clear existing preview

        if (file) {
            // Create preview elements
            const imageContainer = document.createElement('div');
            imageContainer.className = 'position-relative d-inline-block';

            const img = document.createElement('img');
            img.className = 'rounded';
            img.style.width = '100px';  // Smaller size for single product image
            img.style.height = '100px';
            img.style.objectFit = 'cover';
            img.style.border = '1px solid #dee2e6';

            const removeBtn = document.createElement('button');
            removeBtn.className = 'btn btn-danger btn-sm position-absolute';
            removeBtn.innerHTML = '×';
            removeBtn.type = 'button';
            removeBtn.style.top = '-8px';
            removeBtn.style.right = '-8px';
            removeBtn.style.width = '20px';
            removeBtn.style.height = '20px';
            removeBtn.style.padding = '0';
            removeBtn.style.borderRadius = '50%';
            removeBtn.style.lineHeight = '18px';
            removeBtn.style.fontSize = '16px';

            // Preview the image
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);

            // Remove image handler
            removeBtn.addEventListener('click', function() {
                previewContainer.innerHTML = '';
                productImageInput.value = ''; // Clear the file input
            });

            // Assemble and show preview
            imageContainer.appendChild(img);
            imageContainer.appendChild(removeBtn);
            previewContainer.appendChild(imageContainer);
        }
    });
});
</script>
  
  


@endsection