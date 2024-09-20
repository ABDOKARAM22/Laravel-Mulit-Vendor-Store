@extends('Dashboard.Layouts.main')

@section('page_title', 'Edit Profile')

@section('content')

    <!-- row -->
    <div class="row justify-content-center">
        <div class="col-md-8 mb-5" >
            <div class="card card-statistics h-100">
                <div class="card-body">


                    <form id='profile' action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                    
                        <!-- Profile Photo -->
                        <div class="form-group text-center">
                            <label for="image" class="form-label">Profile Image</label>
                            <div class="mb-3">
                                <img src="{{ $user->profile->image ? asset('uploads/' . $user->profile->image) : asset('dist/img/user2-160x160.jpg') }}" 
                                alt="Profile Image" 
                                class="rounded-circle img-thumbnail" 
                                style="width: 150px; height: 150px;">                          
                            </div>
                        </div>

                        <x-success_alert/>

                        <!-- First Name -->
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->profile->first_name) }}">
                            @error('first_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Last Name -->
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->profile->last_name) }}">
                            @error('last_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Phone Number -->
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->profile->phone_number) }}">
                            @error('phone_number')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Birthday -->
                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday', $user->profile->birthday) }}">
                            @error('birthday')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Gender -->
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="" disabled>Select Gender</option>
                                <option value="male" @selected(old('gender', $user->profile->gender) == 'male')>Male</option>
                                <option value="female" @selected(old('gender', $user->profile->gender) == 'female')>Female</option>
                            </select>
                            @error('gender')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Street Address -->
                        <div class="form-group">
                            <label for="street_address">Street Address</label>
                            <input type="text" class="form-control" id="street_address" name="street_address" value="{{ old('street_address', $user->profile->street_address) }}">
                            @error('street_address')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- City -->
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $user->profile->city) }}">
                            @error('city')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Postal Code -->
                        <div class="form-group">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->profile->postal_code) }}">
                            @error('postal_code')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Country -->
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select class="form-control" id="country" name="country">
                                <option value="" disabled>Select Country</option>
                                @foreach ($countries as $c_code => $country )
                                <option value="{{$c_code}}" @selected(old('country', $user->profile->country == $c_code))>{{ $country }}</option>
                                @endforeach
                            </select>
                            @error('country')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Language -->
                        <div class="form-group">
                            <label for="language">Language</label>
                            <select class="form-control" id="language" name="language">
                                <option value="" disabled>Select Language</option>
                                @foreach ($languages as $lang_code => $language )
                                <option value="{{$lang_code}}" @selected(old('country', $user->profile->language == $lang_code))>{{ $language }}</option>
                                @endforeach
                            </select>
                            @error('language')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Upload New Profile Image -->
                        <div class="form-group">
                            <label for="image">Upload New Profile Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Submit Button -->
                        <div class="form-group">
                            <input type="submit" value="Save" name="save" class="form-control btn-secondary">
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

@endsection
