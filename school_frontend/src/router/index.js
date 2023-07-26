import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/pages/viewpages/DashboardPage.vue';
const Roles = {
  admin:3,
  classteacher:2,
  staff:1,
  student:0,
};

function hasRole(userRole, requiredRole) {
  // Perform your role validation logic here
  return userRole === requiredRole;
}

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path:'/studenthome',
    component:()=>import('../pages/viewpages/StudentHomePage.vue'),
    meta: {
      role:Roles.student, // Specify the required role for the route
    },
  },
  {
    path:'/staffhome',
    component:()=>import('../pages/viewpages/StaffHomePage.vue'),
    meta: {
      role:Roles.staff, // Specify the required role for the route
    },
  },
  {
    path:'/adminhome',
    component:()=>import('../pages/viewpages/AdminHomePage.vue')
  },
  {
    path:'/register',
    component:()=>import('../pages/addpages/RegisterUserPage.vue'),
   
  },
  {
    path:'/login',
    component:()=>import('../pages/addpages/LoginUserPage.vue')
  },
  {
    path:'/session',
    component:()=>import('../pages/viewpages/SessionPage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },{
    path:'/session/addsession',
    component:()=>import('../pages/addpages/AddSessionPage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
   {
    path:'/klass',
    component:()=>import('../pages/viewpages/ClassPage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/klass/addklass',
    component:()=>import('../pages/addpages/AddClassPage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/subject',
    component:()=>import('../pages/viewpages/SubjectPage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/subject/addsubject',
    component:()=>import('../pages/addpages/AddSubjectPage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/assessment',
    component:()=>import('../pages/viewpages/AssessmentPage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/assessment/addassessment',
    component:()=>import('../pages/addpages/AddAssessmentPage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/subject_allocation',
    component:()=>import('../pages/viewpages/SubjectAllocationPage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/subject_allocation/addsubjectallocation',
    component:()=>import('../pages/addpages/AddSubjectAllocationPage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  
  {
    path:'/class_teacher_allocation',
    component:()=>import('../pages/viewpages/ClassTeacherAllocationPage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/score',
    component:()=>import('../pages/viewpages/ScorePage.vue'),
    meta: {
      meta: {
        role:[Roles.admin,Roles.staff] // Specify the required role for the route
      },
    },
  },
  {
    path:'/score/addscore',
    component:()=>import('../pages/addpages/AddScorePage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/teacher_comment',
    component:()=>import('../pages/viewpages/TeacherCommentPage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/hm_comment',
    component:()=>import('../pages/viewpages/HmCommentPage.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/resumption_opening_date',
    component:()=>import('../pages/viewpages/ResumptionOpening.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },{
    path:'/merge_result',
    component:()=>import('../pages/viewpages/MergePage'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/merge_result/addmergeresult',
    component:()=>import('../pages/addpages/AddMergePage'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },{
    path:'/analyse_result',
    component:()=>import('../pages/viewpages/AnalyseResult'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/affective',
    component:()=>import('../pages/viewpages/AffectivePage'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/psychomotor',
    component:()=>import('../pages/viewpages/PsychomotorPage'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },{
    path:'/broadsheet',
    component:()=>import('../pages/viewpages/BroadSheet.vue'),
    meta: {
      role:Roles.admin, // Specify the required role for the route
    },
  },
  {
    path:'/forbidden',
    component:()=>import('../pages/viewpages/ForbiddenPage.vue'),
   
  }
  
  /*
  {
    path:'/memories/:id',
    component:()=>import('../pages/MemoryDetail.vue')
  },*/
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation guard
router.beforeEach((to, from, next) => {
  const requiredRole = to.meta.role; // Get the required role from the route's meta data
  //alert(localStorage.getItem('token'));
  const role =localStorage.getItem('role');
  const userRole = Number(atob(role));
  
  //const userRole = getUserRole(); // Get the user's role from wherever you store it (e.g., Vuex store, local storage)

  if (requiredRole && !hasRole(userRole, requiredRole)) {
    //alert(userRole)
    //alert(requiredRole)
    // User doesn't have the required role, redirect to a different page or show an error message
    next({ path: '/forbidden'}); 
  } else {
    
    // User has the required role, proceed to the next route
    next();
  }
});
export default router;