<template>
  <base-layout>
      dashboard
  </base-layout>
</template>

<script>
export default {
  data() {
    return {
      isSidebarClosed: false,
    };
  },
  mounted() {
    // jQuery code will be executed after the component is mounted
    this.toggle();
  },
  methods: {
    toggle() {
      console.log('ok');
    },
    toggleSidebar() {
      this.isSidebarClosed = !this.isSidebarClosed;
    },
  },
};
</script>
