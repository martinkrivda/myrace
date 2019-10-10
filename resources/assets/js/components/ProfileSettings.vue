<template>
  <div class="tab-content">
    <div class="active tab-pane" id="settings">
      <form @submit.prevent="update" class="form-horizontal">
        <div class="form-group">
          <label for="inputFirstName" class="col-sm-2 control-label">First name</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputFirstName" placeholder="First name" v-model="authUser.firstname" required />
            <div v-if="errors && errors.message" class="text-danger">{{ errors.message[0] }}</div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputLastName" class="col-sm-2 control-label">Last name</label>

          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputLastName" placeholder="Last name" v-model="authUser.lastname" required />
            <div v-if="errors && errors.message" class="text-danger">{{ errors.message[0] }}</div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-2 control-label">E-mail</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail" placeholder="E-mail" v-model="authUser.email" required />
            <div v-if="errors && errors.message" class="text-danger">{{ errors.message[0] }}</div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputAvatar" class="col-sm-2 control-label">Profile photo</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" id="inputAvatar" @change="getImage"/>
            <cropper
              v-if="avatar"
              classname="cropper pull-left"
              :src="avatar"
              :stencil-props="{
                aspectRatio: 1/1
              }"
              maxHeight="250"
              maxWidth="250"
              :stencilComponent="$options.components.CircleStencil"
              @change="change"
            ></cropper>
            <div v-if="errors && errors.message" class="text-danger">{{ errors.message[0] }}</div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-danger">Submit</button>
          </div>
        </div>
        <div v-if="success" class="alert alert-success mt-3">
            Message sent!
        </div>
      </form>
    </div>
    <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</template>
<script>
    import { Cropper, CircleStencil } from 'vue-advanced-cropper'
    export default {
        name: 'user-detail',
        props: ['authUser'],
        mounted() {
            console.log('Component mounted.')
            console.log(this.authUser)
        },
        data() {
          return {
            firstName: '',
            lastName: '',
            email: '',
            avatar: null,
            errors: {},
            success: false,
            loaded: true,
          }
        },
        methods: {
          getImage(e) {
            let image = e.target.files[0]
            this.readImage(image)
            
          },
          update() {
            if (this.loaded) {
              this.loaded = false;
              this.success = false;
              this.errors = {};
              axios.put('./profile/'+this.authUser.id, {
                firstName: this.authUser.firstname,
                lastName: this.authUser.lastname,
                email: this.authUser.email,
              }).then(response => {
                this.loaded = true;
                this.success = true;
              }).catch(error => {
                this.loaded = true;
                if (error.response.status === 422) {
                  this.errors = error.response.data.errors || {};
                }
              });
            }
          },
          readImage(image){
            let reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = e => {
              this.avatar = e.target.result
            } 
          },
          change({coordinates, canvas}) {
            console.log(coordinates, canvas)
            this.image = canvas.toDataURL()
          },
        },
        components: {
          Cropper,
          CircleStencil
        }
    }
</script>