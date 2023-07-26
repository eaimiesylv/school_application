<template>
  <base-layout>
    <div class="container mt-4">
      <h3 class="add_heading">User Login</h3>
      <form @submit.prevent="submitForm">
       
        <div class="form-group">
          <label for="email">Email/Reg No</label>
          <input type="text" class="form-control" v-model="form.email_regno" id="email" required>
        </div>
       

    
      <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" v-model="form.password" id="password" required>
      </div><!--
      <div class="form-group">
          <label for="password_confirmation">Password Confirmation</label>
          <input type="password" class="form-control" v-model="password_confirmation" id="password_confirmation" required>
      </div>-->
       
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
        email_regno: 'okomemmanuel1@gmail.com',
        password:'11111111',
      },
      isLoading: false,
      error: ''
    };
  },
  methods: {
    async submitForm() {
      this.isLoading = true; // Start the loading indicator
      this.error = ''; // Reset the error message
      try {
        const formData = new FormData(); // Create a new FormData object
       
        formData.append('email_regno', this.form.email_regno);
        formData.append('password', this.form.password); // 
       
        // endpoint, form data, redirect route
        await this.postMethod('/login', formData, '/');
      } catch (error) {
        // Handle the error here
        console.error('Error performing POST request:', error);
      }
    },
    handleFileChange(event) {
      const file = event.target.files[0];
      this.form.passport = file; // Update the form's passport property with the selected file
    }
  }
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
