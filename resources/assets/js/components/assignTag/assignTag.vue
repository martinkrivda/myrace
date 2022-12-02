<template>
    <div>
    <tag-reader :tag="rfidTag" @tag:changed="setTag"></tag-reader>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <i aria-hidden="true" class="fa fa-newspaper-o"></i>

                    <h3 class="box-title"></h3>
                </div>
                <span>{{ timeFormatter.format(time) }}</span>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="form-horizontal" @submit.prevent>
                        <runner-select
                            :selected-runner="runner.bib_nr"
                            :runner-suggestions="runnerSuggestions"
                            @bib:changed="fetchRunner"
                        ></runner-select>
                        <div v-if="errors.message" class="text-danger">
                            {{ errors.message }}
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
                            <!-- <dd>{{ timeFormatter.format(new Date(runner.time)) }}</dd> -->
                            <dd>{{ runner.stime }}</dd>
                        </dl>
                    </div>
                    <div
                        class="btn-group btn-group-lg"
                        role="group"
                        aria-label="Tag assign toolbar"
                    >
                        <button
                            :disabled="!hasTag"
                            type="button"
                            class="btn btn-success"
                            @click="assignTag"
                        >
                            Assign
                        </button>
                        <button
                            :disabled="!hasRunner"
                            type="button"
                            class="btn btn-secondary"
                            @click="displayTimeSet"
                        >
                            Set Runner Time
                        </button>
                        <button
                            :disabled="!hasTag && !hasRunner"
                            type="button"
                            class="btn btn-warning"
                            @click="cancelAssignment"
                        >
                            Cancel
                        </button>
                    </div>
                    <div v-if="showTimeSet" class="form-group my-3">
                        <label class="control-label">Start time:</label>
                        <vue-timepicker
                            id="timeValue"
                            v-model="timeValue"
                            :second-interval="15"
                            format="HH:mm:ss"
                            :hour-range="[[7, 8], [10, 13]]"
                            close-on-complete
                            drop-direction="up"
                            @keyup.enter="setStartTime"
                        ></vue-timepicker>
                        <span id="helpAccountId" class="help-block"
                            >Insert start time of the current runner.</span
                        >
                        <button
                            type="submit"
                            class="btn btn-warning btn-block"
                            @click="setStartTime(timeValue)"
                        >
                            Set time
                        </button>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</div>
</template>

<script>
// Original imports
import VueSweetalert2 from "vue-sweetalert2";
import VueTimepicker from "vue2-timepicker";
import "vue2-timepicker/dist/VueTimepicker.css";
Vue.use(VueSweetalert2);

// Added imports
import TagReader from "./TagReader.vue";
import RunnerSelect from "./RunnerSelect.vue";

