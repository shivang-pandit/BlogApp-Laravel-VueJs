<template>
    <div>
      <!-- <div v-if="$store.state.user"> -->
     <div v-if="isLoggedIn">
      <!--========== ADMIN SIDE MENU one ========-->
      <div class="_1side_menu" >
        <div class="_1side_menu_logo">
          <h3 style="text-align:center;">Logo Image</h3>          
        </div>

        <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
        <div class="_1side_menu_content">
          <div class="_1side_menu_img_name">            
            <p class="_1side_menu_name">Admin</p>
          </div>

          <!--~~~ MENU LIST ~~~~~~-->
          <div class="_1side_menu_list">
            <ul class="_1side_menu_list_ul">
              <li v-for="(menuItem, i) in permissions" :key="i" v-if="permissions.length && menuItem.read">
                <router-link :to="menuItem.permission_route"><Icon type="ios-cog-outline" /> {{ menuItem.name }}</router-link>
              </li>

              <!-- <li><router-link to="/"><Icon type="ios-home" /> Home</router-link></li>
              <li><router-link to="tags"><Icon type="ios-speedometer" /> Tags</router-link></li>
              <li><router-link to="category"><Icon type="ios-speedometer" /> Category</router-link></li>
              <li><router-link to="admins"><Icon type="ios-speedometer" /> Admins</router-link></li>
              <li><router-link to="role"><Icon type="ios-speedometer" /> Role Management</router-link></li>
              <li><router-link to="assignRole"><Icon type="ios-speedometer" /> Assign role</router-link></li> -->


              <li><a href="/admin/logout"><Icon type="ios-speedometer" /> Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
      <!--========== ADMIN SIDE MENU ========-->

      <!--========= HEADER ==========-->
      <div class="header">
        <div class="_2menu _box_shadow">
          <div class="_2menu_logo">
            <ul class="open_button">
              <li>
                <Icon type="ios-list" />
              </li>
              <!--<li><Icon type="ios-albums" /></li>-->
            </ul>
          </div>
        </div>
      </div>
      <!--========= HEADER ==========-->
    </div>
    	<router-view></router-view>
    </div>
</template>
<script>
export default {
  props:['user'],
  data() {
    return {
      isLoggedIn: false,
      permissions: '',
    }
  },
  created() {    
    if(this.user) {
      this.$store.commit('setUser',this.user)
      this.$store.commit('setPermission',JSON.parse(this.user.role.permission))
      if(this.user) {
        this.isLoggedIn = true      
        this.permissions = JSON.parse(this.user.role.permission)
      }
    }
  }
}
</script>