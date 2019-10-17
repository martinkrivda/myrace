<template>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<!-- Receives value from the global Vue instance. Turns red when low. -->
		<div class="battery hidden-xs">
			<div
				class="charge"
				v-bind:class="{ low: batteryLevel <= 30 }"
				:style="{ height: dynamicHeight + '%' }"
			></div>
			<span class="highlight shadow">{{ batteryLevel }}%</span>
		</div>
	</a>
</template>
<script>
export default {
	name: "battery-level",
	mounted() {
		var that = this;

		if (navigator.getBattery) {
			navigator
				.getBattery()
				.then(function(battery) {
					that.batteryLevel = battery.level * 100;
					console.log(that.batteryLevel);
				})
				.catch(function(e) {
					console.error(e);
				});
		} else {
			console.log("Battery API not availalble in your browser");
		}
	},
	data() {
		return {
			batteryLevel: 60,
			interval: 0
		};
	},
	methods: {
		// For demo purposes virtual battery levels are used.
		// In reality this data should be handled via the battery API.

		drainBattery: function(e) {
			clearInterval(this.interval);

			this.interval = setInterval(
				function() {
					if (this.batteryLevel > 20) {
						this.batteryLevel--;
					} else {
						clearInterval(this.interval);
					}
				}.bind(this),
				50
			);
		},

		rechargeBattery: function(e) {
			clearInterval(this.interval);

			this.interval = setInterval(
				function() {
					if (this.batteryLevel < 100) {
						this.batteryLevel++;
					} else {
						clearInterval(this.interval);
					}
				}.bind(this),
				50
			);
		}
	},
	computed: {
		dynamicHeight() {
			return this.batteryLevel;
		}
	},

	ready: function() {}
};
</script>
