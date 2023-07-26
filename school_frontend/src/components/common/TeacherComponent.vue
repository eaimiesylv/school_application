<template>
  
      <!-- Show loading state if classes are being fetched -->
      <div v-if="isLoading" class="text-center">
        <p>Loading...</p>
      </div>

      <!-- Show error message if API call fails -->
      <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div>
      <div class="form-group">
         
          <select v-model="selectedTeacher" class="form-control" id="teacherSelect" @change="getTeacherId">
            <option v-for="teacher in teachers" :value="teacher" :key="teacher.id">{{ teacher.first_name }} {{ teacher.last_name }}</option>
          </select>
      </div>
      
</template>

<script>
import { apiFunctionMixin } from '@/apiFunction.js';


export default {
  mixins: [apiFunctionMixin],
  data() {
    return {
     
      isLoading: false, // Loading state flag
      hasError: '',
      teachers:'',
      selectedTeacher:''
    };
  },
  mounted() {
  
    this.fetchTeachers();
  },
  methods: {
  
    async fetchTeachers() {
      try {
        this.teachers = await this.getMethod('/allteacher');
        
      } catch (error) {
        console.log(error);
      }
    },
    getTeacherId(){
      this.$globalData.teacherData = this.selectedTeacher;
      
    }
  }
};
</script>
<style>
  .nav-link{
    color:black !important;
  }
</style>