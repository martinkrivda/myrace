<template>
    <!-- Profile Image -->
    <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="/img/user4-128x128.jpg" alt="User profile picture">

          <h3 class="profile-username text-center">{{ authUser.firstname }} {{ authUser.lastname }}</h3>
          <p class="text-muted text-center" v-for="role in userRoles">
            {{ role.name }}
          </p>
            <a href="{{../logout" class="btn btn-primary btn-block" id="logout"
               onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
               Logout
            </a>
          <form id="logout-form" action="../logout" method="POST" style="display: none;">
            <input type="submit" value="logout" style="display: none;">
          </form>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</template>

<script>
    export default {
        name: 'user-info',
        props: ['authUser', 'userRoles'],
        mounted() {
            console.log('Component mounted.')
            console.log(this.userRoles)
        }
    }
</script>
