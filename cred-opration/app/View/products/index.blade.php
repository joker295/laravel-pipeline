<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 12 CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="bg-dark text-center text-white py-3">
      <h1 class="h3">Laravel 12 CRUD</h1>
    </div>

    <div class="container">
        <div class="d-flex justify-content-end p-0 mt-3">
            <a href="{{ route('products.create') }}" class="btn btn-dark">Create</a>
        </div>
        
        {{-- Success Message --}}
        @if (Session::has('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        {{-- Error Message --}}
        @if (Session::has('error'))
          <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
         
        <div class="row">
          <div class="card p-0 mt-3">
            <div class="card-header bg-dark text-white">
              <h1 class="h4">Products</h1>
            </div>
            <div class="card-body shadow-lg">
              <table class="table table-striped"> 
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Category</th> <!-- Added Category Column -->
                    <th width="150" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($products->isNotEmpty())
                    @foreach($products as $product)
                      <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                          @if (!empty($product->image))
                            <img class="rounded" src="{{ asset('uploads/products/' . $product->image) }}" 
                            alt="{{ $product->name }}" width="50">
                          @else
                            <img src="https://placehold.co/600x700" alt="{{ $product->name }}" width="50">
                          @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                          @if ($product->status == 'Active')
                            <span class="badge bg-success">Active</span>
                          @elseif ($product->status == 'Inactive')
                            <span class="badge bg-danger">Inactive</span>
                          @endif
                        </td>
                        <td>{{ $product->category->name ?? '-' }}</td> <!-- Show category -->
                        <td class="text-center">
                          <a href="{{ route('products.edit', $product->id) }}" class="btn btn-dark btn-sm">Edit</a>
                          <form action="{{ route('products.destroy', $product->id) }}" 
                                method="POST" class="d-inline-block" 
                                onsubmit="return confirm('Are you sure to delete this product?')">
                             @csrf
                             @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  @else 
                    <tr>
                      <td colspan="8" class="text-center">No products found</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
