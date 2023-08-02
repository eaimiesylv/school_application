<template>
  
   
    <aside class="sidebar" :class="{sidebar: !isSidebarClosed }">
      <ul>
        <li class="text-center">
          <router-link to="/" class="link">
            <img src="/assets/images/user.png" width="75" height="50"/>
          </router-link>
          <h6 class="mt-2 white">Paul 12</h6>
          <h6><small>Admin</small></h6>
        </li>
        <li><i class="fa-solid fa-user"></i><router-link to="/register" class="link">Register</router-link></li>
        <li><i class="fa-solid fa-user"></i><router-link to="/login" class="link">Login</router-link></li>
       
        
        <li v-if="role === 0"><i class="fa-solid fa-dashboard"></i><router-link to="/studenthome" class="link">Dashboard</router-link></li>
        <li v-else-if="role === 3"><i class="fa-solid fa-dashboard"></i><router-link to="/adminhome" class="link">Dashboard</router-link></li>
        <li v-else><i class="fa-solid fa-dashboard"></i><router-link to="/staffhome" class="link">Dashboard</router-link></li>
      
      
        <hr>
        <!-- Add more sidebar links as needed -->
        
        <li v-if="role !== 0"><i class="fa-solid fa-pencil-ruler"></i><router-link to="/score" class="link">Score</router-link></li>
        <li  v-if="role === 3"><i class="fa-solid fa-eraser"></i><router-link to="/merge_subject" class="link">Merge Subject</router-link></li>
        <li v-if="role === 3"><i class="fa-solid fa-eraser"></i><router-link to="/broadsheet" class="link">BroadSheet</router-link></li>
        <li v-if="role === 3"><i class="fa-solid fa-laptop"></i><router-link to="/subject_allocation" class="link">Subject allocation</router-link></li>
        <li v-if="role === 3"><i class="fa-solid fa-chalkboard"></i><router-link to="/class_teacher_allocation" class="link">Class teacher allocation</router-link></li>
        <li v-if="role === 3"><i class="fa-solid fa-calendar"></i><router-link to="/resumption_opening_date" class="link">Resumption/Closing Date</router-link></li>

        <hr>

        <li v-if="role > 1"><i class="fa-solid fa-globe"></i><router-link to="/teacher_comment" class="link">Teacher Comment</router-link></li>
        <li v-if="role === 3"><i class="fa-solid fa-microscope"></i><router-link to="/hm_comment" class="link">Hm Comment</router-link></li>
        <hr>
        <li v-if="role > 1"><i class="fa-solid fa-music"></i><router-link to="/affective" class="link">Affective</router-link></li>
        <li v-if="role > 1"><i class="fa-solid fa-car"></i><router-link to="/psychomotor" class="link">Pyschmotor</router-link></li>
        <li v-if="role === 3"><i class="fa-solid fa-clipboard"></i><router-link to="/analyse_result" class="link">Analyse Result</router-link></li>
        <hr>
        <li v-if="role === 3"><i class="fa-solid fa-school"></i><router-link to="/session" class="link">Session</router-link></li>
        <li v-if="role === 3"><i class="fa-solid fa-pencil"></i><router-link to="/klass" class="link">Class</router-link></li>
        <li v-if="role === 3"><i class="fa-solid fa-book"></i><router-link to="/subject" class="link">Subject</router-link></li>
        <li v-if="role === 3"><i class="fa-solid fa-graduation-cap"></i><router-link to="/assessment" class="link">Assessment</router-link></li>
        <li><i class="fa-solid fa-sign-out"></i><a @click="logout" class="link">Log Out</a></li>

      </ul>
</aside>


   

</template>

<script>
import axios from 'axios';
export default {
 
  data() {
    return {
      role:0,
      sidebar: null, // Initialize sidebar as null
      isSidebarClosed: false, // Set initial value of isSidebarClosed
      session: null, // Changed from this.session to null to prevent default selection
      sessionOptions: [], 
    };
  },
  methods: {
    toggleSidebar() {
      // Toggle the value of isSidebarClosed
      this.isSidebarClosed = !this.isSidebarClosed;
      // Modify the display property based on the value of isSidebarClosed
      this.sidebar.style.display = this.isSidebarClosed ? 'none' : 'block';
    },
    async fetchSessionId() {
      try {
         this.isLoading = true;
         let allSession="";

         const currentSessionData = localStorage.getItem('current_session');
        if (!currentSessionData) {
          // The 'current_session' data is not present in local storage, fetch the latest session
          const response = await axios.get('/session');
          this.session=response.data
           allSession=JSON.stringify(response.data)
          localStorage.setItem('current_session',allSession);
        }else{
          allSession= localStorage.getItem('current_session');
          this.session = JSON.parse(allSession);
        }
         
        
      } catch (error) {
        console.log(error);
        
      }
    },
    async logout(){
      localStorage.removeItem('token');
      localStorage.removeItem('role');

      // Redirect to the login page or any other desired page after logout
      this.$router.push('/login');

      // Redirect to the login page or any other desired page after logout
      this.$router.push('/login');
    }
  },
  mounted() {
     this.fetchSessionId();
    // Get the sidebar element and store it in the data property
    this.sidebar = document.querySelector('.sidebar');
    // Get the computed style of the sidebar
    const computedStyle = getComputedStyle(this.sidebar);
    // Get the value of the display property
    const display = computedStyle.getPropertyValue('display');

    // Set the value of isSidebarClosed based on the display property
    this.isSidebarClosed = display === 'none';

    const roles =localStorage.getItem('role');
    this.role= Number(atob(roles));
  
  },
};
</script>

<style>
/* style the page layout*/
#container {
  display: grid;
  grid-template-columns: max-content 1fr;
  grid-template-rows: 1fr auto;
  grid-template-areas: 
      "aside main"
      "footer footer";
  height: 100vh;
  margin: 0;
  overflow-y: hidden; /* Hide any overflowing content */
}

.sidebar {
  
  max-height: calc(100vh - 30px); /* Adjust the height based on your layout */
  overflow-y: auto;
  background-color: #0F5298;
  padding:0 1em;
}
aside{
  grid-area:aside;
}
main{
  grid-area:main;
  background-color: #f0f0f0;
  padding:1.5em;
  max-height: calc(100vh - 30px); /* Adjust the height based on your layout */
  overflow-y: auto;
}
section{
  margin-top:0.5em
}
header, section{
  background-color: white;
  padding:1.5em;
  
}
footer{
  grid-area:footer;
}
/* style the header element*/
header ul {
  display: flex;
  margin: 0 !important;
  padding: 0 !important;
}

.search-container {
  margin-right: auto;
}

header  li:not(.search-container, .fa-solid){
  margin-left: 1em;
}
header span {
  margin-left:0.5em;
}
/* other custom style*/
.fa-solid {
  margin-right: 10px;
}
aside li,a {
  color: white !important;
  padding:0.5em 0;
}
.link{
  text-decoration:none !important;
}


@media (max-width: 900px) {
  .sidebar ,span{
    display: none;
  }
  
 
}

@media (min-width: 900px) {
  .sidebar {
    display: block;
  }
}
</style>
