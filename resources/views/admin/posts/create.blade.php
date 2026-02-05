@extends('layouts.admin')

@section('title', 'Create Post')
@section('page-title', 'Create New Post')
@section('page-description', 'Write a new blog article')

@section('content')
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.posts._form')
    </form>
@endsection
