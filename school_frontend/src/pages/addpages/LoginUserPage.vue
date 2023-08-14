<template>
  <!--<base-layout>-->
    <div class="container">
      <div class="text-center">
          <img src="/assets/images/user.png"  width="75" height="50"/>
      </div>
      <h3 class="add_heading">User Login</h3>
    
      <form @submit.prevent="submitForm">
       
        <div class="form-group">
          <label for="email">Email/Reg No</label>
          <input type="text" class="form-control" v-model="form.email_regno" id="email" required>
        </div>
       

    
      <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" v-model="form.password" id="password" required>
      </div>
       
        <button type="submit" class="btn btn-primary" :disabled="isLoading">
          <i class="fa-solid fa-sign-in"></i>
          <span v-if="isLoading">Submitting...</span>
          <span v-else>Submit</span>
        </button>
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-user-plus"></i><router-link to="/register" class="link">Register</router-link>
          
        </button>
        
        <p v-if="error" class="error-message">{{ error }}</p>
      </form>
    </div>
  <!--</base-layout>-->
</template>

<script>

import { apiFunctionMixin } from '@/apiFunction.js';

export default {
  mixins: [apiFunctionMixin],
 
  data() {
    return {
      form: {
        email_regno: 'okomemmanuel1@gmail.com',
        password:'1234567',
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
       /*
        for (const [key, value] of formData.entries()) {
         console.log(key, value);
        }*/
        
      
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

/* Apply styles to the container */
.container {
  /* Adjust the container width and add padding if needed */
  max-width: 800px;
  padding: 20px;
  /* Center the container horizontally */
  margin: 0 auto;
  /* Add some spacing at the top */
  margin-top: 100px;
  /* Add a white background to the container */
  background-color: white;
  /* Add rounded corners */
  border-radius: 5px;
  /* Add box shadow for a subtle elevation effect */
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
}

/* Apply styles to the body background */
.body-bg {
  /* Set the background color for the entire body */
  background-color: #f5f5f5; /* Example background color */
  /* Add styling for the full height of the viewport */
  min-height: 100vh;
  /* Center the content vertically */
  display: flex;
  justify-content: center;
  align-items: center;
}

</style>
