<template>
  <base-layout>
      dashboard
  </base-layout>
</template>

<script>
export default {
  data() {
    return {};
  },
  created() {
    if (!localStorage.getItem('visitedBefore')) {
      localStorage.setItem('visitedBefore', 'true');
      window.location.reload();
    }
  },
};
</script>
