<!-- Generic Profile Edit Form Component -->
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-2xl font-semibold mb-6">Edit Profile</h2>
    
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ $updateRoute }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Personal Information Section -->
        <div class="border-b pb-6">
            <h3 class="text-lg font-medium mb-4 text-primary-800">Personal Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ $user->name }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ $user->email }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ $user->phone ?? '' }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Patient-specific fields -->
                @if($user->role === 'patient')
                    <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select id="gender" name="gender" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Select gender</option>
                        <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ $user->date_of_birth ?? '' }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('date_of_birth')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <input type="text" id="address" name="address" value="{{ $user->address ?? '' }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Emergency Contact -->
                    <div>
                        <label for="emergency_contact" class="block text-sm font-medium text-gray-700 mb-1">Emergency Contact</label>
                        <input type="text" id="emergency_contact" name="emergency_contact" value="{{ $user->emergency_contact ?? '' }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        @error('emergency_contact')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Emergency Phone -->
                    <div>
                        <label for="emergency_phone" class="block text-sm font-medium text-gray-700 mb-1">Emergency Phone</label>
                        <input type="tel" id="emergency_phone" name="emergency_phone" value="{{ $user->emergency_phone ?? '' }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        @error('emergency_phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                @endif
            </div>
        </div>
        
        <!-- Doctor-specific section -->
        @if($user->role === 'doctor')
        <div class="border-b pb-6">
            <h3 class="text-lg font-medium mb-4 text-primary-800">Professional Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Specialization -->
                <div>
                    <label for="specialization" class="block text-sm font-medium text-gray-700 mb-1">Specialization</label>
                    <input type="text" id="specialization" name="specialization" value="{{ $user->specialization ?? '' }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('specialization')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Experience Years -->
                <div>
                    <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-1">Years of Experience</label>
                    <input type="number" id="experience_years" name="experience_years" value="{{ $user->experience_years ?? '' }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('experience_years')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Qualifications -->
                <div>
                    <label for="qualifications" class="block text-sm font-medium text-gray-700 mb-1">Qualifications</label>
                    <input type="text" id="qualifications" name="qualifications" value="{{ $user->qualifications ?? '' }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('qualifications')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- License Number -->
                <div>
                    <label for="license_number" class="block text-sm font-medium text-gray-700 mb-1">License Number</label>
                    <input type="text" id="license_number" name="license_number" value="{{ $user->license_number ?? '' }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('license_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        @endif
        
        <!-- Assistant-specific section -->
        @if($user->role === 'assistant')
        <div class="border-b pb-6">
            <h3 class="text-lg font-medium mb-4 text-primary-800">Professional Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Position -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                    <input type="text" id="position" name="position" value="{{ $user->position ?? '' }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('position')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Certification -->
                <div>
                    <label for="certification" class="block text-sm font-medium text-gray-700 mb-1">Certification</label>
                    <input type="text" id="certification" name="certification" value="{{ $user->certification ?? '' }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('certification')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Experience Years -->
                <div>
                    <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-1">Years of Experience</label>
                    <input type="number" id="experience_years" name="experience_years" value="{{ $user->experience_years ?? '' }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('experience_years')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        @endif
        
        <!-- Admin-specific section -->
        @if($user->role === 'admin')
        <div class="border-b pb-6">
            <h3 class="text-lg font-medium mb-4 text-primary-800">Administrative Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Admin Level -->
                <div>
                    <label for="admin_level" class="block text-sm font-medium text-gray-700 mb-1">Admin Level</label>
                    <select id="admin_level" name="admin_level" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Select level</option>
                        <option value="junior" {{ $user->admin_level === 'junior' ? 'selected' : '' }}>Junior Admin</option>
                        <option value="senior" {{ $user->admin_level === 'senior' ? 'selected' : '' }}>Senior Admin</option>
                        <option value="super" {{ $user->admin_level === 'super' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('admin_level')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Department -->
                <div>
                    <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <input type="text" id="department" name="department" value="{{ $user->department ?? '' }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('department')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        @endif
        
        <!-- Password Section -->
        <div class="border-b pb-6">
            <h3 class="text-lg font-medium mb-4 text-primary-800">Change Password</h3>
            <p class="text-sm text-gray-500 mb-4">Leave password fields empty if you don't want to change it.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                    <input type="password" id="current_password" name="current_password" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('current_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" id="password" name="password" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="flex justify-end space-x-4 mt-6">
            <a href="{{ $cancelRoute }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Cancel
            </a>
            
            <button type="submit" class="px-4 py-2 bg-primary-600 border border-transparent rounded-md font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Save Changes
            </button>
        </div>
    </form>
</div> 