<template>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <i aria-hidden="true" class="fa fa-newspaper-o"></i>

                    <h3 class="box-title"></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form @submit.prevent="submit" class="form-horizontal">
                        <div class="form-group">
                            <div class="row">
                                <label
                                    for="inputBibNumber"
                                    class="col-sm-2 control-label"
                                    >Bib. Number</label
                                >
                            </div>
                            <div class="col-sm-12">
                                <input
                                    type="number"
                                    class="form-control"
                                    id="inputBibNumber"
                                    placeholder="Bib number"
                                    v-model="bibNumber"
                                    required
                                />
                                <div
                                    v-if="errors && errors.bibNumber"
                                    class="text-danger"
                                >
                                    {{ errors.bibNumber }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button
                                    type="submit"
                                    class="btn btn-danger btn-block"
                                    :disabled="reading"
                                >
                                    Submit
                                </button>
                            </div>
                        </div>
                        <div
                            v-if="errors && errors.message"
                            class="alert alert-danger mt-3"
                        >
                            {{ errors.message }}
                            <button
                                v-on:click="readTag()"
                                class="pull-right btn btn-warning col-sm-2 "
                                type="button"
                            >
                                Retry
                            </button>
                        </div>
                    </form>
                    <div
                        v-if="runner && runner.registration_ID"
                        class="alert alert-success mt-3"
                    >
                        <dl class="dl-horizontal">
                            <dt>ID:</dt>
                            <dd>{{ runner.registration_ID }}</dd>
                            <dt>Name:</dt>
                            <dd>
                                {{ runner.firstname }} {{ runner.lastname }}
                            </dd>
                            <dt>Class:</dt>
                            <dd>{{ runner.categoryname }}</dd>
                            <dt>Bib. Nr.:</dt>
                            <dd>{{ runner.bib_nr }}</dd>
                            <dt>Start time:</dt>
                            <dd>{{ runner.stime }}</dd>
                        </dl>
                    </div>
                    <center>
                        <bounce-loader :loading="reading"></bounce-loader>
                        <div v-if="rfidTag.epc">
                            <h4>
                                <strong>EPC: {{ rfidTag.epc }}</strong>
                            </h4>
                        </div>
                        <div v-if="runner.stime_ID === null" class="form-group">
                            <label class="control-label">Start time:</label>
                            <vue-timepicker
                                :second-interval="15"
                                format="HH:mm:ss"
                                :hour-range="[[7, 8], [10, 13]]"
                                v-model="timeValue"
                                close-on-complete
                                @keyup.enter="setStartTime"
                                id="timeValue"
                            ></vue-timepicker>
                            <span id="helpAccountId" class="help-block"
                                >Insert start time of the current runner.</span
                            >
                            <button
                                type="submit"
                                v-on:click="setStartTime(timeValue)"
                                class="btn btn-warning btn-block"
                                :disabled="reading"
                            >
                                Set time
                            </button>
                        </div>
                    </center>
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
import VueTimepicker from "vue2-timepicker";
import "vue2-timepicker/dist/VueTimepicker.css";
Vue.use(VueSweetalert2);
export default {
    name: "assign-tag",
    props: ["edition"],
    mounted() {
        console.log("Component mounted.");
    },
    data() {
        return {
            bibNumber: "",
            errors: {},
            runner: {},
            rfidTag: {},
            loaded: false,
            success: false,
            reading: false,
            timeValue: {
                HH: "10",
                mm: "15",
                ss: "00"
            }
        };
    },
    methods: {
        submit() {
            this.runner = {};
            this.errors = {};
            axios
                .get("./fetchrunner", {
                    params: {
                        bibNumber: this.bibNumber
                    }
                })
                .then(response => {
                    this.reading = true;
                    this.success = true;
                    this.runner = response.data;
                    console.log(this.runner.stime_ID);
                    this.readTag();
                })
                .catch(error => {
                    this.reading = false;
                    if (
                        error.response.status &&
                        error.response.status === 422
                    ) {
                        this.errors = error.response.data;
                        console.log(this.errors);
                    }
                    console.log(error);
                });
        },
        readTag() {
            this.errors = {};
            this.reading = true;
            axios.defaults.timeout = 10000;
            axios
                .get("http://192.168.0.100:3001/readtag", { timeout: 5000 })
                .then(rfidResponse => {
                    this.reading = false;
                    this.rfidTag = rfidResponse.data;
                    this.assignTag();
                })
                .catch(error => {
                    this.reading = false;
                    this.errors = error;
                    console.log(this.errors);
                });
        },
        assignTag() {
            this.errors = {};
            axios
                .put(
                    "./updaterunner",
                    {
                        registrationId: this.runner.registration_ID,
                        epc: this.rfidTag.epc
                    },
                    { timeout: 5000 }
                )
                .then(updateResponse => {
                    this.success = true;
                    this.rfidTag.tagId = updateResponse.data.tagId;
                    this.$swal({
                        position: "top-end",
                        type: "success",
                        title: updateResponse.data.message,
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
        setStartTime(startTimeData) {
            this.errors = {};
            const time = startTimeData.HH+':'+startTimeData.mm+':'+startTimeData.ss;
            axios
                .post(
                    "./setstart",
                    {
                        registrationId: this.runner.registration_ID,
                        time: time
                    },
                    { timeout: 5000 }
                )
                .then(response => {
                    this.success = true;
                    this.$swal({
                        position: "top-end",
                        type: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.runner = {};
                })
                .catch(error => {
                    this.reading = false;
                    this.errors = error.response.data;
                    console.log(this.errors);
                });
        }
    },
    components: {
        BounceLoader,
        VueSweetalert2,
        VueTimepicker
    }
};
</script>
