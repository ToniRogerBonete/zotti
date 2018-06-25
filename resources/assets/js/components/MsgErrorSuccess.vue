<template>
   <div>
      <div v-if="$store.state.msgErrorSuccess.status" v-html="$store.state.msgErrorSuccess.msg" style="position: fixed; bottom: 0px; right: 5px; width: 320px; z-index: 99999;"></div>
   </div>
</template>

<script>
   export default {
      props:[],
      mounted() {
         this.$store.commit('setMsgErrorSuccess', {status: true});
      }
   }
</script>