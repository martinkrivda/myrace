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
                    <tag-reader
                        :tag="rfidTag"
                        @tag:changed="setTag"
                    ></tag-reader>

                    <div
                        v-if="errors && errors.message"
                        class="alert alert-danger mt-3"
                    >
                        {{ errors.message }}
                    </div>

                    <button
                        :disabled="!hasTag"
                        type="button"
                        class="btn btn-success"
                        @click="storeTag"
                    >
                        Store
                    </button>
                    <button
                        :disabled="!hasTag"
                        type="button"
                        class="btn btn-warning"
                        @click="clear"
                    >
                        Clear
                    </button>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</template>

<script>
// Original imports
import VueSweetalert2 from "vue-sweetalert2";
Vue.use(VueSweetalert2);

// Added imports
import TagReader from "./TagReader.vue";

export default {
    name: "StoreTag",
    components: {
        TagReader,
        // eslint-disable-next-line vue/no-unused-components
        VueSweetalert2
    },
    data() {
        return {
            errors: {},
            rfidTag: null,
            loaded: false,
            success: false,
            reading: false
        };
    },
    computed: {
        hasTag() {
            return !!this.rfidTag;
        }
    },
    mounted() {
        console.log("Component mounted.");
    },
    methods: {
        setTag(tag) {
            this.rfidTag = tag;
        },
        clear() {
            this.rfidTag = null;
        },
        storeTag() {
            this.errors = {};
            axios
                .post(
                    "./storetag",
                    {
                        epc: this.rfidTag
                    },
                    { timeout: 5000 }
                )
                .then(storeResponse => {
                    this.success = true;
                    console.log(storeResponse.data.epc);
                    console.log(storeResponse.data.tagId);
                    this.$swal({
                        position: "top-end",
                        type: "success",
                        title: storeResponse.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.clear();
                })
                .catch(error => {
                    this.reading = false;
                    this.errors = error.response.data;
                    this.clear();
                    console.log(this.errors);
                });
        }
    }
};
</script>
