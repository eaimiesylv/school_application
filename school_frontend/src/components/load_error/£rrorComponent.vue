<template>
  <div id="container">
   
    <aside class="sidebar" :class="{sidebar: !isSidebarClosed }">
  <ul>
    <li class="text-center">
      <router-link to="/" class="link">
        <img src="/assets/images/user.png" width="75" height="50"/>
      </router-link>
      <h6 class="mt-2 white">Paul 12</h6>
      <h6><small>Admin</small></h6>
    </li>

    <!-- Add more sidebar links as needed -->
    
    <li><i class="fa-solid fa-pencil-ruler"></i><router-link to="/score" class="link">Score</router-link></li>
    <li><i class="fa-solid fa-eraser"></i><router-link to="/merge_result" class="link">Merge Subject</router-link></li>
    <li><i class="fa-solid fa-eraser"></i><router-link to="/broadsheet" class="link">BroadSheet</router-link></li>
    <li><i class="fa-solid fa-laptop"></i><router-link to="/subject_allocation" class="link">Subject allocation</router-link></li>
    <li><i class="fa-solid fa-chalkboard"></i><router-link to="/class_teacher_allocation" class="link">Class teacher allocation</router-link></li>
    <li><i class="fa-solid fa-calendar"></i><router-link to="/resumption_opening_date" class="link">Resumption/Closing Date</router-link></li>

    <hr>

    <li><i class="fa-solid fa-globe"></i><router-link to="/teacher_comment" class="link">Teacher Comment</router-link></li>
    <li><i class="fa-solid fa-microscope"></i><router-link to="/hm_comment" class="link">Hm Comment</router-link></li>
    <hr>
    <li><i class="fa-solid fa-music"></i><router-link to="/affective" class="link">Affective</router-link></li>
    <li><i class="fa-solid fa-car"></i><router-link to="/psychomotor" class="link">Pyschmotor</router-link></li>
    <li><i class="fa-solid fa-clipboard"></i><router-link to="/analyse_result" class="link">Analyse Result</router-link></li>
    <hr>
    <li><i class="fa-solid fa-school"></i><router-link to="/session" class="link">Session</router-link></li>
    <li><i class="fa-solid fa-pencil"></i><router-link to="/klass" class="link">Class</router-link></li>
    <li><i class="fa-solid fa-book"></i><router-link to="/subject" class="link">Subject</router-link></li>
    <li><i class="fa-solid fa-graduation-cap"></i><router-link to="/assessment" class="link">Assessment</router-link></li>
  </ul>
</aside>


    <main>
      <header>
        <ul>
          <li><i id="sidebar-toggle" class="fa-solid fa-bars" @click="toggleSidebar"></i></li>
          <li class="search-container">
            <form>
              <input type="text" placeholder="Search...">
            </form>
          </li>
          <!---<li class="notification"><i class="fa fa-bell"></i><span>Session:2022/2023</span></li>
          <li class="tools"><i class="fa fa-wrench"></i><span>Tools</span></li>-->
          <li class="help"><i class="fa fa-question"></i><span>Help</span></li>
          <li class="logo"><img src="/assets/images/logo.jpg" width="75" height="25"/></li>
        </ul>
      </header>

     
      <section>
        <slot></slot>
      </section>
    </main>
   <footer>ok</footer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      sidebar: null, // Initialize sidebar as null
      isSidebarClosed: false, // Set initial value of isSidebarClosed
    };
  },
  methods: {
    toggleSidebar() {
      // Toggle the value of isSidebarClosed
      this.isSidebarClosed = !this.isSidebarClosed;
      // Modify the display property based on the value of isSidebarClosed
      this.sidebar.style.display = this.isSidebarClosed ? 'none' : 'block';
    },
  },
  mounted() {
    // Get the sidebar element and store it in the data property
    this.sidebar = document.querySelector('.sidebar');
    // Get the computed style of the sidebar
    const computedStyle = getComputedStyle(this.sidebar);
    // Get the value of the display property
    const display = computedStyle.getPropertyValue('display');

    // Set the value of isSidebarClosed based on the display property
    this.isSidebarClosed = display === 'none';
  },
};
</script>

<style>
/* style the page layout*/
#container {
  display: grid;
  grid-template-columns: max-content auto;
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
  .sidebar {
    display: none;
  }
}

@media (min-width: 900px) {
  .sidebar {
    display: block;
  }
}
</style>
