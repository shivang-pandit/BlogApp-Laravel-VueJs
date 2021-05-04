<template>
    <div>
       <div class="content">
			<div class="container-fluid">					
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Admins <Button @click="addModal=true" v-if="isWritePermitted"><Icon type="md-add" />Add Admin</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
                                <th>Id</th>																
								<th>Full Name</th>								
                                <th>Email</th>								
                                <th>User Type</th>								
                                <th>Create At</th>								
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(admin, i) in admins" :key="i" >
								<td>{{admin.id}}</td>
                                <td class="_table_name">{{admin.full_name}}</td>								
                                <td>{{admin.email}}</td>								
                                <td>{{admin.role.name}}</td>								
								<td>{{admin.created_at}}</td>	                                
								<td>									
									<Button class="_btn _action_btn edit_btn1" type="info" @click="showEditModal(admin, i)" v-if="isUpdatePermitted">Edit</button>									
									<Button class="_btn _action_btn make_btn1" type="error" @click="showDeleteModal(admin,i)" :loading="admin.isDeleting" v-if="isDeletePermitted">Delete</button>
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>
				<!-- <Page :total="100" /> -->
                <!-- Tag add modal -->
                <Modal
                    v-model="addModal"
                    title="Add Admin"
                    :mask-closable="false"
                    :closable="false">
                    <div class="space">
                        <Input type="text" v-model="data.fullName" placeholder="Add Full Name"/>
                    </div>
                    <div class="space">
                        <Input type="email" v-model="data.email" placeholder="Add Email"/>
                    </div>
                    <div class="space">
                        <Input type="password" v-model="data.password" placeholder="Add Password"/>
                    </div>
                    <div class="space">
                        <Select v-model="data.roleId" placeholder="Select Admin type">
                            <Option :value="role.id" v-for="(role, i) in roles" :key="i" v-if="roles.length">{{role.name}}</Option>                            
                        </Select>
                    </div>                    
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...':'Add Admin'}}</Button>
                    </div>               
                </Modal>
                <!-- Tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Admin"
                    :mask-closable="false"
                    :closable="false">

                    <div class="space">
                        <Input type="text" v-model="editData.fullName" placeholder="Edit Full Name"/>
                    </div>
                    <div class="space">
                        <Input type="email" v-model="editData.email" placeholder="Edit Email"/>
                    </div>
                    <div class="space">
                        <Input type="password" v-model="editData.password" placeholder="Edit Password"/>
                    </div>
                    <div class="space">
                        <Select v-model="editData.roleId" placeholder="Select Admin type">
                            <Option :value="role.id" v-for="(role, i) in roles" :key="i" v-if="roles.length">{{role.name}}</Option>                            
                        </Select>
                    </div>       

                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...':'Edit Admin'}}</Button>
                    </div>               
                </Modal>
			</div>
            <deleteModal></deleteModal>
		</div>
    </div>
</template>
<script>
import deleteModal from '../components/deleteModal'
import {mapGetters} from 'vuex'
export default {
    data(){
        return {
            data:{
                fullName:'',
                email:'',
                password:'',                
                roleId:'',
            },
            addModal: false,
            isAdding: false,
            editModal: false,            
            editData:{
                fullName:'',
                email:'',
                password:'',
                roleId:'',
            },
            index:-1,
            admins: [],
            roles: []
        }
    },
    methods: {
        async addAdmin(){            
            if(this.data.fullName.trim()=='') return this.e('Full Name is required!')
            if(this.data.email.trim()=='') return this.e('Email is required!')
            if(this.data.password.trim()=='') return this.e('Password is required!')
            console.log('Role Id=>',this.data.roleId)
            if(!this.data.roleId) return this.e('Role is required!')

            this.isAdding=true
            const res = await this.callApi('post', 'app/admin/create', this.data);
            console.log(res);
            if(res.status == 201) {
                this.s('Admin has been added successfully!')
                this.admins.unshift(res.data);
                this.addModal = false
                this.isAdding = false
                this.data.fullName = ''
                this.data.email = ''
                this.data.roleId = ''
                this.data.password = ''
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
        async editAdmin(){            
            if(this.editData.fullName.trim()=='') return this.e('Full Name is required!')
            if(this.editData.email.trim()=='') return this.e('Email is required!')            
            if(!this.editData.roleId) return this.e('Role is required!')            
            this.isAdding=true
            const res = await this.callApi('post', 'app/admin/update', this.editData);
            console.log(res);
            if(res.status == 200) {
                this.s('Admin has been edited successfully!')                
                this.editModal = false
                this.isAdding = false                
                this.admins[this.index].full_name = res.data.full_name
                this.admins[this.index].email = res.data.email
                this.admins[this.index].role_id = res.data.role_id
                this.admins[this.index].role.name = res.data.role.name
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
        async showEditModal(admin,index) {
            let data = {
                id:admin.id,
                fullName:admin.full_name,
                email:admin.email,                
                roleId:admin.role_id,
            }
            this.editData = data
            this.editModal = true
            this.index = index
        },
        showDeleteModal(admin, index){
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: 'app/admin/delete/'+admin.id,
                data: admin,
                deletingIndex: index,
                isDeleted: false,
            }
            this.$store.commit('setDeleteModalProperty', deleteModalObj)
        }
    },
    async created(){
        // const res = await this.callApi('get', 'app/admin');
        // const roles = await this.callApi('get', 'app/role');        
        const [res, roles] = await Promise.all([
            this.callApi('get', 'app/admin'),
            this.callApi('get', 'app/role')
        ]);

        if(res.status == 200) {
            this.admins = res.data            
        } else {
            this.swr();
        }

        if(roles.status == 200) {
            this.roles = roles.data           
        } else {
            this.swr();
        }
    },
    components: {
        deleteModal
    },
    computed: {
        ...mapGetters(['getDeleteModalObj'])
    },
    watch: {
        getDeleteModalObj(obj) {
            if(obj.isDeleted) {
                this.admins.splice(obj.deletingIndex,1)
            }
        }
    }
}
</script>