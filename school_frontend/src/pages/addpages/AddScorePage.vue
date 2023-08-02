<template>
  <base-layout>
    <div class="container mt-4">
       <!-- Show error message if API call fails -->
       <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div>
      <h3 class="add_heading">{{ subjectName }} {{ assessname }} For {{ classname }}</h3>
     {{ classes[students] }}
      <table class="table" v-if="classes">
                <thead>
                  <tr>
                    <th>S/n</th>
                    <th>Image</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Enter Score</th>
                  
                  </tr>
                </thead>
                <tbody>
                <tr v-for="(subjectObj, index) in classes" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td> <img :src="subjectObj.user.passport" alt="Passport Image" class="custom-img" /></td>
                  <td> {{ subjectObj.user.first_name}}</td>
                  <td> {{ subjectObj.user.last_name}}</td>
                  <td> <input
                        id="class-name-input"
                        type="text"
                        class="form-control"
                        
                        :value="subjectObj.scores[0].score"
                        @input="debouncedUpdateScore(subjectObj, $event.target.value)" />
                  </td>
              

                  
                </tr>
              </tbody>
              
              </table>
    </div>
  </base-layout>
</template>

<script>
import { apiFunctionMixin } from '@/apiFunction.js';
import axios from 'axios';
import { debounce } from 'lodash'; // Import debounce from Lodash

export default {
  mixins: [apiFunctionMixin],
  props: ['subjectId','subjectName','assessId','assessname','classname','classId','session_id'],
  data() {
    return {
      
      isLoading: false,
      error: '',
      hasError: '',
      classes:[],
      selectedClassLevel: 1, // Default selected class level is 1
      scores:[],
      debouncedUpdateScore: debounce(this.updateScore, 1000),
    };
  },
  methods: {
    updateScore(subjectObj, newValue) {
      // Update the score property of the first element in the scores array
      subjectObj.scores[0].score = newValue;
      let url=`/student_subject_score/${this.subjectId}/${this.assessId}/${this.session_id}`;
            console.log(url);
    
       this.submitForm(
                      subjectObj.scores[0].id,
                      subjectObj.user_id,
                      subjectObj.scores[0].score,///score
                      this.assessId,
                      this.subjectId,
                      this.classId,
                      this.session_id);
       // this.fetchClasses;

      // If you want to see the updated scores array in the console, you can log it here.
      //console.log(subjectObj.scores);
    },
    async submitForm(score_id,user_id,score,assessment_id,subject_id,class_id,session_id) {
     
      this.isLoading = true; // Start the loading indicator
      this.error = ''; // Reset the error message
      try {
        await this.postMethod('/score', {
          id:score_id,
          user_id:user_id,
          score: score,
          assessment_id:assessment_id,
          subject_id:subject_id,
          class_id:class_id,
          session_id:session_id
        }, '');
        // Redirect to the desired route upon successful POST request (if needed)
        // this.$router.push('/success-route');
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
            
            [this.classes, this.scores] = await axios.all([
            this.getMethod(`/single_klass_student/${this.classId}/${this.session_id}`),
            this.getMethod(`/student_subject_score/${this.subjectId}/${this.assessId}/${this.session_id}`),
            ]);
            this.classes = this.classes[0].students
            let std = this.classes ;
            let score = this.scores ;
            // Merge Student with Scores
            
            // Create the std_score array by merging score and std arrays
            let std_score = std.map((student) => {
              // Find the corresponding scores for the student using user_id
              let studentScores = score.filter((s) => s.user_id === student.user_id);

              // If there are scores for the student, include them in the 'score' property
              if (studentScores.length > 0) {
                student.scores = studentScores;
              } else {
                // If there are no scores for the student, include an empty array in the 'score' property
                student.scores = [{'score':''}];
              }

              return student;
            });
            this.classes = std_score;
            console.log(score);

          } catch (error) {
          console.log(error);
         } finally {
        this.isLoading = false; // Set isLoading to false after the request is completed
         }
    },
  },
  mounted() {
    this.fetchClasses();
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
.custom-img {
  max-width: 60px; /* Ensure the image doesn't exceed its parent container's width */
  max-height: 60px; /* Set a maximum height for the image */
  width: auto; /* Let the image scale its width based on the maximum height */

  /* Additional styles for centering the image and preserving its aspect ratio */
  display: block;
  margin: 0 auto;
}
</style>