export default {
    name: "AssignTag",
    components: {
        // eslint-disable-next-line vue/no-unused-components
        VueSweetalert2,
        VueTimepicker,
        TagReader,
        RunnerSelect
    },
    data() {
        return {
            errors: {},
            // Fetch runner format
            /*
        registration_ID
        firstname
        lastname
        categoryname
        bib_nr
        stime
        stime_ID
      */
            runner: {},
            rfidTag: null,
            timeValue: {
                HH: "10",
                mm: "15",
                ss: "00"
            },
            // StartList format
            /*
        runnerId
        firstName
        lastName
        bibNr
        gender
        categoryId
        time
        timeS
      */
            startList: [],
            showTimeSet: false,
            assignedBibs: [],
            // TODO add detection
            eventStartTimeMs: new Date("2022-12-04 10:15:00").getTime(),
            time: null,
            timeS: 0,
            timerInterval: null,
            timeFormatter: new Intl.DateTimeFormat("default", {
                hour: "numeric",
                minute: "numeric",
                second: "numeric"
            })
        };
    },
    computed: {
        hasRunner() {
            return !!this.runner.registration_ID;
        },
        hasTag() {
            return !!this.rfidTag;
        },
        hasTagRunnerPair() {
            return this.hasRunner && this.hasTag;
        },
        runnerSuggestions() {
            const notStartedNonAssigned = this.startList.filter(
                runner =>
                    this.timeS < runner.timeS &&
                    !this.assignedBibs.includes(runner.bibNr) &&
                    !!runner.bibNr
            );
            notStartedNonAssigned.sort((a, b) => {
                if (a.timeS !== b.timeS) return a.timeS - b.timeS;
                return a.bib_nr - b.bib_nr;
            });
            return notStartedNonAssigned.length > 20
                ? notStartedNonAssigned.slice(0, 20)
                : notStartedNonAssigned;
        }
    },
    mounted() {
        console.log("Component mounted.");
        this.fetchRunners();
        this.timerInterval = setInterval(() => {
            this.updateEventTime();
        }, 1000);
    },
    unmounted() {
        if (this.timerInterval) this.timerInterval();
    },
    methods: {
        fetchRunner(bibNumber) {
            // MOCK VERSION
            // const _mockFetch = startListData.data.find(
            //     item => item.bibNr === bibNumber
            // );
            // this.errors = {};
            // if (_mockFetch) {
            //     const transformedMock = {
            //         registration_ID: _mockFetch.runnerId,
            //         firstname: _mockFetch.firstName,
            //         lastname: _mockFetch.lastName,
            //         categoryname: _mockFetch.categoryId,
            //         bib_nr: _mockFetch.bibNr,
            //         stime: _mockFetch.timeS,
            //         stime_ID: false
            //     };
            //     this.runner = transformedMock;
            //     if (!this.runner.stime_ID) this.showTimeSet = true;
            // } else {
            //     this.runner = {};
            //     this.errors.message = "No runner found for bib number";
            // }

            // SERVER VERSION
            this.errors = {};
            axios
                .get("./fetchrunner", {
                    params: {
                        bibNumber
                    }
                })
                .then(response => {
                    this.runner = response.data;
                    console.log(this.runner.stime_ID);
                    if (!this.runner.stime_ID) this.showTimeSet = true;
                })
                .catch(error => {
                    this.runner = {};
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
        fetchRunners() {
            // Mock version
            // const _mockFetch = startListData.data;
            // this.errors = {};
            // if (_mockFetch) {
            //     this.startList = _mockFetch;
            // } else {
            //     this.errors.message = "No startlist runner data found";
            // }

            // Server version
            this.errors = {};
            axios
                .get("./fetchstartlist")
                .then(response => {
                    this.startList = response.data.data;
                })
                .catch(error => {
                    this.runner = {};
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
        setTag(tag) {
            this.rfidTag = tag;
        },
        assignTag() {
            // Mock version
            // this.errors = {};
            // console.log(
            //     `Runner ${this.runner.registration_ID} has tag ${this.rfidTag}`
            // );
            // this.assignedBibs.push(this.runner.bib_nr);
           // this.$swal({
             //     position: "top-end",
            //     type: "success",
            //     title: "success",
            //     showConfirmButton: false,
            //     timer: 5000
            // });
            // this.clear();

            //Server version
            this.errors = {};
            console.log(
                `Runner ${this.runner.registration_ID} has tag ${this.rfidTag}`
            );
            axios
                .put(
                    "./updaterunner",
                    {
                        registrationId: this.runner.registration_ID,
                        epc: this.rfidTag
                    },
                    { timeout: 5000 }
                )
                .then(updateResponse => {
                    this.assignedBibs.push(this.runner.bib_nr);
                    this.$swal({
                        position: "top-end",
                        type: "success",
                        title: updateResponse.data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    this.clear();
                })
                .catch(error => {
                    this.errors = error.response.data;
                    console.log(this.errors);
                    this.clear();
                });
        },
        cancelAssignment() {
            this.clear();
        },
        clear() {
            this.rfidTag = null;
            this.runner = {};
            this.showTimeSet = false;
        },
        displayTimeSet() {
            this.showTimeSet = true;
        },
        setStartTime(startTimeData) {
            this.errors = {};
            const time =
                startTimeData.HH +
                ":" +
                startTimeData.mm +
                ":" +
                startTimeData.ss;
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
                    this.errors = error.response.data;
                    console.log(this.errors);
                });
        },
        updateEventTime() {
            this.time = new Date();
            const currentTimeMs = this.time.getTime();
            const diffMs = currentTimeMs - this.eventStartTimeMs;
            const diffS = Math.round(diffMs / 1000);
            this.timeS = diffS;
        }
    }
};
</script>
