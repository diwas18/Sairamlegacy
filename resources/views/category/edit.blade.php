@extends('layouts.app')
@section('content')
<h1 class="text-4xl font-extrabold text-blue-900" >Edit Ctegory</h1>
<hr class="h-1 bg-red-500" >
<form action="{{ route('category.update',$category->id)}}" method="POST" class="mt-5">
    @csrf
    <input type="text" placeholder="Enter Priority" name="priority" class="w-full rounded-lg my-2" value= "{{$category->priority}}">
    @error('priority')
    <p class="text-red-500 -mt-2">{{$message}}</p>
    @enderror

    <input type="text" placeholder="Enter Category Name" name="name" class="w-full rounded-lg my-2"value= "{{$category->name}}">
    @error('name')
    <p class="text-red-500 -mt-2">{{$message}}</p>
    @enderror

    <div class="flex mt-4 justify-center gap-4">
        <input type="submit" value="Update Category" class="bg-blue-600 text-white px-5 py-3 rounded-lg
        cursor-pointer">
        <a href="{{ route('product.index') }}" class="bg-red-600 text-white px-10 py-3 rounded-lg">
            Exit </a>
    </div>

</form>
@endsection
