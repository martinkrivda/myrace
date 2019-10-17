<template>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<!-- Receives value from the global Vue instance. Turns red when low. -->
		<div class="clock">
			<span class="highlight shadow" v-text="currentTime"></span>
		</div>
	</a>
</template>
<script>
import moment from "moment";
export default {
	name: "clock",
	data: function() {
		return {
			message: "Current Time:",
			currentTime: null
		};
	},
	methods: {
		updateCurrentTime() {
			this.currentTime = moment().format("LTS");
		}
	},
	created() {
		this.currentTime = moment().format("LTS");
		setInterval(() => this.updateCurrentTime(), 1 * 1000);
	}
};
</script>
