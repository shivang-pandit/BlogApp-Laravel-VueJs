<template>
    <div>
       <div class="content">
			<div class="container-fluid">					
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Assign Role 
                        <Select v-model="data.roleId" placeholder="Select Admin type" @on-change="getRolePermission">
                            <Option :value="role.id" v-for="(role, i) in roles" :key="i" v-if="roles.length">{{role.name}}</Option>                            
                        </Select>
                    </p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
                                <th>Resource Name</th>
								<th>Read</th>
								<th>Write</th>								
                                <th>Update</th>								
								<th>Delete</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(resource, i) in resources" :key="i">
								<td>{{ resource.name }}</td>                                
								<td><Checkbox v-model="resource.read"></Checkbox></td>
                                <td><Checkbox v-model="resource.write"></Checkbox></td>
                                <td><Checkbox v-model="resource.update"></Checkbox></td>
                                <td><Checkbox v-model="resource.delete"></Checkbox></td>
							</tr>
								<!-- ITEMS -->
						</table>
                        <div class="center_button">
                            <Button type="primary" :loading="isSending" :disabled="isSending" @click="assignRole();" v-if="">Assign</Button>
                        </div>
					</div>
				</div>				
			</div>            
		</div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            data:{
                roleId:''
            },
            addModal: false,
            isAdding: false,
            editModal: false,            
            editData:{
                name:''
            },
            index:-1,
            isSending: false,
            resources: [                                                                                                
                {  name:'Home', read: false, write: false, update: false, delete: false, permission_route:'/admin' },
                {  name:'Tags', read: false, write: false, update: false, delete: false, permission_route:'/admin/tags' },
                {  name:'Category', read: false, write: false, update: false, delete: false, permission_route:'/admin/category' },
                {  name:'Blog', read: false, write: false, update: false, delete: false, permission_route:'/admin/blog' },
                {  name:'Admins', read: false, write: false, update: false, delete: false, permission_route:'/admin/admins' },
                {  name:'Role', read: false, write: false, update: false, delete: false, permission_route:'/admin/role' },
                {  name:'Permission', read: false, write: false, update: false, delete: false, permission_route:'/admin/permission' },
            ],
            defaultResources: [                
                {  name:'Home', read: false, write: false, update: false, delete: false, permission_route:'/admin' },
                {  name:'Tags', read: false, write: false, update: false, delete: false, permission_route:'/admin/tags' },
                {  name:'Category', read: false, write: false, update: false, delete: false, permission_route:'/admin/category' },
                {  name:'Blog', read: false, write: false, update: false, delete: false, permission_route:'/admin/blog' },
                {  name:'Admins', read: false, write: false, update: false, delete: false, permission_route:'/admin/admins' },
                {  name:'Role', read: false, write: false, update: false, delete: false, permission_route:'/admin/role' },
                {  name:'Permission', read: false, write: false, update: false, delete: false, permission_route:'/admin/permission' },
            ],
            roles: []
        }
    },
    methods: {       
        async assignRole() {
            let permission =  JSON.stringify(this.resources)
            let reqData = {
                permission : permission,
                role_id: this.data.roleId
            }
            console.log(reqData)
            const res = await this.callApi('post', 'app/role/assign_permission', reqData)

            if(res.status == 200) {
                this.s('Permission successfully assign to the role.')                
                let role_id = res.data.id            
                let index = this.roles.findIndex(role => role.id == role_id)      
                console.log(index)  
                this.roles[index].permission = res.data.permission;
            } else if(res.status == 422){
               if(res.data.error){
                    this.e(res.data.error);
                }
                this.isAdding = false 
            } else {
                this.swr()
                this.isAdding = false 
            }
        },
        async getRolePermission() {
            let role_id = this.data.roleId            
            let index = this.roles.findIndex(role => role.id == role_id)
            console.log(index);
            if(this.roles[index].permission) {
                this.resources = JSON.parse(this.roles[index].permission)
            } else {
                this.resources = this.defaultResources
            }
        }
    },
    async created(){
        console.log(this.$route);
        const res = await this.callApi('get', 'app/role');        
        if(res.status == 200) {
            this.roles = res.data            
            if(this.roles.length) {
                this.data.roleId = this.roles[0].id
                if(this.roles[0].permission) {
                    this.resources = JSON.parse(this.roles[0].permission)
                } else {
                    this.resources = this.defaultResources
                }
            }
        } else {
            this.swr();
        }
    },    
}
</script>