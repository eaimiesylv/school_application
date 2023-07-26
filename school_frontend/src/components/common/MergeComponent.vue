<template>
  <div v-if="classes && classes.length > 0">

        
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"  v-for="(classItem, index) in classes" :key="index">
                                
            <router-link to=""  
              :class="['nav-link', activeTab === index ? 'active' : '']"
              @click="changeActiveTab(index)"
              role="tab"
            >{{classItem.class_name }}</router-link>
          </li>
        </ul>
        <!-- Show the table with subjects for the active tab -->
        <table class="table" v-if="activeClassSubjects.length > 0">
          <thead>
            <tr>
              <th>S/n</th>
              <th>Subject Name</th>
              <th>Select Subject</th>
            </tr>
          </thead>
          <tbody>
          <tr v-for="(subjectObj, index) in activeClassSubjects" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ subjectObj.subject.subjects }}</td>
            <td>
              <input
                type="checkbox"
                :value="subjectObj"
                v-model="selectedSubjects"
              />
            </td>
          </tr>
        </tbody>
        </table>
        <div>
          <h4 v-if="selectedSubjects.length > 0">{{$globalData.teacherData.first_name}} {{$globalData.teacherData.last_name}} Merged Subject</h4>
        <!-- Show the table with subjects for the active tab -->
        <table class="table" v-if="selectedSubjects.length > 0">
          
            <thead>
              <tr>
                <th>S/n</th>
                <th>Subject Name</th>
                <th>Class</th>
                <th>Remove</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(subject, index) in selectedSubjects" :key="subject.id">
                <td>{{ index + 1 }}</td>
                <td>{{ subject.subject.subjects}}</td>
                <td>{{ subject.class_name}}</td>
                <td><button class="btn btn-danger" @click="removeAllocation(subject)">Remove</button></td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-----this part is for merging subjects-->
        <h5>Merge Subject As</h5>
        <select v-model="selectOption" class="form-control" id="teacherSelect" @change="getSubjectId">
        <option  v-for="(subjectObj, index) in activeClassSubjects" :key="index" :value="subjectObj">
          {{ subjectObj.subject.subjects }}
        </option>
      </select>
      <br>
        <button @click="mergeSubject" class="btn btn-primary">Merge Subject</button> 
       
   </div>
    <!-- Show a message if there are no subjects for the active class -->
    <div v-else>No subjects available for this class.</div>
   
    
</template>

<script>
import { apiFunctionMixin } from '@/apiFunction.js';


export default {
  mixins: [apiFunctionMixin],
  data() {
    return {
      classes: [], // Assign the API response to this property
      isLoading: false, // Loading state flag
      hasError: '',
      activeTab: 0, // Index of the currently active tab
      selectedSubjects: [], 
      teachers:'',
      selectOption:''
    };
  },
  mounted() {
    this.fetchClasses();
  
  },
  methods: {
    getSubejctId(){
     // this.$globalData.teacherData = this.selectOption;
      
    },
    async fetchClasses() {
      try {
        this.isLoading = true;
        this.classes = await this.getMethod('/klass_subject');
        console.log(this.classes);
        this.isLoading = false;
        // Update activeClassSubjects with the subjects of the first class initially
        this.activeClassSubjects = this.classes.length > 0 ? this.classes[0].subjects : [];
      } catch (error) {
        console.log(error);
        this.hasError = true;
        this.isLoading = false;
      }
    },
    async mergeSubject() {
      this.isLoading = true; // Start the loading indicator
      this.error = ''; // Reset the error message
      try {
        //endpoint, form data, redirect route
        const mergeSubjects = this.selectedSubjects.map((subjectObj) => ({
             merge_name:  this.selectOption.subject.id,
             subject_id: subjectObj.subject.id,
             session_id: this.$globalData.sessionData.id,
             class_id: subjectObj.subject.class_id,
            
    }));
    
    // Assuming that the endpoint expects an array of allocations as the payload
    await this.postMethod('/merge_subject', { mergesubject: mergeSubjects }, '/merge_result');
       
                              
      } catch (error) {
        // Handle the error here
        console.error('Error performing POST request:', error);
      }
     
    },
    changeActiveTab(index) {
      // Update activeClassSubjects with the subjects of the selected class
      this.activeTab = index;
      this.activeClassSubjects = this.classes[index].subjects;
      this.selectedSubjects= [];
    },
    removeAllocation(subjectObj) {
      const index = this.selectedSubjects.findIndex(
      (subject) => subject.class_name === subjectObj.class_name && subject.subject.subjects === subjectObj.subject.subjects
    );

    if (index !== -1) {
      this.selectedSubjects.splice(index, 1);
    }
    }
    
  },
  computed: {
    activeClassSubjects() {
      return this.classes.length > 0 ? this.classes[this.activeTab].subjects.map(subject => ({
        class_name: this.classes[this.activeTab].class_name,
        subject: subject
      })) : [];
    },
  },

};
</script>

<style>
/* Add your styles here if needed */
</style>
