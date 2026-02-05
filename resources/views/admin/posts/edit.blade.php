@extends('layouts.admin')

@section('title', 'Edit Post')
@section('page-title', 'Edit Post')
@section('page-description', 'Update blog article')

@section('content')
    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.posts._form', ['post' => $post])
    </form>
@endsection
