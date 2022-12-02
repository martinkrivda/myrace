<template>
  <div>
    <div class="form-group">
      <div class="row">
        <label for="inputBibNumber" class="col-sm-2 control-label"
          >Bib. Number</label
        >
      </div>
      <div class="col-sm-12">
        <input
          id="inputBibNumber"
          v-model="bibNumber"
          type="number"
          class="form-control"
          placeholder="Bib number"
          required
          @change="emitRunnerBib(bibNumber)"
        />
      </div>
    </div>
    <div>
      <ul v-if="!bibNumber" class="list-group">
        <li
          v-for="runner in sortedRunners"
          :key="runner.id"
          class="
            list-group-item
            d-flex
            justify-content-between
            align-items-center
          "
          @click="emitRunnerBib(runner.bibNr)"
        >
          <strong>{{ runner.bibNr }}</strong>
          <span>{{ runner.firstName }}</span>
          <span>{{ runner.lastName }}</span>
          <strong>{{ runner.timeHM }}</strong>
        </li>
      </ul>
    </div>
    <!-- 
      runner input
      list of runners by start (maxh 60vh)
    -->
  </div>
</template>

<script>
export default {
  name: 'RunnerSelect',
  props: {
    runnerSuggestions: {
      type: Array,
      default: () => [],
    },
    selectedRunner: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      bibNumber: null,
      timeFormatter: new Intl.DateTimeFormat('default', {
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
      }),
    };
  },
  computed: {
    sortedRunners() {
      const suggestionCopy = [...this.runnerSuggestions];
      const sorted = suggestionCopy.sort((a, b) => {
        if (a.timeS !== b.timeS) return a.timeS - b.timeS;
        return a.bib_nr - b.bib_nr;
      });
      return sorted.map((runner) => {
        runner.timeHM = this.timeFormatter.format(new Date(runner.time));
        return runner;
      });
    },
  },
  watch: {
    selectedRunner: {
      immediate: true,
      handler: function (newBibNumber) {
        if (newBibNumber === this.bibNumber) return;
        if (!newBibNumber) this.bibNumber = null;
        this.bibNumber = newBibNumber;
      },
    },
  },
  methods: {
    emitRunnerBib(bib) {
      this.$emit('bib:changed', typeof bib === 'number' ? bib.toString() : bib);
    },
  },
};
</script>
