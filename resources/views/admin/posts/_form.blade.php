@php $post = $post ?? null; @endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white p-6">
            <!-- Validation Errors Alert -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 text-sm">
                    <p class="font-medium mb-2">Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-neutral-700 mb-2">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $post?->title) }}"
                       class="w-full px-4 py-3 border border-[#e5dfd2] bg-white text-sm focus:outline-none focus:border-[#004d2c] @error('title') border-red-500 @enderror"
                       placeholder="Enter post title" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="excerpt" class="block text-sm font-medium text-neutral-700 mb-2">Short Description</label>
                <textarea name="excerpt" id="excerpt" rows="2"
                          class="w-full px-4 py-3 border border-[#e5dfd2] bg-white text-sm focus:outline-none focus:border-[#004d2c]"
                          placeholder="A brief summary that appears on the blog listing page...">{{ old('excerpt', $post?->excerpt) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">Content *</label>
                <!-- Quill Editor -->
                <div id="editor" class="bg-white" style="height: 350px;">{!! old('content', $post?->content) !!}</div>
                <input type="hidden" name="content" id="content">
                @error('content')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Publish Box -->
        <div class="bg-white p-6">
            <h3 class="text-sm font-semibold text-neutral-900 mb-4">Publish</h3>
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-neutral-700 mb-2">Status *</label>
                <select name="status" id="status" class="w-full px-4 py-3 border border-[#e5dfd2] bg-white text-sm focus:outline-none focus:border-[#004d2c]">
                    <option value="draft" {{ old('status', $post?->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft (not visible)</option>
                    <option value="published" {{ old('status', $post?->status) === 'published' ? 'selected' : '' }}>Published (visible to everyone)</option>
                </select>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.posts.index') }}" class="flex-1 px-4 py-3 border border-[#e5dfd2] text-neutral-600 text-sm text-center hover:bg-[#f0ece3] transition-colors">
                    Cancel
                </a>
                <button type="submit" class="flex-1 px-4 py-3 bg-[#004d2c] text-white text-sm hover:bg-[#003d23] transition-colors">
                    {{ $post ? 'Update' : 'Create' }} Post
                </button>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="bg-white p-6">
            <h3 class="text-sm font-semibold text-neutral-900 mb-4">Featured Image</h3>
            @if($post?->featured_image_url)
                <div class="mb-4">
                    <img src="{{ $post->featured_image_url }}" alt="Current image" class="w-full h-40 object-cover">
                    <p class="mt-2 text-xs text-neutral-500">Current image</p>
                </div>
            @endif
            <input type="file" name="featured_image" id="featured_image" accept="image/jpeg,image/png,image/jpg,image/webp"
                   class="w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:bg-[#f0ece3] file:text-neutral-700 hover:file:bg-[#e5dfd2] @error('featured_image') border border-red-500 @enderror">
            @error('featured_image')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
            <p class="mt-2 text-xs text-neutral-400">Accepted: JPG, PNG, WebP. Max size: 5MB</p>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    .ql-toolbar.ql-snow { border: 1px solid #e5dfd2; border-bottom: none; background: #f8f6f1; }
    .ql-container.ql-snow { border: 1px solid #e5dfd2; font-size: 14px; }
    .ql-editor { min-height: 300px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'header': [2, 3, false] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                ['clean']
            ]
        },
        placeholder: 'Write your post content here...'
    });

    // Sync content to hidden input on every change
    quill.on('text-change', function() {
        var html = quill.root.innerHTML;
        // If empty (just <p><br></p>), set to empty string
        if (html === '<p><br></p>') {
            html = '';
        }
        document.getElementById('content').value = html;
    });

    // Also sync before form submit (backup)
    var form = document.querySelector('form');
    if (form) {
        form.onsubmit = function() {
            var html = quill.root.innerHTML;
            if (html === '<p><br></p>') {
                html = '';
            }
            document.getElementById('content').value = html;
            return true;
        };
    }

    // Initialize with existing content
    document.getElementById('content').value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
</script>
@endpush
