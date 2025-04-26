<script setup>

   import Shimmer from "vue3-loading-shimmer"
   import { ref, onMounted } from 'vue'
   import moment from 'moment'
   import service from '../services'

   const loading = ref(true)
   const activities = ref([])

   const loadContent = async () => {
      loading.value = true
      await service.profile.activity().then((reponse) => { 
        activities.value = reponse.data
        setTimeout(() => { 
            loading.value = false
        }, 1500)
      })
      .catch((error) => {
          console.log(error)
      });
   }

   onMounted( () => {
      loadContent()   
   })

   defineExpose({
      loadContent
   });

</script>
<template>
    <section class="bsb-timeline-1 py-5 py-xl-8">
       <div class="container">
         <div class="row justify-content-center" v-if="loading">
             <Shimmer style="height: 1rem; border-radius: 10px;" class="mb-2" />
             <Shimmer style="height: 1rem; border-radius: 10px;" class="mb-2" />
             <Shimmer style="height: 1rem; border-radius: 10px;" class="mb-2" />
         </div>
         <div class="row justify-content-center" v-else>
             <div class="col-10 col-md-8 col-xl-6">
                <ul class="timeline">
                  <li class="timeline-item" v-for="item in activities">
                     <div class="timeline-body">
                        <div class="timeline-content">
                           <div class="card border-0 bg-primary text-white">
                              <div class="card-body">
                                 <small class="card-subtitle text-secondary mb-1 d-block text-white">{{ moment(item.created_at).format("DD-MM-YYYY HH:mm:ss") }}</small>
                                 <p class="card-text m-0"><small>{{ item.event }} - {{ item.description }}</small></p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </li>
                </ul>
             </div>
          </div>
       </div>
    </section>
 </template>