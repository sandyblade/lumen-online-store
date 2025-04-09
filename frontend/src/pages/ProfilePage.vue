<script setup>
    import TimelineComponent from '../components/TimelineComponent.vue'
</script>
<template>
    <main class="flex-shrink-0 p-3 border-bottom bg-gray text-uppercase mb-5" id="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-2">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Profile</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Change Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </main>
    <main class="flex-shrink-0 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <h3 class='text-uppercase mb-3 text-center'>Account Profile</h3>
                        <div class="mb-3">
                            <i class="bi-person-circle d-block mb-3 image-user-font"></i>
                            <label class="form-label">Image Profile </label>
                            <input type="file" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your First Name" type="text" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your Last Name" type="text" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-Mail Address <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your E-Mail Address" type="email" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your Phone Number" type="tel" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your City" type="text" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your Country" type="text" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your Zip Code" type="text" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Street Address <span class="text-danger">*</span></label>
                            <textarea rows="3" placeholder='Enter Your Street Address' class="form-control"></textarea>
                        </div>
                        <button type='submit' class="btn btn-lg btn-primary me-2">
                            Update Profile
                        </button>
                        <button type='reset' class="btn btn-lg btn-danger">
                            Reset Form
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h3 class='text-uppercase mb-3 text-center'>Your Activity</h3>
                    <div class="p-1">
                        <TimelineComponent/>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>