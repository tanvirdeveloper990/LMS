@extends('user.layouts.app')
@section('title', 'Profile Setting')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="w-full mx-auto bg-white rounded-2xl shadow-lg overflow-hidden px-3">


        <!-- Header -->
        <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 px-6 py-4">
            <h2 class="text-xl font-semibold text-white">Profile Settings</h2>
        </div>

        <!-- Form -->
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Error Messages --}}
            @if ($errors->any())
            <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ $user->name }}" required
                    class="form-input @error('name') border-red-500 @enderror">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Username -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" value="{{ $user->username }}"
                    class="form-input @error('username') border-red-500 @enderror">
                @error('username') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required
                    class="form-input @error('email') border-red-500 @enderror">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="phone" value="{{ $user->phone }}"
                    class="form-input @error('phone') border-red-500 @enderror">
                @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                <select name="gender" class="form-input">
                    <option value="">Select</option>
                    <option value="Male" {{ $user->gender=='Male'?'selected':'' }}>Male</option>
                    <option value="Female" {{ $user->gender=='Female'?'selected':'' }}>Female</option>
                    <option value="Other" {{ $user->gender=='Other'?'selected':'' }}>Other</option>
                </select>
            </div>

            <!-- DOB -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                <input type="date" name="dob" value="{{ $user->dob }}" class="form-input">
            </div>

            <!-- Country -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                <input type="text" name="country" value="{{ $user->country }}" class="form-input">
            </div>

            <!-- State -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                <input type="text" name="state" value="{{ $user->state }}" class="form-input">
            </div>

            <!-- City -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                <input type="text" name="city" value="{{ $user->city }}" class="form-input">
            </div>

            <!-- Zip Code -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Zip Code</label>
                <input type="text" name="zip_code" value="{{ $user->zip_code }}" class="form-input">
            </div>

            <!-- Address -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                <input type="text" name="address" value="{{ $user->address }}" class="form-input">
            </div>

            <!-- Bio -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">About You / Bio</label>
                <textarea name="bio" rows="4" class="form-input">{{ $user->bio }}</textarea>
            </div>

            <!-- Profile Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Image</label>
                <input type="file" name="image" id="image" accept="image/*" class="form-input">

                <div class="mt-4">
                    @if($user->image)
                    <img id="preview-image" src="{{ Storage::url($user->image) }}" class="w-28 h-28 rounded-lg object-cover border">
                    @else
                    <img id="preview-image" class="hidden w-28 h-28 rounded-lg object-cover border">
                    @endif
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t">
                <button class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    <i class="fa fa-edit mr-1"></i> Update
                </button>
            </div>

        </form>
    </div>
</div>

{{-- FORM INPUT STYLE --}}
<style>
    .form-input {
        width: 100%;
        border: 1px solid #d1d5db; /* gray-300 */
        padding: 8px 12px;
        border-radius: 8px;
        transition: 0.2s;
    }
    .form-input:focus {
        border-color: #06b6d4; /* cyan-500 */
        outline: none;
        box-shadow: 0 0 0 1px #06b6d4;
    }
</style>


@section('script')
<script>
document.getElementById('image').addEventListener('change', function(event) {
    const preview = document.getElementById('preview-image');
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection

@endsection
