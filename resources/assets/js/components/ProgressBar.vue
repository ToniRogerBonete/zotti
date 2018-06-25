<template>
   <div>
      <div class="modal fade show" :style="'display:' +  $store.state.progressBar.status" id="exampleModalCenter">
         <div class="modal-dialog modal-dialog-centered" style="width: 50px" role="document">
            <div class="modal-content">
               <div class="modal-body text-center p-2">
                  <i class="fas fa-spinner fa-pulse fa-lg text-primary"></i>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
    export default {
        props:[],
        data: function() {
            return {
            }
        },
        methods: {
            modalShowHide: function (val) {
                if(val=='show') {
                    $('#exampleModalCenter').modal('show');
                } else {
                    $('#exampleModalCenter').modal('hide');
                }
            }
        },
        mounted() {
        }
    }
</script>
