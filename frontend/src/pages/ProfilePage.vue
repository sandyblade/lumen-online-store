<script setup>

    import Shimmer from "vue3-loading-shimmer"
    import TimelineComponent from '../components/TimelineComponent.vue'
    import { Form, Field } from 'vee-validate'
    import { ref, onMounted } from 'vue'
    import * as yup from 'yup'
    import service from '../services'

    const loadingContent = ref(true)
    const loadingSubmit = ref(false)
    const loadingUpload = ref(false)
    const errorResponse = ref('')
    const successResponse = ref('')
    const form = ref(null)
    const timeline = ref(null)
    const formData = ref({})
    const file = ref(null)

    const schema = yup.object().shape({
        email: yup.string().email().required(),
        first_name: yup.string().required(),
        last_name: yup.string().required(),
        gender: yup.string().required(),
        phone: yup.string().required(),
        city: yup.string().required(),
        country: yup.string().required(),
        zip_code: yup.string().required(),
        address: yup.string().required(),
    })

    const loadContent = async () => {

        loadingContent.value = true
        await service.profile.detail().then((reponse) => { 
            formData.value = reponse.data
            setTimeout(() => { 
                loadingContent.value = false
            }, 1500)
        })
        .catch((error) => {
            errorResponse.value = error.status === 401 ? service.expiredMessage : (error.response.data?.message || error.message)
        });
    }

    const handleFileUpload = async () => {
        if (file.value.files.length > 0) {
            let file_image = file.value.files[0]
            let checkImage = validateImageExtension(file_image)
            if (!checkImage) {
                errorResponse.value = 'Upload valid images. Only PNG and JPEG are allowed.'
            } else {
                errorResponse.value = ''
                loadingUpload.value = true   
                await service.profile.upload(file_image).then(async () => {
                    loadingUpload.value = false
                    await loadContent()
                    await timeline.value.loadContent()
                })
            }
        }
    }

    const validateImageExtension = (file) => {
        var allowedExtensions = ["jpg", "jpeg", "png", "gif"];
        var extension = file.name.split('.').pop().toLowerCase();
        return allowedExtensions.indexOf(extension) !== -1;
    }

    const submit = (values) => { 
        loadingSubmit.value = true
        errorResponse.value = ''
        successResponse.value = ''
        setTimeout(() => { 
            service.profile.changeProfile(values).then(async (result) => { 
                loadingSubmit.value = false
                errorResponse.value = ''
                successResponse.value = result.data.message
                form.value.resetForm()

                let profile = await service.profile.detail()
                if (localStorage.getItem('auth_user')) {
                    localStorage.setItem('auth_user', JSON.stringify(profile.data))
                }
                
                setTimeout(async () => {
                    loadContent()
                    await timeline.value.loadContent()
                })
            })
            .catch((error) => {
                loadingSubmit.value = false
                errorResponse.value = error.status === 401 ? service.expiredMessage : (error.response.data?.message || error.message)
            });
        }, 1500)
    }

    onMounted(() => {
        loadContent()
    })

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
            <div v-if="errorResponse" class="alert alert-danger mb-4">
                <span>{{ errorResponse }}</span>
            </div>
            <div v-if="successResponse" class="alert alert-success mb-4">
                <span>{{ successResponse }}</span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <Form ref="form" :validation-schema="schema" @submit="submit" :initial-values="formData">
                        <h3 class='text-uppercase mb-3 text-center'>Account Profile</h3>
                        <div class="mb-3">
                            <span v-if="formData.image">
                                <img class="image img-thumbnail mb-2 d-block" width="200" :src="service.getFile(formData.image)" />
                            </span>
                            <span v-else>
                                <i class="bi-person-circle d-block mb-3 image-user-font"></i>
                            </span>
                            <label class="form-label">Image Profile </label>
                            <span v-if="loadingContent || loadingUpload">
                               <Shimmer style="height: 1rem; border-radius: 10px;" />
                            </span>
                            <span v-else>
                               <input type="file" ref="file" v-on:change="handleFileUpload()" class="form-control">
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <span v-if="loadingContent">
                               <Shimmer style="height: 1rem; border-radius: 10px;" />
                            </span>
                            <span v-else>
                                <Field  name="first_name" v-model="formData.first_name"  v-slot="{ field, errors }">
                                    <input v-bind="field" type="text" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your First Name">
                                    <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                        <span class="d-block" v-for="item in errors">
                                            {{ item }}
                                        </span>
                                    </div>
                                </Field>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <span v-if="loadingContent">
                               <Shimmer style="height: 1rem; border-radius: 10px;" />
                            </span>
                            <span v-else>
                                <Field  name="last_name" v-model="formData.last_name"  v-slot="{ field, errors }">
                                    <input v-bind="field" type="text" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your Last Name">
                                    <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                        <span class="d-block" v-for="item in errors">
                                            {{ item }}
                                        </span>
                                    </div>
                                </Field>
                            </span>
                        </div>
                         <div class="mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <span v-if="loadingContent">
                               <Shimmer style="height: 1rem; border-radius: 10px;" />
                            </span>
                            <span v-else>
                                 <Field  name="gender" v-model="formData.gender"  v-slot="{ field, errors }">
                                    <select v-bind="field" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Select Gender">
                                        <option disabled>Select Gender</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                    <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                        <span class="d-block" v-for="item in errors">
                                            {{ item }}
                                        </span>
                                    </div>
                                 </Field>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-Mail Address <span class="text-danger">*</span></label>
                             <span v-if="loadingContent">
                               <Shimmer style="height: 1rem; border-radius: 10px;" />
                            </span>
                            <span v-else>
                                <Field name="email" v-model="formData.email"  v-slot="{ field, errors }">
                                    <input v-bind="field" type="email" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your E-Mail Address">
                                    <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                        <span class="d-block" v-for="item in errors">
                                            {{ item }}
                                        </span>
                                    </div>
                                </Field>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <span v-if="loadingContent">
                               <Shimmer style="height: 1rem; border-radius: 10px;" />
                            </span>
                            <span v-else>
                               <Field  name="phone" v-model="formData.phone"  v-slot="{ field, errors }">
                                    <input v-bind="field" type="text" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your Phone Number">
                                    <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                        <span class="d-block" v-for="item in errors">
                                            {{ item }}
                                        </span>
                                    </div>
                                </Field>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <span v-if="loadingContent">
                               <Shimmer style="height: 1rem; border-radius: 10px;" />
                            </span>
                            <span v-else>
                                <Field  name="city" v-model="formData.city"  v-slot="{ field, errors }">
                                    <input v-bind="field" type="text" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your City">
                                    <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                        <span class="d-block" v-for="item in errors">
                                            {{ item }}
                                        </span>
                                    </div>
                                </Field>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <span v-if="loadingContent">
                               <Shimmer style="height: 1rem; border-radius: 10px;" />
                            </span>
                            <span v-else>
                               <Field  name="country" v-model="formData.country"  v-slot="{ field, errors }">
                                    <input v-bind="field" type="text" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your Country">
                                    <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                        <span class="d-block" v-for="item in errors">
                                            {{ item }}
                                        </span>
                                    </div>
                                </Field>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                             <span v-if="loadingContent">
                               <Shimmer style="height: 1rem; border-radius: 10px;" />
                            </span>
                            <span v-else>
                               <Field  name="zip_code" v-model="formData.zip_code"  v-slot="{ field, errors }">
                                    <input v-bind="field" type="text" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your Zip Code">
                                    <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                        <span class="d-block" v-for="item in errors">
                                            {{ item }}
                                        </span>
                                    </div>
                                </Field>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Street Address <span class="text-danger">*</span></label>
                             <span v-if="loadingContent">
                               <Shimmer style="height: 5rem; border-radius: 10px;" />
                            </span>
                            <span v-else>
                                <Field  name="address" v-model="formData.address"  v-slot="{ field, errors }">
                                    <textarea rows="3" v-bind="field"  placeholder='Enter Your Street Address' class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" ></textarea>
                                    <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                        <span class="d-block" v-for="item in errors">
                                            {{ item }}
                                        </span>
                                    </div>
                                </Field>
                            </span>
                        </div>
                        <button type='submit' class="btn btn-lg btn-primary me-2" :class="loadingContent || loadingSubmit ? 'disabled': ''" >
                            <span v-if="loadingSubmit"><i class="fas fa-circle-notch fa-spin me-1"></i>Updating Profile...</span>
                            <span v-else>Update Profile</span>
                        </button>
                        <button type='reset' class="btn btn-lg btn-danger" :class="loadingContent || loadingSubmit ? 'disabled': ''">
                            Reset Form
                        </button>
                    </Form>
                </div>
                <div class="col-md-6">
                    <h3 class='text-uppercase mb-3 text-center'>Your Activity</h3>
                    <div class="p-1">
                        <TimelineComponent ref="timeline" />
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>