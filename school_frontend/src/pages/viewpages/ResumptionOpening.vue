<template>
  <base-layout>
    <div class="container mt-4">
       <!-- Show error message if API call fails -->
       <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div>
      <h5 class="add_heading">Resumption and Opening Date: {{$globalData.sessionData.year}} {{$globalData.sessionData.term}}</h5>
      <table class="table" v-if="classes">
         
         <tr >
           <td>Closing Date</td>
           <td>{{ classes.closing}}</td>
         </tr>
        <tr>
           <td>Resumption Date</td>
           <td>{{ classes.resumption }}</td>
         </tr>
         
   
     </table>
    <hr>
    <h6>Set Closing and Resumption Date</h6>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="class_name">Resumption Date</label>
          <input type="date" class="form-control" placeholder="Resumption Date" v-model="form.resumption"  required>
        </div>
        <div class="form-group">
          <label for="class_name">Closing Date</label>
          <input type="date" class="form-control" placeholder="Closing Date" v-model="form.closing" required>
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
        resumption: '',
        closing:'',
        session_id:''
      },
      isLoading: false,
      error: '',
      hasError: '',
      classes:''
    };
  },
 mounted(){
  this.fetchClasses();
 },
  methods: {
    async submitForm() {
      this.isLoading = true; // Start the loading indicator
      this.error = ''; // Reset the error message
     
      try {
        await this.postMethod('/resumption_closing', {
          resumption: this.form.resumption, // Include selected class level in the data
          closing: this.form.closing,
          session_id:this.session_id
        }, '/resumption_opening_date');
       // this.fetchClasses();
       
      } catch (error) {
        // Handle the error here
        console.error('Error performing POST request:', error);
      } finally {
        this.isLoading = false; // Set isLoading to false after the request is completed
      }
    },
    async fetchClasses() {
      try {
        this.isLoading = true;
        this.error = '';
        this.classes = await this.getMethodId(`/resumption_closing/${this.session_id}`);
      
        console.log(this.classes)
     
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false; // Set isLoading to false after the request is completed
      }
    },
  },watch: {
  '$globalData.sessionData': {
    immediate: true,
    handler(value) {
      if (value && value.id) {
        this.session_id = value.id;
        console.log(this.session_id);
        this.fetchClasses();
      } else {
        console.log('Session data is not available yet');
      }
    }
  }
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
