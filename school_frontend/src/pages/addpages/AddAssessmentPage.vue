<template>
  <base-layout>
    <div class="container mt-4">
       <!-- Show error message if API call fails -->
       <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div>
      <!-- globalData is set in main.js -->
      <h5 class="add_heading">Session: {{$globalData.sessionData.year}} {{$globalData.sessionData.term}}</h5>
      <form @submit.prevent="submitForm">
        
        <div class="form-group">
          <label for="assessname">Enter Assessment name</label>
          <input type="text" class="form-control" placeholder="e.g test" v-model="form.assessname" id="assessname" required>
        </div>
        <div class="form-group">
          <label for ="max">Max Score</label>
          <input type="number" max="100" min="0" class="form-control" placeholder="e.g 30" v-model="form.max" id="max" required>
        </div>
        <div class="form-group">
          <label for="min">Min Score</label>
          <input type="number" max="100" min="0" class="form-control" placeholder="e g 10" v-model="form.min" id="min" required>
        </div>
       
        <button type="submit" class="btn btn-primary" :disabled="isLoading">
          <span v-if="isLoading">Submitting...</span>
          <span v-else>Submit</span>
        </button>
        <p v-if="error" class="error-message">{{ error }}</p>
      </form>
    </div>
  </base-layout>
</template>

<script>
import { apiFunctionMixin } from '@/apiFunction.js';

export default {
  mixins: [apiFunctionMixin],
  
  data() {
    return {
      form: {
      
        assessname:'',
        max:'',
        min:'',
       
      },
      isLoading: false,
      error: '',
      hasError:'',
      session_id:''
     
    
    };
  },
  methods: {
   async submitForm() {
      this.isLoading = true; // Start the loading indicator
      this.error = ''; // Reset the error message
      try {
        //endpoint, form data, redirect route
        
        await this.postMethod('/assessment',
                              { 
                                assessname: this.form.assessname,
                                min: this.form.min,
                                max: this.form.max,
                                session_id: this.$globalData.sessionData.id

                              },'/assessment');
      } catch (error) {
        // Handle the error here
        console.error('Error performing POST request:', error);
      }
     
    },
   
  },
  mounted() {
   // this.fetchClasses();
   
   // this.session_id = this.$globalData.sessionData.id
    console.log(this.session_id)
   // let currentSession=localStorage.getItem('selected_session')
   // currentSession = JSON.parse(currentSession)
   // this.current_session='Session: ' +currentSession.year + ' '+ currentSession.term
   // this.session_id = currentSession.id
    //this.$parent.$on('session-updated', this.updateCurrentSession);
    // ... Your existing code ...
  },
  beforeUnmount() {
  
  },
};
</script>

<style>
.add_heading {
  color: orange;
}

.error-message {
  color: red;
}
</style>
