<template>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <i aria-hidden="true" class="fa fa-newspaper-o"></i>
                    <h3 class="box-title">Read tag via reader</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <button
                                type="submit"
                                v-on:click="readTag()"
                                class="btn btn-warning btn-block"
                                :disabled="reading"
                            >
                                Read tag
                            </button>
                                                    <div v-if="rfidTag.epc">
                            <h4>
                                <strong>EPC: {{ rfidTag.epc }}</strong>
                                <strong>ID: {{ rfidTag.tagId }}</strong>
                            </h4>
                        </div>
                    <center>
                        <bounce-loader :loading="reading"></bounce-loader>
                    </center>

                    <div
                            v-if="errors && errors.message"
                            class="alert alert-danger mt-3"
                        >
                            {{ errors.message }}
                        </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</template>

<script>
import BounceLoader from "vue-spinner/src/BounceLoader.vue";
import VueSweetalert2 from "vue-sweetalert2";
Vue.use(VueSweetalert2);
export default {
    name: "store-tag",
    mounted() {
        console.log("Component mounted.");
    },
    data() {
        return {
            errors: {},
            rfidTag: {},
            loaded: false,
            success: false,
            reading: false,
        };
    },
    methods: {
        readTag() {
            this.errors = {};
            this.reading = true;
            axios.defaults.timeout = 10000;
            axios
                .get("http://localhost:3001/readtag", { timeout: 5000 })
                .then(rfidResponse => {
                    this.reading = false;
                    this.rfidTag = rfidResponse.data;
                    this.storeTag();
                })
                .catch(error => {
                    this.reading = false;
                    this.errors = error;
                    console.log(this.errors);
                });
        },
        storeTag() {
            this.errors = {};
            axios
                .post(
                    "./storetag",
                    {
                        epc: this.rfidTag.epc
                    },
                    { timeout: 5000 }
                )
                .then(storeResponse => {
                    this.success = true;
                    this.rfidTag = storeResponse.data;
                    this.$swal({
                        position: "top-end",
                        type: "success",
                        title: storeResponse.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
                .catch(error => {
                    this.reading = false;
                    this.errors = error.response.data;
                    console.log(this.errors);
                });
        },
    },
    components: {
        BounceLoader,
        VueSweetalert2,
    }
};
</script>
