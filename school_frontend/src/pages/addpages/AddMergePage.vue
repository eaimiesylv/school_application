<template>
  <base-layout>
    <div>
      <h5 class="add_heading">Session: {{$globalData.sessionData.year}} {{$globalData.sessionData.term}}</h5>
     
     
      <h6>Select subject</h6>
      <Merge/>
     
      <!-- Show the tab navigation if classes are available -->
      
     
    </div>
  </base-layout>
</template>

<script>
import { apiFunctionMixin } from '@/apiFunction.js';

import Merge from '@/components/common/MergeComponent.vue';

export default {
  mixins: [apiFunctionMixin],
  components:{
    Merge,
   
  },
  data() {
    return {
    
    };
  },
 
};
</script>
<style>
  .nav-link{
    color:black !important;
  }
</style>