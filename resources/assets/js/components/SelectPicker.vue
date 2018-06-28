<template>
    <div>
        <select v-model="listValue" :id="id" :name="name" class="form-control" data-live-search="true" data-size="10" ref="select" :title="title">
            <option v-for="(item,index) in itens" :selected="listValue == item.id ? true : false" :value="item.id">{{item.descricao}}</option>
        </select>
    </div>
</template>


<script>
    export default {
        props: ['id','name','value','itens','multiple','descricao','title'],
        data: function() {
            return {
            };
        },
        methods: {
        },
        computed: {
            listValue: {
                get: function() {
                    return this.value;
                },
                set: function (newValue) {
                }
            }
        },
        updated () {
            $('#' + this.id).selectpicker('refresh');
        },
        mounted() {
            console.log(this.value);
        }
    }
</script>
