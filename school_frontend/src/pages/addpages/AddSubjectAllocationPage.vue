<template>
  <base-layout>
    <div>
      <h5 class="add_heading">Session: {{$globalData.sessionData.year}} {{$globalData.sessionData.term}}</h5>
      <h6>Select Teacher</h6>
      <Teacher/>
      <h6>Select subject</h6>
      <Allocation/>
      <!-- Show the tab navigation if classes are available -->
      
    </div>
  </base-layout>
</template>

<script>
import { apiFunctionMixin } from '@/apiFunction.js';
import Teacher from '@/components/common/TeacherComponent.vue';
import Allocation from '@/components/common/AllocationComponent.vue';
export default {
  mixins: [apiFunctionMixin],
  components:{
    Teacher,
    Allocation
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