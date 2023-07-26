<template>
  <base-layout>
    <div>
      <h4 class="btn btn-primary">
        <router-link to="/subject/addsubject">Create Subject</router-link>
      </h4>

      <!-- Show loading state if classes are being fetched -->
      <div v-if="isLoading" class="text-center">
        <p>Loading...</p>
      </div>

      <!-- Show error message if API call fails -->
      <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div>

      <!-- Show the table if classes are available -->
      <div class="border-box" v-for="classItem in klas_subject" :key="classItem.id">
        <h2>{{ classItem.class_name }}</h2>

        <table v-if="classItem.subjects.length > 0" class="table">
          <thead>
            <tr>
              <th>Subject</th>
              <th>Subject Label</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="subject in classItem.subjects" :key="subject.id">
              <td>{{ subject.subjects }}</td>
              <td>{{ subject.subject_label || '-' }}</td>
            </tr>
          </tbody>
        </table>

        <p v-else>No subjects available for this class.</p>
      </div>
    </div>
  </base-layout>
</template>


<script>
import { apiFunctionMixin } from '@/apiFunction.js';

export default {
  mixins: [apiFunctionMixin],
  data() {
    return {
      klas_subject: [], // Assign the API response to this property
      isLoading: false, // Loading state flag
      hasError:'',
     
    };
  },
  mounted() {
    this.fetchClasSubject();
  },
  methods: {
    async fetchClasSubject() {
      try {
         this.isLoading = true;
         this.klas_subject=await this.getMethod('/klass_subject');
      } catch (error) {
        console.log(error);
        
      }
    },
  },
};
</script>
<style>
.border-box {
  background-color: #fff;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
}

</style>
