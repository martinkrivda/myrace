<template>
	<div class="box-body">
		<div v-for="organiser in userOrganisers">
		  <strong><i class="fa fa-book margin-r-5"></i> {{ organiser.orgname }}</strong>

		  <p class="text-muted">
		    {{ organiser.street }}, {{ organiser.city }}, {{ organiser.postalcode }}
		  </p>
		  <p class="text-muted">
		    <a :href="organiser.web">{{ organiser.web }}</a>
		  </p>

		  <hr>
		</div>

	  <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

	  <p class="text-muted">Malibu, California</p>

	  <hr>

	  <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

	  <p>
	    <span class="label label-danger">UI Design</span>
	    <span class="label label-success">Coding</span>
	    <span class="label label-info">Javascript</span>
	    <span class="label label-warning">PHP</span>
	    <span class="label label-primary">Node.js</span>
	  </p>

	  <hr>

	  <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

	  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
	</div>
	<!-- /.box-body -->
</template>
<script>
    export default {
        name: 'user-organiser',
        props: ['authUser', 'userOrganisers'],
        mounted() {
            console.log('Component mounted.')
            console.log(this.userOrganisers)
        }
    }
</script>