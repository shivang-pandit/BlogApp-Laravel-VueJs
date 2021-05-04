<template>
    <div>
       <div class="content">
			<div class="container-fluid">					
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Roles <Button @click="addModal=true" v-if="isWritePermitted"><Icon type="md-add" />Add Role</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>Id</th>
								<th>Name</th>								
                                <th>Create At</th>								
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(role, i) in roles" :key="i" >
								<td>{{role.id}}</td>
                                <td class="_table_name">{{role.name}}</td>								
								<td>{{role.created_at}}</td>	                                
								<td>									
									<Button class="_btn _action_btn edit_btn1" type="info" @click="showEditModal(role, i)" v-if="isUpdatePermitted">Edit</button>									
									<Button class="_btn _action_btn make_btn1" type="error" @click="showDeleteModal(role,i)" :loading="role.isDeleting" v-if="isDeletePermitted">Delete</button>
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>
				<!-- <Page :total="100" /> -->
                <!-- add modal -->
                <Modal
                    v-model="addModal"
                    title="Add Role"
                    :mask-closable="false"
                    :closable="false">

                    <Input v-model="data.name" placeholder="Add Role Name"/>

                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="add" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...':'Add Role'}}</Button>
                    </div>               
                </Modal>
                <!-- edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Role"
                    :mask-closable="false"
                    :closable="false">

                    <Input v-model="editData.name" placeholder="Edit Role Name"/>

                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="edit" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...':'Edit Role'}}</Button>
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
                name:''
            },
            addModal: false,
            isAdding: false,
            editModal: false,            
            editData:{
                name:''
            },
            index:-1,
            roles: []
        }
    },
    methods: {
        async add(){            
            if(this.data.name.trim()=='') return this.e('Role name is required!')
            this.isAdding=true
            const res = await this.callApi('post', 'app/role/create', this.data);
            console.log(res);
            if(res.status == 201) {
                this.s('Role has been added successfully!')
                this.roles.unshift(res.data);
                this.addModal = false
                this.isAdding = false
                this.data.name = ''
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
        async edit(){            
            if(this.editData.name.trim()=='') return this.e('Role name is required!')
            this.isAdding=true
            const res = await this.callApi('post', 'app/role/update', this.editData);
            console.log(res);
            if(res.status == 200) {
                this.s('Role has been edited successfully!')                
                this.editModal = false
                this.isAdding = false                
                this.roles[this.index].name = res.data.name
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
        async showEditModal(role,index) {
            let data = {
                id:role.id,
                name:role.name
            }
            this.editData = data
            this.editModal = true
            this.index = index
        },
        showDeleteModal(role, index){
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: 'app/role/delete/'+role.id,
                data: role,
                deletingIndex: index,
                isDeleted: false,
            }
            this.$store.commit('setDeleteModalProperty', deleteModalObj)
        }
    },
    async created(){
        const res = await this.callApi('get', 'app/role');        
        if(res.status == 200) {
            this.roles = res.data            
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
            console.log("watch",obj)
            if(obj.isDeleted) {
                this.roles.splice(obj.deletingIndex,1)
            }
        }
    }
}
</script>