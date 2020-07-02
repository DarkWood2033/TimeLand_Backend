<template>
    <div class="row">
        <div class="col-md-6">
            <div class="form_control">
                <label for="qwe">Qwe qwe</label>
                <input id="qwe" type="text" class="default success" v-model="qwe">
                <v-message
                    v-if="errors.qwe"
                    :message="errors.qwe[0]"
                ></v-message>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form_control">
                <label for="asd">ASD asd</label>
                <input id="asd" type="text" class="default success" v-model="asd">
                <v-message
                    v-if="errors.asd"
                    :message="errors.asd[0]"
                ></v-message>
            </div>
        </div>
    </div>
</template>

<script>
    import FormMixins from "../site/js/mixins/forms/FormMixins";
    export default {
        name: "TestForm",
        data(){
            return {
                qwe: '',
                asd: ''
            };
        },
        methods: {
            send(){
                this.success({ data: this.getData });
            }
        },
        computed: {
            getData(){
                return {
                    qwe: this.qwe,
                    asd: this.asd
                };
            },
            getMessages(){
                return {};
            },
            getRules(){
                return {
                    qwe: 'required|min:3',
                    asd: 'max:5'
                };
            }
        },
        mixins: [FormMixins]
    }
</script>

<style scoped>

</style>
