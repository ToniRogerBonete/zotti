<template>
   <div>
      <form :id="id" :class="css" :action="action" :method="defineMethod" :enctype="enctype">
         <input v-model="alterMethod" v-if="alterMethod" type="hidden" name="_method">
         <input v-model="token" v-if="token" type="hidden" name="_token">
         <slot></slot>
      </form>
   </div>
</template>

<script>
   export default {
       props:['css','action','method','enctype','token','id'],
       data: function(){
         return {
            alterMethod: ""
         }
      },
      computed: {
         defineMethod: function() {
            if(this.method.toLowerCase() == "post" || this.method.toLowerCase() == "get"){
               this.alterMethod = "";
               return this.method.toLowerCase();
            }
               if(this.method.toLowerCase() == "put" ){
               this.alterMethod = "put";
            }
            if(this.method.toLowerCase() == "delete" ){
               this.alterMethod = "delete";
            }
            return "post";
         },
      }
   }
</script>