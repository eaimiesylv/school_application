<template>
  <base-layout>
    <div>
      <h5 class="add_heading">Session: {{$globalData.sessionData.year}} {{$globalData.sessionData.term}}</h5>
      <h6>Select Teacher</h6>
      <Teacher/>
      <h6>Select Class</h6>
      <div class="form-group">
         
         <select v-model="selectedClass" class="form-control" id="classSelect" >
           <option v-for="klass in classes" :value="klass.id" :key="klass.id">{{ klass.class_name }}</option>
         </select>
     </div>

     <button @click="submitAllocation" class="btn btn-primary">Submit Allocation</button> 
      
    </div>
  </base-layout>
</template>

<script>
import { apiFunctionMixin } from '@/apiFunction.js';
import Teacher from '@/components/common/TeacherComponent.vue';

export default {
  mixins: [apiFunctionMixin],
  components:{
    Teacher,
   
  },
  data() {
    return {
      classes:'',
      selectedClass:''
    };
  },
  mounted() {
    this.fetchClasses();
  },
  methods: {
  
  async fetchClasses() {
    try {
      this.classes = await this.getMethod('/klass');
      console.log(this.classes)
    } catch (error) {
      console.log(error);
    }
  },
  getTeacherId(){
    this.$globalData.teacherData = this.selectedTeacher;
    
  },
  async submitAllocation() {
    console.log(this.selectedClass)
      this.isLoading = true; // Start the loading indicator
      this.error = ''; // Reset the error message
      try {
        //endpoint, form data, redirect route
        await this.postMethod('/class_teacher_allocation',
                              { 
                                teacher_id: this.$globalData.teacherData.id,
                                  session_id: this.$globalData.sessionData.id,
                                  class_id: this.selectedClass
                              },'/class_teacher_allocation');
      } catch (error) {
        // Handle the error here
        console.error('Error performing POST request:', error);
      }
      
    }
 }
};
</script>
<style>
  .nav-link{
    color:black !important;
  }
</style>