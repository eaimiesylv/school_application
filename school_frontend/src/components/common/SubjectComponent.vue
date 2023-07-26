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
         
          <select v-model="selectedSubject" class="form-control" id="SubjectSelect" @change="getSubjectId">
          <option v-for="Subject in Subjects" :value="Subject" :key="Subject.id">{{ Subject.subjects}}</option>
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
      Subjects:'',
      selectedSubject:''
    };
  },
  mounted() {
  
    this.fetchSubjects();
  },
  methods: {
  
    async fetchSubjects() {
      try {
        this.Subjects = await this.getMethod('/subject');
        
      } catch (error) {
        console.log(error);
      }
    },
    getSubjectId(){
      this.$globalData.SubjectData = this.selectedSubject;
      
    }
  }
};
</script>
<style>
  .nav-link{
    color:black !important;
  }
</style>